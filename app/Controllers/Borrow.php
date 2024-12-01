<?php

namespace App\Controllers;

use App\Models\EquipmentModel;
use App\Models\BorrowedItemModel;
use CodeIgniter\Email\Email;

class Borrow extends BaseController
{
    public function index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $equipmentModel = new EquipmentModel();
        $data['equipment'] = $equipmentModel->where('status', 'Stock')->findAll();

        return view('borrow', $data);
    }

    public function borrow_items()
    {
        $equipmentModel = new EquipmentModel();
        $borrowedItemModel = new BorrowedItemModel();
        $data = $this->request->getJSON();
        $userEmail = session()->get('email'); // Get the user's email from the session
    
        foreach ($data->items as $item) {
            $setItem = $item->item_id;
    
            // Check if the item exists
            $itemExists = $equipmentModel->where('item_id', $setItem)->first();
            if (!$itemExists) {
                log_message('error', 'Item ID not found: ' . $setItem);
                return $this->response->setJSON(['success' => false, 'error' => 'Item not found.']);
            }
    
            // Update item status to 'Active'
            if (!$equipmentModel->update($itemExists['id'], ['status' => 'Active'])) {
                log_message('error', 'Failed to update item status: ' . json_encode($equipmentModel->errors()));
                return $this->response->setJSON(['success' => false, 'error' => 'Failed to update item status.']);
            }
    
            // Save borrow record
            if (!$borrowedItemModel->save([
                'item_id' => $item->item_id,
                'borrow_date' => $item->borrow_date,
                'email' => $userEmail,
                'return_date' => null // Initial return date is null
            ])) {
                log_message('error', 'Failed to save borrow record: ' . json_encode($borrowedItemModel->errors()));
                return $this->response->setJSON(['success' => false, 'error' => 'Failed to save borrow record.']);
            }
        }
    
        // Send confirmation email
        $this->send_borrow_email($userEmail, $data->items);
    
        return $this->response->setJSON(['success' => true]);
    }
    
    private function send_borrow_email($email, $selectedItems)
    {
        $emailService = \Config\Services::email();
        $equipmentModel = new EquipmentModel();
    
        // Start building the email message
        $message = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h4 {
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                    color: #333;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h4>Borrowed Items Details</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody>';
    
        // Fetch item details for each selected item
        foreach ($selectedItems as $item) {
            $equipment = $equipmentModel->where('item_id', $item->item_id)->first();
            $message .= "
            <tr>
                <td>{$item->item_id}</td>
                <td>{$equipment['name']}</td>
                <td>{$equipment['category']}</td>
                <td>{$item->borrow_date}</td>
                <td>Pending</td>
            </tr>";
        }
    
        $message .= '
                    </tbody>
                </table>
                <div class="footer">
                    <p>Thank you for using our service!</p>
                </div>
            </div>
        </body>
        </html>';
    
        // Set up and send the email
        $emailService->setTo($email);
        $emailService->setSubject('Borrowed Items Details');
        $emailService->setMessage($message);
        $emailService->setMailType('html');
    
        if ($emailService->send()) {
            log_message('info', 'Borrow confirmation email sent successfully.');
        } else {
            log_message('error', 'Failed to send borrow confirmation email: ' . $emailService->printDebugger(['headers']));
        }
    }
    

    public function return_index()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/');
        }

        $userEmail = $session->get('email');
        $borrowedItemModel = new BorrowedItemModel();
        $borrowedItems = $borrowedItemModel->where('email', $userEmail)->where('return_date', null)->findAll();
        $data['borrowedItems'] = [];

        foreach ($borrowedItems as $borrowedItem) {
            $equipmentModel = new EquipmentModel();
            $itemDetails = $equipmentModel->where('item_id', $borrowedItem['item_id'])->where('status', 'Active')->first();
            if ($itemDetails) {
                $data['borrowedItems'][] = array_merge($borrowedItem, $itemDetails);
            }
        }

        return view('return', $data);
    }

    public function return_items()
    {
        $equipmentModel = new EquipmentModel();
        $borrowedItemModel = new BorrowedItemModel();
        $data = $this->request->getJSON();
        $returnDate = date('Y-m-d'); // Current date as return date
        $returnedItemsDetails = []; // To store details of returned items for the email
    
        foreach ($data->items as $item) {
            $setItem = $item->item_id;
    
            // Check if the item is borrowed
            $borrowedItem = $borrowedItemModel->where('item_id', $setItem)->where('return_date', null)->first();
            if (!$borrowedItem) {
                log_message('error', 'Item ID not borrowed: ' . $setItem);
                return $this->response->setJSON(['success' => false, 'error' => "Item ID $setItem is not currently borrowed."]);
            }
    
            // Fetch the item from Equipment Model to ensure we're updating the right record
            $equipment = $equipmentModel->where('item_id', $setItem)->first();
            if (!$equipment) {
                log_message('error', 'Equipment not found for Item ID: ' . $setItem);
                return $this->response->setJSON(['success' => false, 'error' => 'Equipment not found.']);
            }
    
            // Check if equipment status is already 'Stock', to avoid unnecessary updates
            if ($equipment['status'] === 'Stock') {
                log_message('info', 'Item ID ' . $setItem . ' is already in stock. No update needed.');
                continue; // Skip the update if it's already in stock
            }
    
            // Update item status to 'Stock'
            $updateData = ['status' => 'Stock'];
            if (!$equipmentModel->update($equipment['id'], $updateData)) {
                log_message('error', 'Failed to update item status for Item ID: ' . $setItem . '. Errors: ' . json_encode($equipmentModel->errors()));
                return $this->response->setJSON(['success' => false, 'error' => 'Failed to update item status.']);
            }
    
            // Update return date in borrow record
            $updateBorrowData = ['return_date' => $returnDate];
            if (!$borrowedItemModel->update($borrowedItem['id'], $updateBorrowData)) {
                log_message('error', 'Failed to update return date for Item ID: ' . $setItem . '. Errors: ' . json_encode($borrowedItemModel->errors()));
                return $this->response->setJSON(['success' => false, 'error' => 'Failed to update return date.']);
            }
    
            // Fetch equipment details for email
            $returnedItemsDetails[] = [
                'item_id' => $setItem,
                'name' => $equipment['name'],
                'category' => $equipment['category'],
                'borrow_date' => $borrowedItem['borrow_date'],
                'return_date' => $returnDate
            ];
        }
    
        // Send email notification
        $userEmail = session()->get('email');
        if ($this->send_return_email($userEmail, $returnedItemsDetails)) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to send email.']);
        }
    }
    
    
    private function send_return_email($email, $items)
    {
        $emailService = \Config\Services::email();

        $emailService->setTo($email);
        $emailService->setSubject('Returned Items Details');

        // Fancy email template
        $message = '
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 0;
                    padding: 0;
                    background-color: #f4f4f4;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 10px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
                h4 {
                    color: #333;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 20px 0;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 10px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                    color: #333;
                }
                tr:nth-child(even) {
                    background-color: #f9f9f9;
                }
                tr:hover {
                    background-color: #f1f1f1;
                }
                .footer {
                    text-align: center;
                    margin-top: 20px;
                    color: #888;
                }
            </style>
        </head>
        <body>
            <div class="container">
                <h4>Returned Items Details</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Item ID</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Borrow Date</th>
                            <th>Return Date</th>
                        </tr>
                    </thead>
                    <tbody>';

        foreach ($items as $item) {
            $message .= "
            <tr>
                <td>{$item['item_id']}</td>
                <td>{$item['name']}</td>
                <td>{$item['category']}</td>
                <td>{$item['borrow_date']}</td>
                <td>{$item['return_date']}</td>
            </tr>";
        }

        $message .= '
                    </tbody>
                </table>
                <div class="footer">
                    <p>Thank you for returning the items!</p>
                </div>
            </div>
        </body>
        </html>';

        $emailService->setMessage($message);
        $emailService->setMailType('html'); // Ensure the email is sent as HTML

        if ($emailService->send()) {
            log_message('info', 'Return confirmation email sent successfully.');
            return true;
        } else {
            log_message('error', 'Failed to send return confirmation email: ' . $emailService->printDebugger(['headers']));
            return false;
        }
    }
}

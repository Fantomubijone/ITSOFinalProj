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
        $data['equipment'] = $equipmentModel->findAll();

        return view('borrow', $data);
    }

    public function borrow_items()
    {
        $equipmentModel = new EquipmentModel();
        $borrowedItemModel = new BorrowedItemModel();
        $data = $this->request->getJSON();

        foreach ($data->items as $item) {
            // Update item status to 'Active'
            $equipmentModel->update($item->item_id, ['status' => 'Active']);

            // Save borrow record
            $borrowedItemModel->save([
                'item_id' => $item->item_id,
                'borrow_date' => $item->borrow_date,
                'user_id' => session()->get('user_id'), // Assuming user_id is stored in session
                'return_date' => null // Initial return date is null
            ]);
        }

        return $this->response->setJSON(['success' => true]);
    }

    public function send_borrow_email()
    {
        $data = $this->request->getJSON();
        $email = \Config\Services::email();

        $email->setTo(session()->get('email')); // Assuming email is stored in session
        $email->setSubject('Borrowed Items Details');

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

        foreach ($data->items as $item) {
            $message .= "
            <tr>
                <td>{$item->item_id}</td>
                <td>{$item->name}</td>
                <td>{$item->category}</td>
                <td>{$item->borrow_date}</td>
                <td>{$item->return_date}</td>
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

        $email->setMessage($message);

        if ($email->send()) {
            return $this->response->setJSON(['success' => true]);
        } else {
            return $this->response->setJSON(['success' => false]);
        }
    }
}

<?php

namespace App\Controllers;

use App\Models\EquipmentModel;
use CodeIgniter\API\ResponseTrait;

class EquipmentManagement extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $session = session();
        if ($session->get('userType') != 'ITSO_Personnel') {
            return redirect()->to('/');
        }

        $equipmentModel = new EquipmentModel();
        $data['equipment'] = $equipmentModel->findAll();

        // Add user data to the view data
        $data['first_name'] = $session->get('first_name');
        $data['last_name'] = $session->get('last_name');
        $data['email'] = $session->get('email');

        return view('equipment_management', $data);
    }

    public function create()
    {
        // Add user data to the view data
        $data['first_name'] = session()->get('first_name');
        $data['last_name'] = session()->get('last_name');
        $data['email'] = session()->get('email');
        
        return view('equipment_create', $data);
    }

    public function store()
    {
        $equipmentModel = new EquipmentModel();
    
        $names = $this->request->getPost('name');
        $statuses = $this->request->getPost('status');
        $quantities = $this->request->getPost('item_count');
        $category = $this->request->getPost('category');
    

        foreach ($names as $index => $name) {
            $itemIDPrefix = strtoupper(str_replace(['a', 'e', 'i', 'o', 'u'], '', $name));
            $lastItem = $equipmentModel->where('item_id LIKE', "$itemIDPrefix%")->orderBy('item_id', 'DESC')->first();
            $newIDNumber = $lastItem ? intval(explode('-', $lastItem['item_id'])[1]) + 1 : 1;

            for ($i = 0; $i < $quantities[$index]; $i++) {
                $itemID = $itemIDPrefix . '-' . str_pad($newIDNumber++, 3, '0', STR_PAD_LEFT);

                $data = [
                    'item_id' => $itemID,
                    'name' => $name,
                    'status' => $statuses[$index],
                    'category' => strtoupper($category[$index])
                ];

                $equipmentModel->save($data);
            }
        }
    
        return redirect()->to('/equipment_management');
    }

 
    public function edit($id)
    {
        $equipmentModel = new EquipmentModel();
        $data['equipment'] = $equipmentModel->find($id);

        return view('edit_equipment', $data);
    }

    public function update($id)
    {
        $equipmentModel = new EquipmentModel();
        $data = $this->request->getPost();

        if ($this->validate([
            'name' => 'required',
            'status' => 'required',
            'category' => 'required'
        ])) {
            $updateData = [
                'name' => $data['name'],
                'status' => $data['status'],
                'category' => $data['category']
            ];

            if ($equipmentModel->update($id, $updateData)) {
                return redirect()->to('/equipment_management')->with('success', 'Equipment updated successfully');
            } else {
                return redirect()->back()->withInput()->with('errors', $equipmentModel->errors());
            }
        } else {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }
    }


    public function deactivate($id)
    {
        $equipmentModel = new EquipmentModel();
        $equipmentModel->update($id, ['status' => 'Defective']);

        return redirect()->to('/equipment_management');
    }

    public function activate($id)
    {
        $equipmentModel = new EquipmentModel();
        $equipmentModel->update($id, ['status' => 'Stock']);

        return redirect()->to('/equipment_management');
    }

    public function getLastItemID($prefix)
    {
        $equipmentModel = new EquipmentModel();
        $lastItem = $equipmentModel->where('item_id LIKE', "$prefix%")->orderBy('item_id', 'DESC')->first();
        return $this->respond([
            'lastItemID' => $lastItem ? $lastItem['item_id'] : null
        ]);
    }
}

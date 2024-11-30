<?php

namespace App\Controllers;

use App\Models\EquipmentModel;

class EquipmentManagement extends BaseController
{
    public function index()
    {
        $equipmentModel = new EquipmentModel();
        $data['equipment'] = $equipmentModel->findAll();

        // Add user data to the view data
        $data['first_name'] = session()->get('first_name');
        $data['last_name'] = session()->get('last_name');
        $data['email'] = session()->get('email');

        return view('equipment_management', $data);
    }

    public function create()
    {

        return view('equipment_create');
    }

    public function store()
    {

        $equipmentModel = new EquipmentModel();

        $data = [
            'id' => $this->request->getPost('id'),
            'name' => $this->request->getPost('name'),
            'item_count' => $this->request->getPost('item_count'),
            'status' => 1, // Default status to available
        ];

        $equipmentModel->save($data);

        return redirect()->to('/equipment_management');
    }

    public function edit($id)
    {


        $equipmentModel = new EquipmentModel();
        $data['item'] = $equipmentModel->find($id);

        return view('equipment_edit', $data);
    }

    public function update($id)
    {


        $equipmentModel = new EquipmentModel();

        $data = [
            'name' => $this->request->getPost('name'),
            'item_count' => $this->request->getPost('item_count'),
            'status' => $this->request->getPost('status'),
        ];

        $equipmentModel->update($id, $data);

        return redirect()->to('/equipment_management');
    }

    public function deactivate($id)
    {

        $equipmentModel = new EquipmentModel();
        $equipmentModel->update($id, ['status' => 0]);

        return redirect()->to('/equipment_management');
    }
}

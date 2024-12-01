<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\EquipmentModel;
use App\Models\BorrowedItemModel;

class Reports extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get('userType') != 'ITSO_Personnel') {
            return redirect()->to('/');
        }

        $userModel = new UserModel();
        $equipmentModel = new EquipmentModel();
        $borrowedItemModel = new BorrowedItemModel();

        $totalUsers = $userModel->countAllResults();
        $totalItems = $equipmentModel->countAllResults();

        // Fetch data for pie charts
        $stockData = $equipmentModel->select('category, COUNT(*) as total')
                                    ->where('status', 'Stock')
                                    ->groupBy('category')
                                    ->findAll();
    
        $defectiveData = $equipmentModel->select('category, COUNT(*) as total')
                                        ->where('status', 'Defective')
                                        ->groupBy('category')
                                        ->findAll();

        $unusableEquipment = $equipmentModel->where('status', 'Defective')->findAll();
        $borrowingHistory = $borrowedItemModel->findAll();

        $data = [
            'totalUsers' => $totalUsers,
            'totalItems' => $totalItems,
            'stockData' => $stockData,
            'defectiveData' => $defectiveData,
            'unusableEquipment' => $unusableEquipment,
            'borrowingHistory' => $borrowingHistory
        ];

        return view('reports', $data);
    }
}

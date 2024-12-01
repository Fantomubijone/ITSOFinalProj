<?php

namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\EquipmentModel;
use CodeIgniter\Controller;

class Reservation extends BaseController
{
    public function index()
    {
        $session = session();
        if ($session->get('userType') != 'Associate') {
            return redirect()->to('/'); // Redirect non-Associates
        }

        $reservationModel = new ReservationModel();
        $data['reservations'] = $reservationModel->where('email', $session->get('email'))->findAll();

        return view('reservations', $data);
    }

    public function create()
    {
        $equipmentModel = new EquipmentModel();
        $data['stockItems'] = $equipmentModel->where('status', 'Stock')->findAll();

        return view('create_reservation', $data);
    }

    public function store()
    {
        $session = session();
        $reservationModel = new ReservationModel();
        $data = $this->request->getPost();

        // Ensure the reservation date is at least a day in the future
        $reservationDate = new \DateTime($data['reservation_date']);
        $today = new \DateTime();
        $today->setTime(0, 0);

        if ($reservationDate <= $today) {
            return redirect()->back()->with('errors', 'Reservation must be at least a day in the future')->withInput();
        }

        // Ensure only Associates can make reservations
        if ($session->get('userType') != 'Associate') {
            return redirect()->to('/'); // Redirect non-Associates
        }

        $reservationModel->save([
            'email' => $session->get('email'),
            'item_id' => $data['item_id'],
            'reservation_date' => $data['reservation_date']
        ]);

        return redirect()->to('/reservation')->with('success', 'Reservation created successfully');
    }

    public function edit($id)
    {
        $session = session();
        $reservationModel = new ReservationModel();
        $reservation = $reservationModel->find($id);

        if (!$reservation || $reservation['email'] !== $session->get('email')) {
            return redirect()->to('/reservation')->with('errors', 'Reservation not found or not authorized');
        }

        $equipmentModel = new EquipmentModel();
        $data['stockItems'] = $equipmentModel->where('status', 'Stock')->findAll();
        $data['reservation'] = $reservation;

        return view('edit_reservation', $data);
    }

    public function update($id)
    {
        $session = session();
        $reservationModel = new ReservationModel();
        $data = $this->request->getPost();

        // Ensure the reservation date is at least a day in the future
        $reservationDate = new \DateTime($data['reservation_date']);
        $today = new \DateTime();
        $today->setTime(0, 0);

        if ($reservationDate <= $today) {
            return redirect()->back()->with('errors', 'Reservation must be at least a day in the future')->withInput();
        }

        $reservation = $reservationModel->find($id);
        if (!$reservation || $reservation['email'] !== $session->get('email')) {
            return redirect()->to('/reservation')->with('errors', 'Reservation not found or not authorized');
        }

        $reservationModel->update($id, [
            'item_id' => $data['item_id'],
            'reservation_date' => $data['reservation_date']
        ]);

        return redirect()->to('/reservation')->with('success', 'Reservation updated successfully');
    }

    public function delete($id)
    {
        $session = session();
        $reservationModel = new ReservationModel();
        $reservation = $reservationModel->find($id);

        if (!$reservation || $reservation['email'] !== $session->get('email')) {
            return redirect()->to('/reservation')->with('errors', 'Reservation not found or not authorized');
        }

        $reservationModel->delete($id);

        return redirect()->to('/reservation')->with('success', 'Reservation deleted successfully');
    }
}

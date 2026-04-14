<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notifikasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jadwal_model');
    }

    public function get() {
        // Return json for notifications
        header('Content-Type: application/json');
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['count' => 0]);
            return;
        }

        $count = $this->Jadwal_model->count_mendekati(3);
        echo json_encode(['count' => $count]);
    }
}

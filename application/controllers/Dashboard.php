<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Motor_model');
        $this->load->model('Service_model');
        $this->load->model('Jadwal_model');
        $this->load->model('UnitAC_model');
    }

    public function index() {
        $this->check_permission('dashboard', 'view');

        $data['title'] = 'Dashboard';
        
        // Load stats
        $data['stats_motor'] = $this->Motor_model->get_stats();
        $data['stats_ac']    = $this->UnitAC_model->get_stats();
        $data['count_jadwal']= $this->Jadwal_model->count_mendekati(3); // within 3 days
        
        $data['jadwal_mendekati'] = $this->Jadwal_model->get_for_dashboard(10);

        $this->render('dashboard/index', $data);
    }

    public function get_notifikasi() {
        // Only valid if logged in
        if (!$this->session->userdata('user_id')) {
            echo json_encode(['count' => 0]);
            return;
        }

        $count = $this->Jadwal_model->count_mendekati(3);
        echo json_encode(['count' => $count]);
    }
}

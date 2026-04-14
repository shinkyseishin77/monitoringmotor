<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Service_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('riwayat', 'view');

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $motor_id = $this->input->get('motor_id');
        
        $this->db->start_cache();
        $this->db->select('services.*, motors.nomor_polisi, motors.nama_pemilik, motors.merk, motors.tipe')
                 ->from('services')
                 ->join('motors', 'motors.id = services.motor_id', 'left')
                 ->where('services.status', 'selesai');
                 
        if ($start_date && $end_date) {
            $this->db->where('services.tanggal_service >=', $start_date);
            $this->db->where('services.tanggal_service <=', $end_date);
        }
        if ($motor_id) {
            $this->db->where('services.motor_id', $motor_id);
        }
        $this->db->stop_cache();

        $config['base_url'] = base_url('riwayat/index');
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 20;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        
        $config['full_tag_open'] = '<ul class="pagination mt-3 d-flex" style="list-style:none; padding:0; gap:5px;">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="btn btn-primary btn-sm">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['attributes'] = array('class' => 'btn btn-sm', 'style' => 'border:1px solid #ddd');

        $this->pagination->initialize($config);
        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;

        $this->db->limit($config['per_page'], $page);
        $this->db->order_by('services.tanggal_service', 'DESC');
        $data['riwayat'] = $this->db->get()->result();
        $this->db->flush_cache();
        
        $this->load->model('Motor_model');
        $data['motors'] = $this->Motor_model->get_dropdown();
        
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Laporan Riwayat Service';
        
        $this->render('laporan/riwayat', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LaporanMonitoring extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('laporan_monitoring', 'view');

        $tipe = $this->input->get('tipe') ? $this->input->get('tipe') : 'motor'; // motor / ac
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        $this->db->start_cache();
        if ($tipe == 'motor') {
            $this->db->select('log_monitoring_motors.*, motors.nomor_polisi, motors.nama_pemilik')
                     ->from('log_monitoring_motors')
                     ->join('motors', 'motors.id = log_monitoring_motors.motor_id', 'left');
            if ($start_date && $end_date) {
                $this->db->where('DATE(log_monitoring_motors.created_at) >=', $start_date);
                $this->db->where('DATE(log_monitoring_motors.created_at) <=', $end_date);
            }
        } else {
            $this->db->select('log_monitoring_acs.*, unit_acs.nama_unit, unit_acs.lokasi')
                     ->from('log_monitoring_acs')
                     ->join('unit_acs', 'unit_acs.id = log_monitoring_acs.unit_ac_id', 'left');
            if ($start_date && $end_date) {
                $this->db->where('DATE(log_monitoring_acs.created_at) >=', $start_date);
                $this->db->where('DATE(log_monitoring_acs.created_at) <=', $end_date);
            }
        }
        $this->db->stop_cache();

        $config['base_url'] = base_url('laporan_monitoring/index');
        $config['total_rows'] = $this->db->count_all_results();
        $config['per_page'] = 25;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        
        // pagination style
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
        if ($tipe == 'motor') {
            $this->db->order_by('log_monitoring_motors.created_at', 'DESC');
        } else {
            $this->db->order_by('log_monitoring_acs.created_at', 'DESC');
        }
        
        $data['logs'] = $this->db->get()->result();
        $this->db->flush_cache();
        
        $data['tipe'] = $tipe;
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Laporan Monitoring';
        
        $this->render('laporan/monitoring', $data);
    }
}

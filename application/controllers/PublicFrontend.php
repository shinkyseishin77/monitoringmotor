<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PublicFrontend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Motor_model');
        $this->load->model('Aduan_model');
        $this->load->model('UnitAC_model');
        $this->load->library('pagination');
        $this->load->library('session');
    }

    public function monitoring_ac() {
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('monitoring-ac-public');
        $config['total_rows'] = $this->UnitAC_model->count_all($search, $status);
        $config['per_page'] = 12;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        
        $config['full_tag_open'] = '<ul class="pagination mt-3 d-flex justify-content-center" style="list-style:none; padding:0; gap:5px;">';
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

        $data['acs'] = $this->UnitAC_model->get_all($search, $status, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Monitoring AC';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/monitoring_ac', $data);
        $this->load->view('frontend/footer', $data);
    }

    public function index() {
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('publicfrontend/index');
        $config['total_rows'] = $this->Motor_model->count_all($search, $status);
        $config['per_page'] = 12;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        
        $config['full_tag_open'] = '<ul class="pagination mt-3 d-flex justify-content-center" style="list-style:none; padding:0; gap:5px;">';
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

        $data['motors'] = $this->Motor_model->get_all($search, $status, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Monitoring Motor';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/index', $data);
        $this->load->view('frontend/footer', $data);
    }
    
    public function aduan() {
        $data['title'] = 'Kirim Aduan';
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/aduan', $data);
        $this->load->view('frontend/footer', $data);
    }

    public function submit_aduan() {
        if ($this->input->post()) {
            $data = [
                'nama_pelapor' => $this->input->post('nama_pelapor'),
                'no_hp' => $this->input->post('no_hp'),
                'isi_aduan' => $this->input->post('isi_aduan'),
                'status' => 'pending'
            ];
            $this->Aduan_model->insert($data);
            $this->session->set_flashdata('success', 'Aduan berhasil dikirim. Terima kasih.');
            redirect('aduan-public');
        } else {
            redirect('aduan-public');
        }
    }
    
    public function daftar_aduan() {
        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('publicfrontend/daftar_aduan');
        $config['total_rows'] = $this->Aduan_model->count_all($search, $status);
        $config['per_page'] = 15;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        
        $config['full_tag_open'] = '<ul class="pagination mt-3 d-flex justify-content-center" style="list-style:none; padding:0; gap:5px;">';
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

        $data['aduans'] = $this->Aduan_model->get_all($search, $status, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Daftar Aduan';
        
        $this->load->view('frontend/header', $data);
        $this->load->view('frontend/daftar_aduan', $data);
        $this->load->view('frontend/footer', $data);
    }
}

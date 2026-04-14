<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActivityLog extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('LogActivity_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('activity_log', 'view');

        $search = $this->input->get('search');
        $module = $this->input->get('module');
        
        $config['base_url'] = base_url('activity_log/index');
        $config['total_rows'] = $this->LogActivity_model->count_all($search, $module);
        $config['per_page'] = 30;
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

        $data['logs'] = $this->LogActivity_model->get_all($search, $module, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Sistem Log Aktivitas';
        
        $this->render('laporan/activity_log', $data);
    }
}

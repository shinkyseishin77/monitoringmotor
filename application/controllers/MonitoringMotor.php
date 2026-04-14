<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonitoringMotor extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Motor_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('monitoring', 'view');

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('monitoring/index');
        $config['total_rows'] = $this->Motor_model->count_all($search, $status);
        $config['per_page'] = 15;
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

        $data['motors'] = $this->Motor_model->get_all($search, $status, $config['per_page'], $page);
        $data['stats'] = $this->Motor_model->get_stats();
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Monitoring Status Motor';
        
        $this->render('monitoring_motor/index', $data);
    }

    public function update_status($id) {
        $this->check_permission('monitoring', 'update');
        $motor = $this->Motor_model->get_by_id($id);
        if (!$motor) show_404();

        if ($this->input->post()) {
            $post = $this->input->post();
            $status = $post['status_motor'];
            
            $data = [
                'status' => $status,
                'lokasi' => $post['lokasi'] ?? null,
                'digunakan_oleh' => ($status == 'digunakan') ? $post['digunakan_oleh'] : null,
                'tujuan' => ($status == 'digunakan') ? $post['tujuan'] : null,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->Motor_model->update_status($id, $data);
            
            // Log Monitoring
            $log = [
                'motor_id' => $id,
                'status' => $status,
                'lokasi' => $post['lokasi'] ?? null,
                'digunakan_oleh' => ($status == 'digunakan') ? $post['digunakan_oleh'] : null,
                'tujuan' => ($status == 'digunakan') ? $post['tujuan'] : null
            ];
            $this->Motor_model->insert_log($log);
            
            $this->log_activity('update_status', 'monitoring_motor', ['status' => $motor->status], ['status' => $status]);
            $this->session->set_flashdata('success', 'Status motor berhasil diperbarui.');
        }
        
        redirect('monitoring');
    }
}

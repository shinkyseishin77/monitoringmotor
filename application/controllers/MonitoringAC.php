<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MonitoringAC extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UnitAC_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('monitoring_ac', 'view');

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('monitoring_ac/index');
        $config['total_rows'] = $this->UnitAC_model->count_all($search, $status);
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

        $data['acs'] = $this->UnitAC_model->get_all($search, $status, $config['per_page'], $page);
        $data['stats'] = $this->UnitAC_model->get_stats();
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Monitoring Status AC';
        
        $this->render('monitoring_ac/index', $data);
    }

    public function update_status($id) {
        $this->check_permission('monitoring_ac', 'update');
        $ac = $this->UnitAC_model->get_by_id($id);
        if (!$ac) show_404();

        if ($this->input->post()) {
            $post = $this->input->post();
            $status = $post['status_ac'];
            
            $data = [
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s')
            ];
            
            $this->UnitAC_model->update($id, $data);
            
            // Log Monitoring
            $log = [
                'ac_id' => $id,
                'status' => $status,
                'suhu' => !empty($post['suhu']) ? $post['suhu'] : null,
                'catatan' => !empty($post['catatan']) ? $post['catatan'] : null
            ];
            $this->UnitAC_model->insert_log($log);
            
            $this->log_activity('update_status', 'monitoring_ac', ['status' => $ac->status], ['status' => $status]);
            $this->session->set_flashdata('success', 'Status Unit AC berhasil diperbarui.');
        }
        
        redirect('monitoring_ac');
    }
}

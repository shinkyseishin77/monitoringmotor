<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Aduan_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('aduan', 'view');

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('aduan/index');
        $config['total_rows'] = $this->Aduan_model->count_all($search, $status);
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

        $data['aduans'] = $this->Aduan_model->get_all($search, $status, $config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Kelola Aduan User';
        
        $this->render('aduan/index', $data);
    }
    
    public function update_status($id) {
        $this->check_permission('aduan', 'update');
        $aduan = $this->Aduan_model->get_by_id($id);
        if (!$aduan) show_404();

        if ($this->input->post()) {
            $status = $this->input->post('status');
            $alasan = $this->input->post('alasan');
            $this->Aduan_model->update($id, [
                'status' => $status,
                'alasan' => (!empty($alasan)) ? $alasan : null
            ]);
            $this->session->set_flashdata('success', 'Status aduan berhasil diperbarui.');
            $this->log_activity('update_status_aduan', 'aduan', ['status' => $aduan->status], ['status' => $status]);
        }
        
        redirect('aduan');
    }

    public function hapus($id) {
        $this->check_permission('aduan', 'delete');
        $aduan = $this->Aduan_model->get_by_id($id);
        if ($aduan) {
            $this->Aduan_model->delete($id);
            $this->session->set_flashdata('success', 'Aduan berhasil dihapus.');
            $this->log_activity('hapus_aduan', 'aduan', (array)$aduan, null);
        }
        redirect('aduan');
    }
}

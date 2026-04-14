<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjadwalan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Jadwal_model');
        $this->load->model('Motor_model');
        $this->load->model('UnitAC_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('jadwal_service', 'view');

        $search = $this->input->get('search');
        $jenis  = $this->input->get('jenis');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('penjadwalan/index');
        $config['total_rows'] = $this->Jadwal_model->count_all($search, $jenis, $status);
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

        $data['jadwal'] = $this->Jadwal_model->get_all($search, $jenis, $status, $config['per_page'], $page);
        $data['count_mendekati'] = $this->Jadwal_model->count_mendekati(3);
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Penjadwalan Service';
        
        $this->render('penjadwalan/index', $data);
    }

    public function tambah() {
        $this->check_permission('jadwal_service', 'create');
        $data['title'] = 'Tambah Jadwal Service';
        $data['motors'] = $this->Motor_model->get_dropdown();
        $data['acs']    = $this->UnitAC_model->get_dropdown();
        $data['action'] = base_url('penjadwalan/simpan');
        $this->render('penjadwalan/form', $data);
    }

    public function simpan() {
        $this->check_permission('jadwal_service', 'create');
        
        $post = $this->input->post();
        
        $this->form_validation->set_rules('jenis_service', 'Jenis Service', 'required');
        $this->form_validation->set_rules('tanggal_jadwal', 'Tanggal Jadwal', 'required');
        
        if ($post['jenis_service'] == 'ac') {
            $this->form_validation->set_rules('unit_ac_id', 'Unit AC', 'required');
        } else {
            $this->form_validation->set_rules('motor_id', 'Motor', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $data = [
                'jenis_service' => $post['jenis_service'],
                'tanggal_jadwal' => $post['tanggal_jadwal'],
                'catatan' => $post['catatan'],
                'status' => $post['status'],
                'motor_id' => $post['jenis_service'] != 'ac' ? $post['motor_id'] : null,
                'unit_ac_id' => $post['jenis_service'] == 'ac' ? $post['unit_ac_id'] : null,
            ];
            $this->Jadwal_model->insert($data);
            $this->log_activity('create', 'jadwal_service', null, $data);
            $this->session->set_flashdata('success', 'Jadwal berhasil ditambahkan');
            redirect('penjadwalan');
        }
    }

    public function edit($id) {
        $this->check_permission('jadwal_service', 'update');
        $data['jadwal'] = $this->Jadwal_model->get_by_id($id);
        if (!$data['jadwal']) show_404();

        $data['motors'] = $this->Motor_model->get_dropdown();
        $data['acs']    = $this->UnitAC_model->get_dropdown();
        $data['title'] = 'Edit Jadwal';
        $data['action'] = base_url('penjadwalan/update/'.$id);
        $this->render('penjadwalan/form', $data);
    }

    public function update($id) {
        $this->check_permission('jadwal_service', 'update');
        $old_data = $this->Jadwal_model->get_by_id($id);
        $post = $this->input->post();
        
        $this->form_validation->set_rules('jenis_service', 'Jenis Service', 'required');
        $this->form_validation->set_rules('tanggal_jadwal', 'Tanggal Jadwal', 'required');
        
        if ($post['jenis_service'] == 'ac') {
            $this->form_validation->set_rules('unit_ac_id', 'Unit AC', 'required');
        } else {
            $this->form_validation->set_rules('motor_id', 'Motor', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'jenis_service' => $post['jenis_service'],
                'tanggal_jadwal' => $post['tanggal_jadwal'],
                'catatan' => $post['catatan'],
                'status' => $post['status'],
                'motor_id' => $post['jenis_service'] != 'ac' ? $post['motor_id'] : null,
                'unit_ac_id' => $post['jenis_service'] == 'ac' ? $post['unit_ac_id'] : null,
            ];
            $this->Jadwal_model->update($id, $data);
            $this->log_activity('update', 'jadwal_service', $old_data, $data);
            $this->session->set_flashdata('success', 'Jadwal berhasil diperbarui');
            redirect('penjadwalan');
        }
    }

    public function detail($id) {
        $this->check_permission('jadwal_service', 'view');
        $data['jadwal'] = $this->Jadwal_model->get_by_id($id);
        if (!$data['jadwal']) show_404();
        
        $data['title'] = 'Detail Jadwal';
        $this->render('penjadwalan/detail', $data);
    }

    public function selesai($id) {
        $this->check_permission('jadwal_service', 'update');
        $this->Jadwal_model->selesai($id);
        $this->session->set_flashdata('success', 'Jadwal telah ditandai selesai');
        redirect('penjadwalan');
    }

    public function hapus($id) {
        $this->check_permission('jadwal_service', 'delete');
        $data = $this->Jadwal_model->get_by_id($id);
        if ($data) {
            $this->Jadwal_model->delete($id);
            $this->log_activity('delete', 'jadwal_service', $data, null);
            $this->session->set_flashdata('success', 'Jadwal berhasil dihapus');
        }
        redirect('penjadwalan');
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MasterAC extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('UnitAC_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('unit_ac', 'view');

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('unit_ac/index');
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
        $data['title'] = 'Master AC';
        
        $this->render('ac/index', $data);
    }

    public function tambah() {
        $this->check_permission('unit_ac', 'create');
        $data['title'] = 'Tambah Unit AC';
        $data['action'] = base_url('unit_ac/simpan');
        $this->render('ac/form', $data);
    }

    public function simpan() {
        $this->check_permission('unit_ac', 'create');
        
        $this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $post = $this->input->post();
            $data = [
                'nama_unit' => $post['nama_unit'],
                'merk' => $post['merk'],
                'tipe' => $post['tipe'],
                'kapasitas' => $post['kapasitas'],
                'lokasi' => $post['lokasi'],
                'tanggal_pasang' => $post['tanggal_pasang'] ? $post['tanggal_pasang'] : null,
                'catatan' => $post['catatan']
            ];
            $this->UnitAC_model->insert($data);
            $this->log_activity('create', 'unit_ac', null, $data);
            $this->session->set_flashdata('success', 'Unit AC berhasil ditambahkan');
            redirect('unit_ac');
        }
    }

    public function edit($id) {
        $this->check_permission('unit_ac', 'update');
        $data['ac'] = $this->UnitAC_model->get_by_id($id);
        if (!$data['ac']) show_404();

        $data['title'] = 'Edit Unit AC';
        $data['action'] = base_url('unit_ac/update/'.$id);
        $this->render('ac/form', $data);
    }

    public function update($id) {
        $this->check_permission('unit_ac', 'update');
        $old_data = $this->UnitAC_model->get_by_id($id);
        
        $this->form_validation->set_rules('nama_unit', 'Nama Unit', 'required');
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $post = $this->input->post();
            $data = [
                'nama_unit' => $post['nama_unit'],
                'merk' => $post['merk'],
                'tipe' => $post['tipe'],
                'kapasitas' => $post['kapasitas'],
                'lokasi' => $post['lokasi'],
                'tanggal_pasang' => $post['tanggal_pasang'] ? $post['tanggal_pasang'] : null,
                'catatan' => $post['catatan']
            ];
            $this->UnitAC_model->update($id, $data);
            $this->log_activity('update', 'unit_ac', $old_data, $data);
            $this->session->set_flashdata('success', 'Unit AC berhasil diperbarui');
            redirect('unit_ac');
        }
    }

    public function hapus($id) {
        $this->check_permission('unit_ac', 'delete');
        $data = $this->UnitAC_model->get_by_id($id);
        if ($data) {
            $this->UnitAC_model->delete($id);
            $this->log_activity('delete', 'unit_ac', $data, null);
            $this->session->set_flashdata('success', 'Unit AC berhasil dihapus');
        }
        redirect('unit_ac');
    }

    public function detail($id) {
        $this->check_permission('unit_ac', 'view');
        $data['ac'] = $this->UnitAC_model->get_by_id($id);
        if (!$data['ac']) show_404();
        
        $data['logs'] = $this->UnitAC_model->get_log_monitoring($id);
        $data['title'] = 'Detail AC: ' . $data['ac']->nama_unit;
        $this->render('ac/detail', $data);
    }
}

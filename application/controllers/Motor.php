<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Motor extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Motor_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('motor', 'view');

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('motor/index');
        $config['total_rows'] = $this->Motor_model->count_all($search, $status);
        $config['per_page'] = 15;
        $config['page_query_string'] = TRUE;
        $config['enable_query_strings'] = TRUE;
        
        // basic bootstrap pagination
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
        $data['title'] = 'Data Motor';
        
        $this->render('motor/index', $data);
    }

    public function tambah() {
        $this->check_permission('motor', 'create');
        $data['title'] = 'Tambah Motor';
        $data['action'] = base_url('motor/simpan');
        $this->render('motor/form', $data);
    }

    public function simpan() {
        $this->check_permission('motor', 'create');
        
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');
        $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required|is_unique[motors.nomor_polisi]');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $post = $this->input->post();
            $data = [
                'nama_pemilik' => $post['nama_pemilik'],
                'no_hp' => $post['no_hp'],
                'merk' => $post['merk'],
                'tipe' => $post['tipe'],
                'nomor_polisi' => strtoupper($post['nomor_polisi']),
                'tahun' => $post['tahun']
            ];
            $this->Motor_model->insert($data);
            $this->log_activity('create', 'motor', null, $data);
            $this->session->set_flashdata('success', 'Data motor berhasil ditambahkan');
            redirect('motor');
        }
    }

    public function edit($id) {
        $this->check_permission('motor', 'update');
        $data['motor'] = $this->Motor_model->get_by_id($id);
        if (!$data['motor']) show_404();

        $data['title'] = 'Edit Motor';
        $data['action'] = base_url('motor/update/'.$id);
        $this->render('motor/form', $data);
    }

    public function update($id) {
        $this->check_permission('motor', 'update');
        $old_data = $this->Motor_model->get_by_id($id);
        
        $this->form_validation->set_rules('nama_pemilik', 'Nama Pemilik', 'required');
        $this->form_validation->set_rules('no_hp', 'No HP', 'required');
        $this->form_validation->set_rules('merk', 'Merk', 'required');
        $this->form_validation->set_rules('tipe', 'Tipe', 'required');
        
        // Check unique nopoli if changed
        if ($old_data->nomor_polisi != strtoupper($this->input->post('nomor_polisi'))) {
            $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required|is_unique[motors.nomor_polisi]');
        } else {
            $this->form_validation->set_rules('nomor_polisi', 'Nomor Polisi', 'required');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $post = $this->input->post();
            $data = [
                'nama_pemilik' => $post['nama_pemilik'],
                'no_hp' => $post['no_hp'],
                'merk' => $post['merk'],
                'tipe' => $post['tipe'],
                'nomor_polisi' => strtoupper($post['nomor_polisi']),
                'tahun' => $post['tahun']
            ];
            $this->Motor_model->update($id, $data);
            $this->log_activity('update', 'motor', $old_data, $data);
            $this->session->set_flashdata('success', 'Data motor berhasil diperbarui');
            redirect('motor');
        }
    }

    public function hapus($id) {
        $this->check_permission('motor', 'delete');
        $data = $this->Motor_model->get_by_id($id);
        if ($data) {
            if ($this->Motor_model->delete($id)) {
                $this->log_activity('delete', 'motor', $data, null);
                $this->session->set_flashdata('success', 'Data motor berhasil dihapus');
            } else {
                $this->session->set_flashdata('error', 'Gagal menghapus! Motor masih memiliki data service.');
            }
        }
        redirect('motor');
    }

    public function detail($id) {
        $this->check_permission('motor', 'view');
        $data['motor'] = $this->Motor_model->get_by_id($id);
        if (!$data['motor']) show_404();
        
        $data['services'] = $this->Motor_model->get_services($id);
        $data['logs'] = $this->Motor_model->get_log_monitoring($id);
        $data['title'] = 'Detail Motor: ' . $data['motor']->nomor_polisi;
        $this->render('motor/detail', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Service_model');
        $this->load->model('Motor_model');
        $this->load->library('pagination');
    }

    public function index() {
        $this->check_permission('service', 'view');

        $search = $this->input->get('search');
        $status = $this->input->get('status');
        
        $config['base_url'] = base_url('service/index');
        $config['total_rows'] = $this->Service_model->count_all($search, $status);
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

        $data['services'] = $this->Service_model->get_all($search, $status, $config['per_page'], $page);
        $data['stats'] = $this->Service_model->get_stats();
        $data['pagination'] = $this->pagination->create_links();
        $data['title'] = 'Data Service Motor';
        
        $this->render('service/index', $data);
    }

    public function tambah() {
        $this->check_permission('service', 'create');
        $data['title'] = 'Tambah Service';
        $data['motors'] = $this->Motor_model->get_dropdown();
        $data['action'] = base_url('service/simpan');
        $this->render('service/form', $data);
    }

    public function simpan() {
        $this->check_permission('service', 'create');
        
        $this->form_validation->set_rules('motor_id', 'Motor', 'required');
        $this->form_validation->set_rules('tanggal_service', 'Tanggal Service', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->tambah();
        } else {
            $post = $this->input->post();
            $data = [
                'motor_id' => $post['motor_id'],
                'tanggal_service' => $post['tanggal_service'],
                'keluhan' => $post['keluhan'],
                'tindakan' => $post['tindakan'],
                'biaya_jasa' => $post['biaya_jasa'] ? str_replace(['.', ','], '', $post['biaya_jasa']) : 0,
                'status' => $post['status']
            ];
            $this->Service_model->insert($data);
            $this->log_activity('create', 'service', null, $data);
            
            // Auto update motor status to service if status is not selesai
            if ($post['status'] != 'selesai') {
                $this->Motor_model->update_status($post['motor_id'], ['status' => 'service']);
                $this->Motor_model->insert_log([
                    'motor_id' => $post['motor_id'],
                    'status' => 'service',
                    'lokasi' => 'Bengkel (Service Routine)'
                ]);
            }
            
            $this->session->set_flashdata('success', 'Data service berhasil ditambahkan');
            redirect('service');
        }
    }

    public function edit($id) {
        $this->check_permission('service', 'update');
        $data['service'] = $this->Service_model->get_by_id($id);
        if (!$data['service']) show_404();

        $data['motors'] = $this->Motor_model->get_dropdown();
        $data['title'] = 'Edit Service';
        $data['action'] = base_url('service/update/'.$id);
        $this->render('service/form', $data);
    }

    public function update($id) {
        $this->check_permission('service', 'update');
        $old_data = $this->Service_model->get_by_id($id);
        
        $this->form_validation->set_rules('motor_id', 'Motor', 'required');
        $this->form_validation->set_rules('tanggal_service', 'Tanggal Service', 'required');
        $this->form_validation->set_rules('keluhan', 'Keluhan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $post = $this->input->post();
            $data = [
                'motor_id' => $post['motor_id'],
                'tanggal_service' => $post['tanggal_service'],
                'keluhan' => $post['keluhan'],
                'tindakan' => $post['tindakan'],
                'biaya_jasa' => $post['biaya_jasa'] ? str_replace(['.', ','], '', $post['biaya_jasa']) : 0,
                'status' => $post['status']
            ];
            $this->Service_model->update($id, $data);
            $this->log_activity('update', 'service', $old_data, $data);
            
            // Auto update motor status if service finished
            if ($post['status'] == 'selesai' && $old_data->status != 'selesai') {
                $this->Motor_model->update_status($post['motor_id'], ['status' => 'tersedia']);
                $this->Motor_model->insert_log([
                    'motor_id' => $post['motor_id'],
                    'status' => 'tersedia',
                    'lokasi' => 'Service Selesai'
                ]);
            }
            
            $this->session->set_flashdata('success', 'Data service berhasil diperbarui');
            redirect('service');
        }
    }

    public function update_status($id) {
        $this->check_permission('service', 'update');
        
        // This is a quick inline update from the dashboard/list to quickly step the status
        $old_data = $this->Service_model->get_by_id($id);
        if (!$old_data) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('service');
        }
        
        $new_status = '';
        if ($old_data->status == 'pending') $new_status = 'proses';
        elseif ($old_data->status == 'proses') $new_status = 'selesai';
        else $new_status = 'selesai';
        
        $this->Service_model->update_status($id, $new_status);
        $this->log_activity('update_status', 'service', $old_data->status, $new_status);
        
        if ($new_status == 'selesai') {
            $this->Motor_model->update_status($old_data->motor_id, ['status' => 'tersedia']);
            $this->Motor_model->insert_log([
                'motor_id' => $old_data->motor_id,
                'status' => 'tersedia',
                'lokasi' => 'Service Selesai'
            ]);
        }
        
        $this->session->set_flashdata('success', 'Status service berhasil diubah menjadi ' . ucfirst($new_status));
        redirect('service');
    }

    public function hapus($id) {
        $this->check_permission('service', 'delete');
        $data = $this->Service_model->get_by_id($id);
        if ($data) {
            $this->Service_model->delete($id);
            $this->log_activity('delete', 'service', $data, null);
            $this->session->set_flashdata('success', 'Data service berhasil dihapus');
        }
        redirect('service');
    }

    public function detail($id) {
        $this->check_permission('service', 'view');
        $data['service'] = $this->Service_model->get_by_id($id);
        if (!$data['service']) show_404();
        
        $data['title'] = 'Detail Service';
        $this->render('service/detail', $data);
    }
}

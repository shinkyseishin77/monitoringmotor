<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengaturan_model');
        // only superadmin (role 1) can access this
        if ($this->session->userdata('role_id') != 1) {
            $this->session->set_flashdata('error', 'Akses ditolak. Hanya Admin Sistem yang dapat mengakses menu pengaturan.');
            redirect('dashboard');
        }
    }

    public function kelola_role() {
        $data['roles'] = $this->Pengaturan_model->get_all_roles();
        $data['modules'] = [
            'dashboard', 'motor', 'service', 'jadwal_service', 
            'monitoring', 'unit_ac', 'monitoring_ac', 
            'riwayat', 'laporan_monitoring', 'activity_log'
        ];
        $data['title'] = 'Kelola Role & Hak Akses';
        $this->render('pengaturan/kelola_role', $data);
    }

    public function simpan_role() {
        $role_name = $this->input->post('role_name');
        if (empty($role_name)) {
            $this->session->set_flashdata('error', 'Nama role wajib diisi');
            redirect('kelola_role');
        }

        $role_id = $this->Pengaturan_model->insert_role(['name' => $role_name]);
        $this->save_permissions($role_id, $this->input->post('permissions'));
        
        $this->log_activity('create', 'role', null, ['name' => $role_name]);
        $this->session->set_flashdata('success', 'Role berhasil ditambahkan');
        redirect('kelola_role');
    }

    public function update_role($role_id) {
        if ($role_id == 1) {
            $this->session->set_flashdata('error', 'Role Administrator tidak dapat diubah hak aksesnya');
            redirect('kelola_role');
        }

        $role_name = $this->input->post('role_name');
        $this->Pengaturan_model->update_role($role_id, ['name' => $role_name]);
        
        $this->Pengaturan_model->delete_permissions($role_id);
        $this->save_permissions($role_id, $this->input->post('permissions'));

        $this->log_activity('update', 'role', ['id' => $role_id], ['name' => $role_name]);
        $this->session->set_flashdata('success', 'Role berhasil diperbarui');
        redirect('kelola_role');
    }

    private function save_permissions($role_id, $permissions) {
        if (!empty($permissions)) {
            $perm_data = [];
            foreach ($permissions as $module => $actions) {
                $perm_data[] = [
                    'role_id' => $role_id,
                    'module' => $module,
                    'can_view' => isset($actions['view']) ? 1 : 0,
                    'can_create' => isset($actions['create']) ? 1 : 0,
                    'can_update' => isset($actions['update']) ? 1 : 0,
                    'can_delete' => isset($actions['delete']) ? 1 : 0,
                ];
            }
            if(count($perm_data) > 0) {
                $this->db->insert_batch('role_permissions', $perm_data);
            }
        }
    }

    public function hapus_role($id) {
        if ($id == 1) {
            $this->session->set_flashdata('error', 'Role Administrator tidak dapat dihapus');
        } else {
            $this->Pengaturan_model->delete_role($id);
            $this->log_activity('delete', 'role', ['id' => $id], null);
            $this->session->set_flashdata('success', 'Role berhasil dihapus');
        }
        redirect('kelola_role');
    }

    // USER MANAGEMENT
    public function kelola_user() {
        $data['users'] = $this->Pengaturan_model->get_all_users();
        $data['roles'] = $this->Pengaturan_model->get_all_roles();
        $data['title'] = 'Kelola Pengguna';
        $this->render('pengaturan/kelola_user', $data);
    }

    public function simpan_user() {
        $post = $this->input->post();
        
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'nama' => $post['nama'],
                'email' => $post['email'],
                'password' => password_hash($post['password'], PASSWORD_BCRYPT),
                'role_id' => $post['role_id'],
                'is_active' => isset($post['is_active']) ? 1 : 0
            ];
            $this->Pengaturan_model->insert_user($data);
            $this->log_activity('create', 'user', null, ['email' => $post['email'], 'nama' => $post['nama']]);
            $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan');
        }
        redirect('kelola_user');
    }

    public function update_user($id) {
        $post = $this->input->post();
        $user = $this->Pengaturan_model->get_user_by_id($id);
        
        $this->form_validation->set_rules('nama', 'Nama Lengkap', 'required');
        if ($post['email'] != $user->email) {
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
        } else {
            $data = [
                'nama' => $post['nama'],
                'email' => $post['email'],
                'role_id' => $post['role_id'],
                'is_active' => isset($post['is_active']) ? 1 : 0
            ];
            
            if (!empty($post['password'])) {
                $data['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
            }
            
            $this->Pengaturan_model->update_user($id, $data);
            $this->log_activity('update', 'user', ['id' => $id], ['email' => $post['email']]);
            $this->session->set_flashdata('success', 'Pengguna berhasil diperbarui');
        }
        redirect('kelola_user');
    }

    public function hapus_user($id) {
        if ($id == $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun Anda sendiri');
        } else {
            $this->Pengaturan_model->delete_user($id);
            $this->log_activity('delete', 'user', ['id' => $id], null);
            $this->session->set_flashdata('success', 'Pengguna berhasil dihapus');
        }
        redirect('kelola_user');
    }
}

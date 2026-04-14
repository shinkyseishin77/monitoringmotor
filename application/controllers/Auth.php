<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function login() {
        // If already logged in, redirect to dashboard
        if ($this->session->userdata('user_id')) {
            redirect('dashboard');
        }

        if ($this->input->post()) {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->get_by_email($email);
            
            // Using password_verify to check bcrypt hashes
            if ($user && password_verify($password, $user->password)) {
                // Get permissions
                $this->load->model('Role_model');
                $perms_db = $this->Role_model->get_permissions($user->role_id);
                $permissions = [];
                foreach ($perms_db as $p) {
                    $permissions[$p->module] = [
                        'can_view' => $p->can_view,
                        'can_create' => $p->can_create,
                        'can_update' => $p->can_update,
                        'can_delete' => $p->can_delete
                    ];
                }

                $session_data = array(
                    'user_id'  => $user->id,
                    'name'     => $user->name,
                    'email'    => $user->email,
                    'role_id'  => $user->role_id,
                    'permissions' => $permissions
                );
                $this->session->set_userdata($session_data);
                
                // Log activity
                $this->db->insert('log_activities', [
                    'user_id' => $user->id,
                    'aksi' => 'login',
                    'modul' => 'auth',
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Email atau password salah!');
                redirect('auth/login');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout() {
        if ($this->session->userdata('user_id')) {
             $this->db->insert('log_activities', [
                'user_id' => $this->session->userdata('user_id'),
                'aksi' => 'logout',
                'modul' => 'auth',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}

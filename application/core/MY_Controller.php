<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    protected $user_id;
    protected $role_id;
    protected $user_name;
    protected $permissions = [];

    public function __construct() {
        parent::__construct();
        
        // Force login check for all controllers EXCEPT Auth
        $class = strtolower($this->router->fetch_class());
        if ($class !== 'auth') {
            if (!$this->session->userdata('user_id')) {
                redirect('auth/login');
            }
            $this->user_id = $this->session->userdata('user_id');
            $this->role_id = $this->session->userdata('role_id');
            $this->user_name = $this->session->userdata('name');
            $this->permissions = $this->session->userdata('permissions') ?? [];
        }
    }

    /**
     * Render view with master layout
     */
    protected function render($view, $data = []) {
        $data['user_name'] = $this->user_name;
        $data['role_id'] = $this->role_id;
        $data['permissions'] = $this->permissions;
        
        $data['pending_aduan_count'] = $this->db->where('status', 'pending')->count_all_results('aduan');
        
        $data['content'] = $this->load->view($view, $data, TRUE);
        $this->load->view('layouts/main', $data);
    }

    /**
     * Check if current user has permission for a specific module and action
     */
    protected function check_permission($module, $action = 'view') {
        if ($this->role_id == 1) return true; // Admin has all rights

        if (!isset($this->permissions[$module])) {
            show_error('Anda tidak memiliki akses ke modul ini.', 403, 'Akses Ditolak');
        }

        $allow = false;
        switch ($action) {
            case 'view':
                $allow = $this->permissions[$module]['can_view'] == 1;
                break;
            case 'create':
                $allow = $this->permissions[$module]['can_create'] == 1;
                break;
            case 'update':
                $allow = $this->permissions[$module]['can_update'] == 1;
                break;
            case 'delete':
                $allow = $this->permissions[$module]['can_delete'] == 1;
                break;
        }

        if (!$allow) {
            if ($this->input->is_ajax_request()) {
                echo json_encode(['status' => 'error', 'message' => 'Akses ditolak pada aksi ini.']);
                exit;
            }
            show_error('Anda tidak memiliki izin untuk melakukan aksi ini.', 403, 'Akses Ditolak');
        }
        return true;
    }

    /**
     * Log Activity Helper
     */
    protected function log_activity($aksi, $modul, $data_lama = null, $data_baru = null) {
        $data = [
            'user_id' => $this->user_id,
            'aksi' => $aksi,
            'modul' => $modul,
            'data_lama' => $data_lama ? json_encode($data_lama) : null,
            'data_baru' => $data_baru ? json_encode($data_baru) : null,
            'created_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('log_activities', $data);
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengaturan_model extends CI_Model {

    // ---- ROLES ----
    public function get_all_roles() {
        $this->db->select('roles.*, COUNT(users.id) as jumlah_user');
        $this->db->join('users', 'users.role_id = roles.id', 'left');
        $this->db->group_by('roles.id');
        return $this->db->get('roles')->result();
    }

    public function get_role_by_id($id) {
        return $this->db->get_where('roles', ['id' => $id])->row();
    }

    public function get_roles_dropdown() {
        return $this->db->get('roles')->result();
    }

    public function insert_role($data) {
        return $this->db->insert('roles', $data);
    }

    public function update_role($id, $data) {
        return $this->db->where('id', $id)->update('roles', $data);
    }

    public function delete_role($id) {
        $count = $this->db->where('role_id', $id)->count_all_results('users');
        if ($count > 0) return false;
        $this->db->where('role_id', $id)->delete('role_permissions');
        return $this->db->where('id', $id)->delete('roles');
    }

    public function insert_id() {
        return $this->db->insert_id();
    }

    // ---- PERMISSIONS ----
    public function get_permissions($role_id) {
        return $this->db->get_where('role_permissions', ['role_id' => $role_id])->result();
    }

    public function get_permissions_map($role_id) {
        $perms_db = $this->get_permissions($role_id);
        $map = [];
        foreach ($perms_db as $p) {
            $map[$p->module] = $p;
        }
        return $map;
    }

    public function sync_permissions($role_id, $permissions_input) {
        $this->db->where('role_id', $role_id)->delete('role_permissions');
        $modules = ['dashboard', 'motor', 'service', 'jadwal_service', 'monitoring', 'unit_ac', 'monitoring_ac', 'riwayat', 'laporan_monitoring', 'activity_log', 'kelola_role', 'kelola_user'];
        foreach ($modules as $module) {
            $this->db->insert('role_permissions', [
                'role_id'    => $role_id,
                'module'     => $module,
                'can_view'   => isset($permissions_input[$module]['can_view']) ? 1 : 0,
                'can_create' => isset($permissions_input[$module]['can_create']) ? 1 : 0,
                'can_update' => isset($permissions_input[$module]['can_update']) ? 1 : 0,
                'can_delete' => isset($permissions_input[$module]['can_delete']) ? 1 : 0,
            ]);
        }
        return true;
    }

    public function get_all_modules() {
        return [
            'Menu Utama'  => ['dashboard' => 'Dashboard', 'motor' => 'Data Motor'],
            'Operasional' => ['service' => 'Service', 'jadwal_service' => 'Penjadwalan', 'monitoring' => 'Monitoring Motor', 'unit_ac' => 'Master AC', 'monitoring_ac' => 'Monitoring AC'],
            'Laporan'     => ['riwayat' => 'Riwayat Service', 'laporan_monitoring' => 'Laporan Monitoring', 'activity_log' => 'Log Aktivitas'],
            'Pengaturan'  => ['kelola_role' => 'Kelola Role', 'kelola_user' => 'Kelola User'],
        ];
    }

    // ---- USERS ----
    public function get_all_users() {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get('users')->result();
    }

    public function get_user_by_id($id) {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->join('roles', 'roles.id = users.role_id', 'left');
        return $this->db->get_where('users', ['users.id' => $id])->row();
    }

    public function insert_user($data) {
        return $this->db->insert('users', $data);
    }

    public function update_user($id, $data) {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete_user($id) {
        return $this->db->where('id', $id)->delete('users');
    }

    public function is_email_unique($email, $exclude_id = null) {
        if ($exclude_id) $this->db->where('id !=', $exclude_id);
        $this->db->where('email', $email);
        return $this->db->count_all_results('users') === 0;
    }
}

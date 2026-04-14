<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LogActivity_model extends CI_Model {

    public function get_all($aksi = '', $modul = '', $limit = 20, $offset = 0) {
        $this->db->select('log_activities.*, users.name as user_name, users.email');
        $this->db->join('users', 'users.id = log_activities.user_id', 'left');
        if ($aksi)  $this->db->where('log_activities.aksi', $aksi);
        if ($modul) $this->db->where('log_activities.modul', $modul);
        $this->db->order_by('log_activities.created_at', 'DESC');
        return $this->db->get('log_activities', $limit, $offset)->result();
    }

    public function count_all($aksi = '', $modul = '') {
        $this->db->join('users', 'users.id = log_activities.user_id', 'left');
        if ($aksi)  $this->db->where('log_activities.aksi', $aksi);
        if ($modul) $this->db->where('log_activities.modul', $modul);
        return $this->db->count_all_results('log_activities');
    }

    public function get_distinct_aksi() {
        return $this->db->select('DISTINCT aksi')->get('log_activities')->result();
    }

    public function get_distinct_modul() {
        return $this->db->select('DISTINCT modul')->get('log_activities')->result();
    }
}

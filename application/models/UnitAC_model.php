<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UnitAC_model extends CI_Model {

    public function get_all($search = '', $status = '', $limit = 15, $offset = 0) {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_unit', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('lokasi', $search);
            $this->db->group_end();
        }
        if ($status) $this->db->where('status', $status);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('unit_acs', $limit, $offset)->result();
    }

    public function count_all($search = '', $status = '') {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_unit', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('lokasi', $search);
            $this->db->group_end();
        }
        if ($status) $this->db->where('status', $status);
        return $this->db->count_all_results('unit_acs');
    }

    public function get_by_id($id) {
        return $this->db->get_where('unit_acs', ['id' => $id])->row();
    }

    public function get_dropdown() {
        return $this->db->select('id, CONCAT(nama_unit, " - ", lokasi) as label')
            ->get('unit_acs')->result();
    }

    public function get_stats() {
        return [
            'total'   => $this->db->count_all('unit_acs'),
            'aktif'   => $this->db->where('status', 'aktif')->count_all_results('unit_acs'),
            'service' => $this->db->where('status', 'service')->count_all_results('unit_acs'),
            'mati'    => $this->db->where('status', 'mati')->count_all_results('unit_acs'),
        ];
    }

    public function insert($data) {
        return $this->db->insert('unit_acs', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('unit_acs', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('unit_acs');
    }

    public function get_log_monitoring($ac_id, $limit = 15) {
        return $this->db->where('ac_id', $ac_id)
            ->order_by('created_at', 'DESC')
            ->get('log_monitoring_acs', $limit)->result();
    }

    public function insert_log($data) {
        return $this->db->insert('log_monitoring_acs', $data);
    }

    public function get_log_for_laporan($search = '', $status = '', $date_from = '', $date_to = '', $limit = 20, $offset = 0) {
        $this->db->select('log_monitoring_acs.*, unit_acs.nama_unit, unit_acs.lokasi');
        $this->db->join('unit_acs', 'unit_acs.id = log_monitoring_acs.ac_id');
        if ($search) {
            $this->db->group_start();
            $this->db->like('unit_acs.nama_unit', $search);
            $this->db->or_like('unit_acs.lokasi', $search);
            $this->db->group_end();
        }
        if ($status)    $this->db->where('log_monitoring_acs.status', $status);
        if ($date_from) $this->db->where('DATE(log_monitoring_acs.created_at) >=', $date_from);
        if ($date_to)   $this->db->where('DATE(log_monitoring_acs.created_at) <=', $date_to);
        $this->db->order_by('log_monitoring_acs.created_at', 'DESC');
        return $this->db->get('log_monitoring_acs', $limit, $offset)->result();
    }
}

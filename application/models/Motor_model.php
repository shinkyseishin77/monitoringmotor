<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Motor_model extends CI_Model {

    public function get_all($search = '', $status = '', $limit = 15, $offset = 0) {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_pemilik', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('tipe', $search);
            $this->db->or_like('nomor_polisi', $search);
            $this->db->group_end();
        }
        if ($status) $this->db->where('status', $status);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('motors', $limit, $offset)->result();
    }

    public function count_all($search = '', $status = '') {
        if ($search) {
            $this->db->group_start();
            $this->db->like('nama_pemilik', $search);
            $this->db->or_like('merk', $search);
            $this->db->or_like('tipe', $search);
            $this->db->or_like('nomor_polisi', $search);
            $this->db->group_end();
        }
        if ($status) $this->db->where('status', $status);
        return $this->db->count_all_results('motors');
    }

    public function get_by_id($id) {
        return $this->db->get_where('motors', ['id' => $id])->row();
    }

    public function get_dropdown() {
        return $this->db->select('id, CONCAT(nama_pemilik, " - ", nomor_polisi, " (", merk, " ", tipe, ")") as label')
            ->get('motors')->result();
    }

    public function get_stats() {
        $stats = [
            'total'     => $this->db->count_all('motors'),
            'tersedia'  => $this->db->where('status', 'tersedia')->count_all_results('motors'),
            'service'   => $this->db->where('status', 'service')->count_all_results('motors'),
            'digunakan' => $this->db->where('status', 'digunakan')->count_all_results('motors'),
        ];
        return $stats;
    }

    public function insert($data) {
        return $this->db->insert('motors', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('motors', $data);
    }

    public function delete($id) {
        // Check if motor has services
        $count = $this->db->where('motor_id', $id)->count_all_results('services');
        if ($count > 0) {
            return false;
        }
        return $this->db->where('id', $id)->delete('motors');
    }

    public function update_status($id, $data) {
        return $this->db->where('id', $id)->update('motors', $data);
    }

    public function is_nomor_polisi_unique($nomor_polisi, $exclude_id = null) {
        if ($exclude_id) {
            $this->db->where('id !=', $exclude_id);
        }
        $this->db->where('nomor_polisi', $nomor_polisi);
        return $this->db->count_all_results('motors') === 0;
    }

    public function get_log_monitoring($motor_id, $limit = 15) {
        return $this->db->where('motor_id', $motor_id)
            ->order_by('created_at', 'DESC')
            ->get('log_monitoring_motors', $limit)->result();
    }

    public function insert_log($data) {
        return $this->db->insert('log_monitoring_motors', $data);
    }

    public function get_services($motor_id) {
        return $this->db->where('motor_id', $motor_id)
            ->order_by('tanggal_service', 'DESC')
            ->get('services')->result();
    }
}

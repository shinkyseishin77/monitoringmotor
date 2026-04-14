<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service_model extends CI_Model {

    public function get_all($search = '', $status = '', $limit = 15, $offset = 0) {
        $this->db->select('services.*, motors.nama_pemilik, motors.merk, motors.tipe, motors.nomor_polisi');
        $this->db->join('motors', 'motors.id = services.motor_id', 'left');
        if ($search) {
            $this->db->group_start();
            $this->db->like('services.keluhan', $search);
            $this->db->or_like('services.tindakan', $search);
            $this->db->or_like('motors.nama_pemilik', $search);
            $this->db->or_like('motors.nomor_polisi', $search);
            $this->db->group_end();
        }
        if ($status) $this->db->where('services.status', $status);
        $this->db->order_by('services.id', 'DESC');
        return $this->db->get('services', $limit, $offset)->result();
    }

    public function count_all($search = '', $status = '') {
        $this->db->join('motors', 'motors.id = services.motor_id', 'left');
        if ($search) {
            $this->db->group_start();
            $this->db->like('services.keluhan', $search);
            $this->db->or_like('services.tindakan', $search);
            $this->db->or_like('motors.nama_pemilik', $search);
            $this->db->or_like('motors.nomor_polisi', $search);
            $this->db->group_end();
        }
        if ($status) $this->db->where('services.status', $status);
        return $this->db->count_all_results('services');
    }

    public function get_by_id($id) {
        $this->db->select('services.*, motors.nama_pemilik, motors.merk, motors.tipe, motors.nomor_polisi, motors.no_hp');
        $this->db->join('motors', 'motors.id = services.motor_id', 'left');
        return $this->db->get_where('services', ['services.id' => $id])->row();
    }

    public function get_stats() {
        return [
            'total'   => $this->db->count_all('services'),
            'pending' => $this->db->where('status', 'pending')->count_all_results('services'),
            'proses'  => $this->db->where('status', 'proses')->count_all_results('services'),
            'selesai' => $this->db->where('status', 'selesai')->count_all_results('services'),
        ];
    }

    public function insert($data) {
        return $this->db->insert('services', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('services', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('services');
    }

    public function update_status($id, $status) {
        return $this->db->where('id', $id)->update('services', ['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public function get_completed($search = '', $date_from = '', $date_to = '', $limit = 15, $offset = 0) {
        $this->db->select('services.*, motors.nama_pemilik, motors.merk, motors.tipe, motors.nomor_polisi');
        $this->db->join('motors', 'motors.id = services.motor_id', 'left');
        $this->db->where('services.status', 'selesai');
        if ($search) {
            $this->db->group_start();
            $this->db->like('services.keluhan', $search);
            $this->db->or_like('motors.nama_pemilik', $search);
            $this->db->or_like('motors.nomor_polisi', $search);
            $this->db->group_end();
        }
        if ($date_from) $this->db->where('services.tanggal_service >=', $date_from);
        if ($date_to)   $this->db->where('services.tanggal_service <=', $date_to);
        $this->db->order_by('services.tanggal_service', 'DESC');
        return $this->db->get('services', $limit, $offset)->result();
    }

    public function count_completed($search = '', $date_from = '', $date_to = '') {
        $this->db->join('motors', 'motors.id = services.motor_id', 'left');
        $this->db->where('services.status', 'selesai');
        if ($search) {
            $this->db->group_start();
            $this->db->like('services.keluhan', $search);
            $this->db->or_like('motors.nama_pemilik', $search);
            $this->db->or_like('motors.nomor_polisi', $search);
            $this->db->group_end();
        }
        if ($date_from) $this->db->where('services.tanggal_service >=', $date_from);
        if ($date_to)   $this->db->where('services.tanggal_service <=', $date_to);
        return $this->db->count_all_results('services');
    }
}

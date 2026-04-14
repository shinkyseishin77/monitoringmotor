<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

    public function get_all($search = '', $jenis = '', $status = '', $limit = 15, $offset = 0) {
        $this->db->select('jadwal_services.*, motors.nama_pemilik, motors.nomor_polisi, motors.merk, motors.tipe, unit_acs.nama_unit, unit_acs.lokasi as lokasi_ac');
        $this->db->join('motors', 'motors.id = jadwal_services.motor_id', 'left');
        $this->db->join('unit_acs', 'unit_acs.id = jadwal_services.unit_ac_id', 'left');
        if ($search) {
            $this->db->group_start();
            $this->db->like('motors.nama_pemilik', $search);
            $this->db->or_like('motors.nomor_polisi', $search);
            $this->db->or_like('unit_acs.nama_unit', $search);
            $this->db->or_like('jadwal_services.catatan', $search);
            $this->db->group_end();
        }
        if ($jenis)  $this->db->where('jadwal_services.jenis_service', $jenis);
        if ($status) $this->db->where('jadwal_services.status', $status);
        $this->db->order_by('jadwal_services.tanggal_jadwal', 'ASC');
        return $this->db->get('jadwal_services', $limit, $offset)->result();
    }

    public function count_all($search = '', $jenis = '', $status = '') {
        $this->db->join('motors', 'motors.id = jadwal_services.motor_id', 'left');
        $this->db->join('unit_acs', 'unit_acs.id = jadwal_services.unit_ac_id', 'left');
        if ($search) {
            $this->db->group_start();
            $this->db->like('motors.nama_pemilik', $search);
            $this->db->or_like('motors.nomor_polisi', $search);
            $this->db->or_like('unit_acs.nama_unit', $search);
            $this->db->group_end();
        }
        if ($jenis)  $this->db->where('jadwal_services.jenis_service', $jenis);
        if ($status) $this->db->where('jadwal_services.status', $status);
        return $this->db->count_all_results('jadwal_services');
    }

    public function get_by_id($id) {
        $this->db->select('jadwal_services.*, motors.nama_pemilik, motors.nomor_polisi, motors.merk, motors.tipe, unit_acs.nama_unit, unit_acs.lokasi as lokasi_ac, unit_acs.merk as ac_merk');
        $this->db->join('motors', 'motors.id = jadwal_services.motor_id', 'left');
        $this->db->join('unit_acs', 'unit_acs.id = jadwal_services.unit_ac_id', 'left');
        return $this->db->get_where('jadwal_services', ['jadwal_services.id' => $id])->row();
    }

    public function get_mendekati($days = 3) {
        $today = date('Y-m-d');
        $limit_date = date('Y-m-d', strtotime("+$days days"));
        $this->db->select('jadwal_services.*, motors.nama_pemilik, motors.nomor_polisi, unit_acs.nama_unit, unit_acs.lokasi as lokasi_ac');
        $this->db->join('motors', 'motors.id = jadwal_services.motor_id', 'left');
        $this->db->join('unit_acs', 'unit_acs.id = jadwal_services.unit_ac_id', 'left');
        $this->db->where('jadwal_services.status', 'dijadwalkan');
        $this->db->where('jadwal_services.tanggal_jadwal >=', $today);
        $this->db->where('jadwal_services.tanggal_jadwal <=', $limit_date);
        $this->db->order_by('jadwal_services.tanggal_jadwal', 'ASC');
        return $this->db->get('jadwal_services')->result();
    }

    public function get_jadwal_ac_mendatang() {
        $today = date('Y-m-d');
        $this->db->select('jadwal_services.*, unit_acs.nama_unit, unit_acs.lokasi as lokasi_ac');
        $this->db->join('unit_acs', 'unit_acs.id = jadwal_services.unit_ac_id', 'left');
        $this->db->where('jadwal_services.jenis_service', 'ac');
        $this->db->where('jadwal_services.status', 'dijadwalkan');
        $this->db->where('jadwal_services.tanggal_jadwal >=', $today);
        $this->db->order_by('jadwal_services.tanggal_jadwal', 'ASC');
        return $this->db->get('jadwal_services')->result();
    }

    public function count_mendekati($days = 3) {
        $today = date('Y-m-d');
        $limit_date = date('Y-m-d', strtotime("+$days days"));
        $this->db->where('status', 'dijadwalkan');
        $this->db->where('tanggal_jadwal >=', $today);
        $this->db->where('tanggal_jadwal <=', $limit_date);
        return $this->db->count_all_results('jadwal_services');
    }

    public function insert($data) {
        return $this->db->insert('jadwal_services', $data);
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update('jadwal_services', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('jadwal_services');
    }

    public function selesai($id) {
        return $this->db->where('id', $id)->update('jadwal_services', ['status' => 'selesai', 'updated_at' => date('Y-m-d H:i:s')]);
    }

    public function get_for_dashboard($limit = 10) {
        $today = date('Y-m-d');
        $limit_date = date('Y-m-d', strtotime('+3 days'));
        $this->db->select('jadwal_services.*, motors.nama_pemilik, motors.nomor_polisi, unit_acs.nama_unit, unit_acs.lokasi as lokasi_ac');
        $this->db->join('motors', 'motors.id = jadwal_services.motor_id', 'left');
        $this->db->join('unit_acs', 'unit_acs.id = jadwal_services.unit_ac_id', 'left');
        $this->db->where('jadwal_services.status', 'dijadwalkan');
        $this->db->where('jadwal_services.tanggal_jadwal <=', $limit_date);
        $this->db->order_by('jadwal_services.tanggal_jadwal', 'ASC');
        return $this->db->get('jadwal_services', $limit)->result();
    }
}

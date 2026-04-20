<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aduan_model extends CI_Model {

    protected $table = 'aduan';

    public function get_all($search = '', $status = '', $limit = null, $offset = null) {
        $this->db->select('*');
        $this->db->from($this->table);
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_pelapor', $search);
            $this->db->or_like('isi_aduan', $search);
            $this->db->group_end();
        }
        
        if (!empty($status)) {
            $this->db->where('status', $status);
        }
        
        $this->db->order_by('created_at', 'DESC');
        
        if ($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    public function count_all($search = '', $status = '') {
        $this->db->from($this->table);
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('nama_pelapor', $search);
            $this->db->or_like('isi_aduan', $search);
            $this->db->group_end();
        }
        
        if (!empty($status)) {
            $this->db->where('status', $status);
        }
        
        return $this->db->count_all_results();
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }
    
    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
}

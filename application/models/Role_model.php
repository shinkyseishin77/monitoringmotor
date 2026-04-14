<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model {
    public function get_permissions($role_id) {
        return $this->db->get_where('role_permissions', ['role_id' => $role_id])->result();
    }
}

<?php

class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getAllUsers(){
        $query = $this->db->get('user');
        return $query->result_array();
    }
    
    public function insertUser($data) {
        return $this->db->insert('user', $data);
    }

    public function loginUser($name, $pwd) {
        $user = $this->findUserByName($name);
        if ($user != null) {
            if ($user['user_pwd'] == $pwd)
                return 2;
            else
                return 1;
        } else
        return 0;
    }

    public function findUserByName($name) {
        $query = $this->db->get_where('user', array('user_name' => $name));
        if ($query->num_rows() > 0)
            return $query->result_array()[0];
        else return null;
    }

    public function updateUser($id, $data) {
        $this->db->where(array('user_id'=>$id));
        return $this->db->update('user', $data);
    }

    public function getUser($userId) {
        $query = $this->db->get_where('user', array('user_id' => $userId));
        if ($query->num_rows() > 0)
            return $query->result_array()[0];
        else
            return null;
    }
}

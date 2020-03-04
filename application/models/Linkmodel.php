<?php

class LinkModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function getById($id) {
        $this->db->from('link');
	$this->db->where('id', $id);
	$query = $this->db->get();
	return $query->result_array();
    }

    public function getAllLinks() {
        $this->db->from('link');
        $this->db->order_by('campaign_id', 'asc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getAllCampaignIds() {
        $this->db->group_by('campaign_id');
        $this->db->select('campaign_id');
        $query = $this->db->get('link');
        return $query->result_array();
    }
    
    public function insertLink($data) {
        return $this->db->insert('link', $data);
    }

    public function deleteLink($id) {
        return $this->db->delete('link', array('id' => $id));
    }

    public function updateLink($id, $data) {
        $this->db->where(array('id' => $id));
        return $this->db->update('link', $data);
    }
}

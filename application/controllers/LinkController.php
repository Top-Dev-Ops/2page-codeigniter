<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LinkController extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('string');
		$this->load->helper('url');
		$this->load->model('statusmodel');
		$this->load->model('linkmodel');
	}

	public function index()
	{
		$all = $this->linkmodel->getAllLinks();
		$campaign_ids = $this->linkmodel->getAllCampaignIds();
		$data['links'] = $all;
		$data['campaign_ids'] = $campaign_ids;
		$this->load->view('link', $data);
	}

	public function insert()
	{
		$campaign_id = $this->input->get('new_campaign_id');
		$real_link = $this->input->get('new_real_link');
		$filter_link = $this->input->get('new_filter_link');
		$row = array(
			'campaign_id' => $campaign_id,
			'real_link' => $real_link,
			'filter_link' => $filter_link,
			'state' => 'green' 
		);
		$this->linkmodel->insertLink($row);
		redirect('../../link');
	}

	public function update()
	{
		$id = $this->input->get('update_id');
		$real_link = $this->input->get('update_real_link');
		$filter_link = $this->input->get('update_filter_link');
		$row = array(
			'real_link' => $real_link,
			'filter_link' => $filter_link,
		);
		$this->linkmodel->updateLink($id, $row);
		redirect('../../link');
	}

	public function delete()
	{
		$id = $this->input->get('id');
		$this->linkmodel->deleteLink($id);
		$this->statusmodel->deleteClick($id);
		$result['success'] = true;
		echo json_encode($result);
	}
}

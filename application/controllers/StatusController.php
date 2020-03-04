<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StatusController extends CI_Controller {

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
		$all = $this->statusmodel->getAll();
		$status = array();
		foreach($all as $each) {
			if(array_key_exists($each['campaign_id'], $status)){
				if($each['is_real'] == 1) {
					$status[$each['campaign_id']]['real_traffic']++;
				} else {
					$status[$each['campaign_id']]['filter_traffic']++;
				}
			} else {
				if($each['is_real'] == 1) {
					$new_array = array(
						'campaign_id'=> $each['campaign_id'],
						'real_traffic' => 1,
						'filter_traffic' => 0 
					);
				} else {
					$new_array = array(
						'campaign_id'=> $each['campaign_id'],
						'real_traffic' => 0,
						'filter_traffic' => 1 
					);
				}
				
				$status[$each['campaign_id']] = $new_array;
			}
		}
		$data['status'] = $status;
		$this->load->view('status', $data);
	}

	public function getAll() {
		$all = $this->statusmodel->getAll();
		//$allCampaignIds = $this->linkmodel->getAllCampaignIds();
		//foreach($allCampaignIds as each) {
			
		//}
		$status = array();
		foreach($all as $each) {
			if(array_key_exists($each['campaign_id'], $status)){
				if($each['is_real'] == 1) {
					$status[$each['campaign_id']]['real_traffic']++;
				} else {
					$status[$each['campaign_id']]['filter_traffic']++;
				}
			} else {
				if($each['is_real'] == 1) {
					$new_array = array(
						'campaign_id'=> $each['campaign_id'],
						'real_traffic' => 1,
						'filter_traffic' => 0 
					);
				} else {
					$new_array = array(
						'campaign_id'=> $each['campaign_id'],
						'real_traffic' => 0,
						'filter_traffic' => 1 
					);
				}
				
				$status[$each['campaign_id']] = $new_array;
			}
		}
		$result['data'] = $status;
		$result['success'] = true;
		echo json_encode($result);
	}

	public function insert()
	{
		$id = $this->input->get('id');
		$is_real = $this->input->get('is_real');
		$link = $this->linkmodel->getById($id);
		if(count($link) > 0) {
			$data = array(
				'link_id' => $id,
				'click_date' => date('Y-m-d'),
				'is_real' => $is_real,
			);
			if($is_real < 2) {
				$this->statusmodel->insertClick($data);
				$result['success'] = true;
			} else {
				$result['success'] = false;
			}
		} else {
			$result['success'] = false;
		}
		//$result['success'] = true;
		echo json_encode($result);
	}

	public function delete()
	{
		$id = $this->input->get('id');
		$this->linkmodel->deleteLink($id);
		$this->statusmodel->deleteClick($id);
		$result['success'] = true;
		echo json_encode($result);
	}

	

	public function remove() {
		$id = $this->input->get('id');
		$this->linkmodel->deleteLink($id);
		$this->statusmodel->deleteClick($id);
		$result['success'] = true;
		echo json_encode($result);
	}

	public function send()
	{
		$this->load->library('email');
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'greatitteam0723@gmail.com',
			'smtp_pass' => 'visioncountry0723'
		);
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		$to = $this->input->get('to');
		$subject = $this->input->get('subject');
		$message = $this->input->get('message');
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->from('greatitteam0723@gmail.com');
		if($this->email->send()) {
			redirect('../../status');
		} else {
			echo "Error!";
		}
	}
		
	public function getByOption()
	{
		$option = $this->input->get('option');
		$from_year = $this->input->get('from_year');
		$from_month = $this->input->get('from_month') + 1;
		$from_day = $this->input->get('from_day');
		$to_year = $this->input->get('to_year');
		$to_month = $this->input->get('to_month') + 1;
		$to_day = $this->input->get('to_day');
		if($from_month < 10) {
			if($from_day < 10) {
				$from_date = $from_year.'-0'.$from_month.'-0'.$from_day;
			} else {
				$from_date = $from_year.'-0'.$from_month.'-'.$from_day;
			}
		} else {
			if($from_day < 10) {
				$from_date = $from_year.'-'.$from_month.'-0'.$from_day;
			} else {
				$from_date = $from_year.'-'.$from_month.'-'.$from_day;
			}
			
		}

		if($to_month < 10) {
			if($to_day < 10) {
				$to_date = $to_year.'-0'.$to_month.'-0'.$to_day;
			} else {
				$to_date = $to_year.'-0'.$to_month.'-'.$to_day;
			}
		} else {
			if($to_day < 10) {
				$to_date = $to_year.'-'.$to_month.'-0'.$to_day;
			} else {
				$to_date = $to_year.'-'.$to_month.'-'.$to_day;
			}
			
		}
		$real_clicks = $this->statusmodel->getReal();
		$filter_clicks = $this->statusmodel->getFilter();
		if($option === 'Daily') {
			$all = $this->statusmodel->getDaily($from_date);
		} else if($option === 'Monthly') {
			$all = $this->statusmodel->getMonthly($from_year, $from_month);
		} else if($option === 'Yearly') {
			$all = $this->statusmodel->getYearly($from_year);
		} else {
			$all = $this->statusmodel->getRange($from_date, $to_date);
		}
		$status = array();
		$colors = array();
		$clicks = array();
		$all_ids = $this->linkmodel->getAllCampaignIds();
		foreach($all_ids as $each) {
			$new_array = array('real' => 0, 'filter' => 0);
			$clicks[$each['campaign_id']] = $new_array;
		}

		foreach($real_clicks as $real_click) {
			$clicks[$real_click['campaign_id']]['real'] += $real_click['real'];
		}
		foreach($filter_clicks as $filter_click) {
			$clicks[$filter_click['campaign_id']]['filter'] += $filter_click['filter'];
		}

		foreach($all_ids as $each) {
			if(!array_key_exists($each['campaign_id'], $status)) {
				$new_array = array(
					'campaign_id' => $each['campaign_id'],
					'real_traffic' => 0,
					'filter_traffic' => 0,
					'color' => 'black',
				);
				if($clicks[$each['campaign_id']]['real'] != 0 && $clicks[$each['campaign_id']]['filter'] != 0) {
					if($clicks[$each['campaign_id']]['real'] * 100 < $clicks[$each['campaign_id']]['filter'])
						$new_array['color'] = 'red';
					else
						$new_array['color'] = 'green';
				}
				$status[$each['campaign_id']] = $new_array;
			}
			//$new_array = array('real' => 0, 'filter' => 0);
			//$clicks[$each['campaign_id']] = $new_array;
			
		}

		//foreach($real_clicks as $real_click) {
		//	$clicks[$real_click['campaign_id']]['real'] += $real_click['real'];
		//}
		//foreach($filter_clicks as $filter_click) {
		//	$clicks[$filter_click['campaign_id']]['filter'] += $filter_click['filter'];
		//}
		foreach($all as $each) {
			if(array_key_exists($each['campaign_id'], $status)){
				if($each['is_real'] == 1) {
					$status[$each['campaign_id']]['real_traffic']++;
				} else {
					$status[$each['campaign_id']]['filter_traffic']++;
				}
			} else {
				if($each['is_real'] == 1) {
					$new_array = array(
						'campaign_id'=> $each['campaign_id'],
						'real_traffic' => 1,
						'filter_traffic' => 0,
						'color' => 'black',
					);
				} else {
					$new_array = array(
						'campaign_id'=> $each['campaign_id'],
						'real_traffic' => 0,
						'filter_traffic' => 1,
						'color' => 'black', 
					);
				}
				if($clicks[$each['campaign_id']]['real'] != 0 && $clicks[$each['campaign_id']]['filter'] != 0) {
					if($clicks[$each['campaign_id']]['real'] * 100 < $clicks[$each['campaign_id']]['filter'])
						$new_array['color'] = 'red';
					else
						$new_array['color'] = 'green';
				}
				$status[$each['campaign_id']] = $new_array;
			}
		}
		$result['success'] = true;
		$result['data'] = $status;
		// echo json_encode($status);
		echo json_encode($result);
	}
}

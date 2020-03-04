<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->load->helper('string');
        $this->load->helper('url');
        $this->load->library('session');
		$this->load->model('usermodel');
	}

	public function index($msg=null)
	{
		$data['msg'] = $msg;
		$this->load->view('login', $data);
	}

	public function login()
	{

		// $this->load->library('session');
		$id = $this->input->get('user_name');
		$pwd = $this->input->get('user_pwd');
		// $result['data'] = $id;
		$login = $this->usermodel->loginUser($id, $pwd);
		if($login == 2)
		{
			$result['success'] = true;
			$user = $this->usermodel->findUserByName($id);
			$sessionarray = array(
				'logged_in' => 'true',
				'user_name' => $user['user_name']
			);
			$this->session->set_userdata($sessionarray);
			redirect('../../status');
		} else if($login == 1){
			$result['success'] = false;
			$result['msg'] = "Wrong password!";
			redirect('../../login');
		} else if($login == 1){
			$result['success'] = false;
			$result['msg'] = "Wrong username!";
			redirect('../../login');
		}
		redirect('../../login');
		echo json_encode($result);
	}

	public function logout()
	{
		$this->load->library('session');
		$this->session->unset_userdata(array('logged_in', 'user_name'));
		redirect('../../login');
	}
}

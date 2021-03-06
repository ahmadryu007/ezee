<?php

class Main extends CI_Controller{
	function __construct(){
		parent::__construct();
		$this->user	= unserialize(base64_decode($this->session->userdata('user')));
	}

	function index(){
		$data['user'] = $this->user;
		$data['error'] = $this->session->flashdata('err_login');
		$data['base_url'] = $this->config->item('base_url');

		if (empty($this->session->userdata('user'))){
			$this->load->view('login', $data);
		}else{
			$this->page('admin_ezeelink','dashboard');
		}
	}

	function page($kat,$hal){
		$data['user'] = $this->user;
		$data['base_url'] = $this->config->item('base_url');
		$data['halaman'] = $kat."/".$hal;
		$this->load->view('main',$data);	
	}

	function login(){
		$data['base_url'] = $this->config->item('base_url');
		$this->load->view('login',$data);
	}
}

/* Akhir file */
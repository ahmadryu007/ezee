<?php
	class MerchantDashboard extends CI_Controller{

		function __construct(){
			parent::__construct();

			if (empty($this->session->userdata('user'))){
				redirect('main');
			}

			$this->user	= unserialize(base64_decode($this->session->userdata('user')));
			
		}

		function index(){
			$data['base_url'] = $this->config->item('base_url');

			$this->load->view('admin_merchant/header', $data);
			$this->load->view('admin_merchant/dashboard', $data);
			$this->load->view('admin_merchant/footer', $data);
		}

	}
?>
<?php
	class MerchantProduk extends CI_Controller{

		function __construct(){
			parent::__construct();
		}

		function index(){
			$data['base_url'] = $this->config->item('base_url');

			$this->load->view('admin_merchant/header', $data);
			$this->load->view('admin_merchant/dataProduk', $data);
			$this->load->view('admin_merchant/footer', $data);
		}
	}
?>
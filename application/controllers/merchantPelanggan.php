<?php
	class MerchantPelanggan extends CI_Controller{

		function __construct(){
			parent::__construct();
		}

		function index(){
			$data['base_url'] = $this->config->item('base_url');

			$this->load->view('admin_merchant/header', $data);
			$this->load->view('admin_merchant/dataPelanggan', $data);
			$this->load->view('admin_merchant/footer', $data);
		}
	}
?>
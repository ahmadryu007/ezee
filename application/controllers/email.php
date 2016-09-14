<?php
	class email extends CI_Controller {
		
		public function index()
		{
			$this->load->helper('form');
			$this->load->view('v_email');
		}
		
		public function kirim()
		{
			$this->load->helper(array('form', 'url'));
			$this->load->library('upload');
			//$this->load->library('email');

			$config = Array(
			    'protocol' => 'smtp',
			    'smtp_host' => 'ssl://smtp.googlemail.com',
			    'smtp_port' => 465,
			    'smtp_user' => 'krisman.ryuzaki@gmail.com',
			    'smtp_pass' => '.,@alfiah',
			    'mailtype'  => 'text', 
			    'charset'   => 'iso-8859-1'
			);
			$this->load->library('email', $config);
			$this->email->set_newline("\r\n");

			// Set to, from, message, etc
			//konfigurasi pengiriman
			$this->email->from($this->input->post('from'));
			$this->email->to($this->input->post('to'));
			$this->email->subject($this->input->post('subject'));
			$this->email->message($this->input->post('isi'));
			
			//Configure upload.
			/*
			$this->upload->initialize(array(
            "upload_path"   => "./uploads/",
			"allowed_types" => "*"
			));
			
			//Perform upload.
			if($this->upload->do_multi_upload("lampiran"))
				{
				
				$lamp = $this->upload->get_multi_upload_data();
				foreach ($lamp as $key=>$value)
				{
					$this->email->attach($value['full_path']);
				}
			}else
			{
				echo $this->upload->display_errors();	
			}
			*/
			
			if($this->email->send())
			{
				echo "berhasil mengirim email";
			}else
			{
				echo "gagal mengirim email";
			}
			
		}
	}
?>
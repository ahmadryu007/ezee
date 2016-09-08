<?php
	class MerchantPelanggan extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();

			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('admin_merchant/mPelangganMerchant', '', true);
			$this->file_path = realpath(APPPATH . '../assets');

			if (empty($this->session->userdata('user'))){
				redirect('main');
			}

			$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		}

		function index($offset=0, $order_column='PelangganID', $order_type='asc'){
			
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;
			$data['base_url'] = $this->config->item('base_url');

			if(!empty($search))
				$this->limit = $this->mPelangganMerchant->count_all($this->user['id']);

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'PelangganID';
			if (empty($order_type)) $order_type = 'asc';

			$cust = $this->mPelangganMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('merchantPelanggan/index/');
			$config['total_rows'] = $this->mPelangganMerchant->count_all($this->user['id']);
			$config['per_page'] = $this->limit;
			$config['uri_segment'] = 3;
			$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['attributes'] = array('class' => 'li pagination'); 
			$this->pagination->initialize($config);
			$data['pagination'] = $this->pagination->create_links();

			// generate table data
			$this->load->library('table');
			$config['attributes']['rel'] = FALSE;
			$template = array(
        				'table_open'            => '<table class="table table-bordered table-striped" id="lineItemTable">',
        				'table_close'           => '</table>'
			);

			$this->table->set_template($template);


			$this->table->set_empty(" ");
			$new_order = ($order_type=='asc'?'desc':'asc');
			$this->table->set_heading('<input type="checkbox" name="idxall" value="all" id="checkMaster" onclick="clickAll()">','No',
				anchor('merchantPelanggan/index/'.$offset.'/PelangganID/'.$new_order,'PelangganID'),
				anchor('merchantPelanggan/index/'.$offset.'/Nama/'.$new_order,'Nama','Nama Pelanggan'),
				anchor('merchantPelanggan/index/'.$offset.'/Alamat/'.$new_order,'Alamat'),
				anchor('merchantPelanggan/index/'.$offset.'/Kota/'.$new_order,'Kota'),
				'Aksi');
			$i=0 + $offset;
			foreach ($cust as $c) {
				$this->table->add_row( '<input type="checkbox" name="'.$i.'" value="'.$c->PelangganID.'" onchange="cek()">', 
					++$i, $c->PelangganID, $c->Nama,
					$c->Alamat, $c->Kota, 
					'<a href="'.$this->config->item('base_url').'index.php/merchantPelanggan/updateKartu/'.$c->PelangganID.'"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('merchantPelanggan/delete/'.$c->PelangganID, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Kartu Ini ?')"))
					);
			}

			$data['table'] = $this->table->generate();

			if ($this->uri->segment(3) == 'delete_success')
				$data['message'] = 'Data Berhasil Dihapus';
			else if ($this->uri->segment(3) == 'add_success')
				$data['message'] = 'Data Berhasil Ditambah';
			else if ($this->uri->segment(3) == 'update_success')
				$data['message'] = 'Data Berhasil Diupdate';
			else
				$data['message'] = '';

			//============================================
			//data jumlah pelanggan merchant
			$data['jumlahPelanggan'] = $this->mPelangganMerchant->count_all($this->user['id']);

			$this->load->view('admin_merchant/header', $data);
			$this->load->view('admin_merchant/dataPelanggan', $data);
			$this->load->view('admin_merchant/footer', $data);
		}

		function download_csv(){
			$this->load->model('admin_merchant/mPelangganMerchant');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mPelangganMerchant->get_all_data($this->user['id']);

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_merchant_pelanggan/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_merchant_pelanggan/csv_file.xls');
    		$name = 'Customer-Merchant-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function download_pdf(){
			$this->load->library('cezpdf');
		    $db_data = array();
		    $db_data = $this->mPelangganMerchant->get_all_data($this->user['id'])->result_array();
		    $jumlah = $this->input->get('jumlah');
		    $idx=0;
		    for($i=0;$i<$jumlah;$i++){
		    	$idx++;
		    	$db_data[] = $this->mKartu->get_by_id($this->input->get($idx))->row_array();
		    }

		    $col_names = array();
		    $this->cezpdf->ezTable($db_data);
		    $this->cezpdf->ezStream();
		}

	}
?>
<?php
	class MerchantTransaksi extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();

			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('admin_merchant/mTransaksiMerchant', '', true);
			$this->file_path = realpath(APPPATH . '../assets');

			if (empty($this->session->userdata('user'))){
				redirect('main');
			}

			$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		}

		function index($offset=0, $order_column='TransaksiID', $order_type='asc'){
			
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;
			$data['base_url'] = $this->config->item('base_url');

			if(!empty($search))
				$this->limit = $this->mTransaksiMerchant->count_all($this->user['id']);

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'TransaksiID';
			if (empty($order_type)) $order_type = 'asc';

			$transaksi = $this->mTransaksiMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('merchantTransaksi/index/');
			$config['total_rows'] = $this->mTransaksiMerchant->count_all($this->user['id']);
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
				anchor('merchantTransaksi/index/'.$offset.'/TransaksiID/'.$new_order,'TransaksiID'),
				anchor('merchantTransaksi/index/'.$offset.'/TokoID/'.$new_order,'TokoID'),
				anchor('merchantTransaksi/index/'.$offset.'/Alamat/'.$new_order,'Alamat'),
				anchor('merchantTransaksi/index/'.$offset.'/NamaProduk/'.$new_order,'Nama Produk'),
				anchor('#', 'Jumlah Bayar'),
				anchor('merchantTransaksi/index/'.$offset.'/TanggalTransaksi/'.$new_order,'TanggalTransaksi')
				);
			$i=0 + $offset;
			foreach ($transaksi as $c) {
				$jumlah = $c->HargaPerUnit * $c->Kuantitas;
				$jumlahBayar = $jumlah - ($jumlah * $c->Diskon);
				$this->table->add_row( '<input type="checkbox" name="'.$i.'" value="'.$c->TransaksiID.'" onchange="cek()">', 
					++$i, $c->TransaksiID, $c->TokoID, $c->Alamat,
					$c->NamaProduk, $jumlahBayar, $c->TanggalTransaksi
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
			//data jumlah transaksi merchant
			$data['jumlahTransaksi'] = $this->mTransaksiMerchant->count_all($this->user['id']);

			$transaksi = $this->mTransaksiMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();


			$this->load->view('admin_merchant/header',$data);
			$this->load->view('admin_merchant/dataTransaksi', $data);
			$this->load->view('admin_merchant/footer',$data);
		}
		function download_csv(){
			$this->load->model('admin_merchant/mTransaksiMerchant');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mTransaksiMerchant->get_all_data($this->user['id']);

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_merchant_transaksi/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_merchant_transaksi/csv_file.xls');
    		$name = 'Transaksi-Merchant-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function download_pdf(){
			$this->load->library('cezpdf');
		    $db_data = array();
		    $db_data = $this->mTransaksiMerchant->get_all_data($this->user['id'])->result_array();
		    $jumlah = $this->input->get('jumlah');
		    $idx=0;
		    for($i=0;$i<$jumlah;$i++){
		    	$idx++;
		    	$db_data[] = $this->mTransaksiMerchant->get_by_id($this->input->get($idx))->row_array();
		    }

		    $col_names = array();
		    $this->cezpdf->ezTable($db_data);
		    $this->cezpdf->ezStream();
		}
	}
?>
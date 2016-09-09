<?php
	class MerchantProduk extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();

			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('admin_merchant/mProdukMerchant', '', true);
			$this->file_path = realpath(APPPATH . '../assets');

			if (empty($this->session->userdata('user'))){
				redirect('main');
			}

			$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		}

		function index($offset=0, $order_column='ProdukID', $order_type='asc'){
			
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;
			$data['base_url'] = $this->config->item('base_url');

			if(!empty($search))
				$this->limit = $this->mProdukMerchant->count_all($this->user['id']);

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'ProdukID';
			if (empty($order_type)) $order_type = 'asc';

			$proudk = $this->mProdukMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('merchantProduk/index/');
			$config['total_rows'] = $this->mProdukMerchant->count_all($this->user['id']);
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
				anchor('merchantProduk/index/'.$offset.'/ProdukID/'.$new_order,'ProdukID'),
				anchor('merchantProduk/index/'.$offset.'/Kategori/'.$new_order,'Kategori'),
				anchor('merchantProduk/index/'.$offset.'/NamaProduk/'.$new_order,'NamaProduk'),
				anchor('merchantProduk/index/'.$offset.'/KuantitasPerUnit/'.$new_order,'KuantitasPerUnit'),
				anchor('merchantProduk/index/'.$offset.'/HargaPerUnit/'.$new_order,'HargaPerUnit'),
				'Aksi');
			$i=0 + $offset;
			foreach ($proudk as $c) {
				$this->table->add_row( '<input type="checkbox" name="ck'.$i.'" value="'.$c->ProdukID.'" onchange="cek()">', 
					++$i, $c->ProdukID, $c->NamaKategori,
					$c->NamaProduk, $c->KuantitasPerUnit, $c->HargaPerUnit,
					'<a href="'.$this->config->item('base_url').'index.php/merchantProduk/updateProduk/'.$c->ProdukID.'"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('merchantProduk/delete/'.$c->ProdukID, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Produk Ini ?')"))
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

			// ============================================
			// data jumlah produk merchant
			$data['jumlahProduk'] = $this->mProdukMerchant->count_all($this->user['id']);

			// ============================================
			// data produk paling diminati pria
			$data['highProdukPria'] = $this->mProdukMerchant->get_highProdukPria($this->user['id']);

			// ============================================
			// data produk paling diminati wanita
			$data['highProdukWanita'] = $this->mProdukMerchant->get_highProdukWanita($this->user['id']);

			// ============================================
			// data jumlah kategori produk merchant
			$data['jumlahKategoriProduk'] = $this->mProdukMerchant->get_jumlahKategoriProduk($this->user['id']);

			$this->load->view('admin_merchant/header', $data);
			$this->load->view('admin_merchant/dataProduk', $data);
			$this->load->view('admin_merchant/footer', $data);
		}

		function download_csv(){
			$this->load->model('admin_merchant/mProdukMerchant');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mProdukMerchant->get_all_data($this->user['id']);

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_merchant_produk/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_merchant_produk/csv_file.xls');
    		$name = 'Product-Merchant-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function download_pdf(){
			$this->load->library('cezpdf');
		    $db_data = array();
		    $row_data = array();
		    $jumlah = $this->mProdukMerchant->count_all($this->user['id']);

		    for($i=0;$i <= $jumlah; $i++){
		    	$id = '';
		    	$id = $this->input->post('ck'.$i);
		    	if ($id != '')
		    		$row_data[] = $this->mProdukMerchant->get_by_id($id)->row_array();
		    }

		    $db_data = $row_data;

		    $col_names = array();
		    $this->cezpdf->ezTable($db_data);
		    $this->cezpdf->ezStream();
		}

		function addProduk(){
			$data['base_url'] = $this->config->item('base_url');

			$this->load->view('admin_merchant/header', $data);
			$this->load->view('admin_merchant/addMerchantProduk', $data);
			$this->load->view('admin_merchant/footer', $data);
		}
	}
?>
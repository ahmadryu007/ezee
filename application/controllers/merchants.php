<?php 
	class Merchants extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();
			#load library dan helper
			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url'));
			$this->load->model('mMerchant','',true);
			$this->file_path = realpath(APPPATH . '../assets');
			
			// cek login
			if (empty($this->session->userdata('user'))){
				redirect('main');
			}
		}
		fuction test(){
		}

		function index($offset=0, $order_column='MerchantID', $order_type='asc'){
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['base_url'] = $this->config->item('base_url');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;

			if(!empty($search))
				$this->limit = $this->mMerchant->count_all();

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'MerchantID';
			if (empty($order_type)) $order_type = 'asc';

			$paged_merchant = $this->mMerchant->get_paged_list($this->limit, $offset, $order_column, 
				$order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('merchants/index/');
			$config['total_rows'] = $this->mMerchant->count_all();
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
			$template = array('table_open' => '<table class="table table-bordered table-striped" id="lineItemTable">');
			$this->table->set_template($template);

			$this->table->set_empty(" ");
			$new_order = ($order_type=='asc'?'desc':'asc');
			$this->table->set_heading('<input type="checkbox" name="idxall" value="all" id="checkMaster" onclick="clickAll()">', 'No',
				anchor('merchants/index/'.$offset.'/Nama/'.$new_order,'Nama'),
				anchor('merchants/index/'.$offset.'/Alamat/'.$new_order,'Alamat'),
				anchor('merchants/index/'.$offset.'/Tanggal Daftar/'.$new_order,'TanggalDaftar'),
				anchor('merchants/index/'.$offset.'/Kota/'.$new_order,'Kota'),
				anchor('merchants/index/'.$offset.'/Telepon/'.$new_order,'Telepon'),
				'Aksi');

			$i=0 + $offset;
			
			foreach ($paged_merchant as $m) {
				$this->table->add_row('<input type="checkbox" name="'.$i.'" value="'.$m->MerchantID.'" onchange="cek()">',
					++$i, $m->Nama, $m->Alamat,
					$m->TanggalDaftar, $m->Kota, $m->Telepon, 
					'<a href="'.$this->config->item('base_url').'index.php/merchants/profileMerchant/'.$m->MerchantID.'" class="btn btn-info">Profil</a>'.'&nbsp;&nbsp;&nbsp;'.
					'<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('merchants/delete/'.$m->MerchantID, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Merchant Ini ?')"))
					);
			}
			

			$data['table'] = $this->table->generate();
			if ($this->uri->segment(3) == 'delete_success')
				$data['message'] = 'Data Berhasil Dihapus';
			else if ($this->uri->segment(3) == 'add_success')
				$data['message'] = 'Data Berhasil Ditambah';
			else
				$data['message'] = '';

			$data['jumlahMerchant'] = $this->mMerchant->count_all();

			// ==================================================
			// data jumlah merchant per kota (chart)
			$data['merchantKota'] = $this->mMerchant->get_kota()->result();

			// ===================================================
			// data kota dengan merchant terbanyak
			$data['highKota'] = $this->mMerchant->get_kota()->first_row()->Kota;

			// ===================================================
			// data jumlah merchant perkategori
			$data['merchantKategori'] = $this->mMerchant->get_kategoriMerchant()->result();

			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/dataMerchant', $data);
			$this->load->view('footer', $data);
		}

		function download_csv(){
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mMerchant->get_all_data();

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_merchant/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_merchant/csv_file.xls');
    		$name = 'Merchants-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function profileMerchant($id){
			$data['base_url'] = $this->config->item('base_url');

			// ==================================================
			// data detail merchant
			$data['merchant'] = $this->mMerchant->get_by_id($id)->row();
			// ==================================================

			// ==================================================
			// data table histori transaksi merchant
			$merchantTransaksi = $this->mMerchant->get_merchantTransaksi($id)->result();
			$this->load->library('table');
			$config['attributes']['rel'] = FALSE;
			$template = array(
        				'table_open'            => '<table class="table table-bordered table-striped">',
        				'table_close'           => '</table>'
			);

			$this->table->set_template($template);

			$this->table->set_empty(" ");
			$this->table->set_heading('No','Nama Customer', 'Produk', 'Harga', 'Kuantitas','Diskon','Tempat','Tanggal');
			$i=0;
			foreach ($merchantTransaksi as $c) {
				$this->table->add_row(++$i, $c->namaCustomer, $c->NamaProduk, $c->HargaPerUnit , $c->Kuantitas, 
					$c->Diskon, $c->TempatTransaksi, $c->TanggalTransaksi
					);
			}

			$data['historiTransaksi'] = $this->table->generate();

			// ==================================================
			// data jumlah transaksi merchant
			$data['jumlahTransaksi'] = $i;

			// ==================================================
			// data rating merchant
			$data['ratingMerchant'] = $this->mMerchant->get_ratingMerchant($i);

			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/profileMerchant', $data);
			$this->load->view('footer', $data);
		}
	}
?>	
<?php
	class Transaksi extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();
			#load library dan helper
			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url'));
			$this->load->model('mTransaksi','',true);
			$this->file_path = realpath(APPPATH . '../assets');
			
			// cek login
			if (empty($this->session->userdata('user'))){
				redirect('main');
			}
		}

		function index($offset=0, $order_column='TransaksiID', $order_type='asc'){
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;

			if(!empty($search))
				$this->limit = $this->mTransaksi->count_all();

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'TransaksiID';
			if (empty($order_type)) $order_type = 'asc';

			$paged_transaksi = $this->mTransaksi->get_paged_list($this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('transaksi/index/');
			$config['total_rows'] = $this->mTransaksi->count_all();
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
				anchor('transaksi/index/'.$offset.'/TransaksiID/'.$new_order,'TransaksiID'),
				anchor('transaksi/index/'.$offset.'/MerchantID/'.$new_order,'MerchantID'),
				anchor('transaksi/index/'.$offset.'/PelangganID/'.$new_order,'PelangganID'),
				anchor('transaksi/index/'.$offset.'/TanggalTransaksi/'.$new_order,'TanggalTransaksi'),
				anchor('transaksi/index/'.$offset.'/Kota/'.$new_order,'Kota'),
				anchor('transaksi/index/'.$offset.'/Provinsi/'.$new_order,'Provinsi'));

			$i=0 + $offset;
			foreach ($paged_transaksi as $t) {
				$this->table->add_row('<input type="checkbox" name="'.$i.'" value="'.$t->TransaksiID.'" onchange="cek()">', 
					++$i, $t->TransaksiID, 
					anchor($this->config->item('base_url').'index.php/merchants/profileMerchant/'.$t->MerchantID, $t->MerchantID), 
					anchor($this->config->item('base_url').'index.php/customers/profileCustomer/'.$t->PelangganID, $t->PelangganID),
					$t->TanggalTransaksi, $t->KotaTransaksi, $t->ProvinsiTransaksi);
			}

			// ===================================================================
			// data jumlah transaksi perbulan (chart)
			$selectTahun = $this->input->post('s');
			if (empty($selectTahun)){
				$transaksiPerBulan = $this->mTransaksi->get_transaksiPerbulan()->result();
				$data['selectTahun'] = 1998;
			}else{
				$transaksiPerBulan = $this->mTransaksi->get_transaksiPerbulan($selectTahun)->result();
				$data['selectTahun'] = $selectTahun;
			}
			$jumlah = array();
			foreach ($transaksiPerBulan as $t) {
				$jumlah[] = $t->Jumlah;
			}

			$bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 
				'Oktober', 'November', 'Desember');

			$label = array();
			foreach ($transaksiPerBulan as $t) {
				$label[] = $bulan[$t->Bulan - 1];
			}

			$data['transaksiPerBulan'] = json_encode($jumlah);
			$data['labelPerBulan'] = json_encode($label);
			$data['tahun'] = $this->mTransaksi->get_tahun()->result();

			// end data jumlah transaksi perbulan (chart)

			// ===================================================================
			// data jumlah transaksi Per-Nama hari
			$selectTahun2 = $this->input->post('sTahunHari');
			$data['selectTahun2'] = $selectTahun2;
			$selectBulanHari = $this->input->post('sBulanHari');
			$data['selectBulanHari'] = $selectBulanHari;
			if (empty($selectTahun2) || empty($selectBulanHari))
				$groupHariTransaksi = $this->mTransaksi->get_groupHariTransaksi()->result();
			else
				$groupHariTransaksi = $this->mTransaksi->get_groupHariTransaksi($selectBulanHari, $selectTahun2)->result();

			$hari = array();
			foreach ($groupHariTransaksi as $h) {
				$hari[] = $h->Hari;
			}

			$hariJumlah = array(); // jumlah transaksi per nama hari
			foreach ($groupHariTransaksi as $h) {
				$hariJumlah[] = $h->Jumlah;
			}

			$data['hari'] = json_encode($hari);
			$data['hariJumlah'] = json_encode($hariJumlah);

			// end data jumlah transaksi Per-Nama hari

			// ==================================================================
			// data jumlah transaksi bulan sekarang
			$data['jumlahTransaksiBulanIni'] = $this->mTransaksi->get_jumlahTransaksiBulanIni()->row();
			// -------

			// ==================================================================
			// data jumlah transaksi perkota
			$data['kotaTransaksi'] = $this->mTransaksi->get_kotaTransaksi()->result();
			// -------

			// ==================================================================
			// data kota dengan transaksi terbanyak
			$data['highKota'] = $this->mTransaksi->get_kotaTransaksi()->first_row()->Nama;
			// -------

			// ==================================================================
			// data jumlah transaksi per kategori merchant (chart)
			$transaksiKategoriMerchant = $this->mTransaksi->get_transaksiKategoriMerchant()->result();
			$transaksiKategori = array();
			$transaksiKategoriJumlah = array();

			foreach ($transaksiKategoriMerchant as $t) {
				$transaksiKategori[] = $t->Kategori;
			}

			foreach ($transaksiKategoriMerchant as $t) {
				$transaksiKategoriJumlah[] = $t->Jumlah;
			}

			$data['transaksiKategori'] = json_encode($transaksiKategori);
			$data['transaksiKategoriJumlah'] = json_encode($transaksiKategoriJumlah);

			// ------


			$data['table'] = $this->table->generate();

			$data['base_url'] = $this->config->item('base_url');
			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/dataTransaksi', $data);
			$this->load->view('footer', $data);

		}

		function download_csv(){
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mTransaksi->get_all_data();

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_transaksi/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_transaksi/csv_file.xls');
    		$name = 'Transaksi-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

	}
?>
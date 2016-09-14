<?php
	class MerchantTransaksi extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();

			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('admin_merchant/mTransaksiMerchantMerchant', '', true);
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
				$this->limit = $this->mTransaksiMerchantMerchant->count_all($this->user['id']);

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'TransaksiID';
			if (empty($order_type)) $order_type = 'asc';

			$transaksi = $this->mTransaksiMerchantMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('merchantTransaksi/index/');
			$config['total_rows'] = $this->mTransaksiMerchantMerchant->count_all($this->user['id']);
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
				$this->table->add_row( '<input type="checkbox" name="ck'.$i.'" value="'.$c->TransaksiID.'" onchange="cek()">', 
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

			// ===================================================================
			// data jumlah transaksi perbulan (chart)
			$selectTahun = $this->input->post('s');
			if (empty($selectTahun)){
				$transaksiPerBulan = $this->mTransaksiMerchant->get_transaksiPerbulan($id)->result();
				$data['selectTahun'] = date('Y');
			}else{
				$transaksiPerBulan = $this->mTransaksiMerchant->get_transaksiPerbulan($id, $selectTahun)->result();
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
			$data['tahun'] = $this->mTransaksiMerchant->get_tahun()->result();

			// end data jumlah transaksi perbulan (chart)

			// ===================================================================
			// data jumlah transaksi Per-Nama hari
			$selectTahun2 = $this->input->post('sTahunHari');
			$data['selectTahun2'] = $selectTahun2;
			$selectBulanHari = $this->input->post('sBulanHari');
			$data['selectBulanHari'] = $selectBulanHari;
			if (empty($selectTahun2) || empty($selectBulanHari))
				$groupHariTransaksi = $this->mTransaksiMerchant->get_groupHariTransaksi()->result();
			else
				$groupHariTransaksi = $this->mTransaksiMerchant->get_groupHariTransaksi($selectBulanHari, $selectTahun2)->result();

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
			$data['jumlahTransaksiBulanIni'] = $this->mTransaksiMerchant->get_jumlahTransaksiBulanIni()->row();
			// -------

			//============================================
			//data jumlah transaksi merchant
			$data['jumlahTransaksi'] = $this->mTransaksiMerchantMerchant->count_all($this->user['id']);

			$transaksi = $this->mTransaksiMerchantMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();


			$this->load->view('admin_merchant/header',$data);
			$this->load->view('admin_merchant/dataTransaksi', $data);
			$this->load->view('admin_merchant/footer',$data);
		}
		function download_csv(){
			$this->load->model('admin_merchant/mTransaksiMerchantMerchant');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mTransaksiMerchantMerchant->get_all_data($this->user['id']);

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
		    $row_data = array();
		    $jumlah = $this->mTransaksiMerchantMerchant->count_all($this->user['id']);

		    for($i=0;$i <= $jumlah; $i++){
		    	$id = '';
		    	$id = $this->input->post('ck'.$i);
		    	if ($id != '')
		    		$row_data[] = $this->mTransaksiMerchantMerchant->get_by_id($this->user['id'], $id)->row_array();
		    }

		    $db_data = $row_data;

		    $col_names = array();
		    $this->cezpdf->ezTable($db_data);
		    $this->cezpdf->ezStream();
		}
	}
?>
<?php
	class Dashboard extends CI_Controller{
		function __construct(){
			parent::__construct();

			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('mKartu','',true);
			$this->load->model('mMerchant','',true);
			$this->load->model('mCustomer','',true);
			$this->load->model('mTransaksi','',true);
			$this->file_path = realpath(APPPATH . '../assets');
			
			// cek login
			if (empty($this->session->userdata('user'))){
				redirect('main');
			}
		}

		function index(){
			$data['base_url'] = $this->config->item('base_url');

			// =================================================
			// data jumlah customer
			$data['jumlahCust'] = $this->mCustomer->count_all();

			// =================================================
			// data jumlah transaksi bulan sekarang
			$data['jumlahTransaksiBulanIni'] = $this->mTransaksi->get_jumlahTransaksiBulanIni()->row();

			// =================================================
			// data jumlah merchant
			$data['jumlahMerchant'] = $this->mMerchant->count_all();

			// =================================================
			// data jumlah kartu
			$data['jumlahKartu'] = $this->mKartu->count_all();

			// =================================================
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

			// ==================================================
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

			// ==================================================
			// analisis jumlah pelanggan perkota
			$kota = $this->mCustomer->get_city()->result();
			$data['customerKota'] = $kota; // data banyaknya customer per kota
			
			// ==================================================
			// data jumlah merchant per kota (chart)
			$data['merchantKota'] = $this->mMerchant->get_kotaMerchant()->result();


			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/dashboard', $data);
			$this->load->view('footer', $data);
		}
	}
?>
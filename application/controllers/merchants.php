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
				'Aksi');

			$i=0 + $offset;
			
			foreach ($paged_merchant as $m) {
				$this->table->add_row('<input type="checkbox" name="'.$i.'" value="'.$m->MerchantID.'" onchange="cek()">',
					++$i, $m->Nama, 
					'<a href="'.$this->config->item('base_url').'index.php/merchants/profileMerchant/'.$m->MerchantID.'" class="btn btn-info">Profil</a>'.'&nbsp;&nbsp;&nbsp;'.
					'<a href="'.$this->config->item('base_url').'index.php/merchants/update/'.$m->MerchantID.'"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('merchants/delete/'.$m->MerchantID, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Merchant Ini ?')"))
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

			$data['jumlahMerchant'] = $this->mMerchant->count_all();

			
			// ==================================================
			// data jumlah merchant per kota (chart)
			$data['merchantKota'] = $this->mMerchant->get_kotaMerchant()->result();

			// ===================================================
			// data kota dengan merchant terbanyak
			$data['highKota'] = $this->mMerchant->get_kotaMerchant()->first_row()->Kota;

			// ===================================================
			// data jumlah merchant perkategori
			$data['merchantKategori'] = $this->mMerchant->get_kategoriMerchant()->result();

			// ===================================================
			// data jumlah toko merchant di jakarta
			$data['tokoJakarta'] = $this->mMerchant->get_merchantJakarta();

			// ===================================================
			// data jumlah toko merchant di luar jakarta
			$data['tokoLuarJakarta'] = $this->mMerchant->get_merchantLuarJakarta();

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
			$this->table->set_heading(' ','No Kartu','Tanggal', 'Jumlah Bayar(Rp.)','Nama Produk','Tempat', 'ID Toko');
			$i=0;
			foreach ($merchantTransaksi as $c) {
				$jumlah = $c->HargaPerUnit * $c->Kuantitas;
				$jumlahBayar = $jumlah - ($jumlah * $c->Diskon);
				$this->table->add_row(++$i, $c->NoKartu,
					$c->TanggalTransaksi, $jumlahBayar , $c->NamaProduk,
					$c->Alamat.', '.$c->Kota , $c->TokoID 
					);
			}

			$data['historiTransaksi'] = $this->table->generate();

			// ==================================================
			// data jumlah transaksi merchant
			$data['jumlahTransaksi'] = $i;

			// ==================================================
			// data rating merchant
			$data['ratingMerchant'] = $this->mMerchant->get_ratingMerchant($i);

			// ==================================================
			// data toko merchant
			$data['tokoMerchant'] = $this->mMerchant->get_tokoMerchant($id)->result();

			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/profileMerchant', $data);
			$this->load->view('footer', $data);
		}

		function addMerchant(){
			$data['base_url'] = $this->config->item('base_url');

			$sql = "select * from kategori_merchant";
			$kategori = $this->db->query($sql)->result();
			$data['kategori'] = $kategori;

			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/addMerchant');
			$this->load->view('footer', $data);
		}

		function addSubmit(){
			$data = array(
				'MerchantID' => $this->input->post('MerchantID'),
				'Nama' => $this->input->post('NamaMerchant'),
				'KategoriID' => $this->input->post('KategoriID'),
				'AlamatFB' => $this->input->post('AlamatFB'),
				'AlamatTW' => $this->input->post('AlamatTW'),
				'AlamatWWW' => $this->input->post('AlamatWWW'),
				'Tagline' => $this->input->post('Tagline'),
				'TanggalInput' => $this->input->post('TanggalInput'),
				'Logo' => $this->input->post('Logo'),
				'Catatan' => $this->input->post('Catatan')
				);
			$this->mMerchant->save($data);
			header("location:".$this->config->item('base_url')."index.php/merchants/index/add_success");
		}

		function delete($id){
			$this->mMerchant->delete($id);
			redirect('merchants/index/delete_success','refresh');
		}

		function update($id){
			$data['base_url'] = $this->config->item('base_url');
			$sql = "select * from kategori_merchant";
			$kategori = $this->db->query($sql)->result();
			$data['kategori'] = $kategori;

			$data['merchant'] = $this->mMerchant->get_by_id($id)->row();

			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/updateMerchant');
			$this->load->view('footer', $data);
		}

		function updateSubmit($id){
			$data = array(
				'MerchantID' => $this->input->post('MerchantID'),
				'Nama' => $this->input->post('NamaMerchant'),
				'KategoriID' => $this->input->post('KategoriID'),
				'AlamatFB' => $this->input->post('AlamatFB'),
				'AlamatTW' => $this->input->post('AlamatTW'),
				'AlamatWWW' => $this->input->post('AlamatWWW'),
				'Tagline' => $this->input->post('Tagline'),
				'TanggalInput' => $this->input->post('TanggalInput'),
				'Logo' => $this->input->post('Logo'),
				'Catatan' => $this->input->post('Catatan')
				);
			$this->mMerchant->update($id, $data);
			redirect('merchants/index/update_success', 'refresh');
		}

	}
?>	
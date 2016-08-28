<?php
	class Customers extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();
			#load liblary dan helper
			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('mCustomer','',true);
			$this->file_path = realpath(APPPATH . '../assets');
			
			// cek login
			if (empty($this->session->userdata('user'))){
				redirect('main');
			}
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
				$this->limit = $this->mCustomer->count_all();

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'PelangganID';
			if (empty($order_type)) $order_type = 'asc';

			$customers = $this->mCustomer->get_paged_list($this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('customers/index/');
			$config['total_rows'] = $this->mCustomer->count_all();
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
				anchor('customers/index/'.$offset.'/CompanyName/'.$new_order,'CompanyName'),
				anchor('customers/index/'.$offset.'/Nama/'.$new_order,'Nama'),
				anchor('customers/index/'.$offset.'/Alamat/'.$new_order,'Alamat'),
				anchor('customers/index/'.$offset.'/Kota/'.$new_order,'Kota'),
				'Aksi');
			$i=0 + $offset;
			foreach ($customers as $customer) {
				$this->table->add_row( '<input type="checkbox" name="'.$i.'" value="'.$customer->PelangganID.'" onchange="cek()">', 
					++$i, $customer->CompanyName, $customer->Nama,
					$customer->Alamat, $customer->Kota,
					'<a href="'.$this->config->item('base_url').'index.php/customers/profileCustomer/'.$customer->PelangganID.'" class="btn btn-info">Profil</a>'.'&nbsp;&nbsp;&nbsp;'.
					'<a href="#"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('customers/delete/'.$customer->PelangganID, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Customers Ini ?')"))
					);
			}

			// $data['table'] = highlight_phrase($this->table->generate(), $search, '<span style="color:#990000;">', '</span>');
			$data['table'] = $this->table->generate();

			if ($this->uri->segment(3) == 'delete_success')
				$data['message'] = 'Data Berhasil Dihapus';
			else if ($this->uri->segment(3) == 'add_success')
				$data['message'] = 'Data Berhasil Ditambah';
			else
				$data['message'] = '';

			$data['jumlahCust'] = $this->mCustomer->count_all();

			// data untuk chart analisis pekerjaan customer
			// -----------------------------------------------
			$contactTitle = $this->mCustomer->get_dataPekerjaan()->result();
			$groupContactTitle = $this->mCustomer->get_groupPekerjaan()->result();

			$dataContactTitle = array();
			$dataGroupContactTitle = array();
			foreach($contactTitle as $c){
				$dataContactTitle[] = $c->Pekerjaan;
			}
			
			foreach ($groupContactTitle as $d) {
				$dataGroupContactTitle[] = $d->Jumlah;
			}

			$data['contactTitle'] = json_encode($dataContactTitle);
			$data['groupContactTitle'] = json_encode($dataGroupContactTitle);
			//-------------------------------------------------


			// data untuk analisis kota customer
			// ------------------------------------------------
			$kota = $this->mCustomer->get_city()->result();
			$data['customerKota'] = $kota; // data banyaknya customer per kota
			// ------------------------------------------------

			// data untuk kota dengan customer terbanyak
			// ----------------------------------------------
			$data['highCity'] = $this->mCustomer->get_city()->first_row();
			// --------------------------------------------

			// data untuk chart rating pelanggan
			// ----------------------------------------------
			$data['groupRatingPelanggan'] = json_encode($this->mCustomer->get_groupRatingPelanggan());
			//-----------------------------------------------

			// data untuk chart group umur pelanggan
			// ----------------------------------------------
			$data['groupUmur'] = $this->mCustomer->get_groupUmur()->result();
			// ---------------------------------------------


			$this->load->view('header',$data);
			$this->load->view('admin_ezeelink/dataCustomer', $data);
			$this->load->view('footer',$data);
		}

		function download_csv(){
			$this->load->model('mCustomer');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mCustomer->get_all_data();

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_customer/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_customer/csv_file.xls');
    		$name = 'Customers-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function download_pdf(){
			$this->load->library('cezpdf');
		    $db_data = array();
		    $db_data = $this->mCustomer->get_all_data()->result_array();
		    $jumlah = $this->input->get('jumlah');
		    $idx=0;
		    for($i=0;$i<$jumlah;$i++){
		    	$idx++;
		    	$db_data[] = $this->mCustomer->get_by_id($this->input->get($idx))->row_array();
		    }

		    $col_names = array();
		    $this->cezpdf->ezTable($db_data);
		    $this->cezpdf->ezStream();
		}


		function delete($id){
			$this->mCustomer->delete($id);
			redirect('customer/index/delete_success', 'refresh');
		}

		function profileCustomer($id){
			$data['customer'] = $this->mCustomer->get_by_id($id)->row();
			$data['base_url'] = $this->config->item('base_url');

			// data histori transaksi
			$customerOrders = $this->mCustomer->get_transaksiPelanggan($id)->result();
			$this->load->library('table');
			$config['attributes']['rel'] = FALSE;
			$template = array(
        				'table_open'            => '<table class="table table-bordered table-striped">',
        				'table_close'           => '</table>'
			);

			$this->table->set_template($template);


			$this->table->set_empty(" ");
			$this->table->set_heading('No','Nama Merchant', 'Diskon','Tempat','Tanggal');
			$i=0;
			foreach ($customerOrders as $c) {
				$this->table->add_row(++$i, $c->Nama,
					$c->Diskon, $c->TempatTransaksi, $c->TanggalTransaksi
					);
			}

			$data['historiTransaksi'] = $this->table->generate();
			// =================================================

			// data banyaknya transaksi customer per merchant 
			$data['customerMerchant'] = $this->mCustomer->get_pelangganMerchant($id)->result();
			// =================================================

			$data['jumlahTransaksi'] = $i;
			$data['rating'] = $this->mCustomer->get_ratingPelanggan($i);

			$this->load->view('header',$data);
			$this->load->view('admin_ezeelink/profileCustomer', $data);
			$this->load->view('footer', $data);

		}
	}
?>
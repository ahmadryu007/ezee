<?php
	class MerchantToko extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();

			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('admin_merchant/mTokoMerchant', '', true);
			$this->file_path = realpath(APPPATH . '../assets');

			if (empty($this->session->userdata('user'))){
				redirect('main');
			}

			$this->user	= unserialize(base64_decode($this->session->userdata('user')));
		}

		function index($offset=0, $order_column='TokoID', $order_type='asc'){
			
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;
			$data['base_url'] = $this->config->item('base_url');

			if(!empty($search))
				$this->limit = $this->mTokoMerchant->count_all($this->user['id']);

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'TokoID';
			if (empty($order_type)) $order_type = 'asc';

			$store = $this->mTokoMerchant->get_paged_list($this->user['id'],$this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('merchantToko/index/');
			$config['total_rows'] = $this->mTokoMerchant->count_all($this->user['id']);
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
				anchor('merchantToko/index/'.$offset.'/TokoID/'.$new_order,'TokoID'),
				anchor('merchantToko/index/'.$offset.'/Alamat/'.$new_order,'Alamat'),
				anchor('merchantToko/index/'.$offset.'/Kota/'.$new_order,'Kota'),
				anchor('merchantToko/index/'.$offset.'/Provinsi/'.$new_order,'Provinsi'),
				anchor('merchantToko/index/'.$offset.'/Telepon/'.$new_order,'Telepon'),
				anchor('merchantToko/index/'.$offset.'/Email/'.$new_order,'Email'),
				anchor('merchantToko/index/'.$offset.'/TanggalInput/'.$new_order,'TanggalInput'),
				'Aksi');
			$i=0 + $offset;
			foreach ($store as $c) {
				$this->table->add_row( '<input type="checkbox" name="ck'.$i.'" value="'.$c->TokoID.'" onchange="cek()">', 
					++$i, $c->TokoID, $c->Alamat,
					$c->Kota, $c->Provinsi, $c->Telepon, $c->Email, $c->TanggalInput,
					'<a href="'.$this->config->item('base_url').'index.php/merchantToko/updateToko/'.$c->TokoID.'"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('merchantToko/delete/'.$c->TokoID, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Kartu Ini ?')"))
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
			// data jumlah toko merchant
			$data['jumlahToko'] = $this->mTokoMerchant->count_all($this->user['id']);

			// ============================================
			// data kota dengan toko merchant terbanyak
			$data['highCity'] = $this->mTokoMerchant->get_kotaTokoMerchant($this->user['id'])->first_row()->Kota;

			// ============================================
			// data toko dengan transaksi tebanyak
			$data['highStore'] = $this->mTokoMerchant->get_transaksiToko($this->user['id'])->first_row()->TokoID;


			$this->load->view('admin_merchant/header',$data);
			$this->load->view('admin_merchant/dataToko', $data);
			$this->load->view('admin_merchant/footer',$data);
		}

		function download_csv(){
			$this->load->model('admin_merchant/mTokoMerchant');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mTokoMerchant->get_all_data($this->user['id']);

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_merchant_pelanggan/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_merchant_pelanggan/csv_file.xls');
    		$name = 'Store-Merchant-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function download_pdf(){
			$this->load->library('cezpdf');
		    $db_data = array();
		    $row_data = array();
		    $jumlah = $this->mTokoMerchant->count_all($this->user['id']);

		    for($i=0;$i <= $jumlah; $i++){
		    	$id = '';
		    	$id = $this->input->post('ck'.$i);
		    	if ($id != '')
		    		$row_data[] = $this->mTokoMerchant->get_by_id($id)->row_array();
		    }

		    $db_data = $row_data;

		    $col_names = array();
		    $this->cezpdf->ezTable($db_data);
		    $this->cezpdf->ezStream();
		}
	}
?>
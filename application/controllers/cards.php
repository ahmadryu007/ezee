<?php 
	class Cards extends CI_Controller{
		private $limit = 10;

		function __construct(){
			parent::__construct();
			#load liblary dan helper
			$this->load->library(array('table', 'form_validation'));
			$this->load->helper(array('form', 'url', 'text'));
			$this->load->model('mKartu','',true);
			$this->file_path = realpath(APPPATH . '../assets');
			
			// cek login
			if (empty($this->session->userdata('user'))){
				redirect('main');
			}
		}

		function index($offset=0, $order_column='NoKartu', $order_type='asc'){
			
			if(!empty($this->input->post('limit')))
				$this->limit = $this->input->post('limit');

			$search = $this->input->post('q');
			$data['search'] = $search;
			$searchField = $this->input->post('searchField');
			$data['searchField'] = $searchField;
			$data['base_url'] = $this->config->item('base_url');

			if(!empty($search))
				$this->limit = $this->mKartu->count_all();

			if (empty($offset)) $offset = 0;
			if (empty($order_column)) $order_column = 'NoKartu';
			if (empty($order_type)) $order_type = 'asc';

			$cards = $this->mKartu->get_paged_list($this->limit, $offset, 
				$order_column, $order_type, $search, $searchField)->result();

			// generate pagination
			$this->load->library('pagination');
			$config['base_url'] = site_url('cards/index/');
			$config['total_rows'] = $this->mKartu->count_all();
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
				anchor('cards/index/'.$offset.'/UserID/'.$new_order,'UserID'),
				anchor('cards/index/'.$offset.'/NoKartu/'.$new_order,'NoKartu'),
				anchor('cards/index/'.$offset.'/FlagMain/'.$new_order,'FlagMain'),
				anchor('cards/index/'.$offset.'/FlagAktiv/'.$new_order,'FlagAktiv'),
				anchor('cards/index/'.$offset.'/TransDate/'.$new_order,'TransDate'),
				anchor('cards/index/'.$offset.'/MerchantID/'.$new_order,'MerchantID'),
				'Aksi');
			$i=0 + $offset;
			foreach ($cards as $c) {
				$this->table->add_row( '<input type="checkbox" name="'.$i.'" value="'.$c->NoKartu.'" onchange="cek()">', 
					++$i, $c->UserID, $c->NoKartu,
					$c->FlagMain, $c->FlagAktiv, $c->TransDate, $c->MerchantID,
					'<a href="'.$this->config->item('base_url').'index.php/cards/updateCard/'.$c->NoKartu.'"><span class="glyphicon glyphicon-pencil"></span></a>'.'&nbsp;&nbsp;&nbsp;'.
					anchor('cards/delete/'.$c->NoKartu, '<span class="glyphicon glyphicon-remove">', array('onclick' => "return confirm('Apakah Anda Yakin Ingin Menghapus Data Kartu Ini ?')"))
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

			// ================================================
			// data jumlah kartu
			$data['jumlahKartu'] = $this->mKartu->count_all();

			// ===============================================
			// data jumlah kartu dengan flag aktiv true
			$data['flagAktivTrue'] = $this->mKartu->get_aktivTrue();

			// ===============================================
			// data jumlah kartu dengan flag aktiv false
			$data['flagAktivFalse'] = $this->mKartu->get_aktivFalse();

			$this->load->view('header',$data);
			$this->load->view('admin_ezeelink/dataCard', $data);
			$this->load->view('footer',$data);
		}

		function download_csv(){
			$this->load->model('mKartu');
    		$this->load->dbutil();
    		$this->load->helper('file');
    
    		$report = $this->mKartu->get_all_data();

    		$delimiter = ",";
    		$newline = "\r\n";
    		$new_report = $this->dbutil->csv_from_result($report, $delimiter, $newline);
    
    		write_file($this->file_path . '/csv_card/csv_file.xls', $new_report);
    		
    		$this->load->helper('download');
    		$data = file_get_contents($this->file_path . '/csv_card/csv_file.xls');
    		$name = 'Cards-'.date('d-m-Y').'.xls';
    		force_download($name, $data);
		}

		function download_pdf(){
			$this->load->library('cezpdf');
		    $db_data = array();
		    $db_data = $this->mKartu->get_all_data()->result_array();
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

		function delete($id){
			$this->mKartu->delete($id);
			redirect('cards/index/delete_success', 'refresh');
		}

		function addCard(){
			$data['base_url'] = $this->config->item('base_url');
			$data['idPelanggan'] = $this->mKartu->get_idPelanggan()->result();
			$data['idMerchant'] = $this->mKartu->get_idMerchant()->result();


			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/addCard', $data);
			$this->load->view('footer', $data);
		}

		function addSubmit(){
			$flagMain = '';
			if ($this->input->post('FlagMain') == "T" )
				$flagMain = "T";
			else 
				$flagMain = "F";

			$flagAktiv = '';
			if ($this->input->post('FlagAktiv') == "T" )
				$flagAktiv = "T";
			else 
				$flagAktiv = "F";

			$data = array(
				'UserID' => $this->input->post('UserID'),
				'NoKartu' => $this->input->post('NoKartu'),
				'MerchantID' => $this->input->post('MerchantID'),
				'PelangganID' => $this->input->post('PelangganID'),
				'FlagMain' => $flagMain,
				'FlagAktiv' => $flagAktiv,
				'TransDate' => $this->input->post('TransDate')
				);
			$this->mKartu->save($data);
			redirect('cards/index/add_success', 'refresh');
		}

		function updateCard($no){
			$data['base_url'] = $this->config->item('base_url');
			$data['card'] = $this->mKartu->get_by_id($no)->row();
			$data['idPelanggan'] = $this->mKartu->get_idPelanggan()->result();
			$data['idMerchant'] = $this->mKartu->get_idMerchant()->result();

			$this->load->view('header', $data);
			$this->load->view('admin_ezeelink/updateCard', $data);
			$this->load->view('footer', $data);	
		}

		function updateSubmit($no){
			$flagMain = '';
			if ($this->input->post('FlagMain') == "T" )
				$flagMain = "T";
			else 
				$flagMain = "F";

			$flagAktiv = '';
			if ($this->input->post('FlagAktiv') == "T" )
				$flagAktiv = "T";
			else 
				$flagAktiv = "F";

			$data = array(
				'UserID' => $this->input->post('UserID'),
				'NoKartu' => $this->input->post('NoKartu'),
				'MerchantID' => $this->input->post('MerchantID'),
				'PelangganID' => $this->input->post('PelangganID'),
				'FlagMain' => $flagMain,
				'FlagAktiv' => $flagAktiv,
				'TransDate' => $this->input->post('TransDate')
				);
			$this->mKartu->update($no, $data);
			redirect('cards/index/update_success', 'refresh');	
		}

	}
?>
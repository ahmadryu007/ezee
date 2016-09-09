<?php 
	class MPelangganMerchant extends CI_Model{
		private $primary_key = 'PelangganID';
		private $table_name = 'pelanggan';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($merchantID, $limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='PelangganID')
		{
			if (empty($searchField))
				$searchField = 'PelangganID';
			
			if(empty($order_column) || empty($order_type) || empty($search) || empty($searchField))
			{
				$this->db->join('kartu', 'pelanggan.PelangganID = kartu.PelangganID');
				$this->db->where('MerchantID', $merchantID);
				//$this->db->order_by($this->primary_key, 'asc');
			}else{
				$this->db->join('kartu', 'pelanggan.PelangganID = kartu.PelangganID');
				$this->db->where('MerchantID', $merchantID);
				//$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			}
			return $this->db->get($this->table_name, $limit, $offset);

		}

		function count_all($id){
			$sql = "select COUNT(pelanggan.PelangganID) as Jumlah from pelanggan, kartu 
					where pelanggan.PelangganID = kartu.PelangganID 
					and kartu.MerchantID =".$id;
			return $this->db->query($sql)->row()->Jumlah;
		}

		function save($card){
			$this->db->insert($this->table_name, $card);
			return $this->db->insert_id();
		}

		function update($id, $card){
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->table_name, $card);
		}

		function delete($id){
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->table_name);
		}

		function get_all_data($id){
			$sql = "select pelanggan.Nama, pelanggan.Alamat, pelanggan.Kota, 
					pelanggan.Provinsi, pelanggan.Negara, pelanggan.Telepon, 
					pelanggan.Alamat, pelanggan.JenisKelamin, pelanggan.TanggalLahir
					from pelanggan, kartu 
					where kartu.PelangganID = pelanggan.PelangganID and 
					kartu.MerchantID =".$id;
			return $this->db->query($sql);
		}

		function get_by_id($idMerchant, $idPelanggan){
			$sql = "select pelanggan.Nama, pelanggan.Alamat, pelanggan.Kota, 
					pelanggan.Provinsi, pelanggan.Negara, pelanggan.Telepon, 
					pelanggan.Alamat, pelanggan.JenisKelamin, pelanggan.TanggalLahir
					from pelanggan, kartu 
					where kartu.PelangganID = pelanggan.PelangganID and 
					kartu.MerchantID =".$idMerchant." and pelanggan.PelangganID=".$idPelanggan;
			return $this->db->query($sql);
		}
	}
?>
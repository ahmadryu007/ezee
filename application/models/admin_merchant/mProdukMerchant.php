<?php 
	class MProdukMerchant extends CI_Model{
		private $primary_key = 'ProdukID';
		private $table_name = 'produk';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($merchantID, $limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='ProdukID')
		{
			if (empty($searchField))
				$searchField = 'ProdukID';
			
			if(empty($order_column) || empty($order_type) || empty($search) || empty($searchField))
			{
				$this->db->select(array('ProdukID', 'NamaProduk', 'NamaKategori', 'KuantitasPerUnit', 'HargaPerUnit'));
				$this->db->join('kategori_produk', 'produk.KategoriID = kategori_produk.KategoriID');
				$this->db->where('MerchantID', $merchantID);
				$this->db->order_by($this->primary_key, 'asc');
			}else{
				$this->db->select(array('ProdukID', 'NamaProduk', 'NamaKategori', 'KuantitasPerUnit', 'HargaPerUnit'));
				$this->db->join('kategori_produk', 'produk.KategoriID = kategori_produk.KategoriID');
				$this->db->where('MerchantID', $merchantID);
				$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			}
			return $this->db->get($this->table_name, $limit, $offset);

		}

		function count_all($id){
			$sql = "select COUNT(*) as Jumlah from produk where MerchantID=".$id;
			return $this->db->query($sql)->row()->Jumlah;
		}

		function save($produk){
			$this->db->insert($this->table_name, $produk);
			return $this->db->insert_id();
		}

		function update($id, $produk){
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->table_name, $produk);
		}

		function delete($id){
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->table_name);
		}

		function get_all_data($id){
			$sql = "select * from ".$this->table_name." where MerchantID=".$id;
			return $this->db->query($sql);
		}

		function get_by_id($id){
			$sql = "select * from ".$this->table_name." where ".$this->primary_key." ='".$id."' ";
			return $this->db->query($sql);
		}

		function get_highProdukPria($id){ // mendapatkan produk paling diminati pria
			$sql = "select produk.NamaProduk, COUNT(transaksi_detail.ID) as Jumlah 
					from produk, transaksi_detail, transaksi, kartu, pelanggan
					where transaksi_detail.ProdukID = produk.ProdukID and 
					transaksi_detail.TransaksiID = transaksi.TransaksiID and 
					transaksi.NoKartu = kartu.NoKartu and 
					kartu.PelangganID = pelanggan.PelangganID and 
					pelanggan.JenisKelamin like 'M' and 
					produk.MerchantID = '".$id."'
					group by produk.NamaProduk 
					order by Jumlah desc";
			return $this->db->query($sql)->first_row()->NamaProduk;
		}

		function get_highProdukWanita($id){ // mendapatkan produk paling diminati wanita
			$sql = "select produk.NamaProduk, COUNT(transaksi_detail.ID) as Jumlah 
					from produk, transaksi_detail, transaksi, kartu, pelanggan
					where transaksi_detail.ProdukID = produk.ProdukID and 
					transaksi_detail.TransaksiID = transaksi.TransaksiID and 
					transaksi.NoKartu = kartu.NoKartu and 
					kartu.PelangganID = pelanggan.PelangganID and 
					pelanggan.JenisKelamin like 'F' and 
					produk.MerchantID = '".$id."'
					group by produk.NamaProduk 
					order by Jumlah desc";
			return $this->db->query($sql)->first_row()->NamaProduk;
		}

		function get_jumlahKategoriProduk($id){
			$sql = "select distinct KategoriID from produk where MerchantID=".$id;
			return $this->db->query($sql)->num_rows();
		}

		function get_kategoriProduk(){ // mendapatkan jumlah produk per kategori
			$sql = "select kategori_produk.NamaKategori, COUNT(produk.ProdukID) as Jumlah from produk, kategori_produk 
					where kategori_produk.KategoriID = produk.KategoriID 
					group by kategori_produk.NamaKategori";
			return $this->db->query($sql);
		}
	}
?>
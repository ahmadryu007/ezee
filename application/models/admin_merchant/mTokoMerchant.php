<?php 
	class MTokoMerchant extends CI_Model{
		private $primary_key = 'TokoID';
		private $table_name = 'toko_merchant';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($merchantID, $limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='TokoID')
		{
			if (empty($searchField))
				$searchField = 'TokoID';
			
			if(empty($order_column) || empty($order_type) || empty($search) || empty($searchField))
			{
				$this->db->where('MerchantID', $merchantID);
				$this->db->order_by($this->primary_key, 'asc');
			}else{
				$this->db->where('MerchantID', $merchantID);
				$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			}
			return $this->db->get($this->table_name, $limit, $offset);

		}

		function count_all($id){
			$sql = "select COUNT(*) as Jumlah from toko_merchant where MerchantID=".$id;
			return $this->db->query($sql)->row()->Jumlah;
		}

		function save($store){
			$this->db->insert($this->table_name, $store);
			return $this->db->insert_id();
		}

		function update($id, $store){
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->table_name, $store);
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

		function get_kotaTokoMerchant($id){ // mendapatkan jumlah toko merchant per kota
			$sql = "select Kota, COUNT(TokoID) as Jumlah 
					from toko_merchant 
					where MerchantID='".$id."'
					group by Kota order by Jumlah desc";
			return $this->db->query($sql);
		}

		function get_transaksiToko($id){ // mendapatkan jumlah transaksi per toko merchant
			$sql = "select transaksi.TokoID, count(transaksi.TokoID) as jumlahTransaksi
					from transaksi, toko_merchant 
					where transaksi.TokoID = toko_merchant.TokoID and 
					toko_merchant.MerchantID = '".$id."' 
					group by transaksi.TokoID 
					order by jumlahTransaksi desc";
			return $this->db->query($sql);
		}

		function get_ratingToko($id, $jumlahTransaksi){
			$transaksiTerbanyak = $this->get_transaksiToko($id)->first_row()->jumlahTransaksi;
			$range = $transaksiTerbanyak / 5;
			$bintang = array($range * 1, $range * 2, $range * 3,$range * 4, $range * 5);
			$indeksBintang = 0;
			
			for ($i=0;$i<5;$i++){
				$indeksBintang++;
				if ($jumlahTransaksi < $bintang[$i]){
					break;
				}
			}
			return $indeksBintang;
		}

		function get_historiTransaksi($id){ // mendapatkan histori transaksi toko merchant
			$sql = "select transaksi.NoKartu, transaksi.TanggalTransaksi,  
					transaksi_detail.Kuantitas, transaksi_detail.Diskon, 
					produk.NamaProduk, produk.HargaPerUnit, kategori_produk.NamaKategori as KategoriProduk, 
					toko_merchant.Alamat, toko_merchant.Kota, 
					pelanggan.Nama, toko_merchant.TokoID
					from transaksi, transaksi_detail, produk, kategori_produk, toko_merchant, kartu, pelanggan, merchant
					where transaksi.TransaksiID = transaksi_detail.TransaksiID and 
					transaksi_detail.ProdukID = produk.ProdukID and 
					produk.KategoriID = kategori_produk.KategoriID and 
					transaksi.TokoID = toko_merchant.TokoID and 
					transaksi.NoKartu = kartu.NoKartu and 
					kartu.PelangganID = pelanggan.PelangganID and 
					toko_merchant.MerchantID = merchant.MerchantID and 
					toko_merchant.TokoID=".$id." order by TanggalTransaksi desc";
			return $this->db->query($sql);
		}
	}
?>
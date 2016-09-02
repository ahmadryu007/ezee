<?php 
	class MMerchant extends CI_Model{
		private $primary_key = 'MerchantID';
		private $table_name = 'merchant';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='Nama')
		{
			if (empty($searchField))
				$searchField = 'Nama';

			if(empty($order_column) || empty($order_type) || empty($search))
				$this->db->order_by($this->primary_key, 'asc');
			else
				$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			return $this->db->get($this->table_name, $limit, $offset);
		}

		function get_all_data(){
			$sql = "select * from ".$this->table_name;
			return $this->db->query($sql);
		}

		function save($merchant){
			$this->db->insert($this->table_name, $merchant);
			return $this->db->insert_id();
		}

		function update($id, $merchant){
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->table_name, $merchant);
		}

		function get_by_id($id){
			$sql = "select kategori_merchant.Nama as Kategori, merchant.* 
					from kategori_merchant, merchant 
					where merchant.KategoriID = kategori_merchant.KategoriID and 
					merchant.MerchantID =".$id;
			return $this->db->query($sql);
		}

		function count_all(){
			return $this->db->count_all($this->table_name);
		}

		function delete($id){
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->table_name);
		}

		function get_merchantTransaksi($id){ // function untuk mendapatkan data histori transaksi di suatu merchant
			$sql = "select [dbo].[pelanggan].[Nama] as namaCustomer, 
					[dbo].[transaksi].[TempatTransaksi], [dbo].[transaksi_detail].[Diskon], [dbo].[transaksi_detail].[Kuantitas], 
					[dbo].[transaksi].[TanggalTransaksi], [dbo].[produk].*
					from [dbo].[transaksi], [dbo].[transaksi_detail], [dbo].[merchant], [dbo].[pelanggan], [dbo].[produk]
					where [merchant].[MerchantID] = 4 and 
					[transaksi].[MerchantID] = [merchant].[MerchantID] and
					[transaksi].[TransaksiID] = [transaksi_detail].[TransaksiID] and 
					[transaksi].[PelangganID] = [pelanggan].[PelangganID] and
					[transaksi].[TransaksiID] = [transaksi_detail].[TransaksiID] and
					[transaksi_detail].[ProdukID] = [produk].[ProdukID]
					order by [dbo].[transaksi].[TanggalTransaksi] desc";
			return $this->db->query($sql);
		}

		function get_jumlahMerchantTransaksi(){ // function untuk mendapatkan jumlah transaksi merchant
			$sql = "select merchant.Nama as namaMerchant, count(transaksi_detail.TransaksiID) as jumlahTransaksi 
					from transaksi, transaksi_detail, merchant, pelanggan 
					where pelanggan.PelangganID = transaksi.PelangganID and 
					transaksi.MerchantID = merchant.MerchantID and 
					transaksi.TransaksiID = transaksi_detail.TransaksiID 
					group by merchant.Nama order by jumlahTransaksi desc";
			return $this->db->query($sql);
		}

		function get_ratingMerchant($jumlahTransaksi){
			$transaksiTerbanyak = $this->get_jumlahMerchantTransaksi()->first_row()->jumlahTransaksi;
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

		function get_kota(){ // function untuk mendapatkan jumlah merchant per kota
			$sql = "select Kota, count(MerchantID) as Jumlah from merchant group by Kota order by Jumlah desc";
			return $this->db->query($sql);
		}

		function get_kategoriMerchant(){ // mendapatkan data group kategori merchant
			$sql = "select kategori_merchant.Nama, COUNT(merchant.KategoriID)as Jumlah
					from merchant, kategori_merchant 
					where merchant.KategoriID = kategori_merchant.KategoriID group by kategori_merchant.Nama 
					order by Jumlah desc";
			return $this->db->query($sql);
		}
	}
?>
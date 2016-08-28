<?php 
	class MTransaksi extends CI_Model{

		private $table_name = 'transaksi';
		private $primary_key = 'TransaksiID';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='TransaksiID')
		{
			if (empty($searchField))
				$searchField = $this->primary_key;

			if(empty($order_column) || empty($order_type) || empty($search))
				$this->db->order_by($this->primary_key, 'asc');
			else
				$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			return $this->db->get($this->table_name, $limit, $offset);
		}

		function count_all(){
			return $this->db->count_all($this->table_name);
		}

		function get_all_data(){
			$sql = "select * from ".$this->table_name;
			return $this->db->query($sql);
		}

		function get_transaksiPerbulan($tahun=1998){
			$sql = "";
			if(empty($tahun))
				$sql = "select MONTH(TanggalTransaksi)as Bulan, COUNT(TanggalTransaksi)as Jumlah 
						from transaksi where year(TanggalTransaksi) = 1998 group by MONTH(TanggalTransaksi)";
			else
				$sql = "select MONTH(TanggalTransaksi)as Bulan, COUNT(TanggalTransaksi)as Jumlah 
						from transaksi where year(TanggalTransaksi) = ".$tahun." group by MONTH(TanggalTransaksi)";

			return $this->db->query($sql);
		}

		function get_tahun(){
			$sql = "select distinct YEAR(TanggalTransaksi) as Tahun from transaksi order by Tahun desc";
			return $this->db->query($sql);
		}

		function get_groupHariTransaksi($bulan='',$tahun=''){ // mendapatkan jumlah transaksi dalam suatu nama hari
			if (empty($bulan))
				$bulan = 'MONTH(TanggalTransaksi)';

			if (empty($tahun))
				$tahun = 'YEAR(TanggalTransaksi)';

			$sql = "SELECT datename(dw,TanggalTransaksi) as Hari, 
					(CASE WHEN DATENAME(dw, TanggalTransaksi)= 'Sunday' then 1
					WHEN DATENAME(dw, TanggalTransaksi)='Monday' THEN 2
					WHEN DATENAME(dw, TanggalTransaksi)='Tuesday' THEN 3
					WHEN DATENAME(dw, TanggalTransaksi)='Wednesday' THEN 4
					WHEN DATENAME(dw, TanggalTransaksi)='Thursday' THEN 5
					WHEN DATENAME(dw, TanggalTransaksi)='Friday' THEN 6 ELSE 7 END ) as indexHari, 
					COUNT(TransaksiID) as Jumlah
					FROM transaksi where MONTH(TanggalTransaksi) = ".$bulan." and 
					YEAR(TanggalTransaksi) = ".$tahun." 
					group by datename(dw,TanggalTransaksi) order by indexHari";
			return $this->db->query($sql);
		}

		function get_jumlahTransaksiBulanIni(){
			$sql = "select count(TransaksiID) as Jumlah from transaksi 
					where MONTH(TanggalTransaksi) = MONTH(getDate()) and 
					YEAR(TanggalTransaksi) = YEAR(getDate())";
			return $this->db->query($sql);
		}

		function get_kotaTransaksi(){ // mendapatkan jumlah transaksi perkota
			$sql ="select KotaTransaksi as Nama, count(TransaksiID) as Jumlah 
					from transaksi group by KotaTransaksi order by Jumlah desc";
			return $this->db->query($sql);
		}

		function get_transaksiKategoriMerchant(){ // mendapatkan jumlah transaksi per kategori merchant
			$sql = "select kategori_merchant.Nama as Kategori, 
					COUNT(kategori_merchant.Nama) as Jumlah 
					from transaksi, merchant, kategori_merchant 
					where transaksi.MerchantID = merchant.MerchantID and 
					merchant.KategoriID = kategori_merchant.KategoriID 
					group by kategori_merchant.Nama";
			return $this->db->query($sql);
		}
	}
?>
<?php
	class MCustomer extends CI_Model{
		private $primary_key = 'PelangganID';
		private $table_name = 'pelanggan';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='Nama')
		{
			if (empty($searchField))
				$searchField = 'Nama';
			
			if(empty($order_column) || empty($order_type) || empty($search) || empty($searchField))
				$this->db->order_by($this->primary_key, 'asc');
			else
				$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			return $this->db->get($this->table_name, $limit, $offset);
			
			/*
			$sql = "";
			if(empty($order_column) || empty($order_type) || empty($search))
				$sql = "select top ".$limit." * from ".$this->table_name." 
						where ".$this->primary_key." not in (select top ".$offset." from ".$this->table_name." ) order by ".$this->primary_key." asc ";
			else
				$sql = "select top ".$limit." * from ".$this->table_name." 
						where ".$this->primary_key." not in (select top ".$offset." from ".$this->table_name." ) order by ".$order_column." ".$order_type;
			return $this->db->query($sql);
			*/

		}

		function count_all(){
			return $this->db->count_all($this->table_name);
		}

		function get_by_id($id){
			$sql = "select *, datediff(yy,TanggalLahir,getdate()) as Umur from ".$this->table_name." 
					where ".$this->primary_key."='".$id."'";
			return $this->db->query($sql);
			// $this->db->where($this->primary_key, $id);
			// return $this->db->get($this->table_name);
		}

		function save($person){
			$this->db->insert($this->table_name, $person);
			return $this->db->insert_id();
		}

		function update($id, $person){
			$this->db->where($this->primary_key, $id);
			$this->db->update($this->table_name, $person);
		}

		function delete($id){
			$this->db->where($this->primary_key, $id);
			$this->db->delete($this->table_name);
		}

		// demo
		function get_dataPekerjaan(){
			$sql = "select distinct Pekerjaan from pelanggan";
			return $this->db->query($sql);
		}

		function get_groupPekerjaan(){
			$sql = "SELECT COUNT(".$this->primary_key.") as Jumlah FROM ".$this->table_name." GROUP BY Pekerjaan";
			return $this->db->query($sql);
		}

		function get_all_data(){
			$sql = "select * from ".$this->table_name;
			return $this->db->query($sql);
		}

		function get_transaksiPelanggan($id){ // mendapatkan informasi histori transaksi
			$sql = "select [dbo].[transaksi].*, [dbo].[transaksi_detail].*, [dbo].[merchant].* 
					from [dbo].[transaksi], [dbo].[transaksi_detail], [dbo].[merchant] 
					where [transaksi].[PelangganID] = '".$id."' and 
					[transaksi].[MerchantID] = [merchant].[MerchantID] and
					[transaksi].[TransaksiID] = [transaksi_detail].[TransaksiID]";
			return $this->db->query($sql);
		}

		function get_pelangganMerchant($id){ // function untuk mengetahui banyaknya transaksi customer per merchant
			$sql= "select merchant.Nama as NamaMerchant, count(merchant.Nama) as Jumlah 
					from transaksi, transaksi_detail, merchant 
					where transaksi.PelangganID = '".$id."' and 
					transaksi.MerchantID = merchant.MerchantID and 
					transaksi.TransaksiID = transaksi_detail.TransaksiID 
					group by merchant.Nama";
			return $this->db->query($sql);

		}

		function get_city(){ // mendapatkan informasi jumlah customer per kota
			$sql ="select Kota, count(PelangganID) as Jumlah from pelanggan group by Kota order by Jumlah desc";
			return $this->db->query($sql);
		}

		function get_customerTransaksi(){ // mendapatkan informasi jumlah transaksi per customer
			$sql = "select pelanggan.Nama as namaCustomer, count(transaksi_detail.TransaksiID) as jumlahTransaksi 
					from transaksi, transaksi_detail, merchant, pelanggan 
					where pelanggan.PelangganID = transaksi.PelangganID and 
					transaksi.MerchantID = merchant.MerchantID and 
					transaksi.TransaksiID = transaksi_detail.TransaksiID 
					group by pelanggan.Nama order by jumlahTransaksi desc";
			return $this->db->query($sql);
		}

		function get_ratingPelanggan($jumlahTransaksi){
			$transaksiTerbanyak = $this->get_customerTransaksi()->first_row()->jumlahTransaksi;
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

		function get_groupRatingPelanggan(){ // mendapatkan data untuk chart rating pelanggan
			$bintang_satu = 0;
			$bintang_dua = 0;
			$bintang_tiga = 0;
			$bintang_empat = 0; 
			$bintang_lima = 0;
			$transaksiPelanggan = $this->get_customerTransaksi()->result_array();
			foreach ($transaksiPelanggan as $t) {
				switch ($this->get_ratingPelanggan($t['jumlahTransaksi'])) {
					case '1':
						$bintang_satu++;
						break;
					case '2':
						$bintang_dua++;
						break;
					case '3':
						$bintang_tiga++;
						break;
					case '4':
						$bintang_empat++;
						break;
					case '5':
						$bintang_lima++;
						break;
					
				}
			}

			$arrGroup = array($bintang_satu, $bintang_dua, $bintang_tiga, $bintang_empat, $bintang_lima);
			return $arrGroup;
		}

		function get_groupUmur(){
			$sql = "select datediff(yy,TanggalLahir,getdate()) as Umur, 
					COUNT(datediff(yy,TanggalLahir,getdate())) as Jumlah 
					from ".$this->table_name." group by datediff(yy,TanggalLahir,getdate())";
			return $this->db->query($sql);
		}

	}
?>
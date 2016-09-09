<?php 
	class MTransaksiMerchant extends CI_Model{
		private $primary_key = 'TransaksiID';
		private $table_name = 'transaksi';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($merchantID, $limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='TransaksiID')
		{
			if (empty($searchField))
				$searchField = 'TransaksiID';
			
			if(empty($order_column) || empty($order_type) || empty($search) || empty($searchField))
			{
				$this->db->join('transaksi_detail', 'transaksi.TransaksiID = transaksi_detail.TransaksiID');
				$this->db->join('toko_merchant', 'transaksi.TokoID = toko_merchant.TokoID');
				$this->db->join('produk', 'transaksi_detail.ProdukID = produk.ProdukID');
				$this->db->where('toko_merchant.MerchantID', $merchantID);
				$this->db->where('produk.MerchantID', $merchantID);
				//$this->db->order_by($this->primary_key, 'asc');
			}else{
				$this->db->join('transaksi_detail', 'transaksi.TransaksiID = transaksi_detail.TransaksiID');
				$this->db->join('toko_merchant', 'transaksi.TokoID = toko_merchant.TokoID');
				$this->db->join('produk', 'transaksi_detail.ProdukID = produk.ProdukID');
				$this->db->where('toko_merchant.MerchantID', $merchantID);
				//$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
				$this->db->where('produk.MerchantID', $merchantID);
			}
			return $this->db->get($this->table_name, $limit, $offset);

		}

		function count_all($id){
			$sql = "select COUNT(transaksi.TransaksiID) as Jumlah 
					from transaksi, transaksi_detail, merchant, toko_merchant 
					where transaksi.TokoID = toko_merchant.TokoID and 
					transaksi.TransaksiID = transaksi_detail.TransaksiID and 
					toko_merchant.MerchantID = merchant.MerchantID and 
					merchant.MerchantID =".$id;
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
			$sql = "select transaksi.TransaksiID, transaksi.NoKartu, transaksi.TanggalTransaksi,transaksi.TokoID, 
					produk.NamaProduk, produk.HargaPerUnit, 
					transaksi_detail.Kuantitas, transaksi_detail.Diskon, 
					toko_merchant.Alamat
					 FROM transaksi
					JOIN transaksi_detail ON transaksi.TransaksiID = transaksi_detail.TransaksiID 
					JOIN toko_merchant ON transaksi.TokoID = toko_merchant.TokoID 
					JOIN produk ON transaksi_detail.ProdukID = produk.ProdukID 
					WHERE toko_merchant.MerchantID = '".$id."' and 
					produk.MerchantID = '".$id."'";
			return $this->db->query($sql);
		}

		function get_by_id($idMerchant, $idTransaksi){
			$sql = "select transaksi.TransaksiID, transaksi.NoKartu, transaksi.TanggalTransaksi,transaksi.TokoID, 
					produk.NamaProduk, produk.HargaPerUnit, 
					transaksi_detail.Kuantitas, transaksi_detail.Diskon, 
					toko_merchant.Alamat
					 FROM transaksi
					JOIN transaksi_detail ON transaksi.TransaksiID = transaksi_detail.TransaksiID 
					JOIN toko_merchant ON transaksi.TokoID = toko_merchant.TokoID 
					JOIN produk ON transaksi_detail.ProdukID = produk.ProdukID 
					WHERE toko_merchant.MerchantID = '".$idMerchant."' and 
					produk.MerchantID = '".$idMerchant."' and transaksi.TransaksiID=".$idTransaksi;
			return $this->db->query($sql);
		}
	}
?>
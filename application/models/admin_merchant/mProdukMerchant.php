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
				$this->db->join('kategori_produk', 'produk.KategoriID = kategori_produk.KategoriID');
				$this->db->where('MerchantID', $merchantID);
				$this->db->order_by($this->primary_key, 'asc');
			}else{
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
			$sql = "select * from ".$this->table_name." where MerchantID=".$id;
			return $this->db->query($sql);
		}

		function get_by_id($id){
			$sql = "select * from ".$this->table_name." where ".$this->primary_key." ='".$id."' ";
			return $this->db->query($sql);
		}
	}
?>
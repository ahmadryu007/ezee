<?php 
	class MKartu extends CI_Model{
		private $primary_key = 'NoKartu';
		private $table_name = 'kartu';

		function __construct(){
			parent::__construct();
		}

		function get_paged_list($limit=10, $offset=0, $order_column='', $order_type='asc', $search='', $searchField='NoKartu')
		{
			if (empty($searchField))
				$searchField = 'NoKartu';
			
			if(empty($order_column) || empty($order_type) || empty($search) || empty($searchField))
				$this->db->order_by($this->primary_key, 'asc');
			else
				$this->db->order_by($order_column, $order_type);
				$this->db->like($searchField, $search);
			return $this->db->get($this->table_name, $limit, $offset);

		}

		function count_all(){
			return $this->db->count_all($this->table_name);
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

		function get_all_data(){
			$sql = "select * from ".$this->table_name;
			return $this->db->query($sql);
		}

		function get_by_id($no){
			$sql = "select * from ".$this->table_name." where ".$this->primary_key." = ".$no;
			return $this->db->query($sql);
		}
	}
?>
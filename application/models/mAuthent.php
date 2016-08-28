	<?php 
	if (!defined('BASEPATH')) 
	{exit('No direct script access allowed');}
	
	class mAuthent extends CI_Model 
	{
	
		function __construct() 
		{
			parent::__construct();
		}
	
		function get_user($userid)
		{
			$sql = $this->db->query("select * 
					from ss_user 
					where 
					user_id='$userid' and status=1");
			return $sql->row_array();
		}
	}
	/* End of file mAuthent.php */
	/* Location: ./application/models/mAuthent.php */
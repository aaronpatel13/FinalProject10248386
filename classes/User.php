<?php
class User extends Application {
	
	private $_table = "clients";
	public $_id;
	
	
	
	
	
	
	
	
	
	public function isUser($email, $password) {
		$password = Login::string2hash($password);
		$sql = "SELECT * FROM `{$this->_table}`
				WHERE `email` = '".$this->db->escape($email)."'
				AND `password` = '".$this->db->escape($password)."'
				AND `active` = 1";
		$result = $this->db->fetchOne($sql);
		if (!empty($result)) {
			$this->_id = $result['id'];
			return true;
		}
		return false;
	}




		public function addUser($params = null, $password = null) {
	
		if (!empty($params) && !empty($password)) {
			$this->db->prepareInsert($params);
			if ($this->db->insert($this->_table)) {
				
				
			}
			return true;
		}
		return false;
	
	}



	
	public function getUser($id = null) {
		if (!empty($id)) {
			$sql = "SELECT * FROM `{$this->_table}`
					WHERE `id` = '".$this->db->escape($id)."'";
			return $this->db->fetchOne($sql);
		}
	}


		public function updateUser($array = null, $id = null) {
		if (!empty($array) && !empty($id)) {
			$this->db->prepareUpdate($array);
			if ($this->db->update($this->_table, $id)) {
				return true;
			}
			return false;
		}
	}

	


}
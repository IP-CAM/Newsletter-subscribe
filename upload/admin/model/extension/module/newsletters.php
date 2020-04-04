<?php

class ModelExtensionModuleNewsletters extends Model {
	public function install(){
		$this->db->query("			
			CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "newsletter` (
				`news_id` INT(11) NOT NULL AUTO_INCREMENT,
				`news_email` VARCHAR(255) NOT NULL,
				`news_added` DATETIME NOT NULL,
				PRIMARY KEY (`news_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
	}

	public function uninstall(){
		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "newsletter`");
	}

	public function getNewsLetters() {
		$query = $this->db->query("SELECT * FROM ". DB_PREFIX ."newsletter");
		return $query->rows;
	}

	public function unsubscription($data){
		if($this->db->query("DELETE FROM " . DB_PREFIX . "newsletter WHERE news_id='" . $this->db->escape($data['id']) . "'")){
			return true;
		}else{
			return false;
		}
	}
}
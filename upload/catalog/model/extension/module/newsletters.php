<?php 
class ModelExtensionModuleNewsletters extends Model{
	public function subscribes($data){
		$check = $this->db->query("SELECT * FROM " . DB_PREFIX . "newsletter WHERE `news_email`='" . $this->db->escape($data['email']) . "'");

		if($check->num_rows){
			return "Email есть в нашей базе рассылки!";
		}else{

			if($this->db->query("INSERT INTO " . DB_PREFIX . "newsletter (news_email, news_added) VALUES ('" . $this->db->escape($data['email']) . "', NOW() )")){
				return "Подписка успешно оформлена";
			}else{
				return "Подписка не оформлена";
			}
		}
	}	
}
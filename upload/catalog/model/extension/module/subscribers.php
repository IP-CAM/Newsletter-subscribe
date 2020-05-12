<?php 
class ModelExtensionModuleSubscribers extends Model{
	public function Subscribe($data){
		// check email in our base
		$check = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE `email`='" . $this->db->escape($data['email']) . "'");

		if($check->num_rows){
			return "Email есть в нашей базе подписок!";
		}else{
			$customer_status = "1"; // customer status 
			$customer_newsletter = "1"; // customer newsletter status

			if($this->db->query("INSERT INTO " . DB_PREFIX . "customer (customer_group_id, store_id, language_id, email, salt, password, newsletter, status, ip, date_added) VALUES ('" . (int)$this->config->get('config_customer_group_id') . "','" . (int)$this->config->get('config_store_id') . "','" . (int)$this->config->get('config_language_id') . "','" . $this->db->escape($data['email']) . "','" . $this->db->escape($salt = token(9)) . "','" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['email'])))) . "','" . (int)$this->db->escape($customer_newsletter) . "','" . (int)$this->db->escape($customer_status) . "','" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', NOW() )")){
				return "Подписка успешно оформлена! Создан личный кабинет на сайте: в поле пароль укажите вашу почту.";
			}else{
				return "Подписка не оформлена";
			}
		}
	}	
}
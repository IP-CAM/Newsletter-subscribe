<?php 
class ModelExtensionModuleSubscribers extends Model{
	public function Subscribe($data){
		$this->load->language('extension/module/subscribers');

		// check email in our base
		if ((utf8_strlen($data['email']) > 96) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return $this->language->get('text_not_validate');
		}else{
			$check = $this->db->query("SELECT `email` FROM " . DB_PREFIX . "customer WHERE `email`='" . $this->db->escape($data['email']) . "'");

			if($check->num_rows){
				return $this->language->get('text_founded_email');
			}else{
				$customer_status = "1"; // customer status 
				$customer_newsletter = "1"; // customer newsletter status

				if($this->db->query("INSERT INTO " . DB_PREFIX . "customer (customer_group_id, store_id, language_id, firstname, lastname, email, salt, password, newsletter, status, ip, date_added) VALUES ('" . (int)$this->config->get('module_subscribers_customer_group') . "','" . (int)$this->config->get('config_store_id') . "','" . (int)$this->config->get('config_language_id') . "','" . $this->db->escape($data['email']) . "','" . $this->db->escape($data['email']) . "','" . $this->db->escape($data['email']) . "','" . $this->db->escape($salt = token(9)) . "','" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['email'])))) . "','" . (int)$this->db->escape($customer_newsletter) . "','" . (int)$this->db->escape($customer_status) . "','" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', NOW() )")){
					return $this->language->get('text_success_email');
				}else{
					return $this->language->get('text_failed_email');
				}
			}
		}
		
	}	
}
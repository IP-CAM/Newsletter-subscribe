<?php
class ControllerExtensionModuleSubscribers extends Controller{
	public function index(){
		$this->load->language('extension/module/subscribers');

		$data['heading_title'] = $this->language->get('heading_title');
		
		$this->load->model('catalog/information');
		$information_info = $this->model_catalog_information->getInformation($this->config->get('module_subscribers_agree'));
		$data['text_link'] = $this->url->link('information/information', 'information_id=' . $this->config->get('module_subscribers_agree'));
		$data['title'] = $information_info['title'];
		$data['text_agreer'] = sprintf($this->language->get('entry_submit'));
		
		return $this->load->view('extension/module/subscribers', $data);
	}

	public function newSubscribe(){
		$this->load->model('extension/module/subscribers');
		
		$json = array();
		$json['message'] = $this->model_extension_module_subscribers->Subscribe($this->request->post);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
	
}
<?php
class ControllerExtensionModuleSubscribers extends Controller{
	public function index(){
		$this->load->language('extension/module/subscribers');

		$data['heading_title'] = $this->language->get('heading_title');

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
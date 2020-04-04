<?php
class ControllerExtensionModuleNewsletters extends Controller{
	public function index(){
		$this->load->language('extension/module/newsletters');

		$data['heading_title'] = $this->language->get('heading_title');

		return $this->load->view('extension/module/newsletters', $data);
	}

	public function newSubscribe(){
		$this->load->model('extension/module/newsletters');

		$json = array();
		$json['message'] = $this->model_extension_module_newsletters->subscribes($this->request->post);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
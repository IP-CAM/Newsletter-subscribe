<?php
class ControllerExtensionModuleSubscribers extends Controller {
	private $error = array();

	public function index() {
		$data = $this->load->language('extension/module/subscribers');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_subscribers', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		$data['user_token'] = $this->session->data['user_token'];
		
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/subscribers', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/subscribers', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);

		if (isset($this->request->post['module_subscribers_status'])) {
			$data['module_subscribers_status'] = $this->request->post['module_subscribers_status'];
		} else {
			$data['module_subscribers_status'] = $this->config->get('module_subscribers_status');
		}

		$this->load->model('catalog/information');

		$data['informations'] = $this->model_catalog_information->getInformations();
		
		if (isset($this->request->post['module_subscribers_agree'])) {
			$data['module_subscribers_agree'] = $this->request->post['module_subscribers_agree'];
		} else {
			$data['module_subscribers_agree'] = $this->config->get('module_subscribers_agree');
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();
		
		if (isset($this->request->post['module_subscribers_customer_group'])) {
			$data['module_subscribers_customer_group'] = $this->request->post['module_subscribers_customer_group'];
		} else {
			$data['module_subscribers_customer_group'] = $this->config->get('module_subscribers_customer_group');
		}


		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');


		$this->response->setOutput($this->load->view('extension/module/subscribers', $data));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/banner')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}
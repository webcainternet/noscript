<?php
class ControllerModuleMyoccmenu extends Controller {
	private $error = array();

	public function index()
	{
		$this->load->language('module/myoccmenu');

		$this->document->setTitle($this->language->get('common_title'));
	
		$this->load->model('myoc/cmenu');

		$this->getList();
	}

	public function add()
	{
		$this->load->language('module/myoccmenu');

		$this->document->setTitle($this->language->get('common_title'));
	
		$this->load->model('myoc/cmenu');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$cmenu_id = $this->model_myoc_cmenu->addCmenu($this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			if (isset($this->request->get['exit'])) {
      			$this->response->redirect($this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			} else {
				$this->response->redirect($this->url->link('module/myoccmenu/edit', 'token=' . $this->session->data['token'] . '&cmenu_id=' . $cmenu_id, 'SSL'));
			}
		}

		$this->getForm();
	}

	public function copy()
	{
		$this->load->language('module/myoccmenu');
	
    	$this->document->setTitle($this->language->get('common_title'));
		
		$this->load->model('myoc/cmenu');
		
    	if (isset($this->request->post['selected']) && $this->validateList()) {
			
			foreach ($this->request->post['selected'] as $cmenu_id) {
				$cmenu = $this->model_myoc_cmenu->getCmenu($cmenu_id);
				$cmenu['status'] = 0;
				$cmenu['cmenu_description'] = $this->model_myoc_cmenu->getCmenuDescriptions($cmenu_id);
				$this->model_myoc_cmenu->addCmenu($cmenu);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
	}

	public function edit()
	{
		$this->load->language('module/myoccmenu');

		$this->document->setTitle($this->language->get('common_title'));
	
		$this->load->model('myoc/cmenu');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$this->model_myoc_cmenu->editCmenu($this->request->get['cmenu_id'], $this->request->post);
		  	
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['exit'])) {
      			$this->response->redirect($this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			} else {
				$this->response->redirect($this->url->link('module/myoccmenu/edit', 'token=' . $this->session->data['token'] . '&cmenu_id=' . $this->request->get['cmenu_id'], 'SSL'));
			}
		}

		$this->getForm();
	}

	public function delete()
	{
		$this->load->language('module/myoccmenu');
	
    	$this->document->setTitle($this->language->get('common_title'));
		
		$this->load->model('myoc/cmenu');
		
    	if (isset($this->request->post['selected']) && $this->validateList()) {
			foreach ($this->request->post['selected'] as $cmenu_id) {
				$this->model_myoc_cmenu->deleteCmenu($cmenu_id);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
	}

	public function sort()
	{
		$this->load->language('module/myoccmenu');
	
    	$this->document->setTitle($this->language->get('common_title'));
		
		$this->load->model('myoc/cmenu');
		
    	if ($this->validateList()) {
			foreach ($this->request->post['cmenu'] as $cmenu_id => $sort_order) {
				$cmenu = $this->model_myoc_cmenu->getCmenu($cmenu_id);
				$cmenu['sort_order'] = $sort_order['sort_order'];
				$cmenu['cmenu_description'] = $this->model_myoc_cmenu->getCmenuDescriptions($cmenu_id);
				$this->model_myoc_cmenu->editCmenu($cmenu_id, $cmenu);
			}
			      		
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->response->redirect($this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}
	
    	$this->getList();
	}

	private function getList()
	{
		$this->fixTable();
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cd.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('common_title'),
			'href'      => $this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$data['add'] = $this->url->link('module/myoccmenu/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('module/myoccmenu/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('module/myoccmenu/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	
		$data['save'] = $this->url->link('module/myoccmenu/sort', 'token=' . $this->session->data['token'], 'SSL');
		$data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		
		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$cmenu_total = $this->model_myoc_cmenu->getTotalCmenus();

		$results = $this->model_myoc_cmenu->getCmenus($filter_data);
 
		$data['cmenus'] = array();

    	foreach ($results as $result) {						
			$data['cmenus'][] = array(
				'cmenu_id'   => $result['cmenu_id'],
				'name'       => $result['name'],
				'sort_order' => $result['sort_order'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'selected'   => isset($this->request->post['selected']) && in_array($result['cmenu_id'], $this->request->post['selected']),
				'edit'       => $this->url->link('module/myoccmenu/edit', 'token=' . $this->session->data['token'] . '&cmenu_id=' . $result['cmenu_id'] . $url, 'SSL')
			);
		}	

		$data['heading_title'] = $this->language->get('common_title');

		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_list'] = $this->language->get('text_list');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_status'] = $this->language->get('column_status');		
		$data['column_action'] = $this->language->get('column_action');		
		
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_copy'] = $this->language->get('button_copy');
 		$data['button_delete'] = $this->language->get('button_delete');
 		$data['button_save'] = $this->language->get('button_save');
 		$data['button_cancel'] = $this->language->get('button_cancel');

 		$data['myoc_copyright'] = $this->language->get('myoc_copyright');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_name'] = $this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . '&sort=cd.name' . $url, 'SSL');
		$data['sort_sort_order'] = $this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . '&sort=c.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $cmenu_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($cmenu_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($cmenu_total - $this->config->get('config_limit_admin'))) ? $cmenu_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $cmenu_total, ceil($cmenu_total / $this->config->get('config_limit_admin')));


		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('myoc/cmenu_list.tpl', $data));
	}

	private function getForm()
	{
		$this->fixTable();
        $data['heading_title'] = $this->language->get('common_title');
		
		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_link'] = $this->language->get('entry_link');
		$data['entry_popup'] = $this->language->get('entry_popup');
		$data['entry_parent_cmenu'] = $this->language->get('entry_parent_cmenu');
		$data['entry_parent_category'] = $this->language->get('entry_parent_category');
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_in_module'] = $this->language->get('entry_in_module');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_login'] = $this->language->get('entry_login');
		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_sort'] = $this->language->get('entry_sort');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_route'] = $this->language->get('entry_route');
		$data['entry_information'] = $this->language->get('entry_information');
		$data['entry_product'] = $this->language->get('entry_product');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');

		$data['help_link'] = $this->language->get('help_link');
		$data['help_column'] = $this->language->get('help_column');
		$data['help_sort'] = $this->language->get('help_sort');

		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_form'] = $this->language->get('text_form');
		
		$data['myoc_copyright'] = $this->language->get('myoc_copyright');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_save_exit'] = $this->language->get('button_save_exit');
		$data['button_cancel'] = $this->language->get('button_cancel');

 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['link'])) {
			$data['error_link'] = $this->error['link'];
		} else {
			$data['error_link'] = false;
		}

		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

        $data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('common_title'),
			'href'      => $this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['cmenu_id'])) {
        	$data['action'] = $this->url->link('module/myoccmenu/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
        	$data['action_exit'] = $this->url->link('module/myoccmenu/add', 'token=' . $this->session->data['token'] . $url . '&exit=1', 'SSL');
		} else {
			$data['action'] = $this->url->link('module/myoccmenu/edit', 'token=' . $this->session->data['token'] . '&cmenu_id=' . $this->request->get['cmenu_id'] . $url, 'SSL');
			$data['action_exit'] = $this->url->link('module/myoccmenu/edit', 'token=' . $this->session->data['token'] . '&cmenu_id=' . $this->request->get['cmenu_id'] . $url . '&exit=1', 'SSL');
		}
		$data['cancel'] = $this->url->link('module/myoccmenu', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['cmenu_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$cmenu_info = $this->model_myoc_cmenu->getCmenu($this->request->get['cmenu_id']);
		}

		if (isset($this->request->post['cmenu_id'])) {
			$data['cmenu_id'] = $this->request->post['cmenu_id'];
		} elseif (!empty($cmenu_info)) {
			$data['cmenu_id'] = $cmenu_info['cmenu_id'];
		} else {
			$data['cmenu_id'] = 0;
		}

		$this->load->model('localisation/language');
		
		$data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['cmenu_description'])) {
			$data['cmenu_description'] = $this->request->post['cmenu_description'];
		} elseif (isset($this->request->get['cmenu_id'])) {
			$data['cmenu_description'] = $this->model_myoc_cmenu->getCmenuDescriptions($this->request->get['cmenu_id']);
		} else {
			$data['cmenu_description'] = array();
		}

		$this->load->model('catalog/information');
		$informations = $this->model_catalog_information->getInformations();
		$data['informations'] = array();
		foreach ($informations as $information) {
			$data['informations'][$information['title']] = HTTP_CATALOG . 'index.php?route=information/information&amp;information_id=' . $information['information_id'];
		}

		$this->load->model('catalog/manufacturer');
		$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
		$data['manufacturers'] = array();
		foreach ($manufacturers as $manufacturer) {
			$data['manufacturers'][$manufacturer['name']] = HTTP_CATALOG . 'index.php?route=product/manufacturer/info&amp;manufacturer_id=' . $manufacturer['manufacturer_id'];
		}

		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$categories = $this->model_myoc_cmenu->getCategories(0);

		$data['categories'] = array();

		foreach ($categories as $category) {					
			// Level 1
			$data['categories'][] = array(
				'category_id' => $category['category_id'],
				'name' => $category['name'],
				'path' => $category['category_id']
			);

			// Level 2
			$children = $this->model_myoc_cmenu->getCategories($category['category_id']);
				
			foreach ($children as $child) {
				$data['categories'][] = array(
					'category_id' => $child['category_id'],
					'name' => $category['name'] . ' > ' . $child['name'],
					'path' => $category['category_id'] . '_' . $child['category_id']
				);

				// Level 3
				$gchildren = $this->model_myoc_cmenu->getCategories($child['category_id']);

				foreach ($gchildren as $gchild) {
					$data['categories'][] = array(
						'category_id' => $gchild['category_id'],
						'name' => $category['name'] . ' > ' . $child['name'] . ' > ' . $gchild['name'],
						'path' => $category['category_id'] . '_' . $child['category_id'] . '_' . $gchild['category_id']
					);
				}
			}
		}

		$data['category_products'] = array();
		
		foreach ($data['categories'] as $category) {
			$products = $this->model_catalog_product->getProductsByCategoryId($category['category_id']);
			if($products)
			{
				$data['category_products'][$category['category_id']] = array();
				foreach ($products as $product) {
					$data['category_products'][$category['category_id']][$product['product_id']] = $product['name'];
				}
			}
		}
		$data['http_catalog'] = HTTP_CATALOG;

		$data['routes'] = array(
			'account/account' => HTTP_CATALOG . 'index.php?route=account/account',
			'account/login' => HTTP_CATALOG . 'index.php?route=account/login',
			'account/logout' => HTTP_CATALOG . 'index.php?route=account/logout',
			'account/register' => HTTP_CATALOG . 'index.php?route=account/register',
			'account/voucher' => HTTP_CATALOG . 'index.php?route=account/voucher',
			'account/wishlist' => HTTP_CATALOG . 'index.php?route=account/wishlist',
			'account/return/add' => HTTP_CATALOG . 'index.php?route=account/return/add',
			'affiliate/account' => HTTP_CATALOG . 'index.php?route=affiliate/account',
			'checkout/cart' => HTTP_CATALOG . 'index.php?route=checkout/cart',
			'checkout/checkout' => HTTP_CATALOG . 'index.php?route=checkout/checkout',
			'common/home' => HTTP_CATALOG . 'index.php?route=common/home',
			'information/contact' => HTTP_CATALOG . 'index.php?route=information/contact',
			'information/sitemap' => HTTP_CATALOG . 'index.php?route=information/sitemap',
			'product/manufacturer' => HTTP_CATALOG . 'index.php?route=product/manufacturer',
			'product/special' => HTTP_CATALOG . 'index.php?route=product/special',
		);


		if (isset($this->request->post['link'])) {
			$data['link'] = $this->request->post['link'];
		} elseif (!empty($cmenu_info)) {
			$data['link'] = $cmenu_info['link'];
		} else {
			$data['link'] = 'http://';
		}

		if (isset($this->request->post['popup'])) {
			$data['popup'] = $this->request->post['popup'];
		} elseif (!empty($cmenu_info)) {
			$data['popup'] = $cmenu_info['popup'];
		} else {
			$data['popup'] = '';
		}

		$cmenus = $this->model_myoc_cmenu->getCmenus();
		$data['cmenus'] = $cmenus;

		if (isset($this->request->post['parent_cmenu_id'])) {
			$data['parent_cmenu_id'] = $this->request->post['parent_cmenu_id'];
		} elseif (!empty($cmenu_info)) {
			$data['parent_cmenu_id'] = $cmenu_info['parent_cmenu_id'];
		} else {
			$data['parent_cmenu_id'] = 0;
		}

		if (isset($this->request->post['parent_category_id'])) {
			$data['parent_category_id'] = $this->request->post['parent_category_id'];
		} elseif (!empty($cmenu_info)) {
			$data['parent_category_id'] = $cmenu_info['parent_category_id'];
		} else {
			$data['parent_category_id'] = 0;
		}

		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($cmenu_info)) {
			$data['top'] = $cmenu_info['top'];
		} else {
			$data['top'] = 1;
		}

		if (isset($this->request->post['in_module'])) {
			$data['in_module'] = $this->request->post['in_module'];
		} elseif (!empty($cmenu_info)) {
			$data['in_module'] = $cmenu_info['in_module'];
		} else {
			$data['in_module'] = 0;
		}

		if (isset($this->request->post['column'])) {
			$data['column'] = $this->request->post['column'];
		} elseif (!empty($cmenu_info)) {
			$data['column'] = $cmenu_info['column'];
		} else {
			$data['column'] = '1';
		}

		if (isset($this->request->post['login'])) {
			$data['login'] = $this->request->post['login'];
		} elseif (!empty($cmenu_info)) {
			$data['login'] = $cmenu_info['login'];
		} else {
			$data['login'] = 0;
		}

        $this->load->model('sale/customer_group');
        $data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

        if (isset($this->request->post['customer_group'])) {
			$data['cmenu_customer_groups'] = $this->request->post['customer_group'];
        } elseif (!empty($cmenu_info)) {
			$data['cmenu_customer_groups'] = $cmenu_info['customer_group'];
		} else {
			$data['cmenu_customer_groups'] = array();
		}

		$this->load->model('setting/store');
        $data['stores'] = $this->model_setting_store->getStores();

        if (isset($this->request->post['store'])) {
			$data['cmenu_stores'] = $this->request->post['store'];
        } elseif (!empty($cmenu_info)) {
			$data['cmenu_stores'] = $cmenu_info['store'];
		} else {
			$data['cmenu_stores'] = array();
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($cmenu_info)) {
			$data['sort_order'] = $cmenu_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($cmenu_info)) {
			$data['status'] = $cmenu_info['status'];
		} else {
			$data['status'] = 1;
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('myoc/cmenu_form.tpl', $data));
	}

	private function validateForm()
	{
    	if (!$this->user->hasPermission('modify', 'module/myoccmenu')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

    	if($this->request->post['link'] != "#" && !filter_var($this->request->post['link'], FILTER_VALIDATE_URL)) {
    		$this->error['link'] = $this->language->get('error_link');
    	}

    	foreach ($this->request->post['cmenu_description'] as $language_id => $value) {
    		if(function_exists('utf8_strlen'))
    		{
	      		if ((utf8_strlen($value['name']) < 1) || (utf8_strlen($value['name']) > 255)) {
	        		$this->error['name'][$language_id] = $this->language->get('error_name');
	      		}
	      	} else {
	      		if ((strlen($value['name']) < 1) || (strlen($value['name']) > 255)) {
	        		$this->error['name'][$language_id] = $this->language->get('error_name');
	      		}
	      	}
    	}
		
		return !$this->error;
  	}

  	private function validateList()
  	{
		if (!$this->user->hasPermission('modify', 'module/myoccmenu')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
		
		return !$this->error;
  	}

  	public function install()
  	{
  		$this->load->model('myoc/cmenu');
  		$this->model_myoc_cmenu->installTable();

  		$this->load->model('setting/setting');
  		$this->model_setting_setting->editSetting('myoccmenu', array('cmenu_installed' => 1));
  	}

  	public function uninstall()
  	{
  		$this->load->model('myoc/cmenu');
  		$this->model_myoc_cmenu->uninstallTable();

  		$this->load->model('setting/setting');
  		$this->model_setting_setting->deleteSetting('myoccmenu');
  	}

  	public function fixTable()
  	{
  		$this->load->model('myoc/cmenu');
  		$this->model_myoc_cmenu->fixTable();
  	}
}
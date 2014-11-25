<?php
class ControllerCommonHeader extends Controller {
private static function sortCatCmenu($a, $b)
                {
                    $val = $a['sort_order'] - $b['sort_order'];
                    if($val == 0)
                    {
                        return strcmp(strtolower($a['name']), strtolower($b['name']));
                    }
                    return $val;
                }

                private function seoUrl($link)
                {
                    $parsed_url = @parse_url($link);
                    $http_server = parse_url(HTTP_SERVER);
                    $route = $path = '';
                    if ($this->config->get('config_seo_url') && isset($parsed_url['host']) && $parsed_url['host'] == $http_server['host'] && isset($parsed_url['query']) && substr($parsed_url['query'], 0, 5) == 'route') {
                        $url_query = strstr($parsed_url['query'], '=');
                        if(strpos($url_query, '&')) {
                            $route = substr($url_query, 1, strpos($url_query, '&') - 1);
                        } else {
                            $route = substr($url_query, 1);
                        }
                        $path = substr(html_entity_decode(strstr($url_query, '&')), 1);
                        return $this->url->link($route, $path);
                    } else {
                        return ($link == '#' ? '#" onclick="return false;' : $link);
                    }
                }
	public function index() {
		$data['title'] = $this->document->getTitle();

		if ($this->request->server['HTTPS']) {
			$server = $this->config->get('config_ssl');
		} else {
			$server = $this->config->get('config_url');
		}

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');
		$data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$data['icon'] = $server . 'image/' . $this->config->get('config_icon');
		} else {
			$data['icon'] = '';
		}

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');

		$data['text_home'] = $this->language->get('text_home');
		$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		$data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
		$data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

		$data['text_account'] = $this->language->get('text_account');
		$data['text_register'] = $this->language->get('text_register');
		$data['text_login'] = $this->language->get('text_login');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_transaction'] = $this->language->get('text_transaction');
		$data['text_download'] = $this->language->get('text_download');
		$data['text_logout'] = $this->language->get('text_logout');
		$data['text_checkout'] = $this->language->get('text_checkout');
		$data['text_category'] = $this->language->get('text_category');
		$data['text_all'] = $this->language->get('text_all');

		$data['home'] = $this->url->link('common/home');
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['logged'] = $this->customer->isLogged();
		$data['account'] = $this->url->link('account/account', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['login'] = $this->url->link('account/login', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['logout'] = $this->url->link('account/logout', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
		$data['contact'] = $this->url->link('information/contact');
		$data['telephone'] = $this->config->get('config_telephone');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = array();

		$categories = $this->model_catalog_category->getCategories(0);

		foreach ($categories as $category) {
			if ($category['top']) {
				// Level 2
				$children_data = array();

				$children = $this->model_catalog_category->getCategories($category['category_id']);

				foreach ($children as $child) {
					$filter_data = array(
						'filter_category_id'  => $child['category_id'],
						'filter_sub_category' => true
					);

					$children_data[] = array(
						'name'  => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
						'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
					);
				}

				// Level 1
				$data['categories'][] = array(
					'name'     => $category['name'],
					'children' => $children_data,
					'column'   => $category['column'] ? $category['column'] : 1,
					'href'     => $this->url->link('product/category', 'path=' . $category['category_id'])
				);
			}
		}

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

$this->load->model('extension/extension');
        
                $extensions = $this->model_extension_extension->getExtensions('module');

                $cmenu_installed = false;
                foreach ($extensions as $extension) {
                    if($extension['code'] == 'myoccmenu')
                    {
                        $cmenu_installed = true;
                        break;
                    }
                }

                $current_url = 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];

                $this->load->model('catalog/category');
                $this->load->model('catalog/product');
                $this->load->model('myoc/cmenu');

                $data['categories'] = array();
                            
                //$categories = $this->model_catalog_category->getCategories(0);

                $cmenu_data = array(
                    'parent_cmenu_id' => 0,
                    'parent_category_id' => 0,
                );
                $cmenus = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($cmenu_data) : array();
                $cmenus = array_merge($cmenus, $categories);
                
                usort($cmenus, array(get_class($this), 'sortCatCmenu'));

                foreach ($cmenus as $cmenu) {
                    if((!isset($setting) || !isset($cmenu['in_module']) || $cmenu['in_module']) && (isset($setting) || $cmenu['top']))
                    {
                        $children_data = array();
                        $parent_id = 0;

                        if(isset($cmenu['category_id']))
                        {
                            $category_children = $this->model_catalog_category->getCategories($cmenu['category_id']);
                        
                            $cmenu_data = array(
                                'parent_category_id' => $cmenu['category_id'],
                            );
                            $cmenu_children = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($cmenu_data) : array();
                        
                            $cmenu_children = array_merge($cmenu_children, $category_children);
                        } else {
                            $cmenu_data = array(
                                'parent_cmenu_id' => $cmenu['cmenu_id'],
                            );
                            $cmenu_children = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($cmenu_data) : array();
                        }
                        usort($cmenu_children, array(get_class($this), 'sortCatCmenu'));

                        foreach ($cmenu_children as $cmenu_child) {
                            //3rd level
                            $gchildren_data = array();

                            if(isset($cmenu_child['category_id']))
                            {
                                $category_gchildren = $this->model_catalog_category->getCategories($cmenu_child['category_id']);
                            
                                $cmenu_data = array(
                                    'parent_category_id' => $cmenu_child['category_id'],
                                );
                                $cmenu_gchildren = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($cmenu_data) : array();
                            
                                $cmenu_gchildren = array_merge($cmenu_gchildren, $category_gchildren);
                            } else {
                                $cmenu_data = array(
                                    'parent_cmenu_id' => $cmenu_child['cmenu_id'],
                                );
                                $cmenu_gchildren = $cmenu_installed ? $this->model_myoc_cmenu->getCmenus($cmenu_data) : array();
                            }

                            foreach ($cmenu_gchildren as $cmenu_gchild) {
                                if(isset($cmenu_gchild['category_id']))
                                {
                                    $cmenu_data = array(
                                        'filter_category_id'  => $cmenu_gchild['category_id'],
                                        'filter_sub_category' => true   
                                    );      
                                        
                                    $product_total = $this->model_catalog_product->getTotalProducts($cmenu_data);
                                    
                                    $href = $this->url->link('product/category', 'path=' . $cmenu['category_id'] . '_' . $cmenu_child['category_id'] . '_' . $cmenu_gchild['category_id']);

                                    $gchildren_data[] = array(
                                        'category_id' => $cmenu_gchild['category_id'],
                                        'name'    => $cmenu_gchild['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                                        'href'    => $href, 
                                        'popup'   => false,
                                        'current' => $current_url == $href,
                                    );
                                } elseif((!isset($setting) && $cmenu_gchild['top']) || (isset($setting) && $cmenu_gchild['in_module'])) {
                                    $href = $this->seoUrl($cmenu_gchild['link']);

                                    $gchildren_data[] = array(
                                        'category_id' => $cmenu_gchild['cmenu_id'],
                                        'name'    => $cmenu_gchild['name'],
                                        'href'    => $href . ($cmenu_gchild['popup'] ? '" target="_blank' : ''),
                                        'popup'   => $cmenu_gchild['popup'],
                                        'current' => $current_url == $href,
                                    );
                                }
                            }
                            //end 3rd level

                            if(isset($cmenu_child['category_id']))
                            {
                                $cmenu_data = array(
                                    'filter_category_id'  => $cmenu_child['category_id'],
                                    'filter_sub_category' => true   
                                );      
                                    
                                $product_total = $this->model_catalog_product->getTotalProducts($cmenu_data);

                                $href = $this->url->link('product/category', 'path=' . $cmenu['category_id'] . '_' . $cmenu_child['category_id']);
                                
                                $children_data[] = array(
                                    'category_id' => $cmenu_child['category_id'],
                                    'name'     => $cmenu_child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                                    'children' => $gchildren_data, //3rd level
                                    'column'   => $cmenu_child['column'] ? $cmenu_child['column'] : 1,
                                    'href'     => $href,    
                                    'popup'    => false,
                                    'current'  => $current_url == $href,
                                );
                            } elseif((!isset($setting) && $cmenu_child['top']) || (isset($setting) && $cmenu_child['in_module'])) {
                                $href = $this->seoUrl($cmenu_child['link']);

                                if(!isset($this->request->get['path']) && $href == ("http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")) {
                                    $data['child_id'] = $cmenu_child['cmenu_id'];
                                    $parent_id = $cmenu_child['parent_cmenu_id'] ? $cmenu_child['parent_cmenu_id'] : $cmenu_child['parent_category_id'];
                                }

                                $children_data[] = array(
                                    'category_id' => $cmenu_child['cmenu_id'],
                                    'name'     => $cmenu_child['name'],
                                    'children' => $gchildren_data, //3rd level
                                    'column'   => $cmenu_child['column'] ? $cmenu_child['column'] : 1,
                                    'href'     => $href . ($cmenu_child['popup'] ? '" target="_blank' : ''),
                                    'popup'    => $cmenu_child['popup'],
                                    'current'  => $current_url == $href,
                                );
                            }
                        }

                        $href = isset($cmenu['link']) ? $this->seoUrl($cmenu['link']) : $this->url->link('product/category', 'path=' . $cmenu['category_id']);

                        if(!isset($this->request->get['path'])) {
                            if($parent_id) {
                                $data['category_id'] = $parent_id;
                            } elseif ($href == ("http" . (isset($_SERVER['HTTPS']) ? "s" : "") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")) {
                                $data['category_id'] = isset($cmenu['cmenu_id']) ? $cmenu['cmenu_id'] : $cmenu['category_id'];
                            }
                        }

                        $data['categories'][] = array(
                            'category_id' => isset($cmenu['cmenu_id']) ? $cmenu['cmenu_id'] : $cmenu['category_id'],
                            'name'     => $cmenu['name'],
                            'children' => $children_data,
                            'column'   => $cmenu['column'] ? $cmenu['column'] : 1,
                            'href'     => $href . ((isset($cmenu['popup']) && $cmenu['popup']) ? '" target="_blank' : ''),
                            'popup'    => isset($cmenu['popup']) ? $cmenu['popup'] : false,
                            'current'  => $current_url == $href,
                        );
                    }
                }
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}
}
<?php

/**
 * @author Sonnk
 * @copyright 2015
 */
class incSlide extends CI_Include {

    function __construct() {
        parent::__construct();
        $this->load->incModel();
		$data = new stdClass();
		$control = $this->uri->segment(1);
		if($control = 'product'){
			$friendlyurl = $this->uri->segment(2);
		}
		else{
			$friendlyurl = '';
		}
		$data->categories = $this->model->getCategories();
		$data->products = $this->model->getProduct($friendlyurl);
		$data->friendlyurl = $friendlyurl;
		$this->load->incView($data);
    }
}
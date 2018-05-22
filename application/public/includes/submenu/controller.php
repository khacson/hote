<?php

/**
 * @author Sonnk
 * @copyright 2011
 */
class incSubmenu extends CI_Include {

    function __construct() {
        parent::__construct();
        $this->load->incModel();
		$data = new stdClass();
		$controller = $this->uri->segment(1);
		//$data->datas = $this->model->getBreadCrumb($controller);
		$this->load->incView($data);
    }
}
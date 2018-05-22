<?php

/**
 * @author Sonnk
 * @copyright 2015
 */
class incBreadcrumb extends CI_Include {

    function __construct() {
        parent::__construct();
        $this->load->incModel();
		$data = new stdClass();
		$control = $this->uri->segment(1);
		$data->url = $this->model->getMap($control);
		$this->load->incView($data);
    }
}
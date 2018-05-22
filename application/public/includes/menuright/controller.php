<?php

/**
 * @author Sonnk
 * @copyright 2015
 */
class incMenuright extends CI_Include {

    function __construct() {
        parent::__construct();
        $this->load->incModel();
		$data = new stdClass();
		$login = $this->site->GetSession("login");
		$data->logins = $login;
		$data->orders = $this->model->getOrders();
		$this->load->incView($data);
    }
}
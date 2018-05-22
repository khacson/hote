<?php

/**
 * @author Sonnk
 * @copyright 2018
 */
class incFooter extends CI_Include {

    function __construct() {
        parent::__construct();
        $this->load->incModel();
		$data = new stdClass();
		$this->load->incView($data);
    }
}
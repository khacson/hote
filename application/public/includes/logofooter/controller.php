<?php

/**
 * @author Sonnk
 * @copyright 2015
 */
class incLogofooter extends CI_Include {

    function __construct() {
        parent::__construct();
        $this->load->incModel();
		$data = new stdClass();
		$this->load->incView($data);
    }
}
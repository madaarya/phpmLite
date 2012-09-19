<?php

class MY_Controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library(array("form_validation","session","tampilan","table"));
		$this->load->helper(array("html","form","url","tanggal"));
		$this->load->database();
	}




}








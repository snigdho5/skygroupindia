<?php

$this->load->view('layouts/header');
	
$this->load->view('layouts/left-menu');

$this->load->view($content);

$this->load->view('layouts/footer');

?>
<?php
/*
 * Contacts version 1.0
 * Simply get list of contacts using oAuth2 from popular Social Networks and E-Mail Providers.
 * 
 * http://spanlayer.com/contacts
 * 
 * By: SpanLayer.com
 * 
 * License: GPLv2
 */

class contacts {

	private $service;
	private $redirect_uri;

	function __construct() {
		session_start();
		
		require_once "contacts/service.php";
	}

	function load($service) {
		require_once "contacts/services/{$service}.php";
		$this->service =& new $service;
		
		$this->service->redirect_uri = $this->service->current_url();
		
		return $this->service;
	}
	
}


?>

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

abstract class service {

	public $access_token;
	public $client_id;
	public $client_secret;
	private $auth_url;

	abstract function get_contacts();
	abstract function get_access_token();
	
	function __construct() {
	
	}

	function req($method, $url, $data=Array(), $extra=Array()) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		$extra[] = "User-agent: SpanLayer 1.0";

		if($method == 'POST')
		{		
			$content = '';
			if(is_array($data))
				$content = http_build_query($data);
	
			$extra[] = "Content-length: " . strlen($content);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		}
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $extra);
		
		$output = curl_exec($ch);
		curl_close($ch);
		
		return $output;
	}
	
	function current_url() {
		$pageURL = 'http';
		
		if ($_SERVER["HTTPS"] == "on")
			$pageURL .= "s";
		
		$pageURL .= "://";
		
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		
		$pageURL = preg_replace('/(\?code\=.+)/', '', $pageURL);
		
		return $pageURL;
	}

}

?>

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

class google extends service {

	function __construct() {
		parent::__construct();
		
		$this->access_token = $_SESSION["google_access_token"];
	}
	
	function get_access_token() {
		if($this->access_token)
			return $this->access_token;
			
		if(isset($_GET['code']))
		{
			$code = $_GET['code'];
			
			$resp = $this->req('POST', 'https://accounts.google.com/o/oauth2/token'
					, Array(
						'code' => $code,
						'client_id' => $this->client_id,
						'client_secret'	=> $this->client_secret,
						'redirect_uri' => $this->redirect_uri,
						'grant_type' => 'authorization_code'
					)
			);

			$resp_data = json_decode($resp);
			$this->access_token = $resp_data->access_token;
			$_SESSION["google_access_token"] = $this->access_token;
			header("Location: " . $this->current_url());
		}
		else
		{
			$this->auth_url = 'https://accounts.google.com/o/oauth2/auth?'
				. 'client_id=' . $this->client_id
				. '&scope=' . urlencode('https://www.google.com/m8/feeds')
				. '&redirect_uri=' . urlencode($this->redirect_uri)
				. '&response_type=code'
				. '&approval_prompt=force'
			;
			
			header("Location: {$this->auth_url}");
		}
	}
	
	function get_contacts() {
		$resp = $this->req('GET', 'https://www.google.com/m8/feeds/contacts/default/full?access_token=' . $this->access_token, Array(), Array("Authorization: Bearer {$this->access_token}"));
		
		return $resp;
	}

	
	
}

?>

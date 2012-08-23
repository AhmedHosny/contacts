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

require_once('contacts.php');
$contacts = new contacts();

$google = $contacts->load('google');

$google->client_id = '';
$google->client_secret = '';

if(!$google->access_token)
	$google->get_access_token();

$data = $google->get_contacts();
var_dump($data);



?>

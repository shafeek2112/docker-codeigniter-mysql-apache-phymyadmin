<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Configuration options for Xero private application
 */

$config = array(
	'consumer'	=> array(
    	'key'		=> 'Q3MRDGGCACIZ01D4NUHAZQXVOZL489',
    	'secret'	=> 'OOUNT3NPJADQK7LZ9A718GOOBHOKVU'
    ),
    'certs'		=> array(
    	'private'  	=> APPPATH.'certs/privatekey.pem',
    	'public'  	=> APPPATH.'certs/publickey.cer'
    ),
    'format'    => 'xml'
);
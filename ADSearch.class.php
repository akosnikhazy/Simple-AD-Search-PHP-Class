<?php
/***********************
* 	Nikházy Ákos 2022
* 
* A simple AD Search Class
* 
* Usage:
* 
* // hard coded credentials and the result have everything (put credentials in the class) 
* $search  = new ADSearch();
* $result  = $search -> Search('John Smi');
* $result2 = $search -> Search('Jane Smi'); 
*
* // setup credential when making the object and result is just some attributes
* $search  = new ADSearch('user@domain.com','password','host.com','portnumber','DC=something,DC=otherthing');
* $result  = $search -> Search('John Smi',array('displayname','samaccountname','mail'));
* $result2 = $search -> Search('Jane Smi',array('mail'));
* 
***********************/
class ADSearch{
	
	private $connection;
	
	private $user = 'user@domain.com';
	private $pass = 'VerySecurePasswordInTheCodeLOL';
	private $host = '0.0.0.0';
	private $port = '389';
	private $base = 'DC=examplpe,DC=com';
	
	function __construct($_user = null,$_pass = null,$_host = null,$_port = null,$_base = null) 
	{
		// if you do not want to hard code these, you can give them when making the object
		if($_user != null) $this->user = $_user;			
		if($_pass != null) $this->pass = $_pass;			
		if($_host != null) $this->host = $_host;			
		if($_port != null) $this->port = $_port;			
		if($_base != null) $this->base = $_base;			
		
		// connect
		$this->connection = ldap_connect($this->host,$this->port);
		
		// you need these so you can search
		ldap_set_option($this->connection, LDAP_OPT_REFERRALS, 0);
		ldap_set_option($this->connection, LDAP_OPT_PROTOCOL_VERSION, 3);
		
		ldap_bind($this->connection,$this->user,$this->pass);

	}
	
	// example: $obj -> ADSearch('John Smith',array('displayname','samaccountname','mail'))
	// example: $obj -> ADSearch('Jane Smith')
	public function Search($searchfor,$attr = array('*'))
	{
		
		if ($searchfor == '')
			return false;
		
		// change the third parameter if you want other search expression
		// see: https://wiki.mozilla.org/Mozilla_LDAP_SDK_Programmer%27s_Guide/Searching_the_Directory_With_LDAP_C_SDK
		$result = ldap_search($this->connection,
							  $this->base, 
							  '(|(displayname=' . $searchfor . '*)(mail=' . $searchfor . '*))', 
							  $attr);
    
		// ha van eredmény visszaadjuk tömb fomában
		return ldap_get_entries($this->connection, $result);
	}
}

<pre>
<?php
require('ADSearch.class.php');

// Make object.
// also it could be: $search = new ADSearch('user@domain.com','VerySecurePassword','0.0.0.0','389','DC=example,DC=com')
$search = new ADSearch();

// Do the search. Its false if something went wrong.
if($result = $search -> Search('John Smi'))
{
	
	var_dump($result);
	
}
else
	echo 'Search failed';

echo '<hr>';

// also it could be: $sarch -> Search('Smith',array('displayname','samaccountname','mail')); 
if($result2 = $search -> Search('Jane Smith',array('mail')))
{
	
	var_dump($result2);
	
}
else
	echo 'Search failed';

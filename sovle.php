<?php 

echo 'hello';
die;

return $_POST['hello'];
debug($_POST['numbers']);


function debug($obj)
{
	print '<pre>';
	print_r($obj);
	print '</pre>';
	die;
}
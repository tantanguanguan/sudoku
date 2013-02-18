<?php 
include('Sudoku.php');
//include('Cell.php');

if(isset($_POST['numbers']))
{
	main($_POST['numbers']);
}
else
{
	return json_encode(array('status' => 'error'));
}

function main($numbers)
{
	$sudoku = new Sudoku($numbers);
	print_r($sudoku->loopBoard());
}
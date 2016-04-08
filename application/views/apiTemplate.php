<?php 
if (isset($output)) 
{
	echo json_encode($output);
}
else
{
	$emptyArray = array(
		'errno' =>  3, 
		'err' => 'No Response:Server did not response or response with empty set.',
		'rsm' => null
		);
	echo json_encode($emptyArray);
}
 ?>

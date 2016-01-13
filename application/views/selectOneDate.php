<?php

$message = array();
if($errorFlag == 1){
	$message['error'] = "Date Format Error";
	echo json_encode($message);
}
if ($errorFlag == 2) {
	$message['error'] = "Result Empty";
	echo json_encode($message);
}
if ($errorFlag ==0) {
	echo json_encode($result);
}

?>
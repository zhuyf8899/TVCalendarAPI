<?php

$message = array();
if($errorFlag == 1){
	$message['error'] = "Date parameter loss";
	echo json_encode($message);
}
if ($errorFlag == 2) {
	$message['error'] = "User's Phone Has Been Used.";
	echo json_encode($message);
}
if ($errorFlag == 3) {
	$message['error'] = "Result Empty";
	echo json_encode($message);
}
if ($errorFlag == 0) {
	echo json_encode($result);
}
/*
echo "<pre>";
echo $errorFlag;
print_r($result);
echo "</pre>";
*/
?>
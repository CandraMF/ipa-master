<?php
	//header("Content-type : application/json");
	//$std->status= array('status' => 'failed');

	$response_json= array('status' => $response);
	
	echo json_encode($response_json, JSON_NUMERIC_CHECK);
?>
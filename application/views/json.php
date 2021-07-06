<?php
	//header("Content-type : application/json");
	//$std->status= array('status' => 'failed');

	if($response=='success'){
		$response_json= array('status' => 'success');
	}else{
		$response_json= array('status' => 'failed');
	}
	
	echo json_encode($response_json, JSON_NUMERIC_CHECK);
?>
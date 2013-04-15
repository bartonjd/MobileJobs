<?php
include('../includes/jsonTableBridge.php');
$db = connect2DB();

switch ($_REQUEST['action']){
	CASE "state_list":
		$sql = "SELECT state_code as value,state as label FROM states WHERE state_code LIKE  $1";
		$query = pg_query_params($db,$sql,array($_REQUEST['term']."%"));
		
		$result = pg_fetch_all($query);
		$returnObj['query'] = $_REQUEST['term'];
		$returnObj['suggestions'] = $result;
	break;
	CASE "city_list":
		$sql = "SELECT city as value,city as label FROM cities WHERE city ILIKE '".$_REQUEST['term']."%'";
		$query = pg_query($db,$sql);
		$result = pg_fetch_all($query);
		$returnObj['query'] = $_REQUEST['term'];
		$returnObj['suggestions'] = $result;
	break;
}

function returnData($returnObj,$returnType){
	if($returnType != 'html'){
		die(json_encode($returnObj));
	} else {
		echo $returnObj;
	}

}


	
if (isset($_REQUEST['action'])){
	returnData($returnObj);
}
function getStates($name){
	$sql = "SELECT state_code as value,state as label FROM states";
	$query = pg_query($sql);
	
	$result = pg_fetch_all($query);
	$html = <<<EOT
	<select name="$name" data-role="none" id="${name}" class="states">
EOT;
	foreach ($result as $value){
$html .= <<<EOT
<option value="{$value[value]}">{$value[label]}</option>
EOT;

	}
	$html .= "</select>";
	return $html;
}

?>
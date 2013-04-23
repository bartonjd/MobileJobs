<?php
set_include_path ('/home/jbarton/public_html/');

require_once('resources/jsonTableBridge.php');
$db = connect2DB();

switch ($_REQUEST['action']){
	CASE "state_list":
		$sql = "SELECT state_code as data,state as value FROM states WHERE state ILIKE  $1";
		$query = pg_query_params($db,$sql,array($_REQUEST['query']."%"));
		$result = pg_fetch_all($query);
		$returnObj['query'] = $_REQUEST['query'];
		$returnObj['suggestions'] = $result;
	break;
	CASE "city_list":
		$sql = "SELECT DISTINCT city as value,city as label FROM cities c JOIN states s ON c.state_code = s.state_code WHERE ((city ILIKE $1) and (s.state = $2)) or zip ILIKE $1";
		$query = pg_query_params($db,$sql,array($_REQUEST['query']."%",$_REQUEST['state']));
		$result = pg_fetch_all($query);
		$returnObj['query'] = $_REQUEST['query'];
		$returnObj['suggestions'] = $result;
	break;
	CASE "tag_list":
		$sql = "SELECT tag_name as data, tag_name as value FROM tags WHERE tag_name ILIKE  $1";
		$query = pg_query_params($db,$sql,array($_REQUEST['query']."%"));
		$result = pg_fetch_all($query);
		$returnObj['query'] = $_REQUEST['query'];
		$returnObj['suggestions'] = $result;		
	break;
	CASE 'update_tags':
		
}

function returnData($returnObj,$returnType=null){
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
	$sql = "SELECT state as value,state as label FROM states";
	$query = pg_query($sql);
	
	$result = pg_fetch_all($query);
	$html = <<<EOT
	<select name="$name" data-role="none" id="${name}" class="states">
		<option value=""></option>
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
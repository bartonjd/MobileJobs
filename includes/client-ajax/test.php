<?php
include('../jsonTableBridge.php');

$db = connect2DB();

$te = new JSONTableBridge('states',null,array('time_id'=>'{false}'),$db);
$data = array("state"=>"ZaYa","state_code"=>"zy",'time_id'=>9225);
$jdat = json_encode($data);
$bob = $te->CREATE($jdat,NULL,true);

//$bob = pg_fetch_assoc($query);
print_r($te->getSQL_LOG());
?>

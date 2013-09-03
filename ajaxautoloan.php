<?php
$header[] = 'Content-Type: application/x-www-form-urlencoded';
$apikey='8fdbb7e7173f9ed861cd0995aec718f4';
$vendor_id=597; 
if($_GET['fetch'] =='make'){	
	$res = curlposting("https://crm.axiombpm.com/leadsystem/api/fetch_make/$vendor_id/$apikey", "" , $header , 10);
	echo $res;
}
elseif($_GET['fetch'] =='model' && !empty($_GET['make'])){
	$res = curlposting("https://crm.axiombpm.com/leadsystem/api/fetch_model/$vendor_id/$apikey/".urlencode($_GET['make']), "" , $header , 10);
	echo $res;
}
elseif($_GET['fetch'] =='trim' && !empty($_GET['model'])){
	$res = curlposting("https://crm.axiombpm.com/leadsystem/api/fetch_trim/$vendor_id/$apikey/".urlencode($_GET['model']), "" , $header , 10);
	echo $res;
}

function curlposting($url , $xml , $header , $buffersize = 60){
		$ch = curl_init();
		$curl_start_time = time();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $buffersize);
		if(!empty($header))curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if(!empty($xml)) curl_setopt($ch, CURLOPT_POST, 1);
		if(!empty($xml))curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	} 

?>

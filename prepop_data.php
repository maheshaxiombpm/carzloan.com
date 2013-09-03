<?php
// =============================ADDED BY HARSH MAHIVAL FOR PULL DATA ============================= //
	$vendor_id =  ""; $sub_id = '';
	$header[] = 'Content-Type: application/x-www-form-urlencoded';
	
	if(isset($_GET['email']) && $_GET['email'] !== '' && filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)){
		$result = 0;
		$result = curlposting_phone('http://datafeeds.axiombpm.com/getdata.php?email='.$_GET['email'], "" , $header , 60);
		
		if($result){
			list($id,$data_vid,$subid,$c_date,$first_name,$last_name,$address,$city,$state,$zip,$phone,$email,$ipaddress,$url,$dob,$mobile,$work_phone,$status) = explode('|',$result);
		}
	}
	elseif(isset($_GET['phone']) && preg_match('/^1?[2-9]{1}[0-9]{9}$/', $_GET['phone'])){
		
		$res = curlposting_phone("http://datafeeds.axiombpm.com/databank_api.php?phone=".$_GET['phone'], "" , $header , 60);
	
	// =============================Chnaged By varsha ============================= //

	preg_match("/<first_name>(.*)<\/first_name>/msUi", $res, $first_name);
	preg_match("/<last_name>(.*)<\/last_name>/msUi", $res, $last_name);
	preg_match("/<email>(.*)<\/email>/msUi", $res, $email);
	preg_match("/<vendor_id>(.*)<\/vendor_id>/msUi", $res, $vid);
	preg_match("/<address>(.*)<\/address>/msUi", $res, $address);
	preg_match("/<city>(.*)<\/city>/msUi", $res, $city);
	preg_match("/<state>(.*)<\/state>/msUi", $res, $state);
	preg_match("/<zip>(.*)<\/zip>/msUi", $res, $zip);
	preg_match("/<empty>(.*)<\/empty>/msUi", $res, $empty);
	preg_match("/<errors>(.*)<\/errors>/msUi", $res, $errors);
	//preg_match("/<mileage_1>(.*)<\/mileage_1>/msUi", $res, $mileage_1);
	//preg_match("/<mile_oneway_1>(.*)<\/mile_oneway_1>/msUi", $res, $mile_oneway_1);
	
	
	$first_name = $first_name[1];
	$phoneval_check = 'yes';
	$last_name = $last_name[1];
	$email = $email[1];
	$vid = $vid[1];
	$address = $address[1];
	$state = strtoupper($state[1]);
	$city = $city[1];
	$zip = $zip[1];
	$car_year = $car_year[1];  // date('Y');
	$model =$model[1];
	$make =$make[1];
	$trim =$trim[1];
	$mobile =$mobile[1];
	
	
}
// =============================ADDED BY HARSH MAHIVAL FOR PULL DATA ============================= //

	function curlposting_phone($url , $xml , $header , $buffersize = 60){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, $buffersize);
		if(!empty($header))curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if(!empty($xml)){
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		}
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

?>
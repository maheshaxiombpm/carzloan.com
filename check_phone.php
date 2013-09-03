<?php	
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
$phone=$_REQUEST["phone"];
$url ="https://crm.axiombpm.com/leadsystem/api/ValidateAreacode";
$fields ='vendor_id=597&apikey=8fdbb7e7173f9ed861cd0995aec718f4&phone='.$phone;
if (!function_exists('curl_init')){
        die('Sorry cURL is not installed!');
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$fields);	
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   echo $xmloutput = curl_exec($ch);
    curl_close($ch);    
?>

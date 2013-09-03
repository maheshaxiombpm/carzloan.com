<?php        
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
$zip=$_REQUEST["zip"];
$url ="https://crm.axiombpm.com/leadsystem/vendor_curl/get_city_state_from_zip/".$zip;
$fields ='';
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
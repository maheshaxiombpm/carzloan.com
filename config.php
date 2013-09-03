<?

		$host='localhost';
		$host_username='autolead_techno';
		$host_password='suchit987';
		
		 $link = mysql_connect($host,$host_username,$host_password);
		if (!$link) {
			die('connected : ' . mysql_error());
		}	
		$database_name = "autolead_apply";	
		$db_selected = mysql_select_db($database_name, $link);
		if (!$db_selected) {
			die ('Can\'t use project : ' . mysql_error());
		}	
	
	
extract($_POST , EXTR_SKIP);

//session_cache_expire(30000);
session_start();
ob_start();
ini_set('max_execution_time',43200);
//ini_set('max_execution_time',9000);
ini_set('max_input_time',43200);
ini_set('max_upload_filesize', 8388608); 

																	   

?>
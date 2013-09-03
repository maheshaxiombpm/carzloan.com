<?php include('detectmobilebrowser.php');?><?php
require("config.php");
error_reporting(1);
extract($_REQUEST);
require "prepop_data.php";
$STATE = array(""=>"--Select--","AL"=>"Alabama","AK"=>"Alaska","AZ"=>"Arizona","AR"=>"Arkansas","CA"=>"California","CO"=>"Colorado","CT"=>"Connecticut","DE"=>"Delaware","DC"=>"District of Columbia","FL"=>"Florida","GA"=>"Georgia","HI"=>"Hawaii","ID"=>"Idaho","IL"=>"Illinois","IN"=>"Indiana","IA"=>"Iowa","KS"=>"Kansas","KY"=>"Kentucky","LA"=>"Louisiana","ME"=>"Maine","MD"=>"Maryland","MA"=>"Massachusetts","MI"=>"Michigan","MN"=>"Minnesota","MS"=>"Mississippi","MO"=>"Missouri","MT"=>"Montana","NE"=>"Nebraska","NV"=>"Nevada","NH"=>"New Hampshire","NJ"=>"New Jersey","NM"=>"New Mexico","NY"=>"New York","NC"=>"North Carolina","ND"=>"North Dakota","OH"=>"Ohio","OK"=>"Oklahoma","OR"=>"Oregon","PA"=>"Pennsylvania","RI"=>"Rhode Island","SC"=>"South Carolina","SD"=>"South Dakota","TN"=>"Tennessee","TX"=>"Texas","UT"=>"Utah","VT"=>"Vermont","VA"=>"Virginia","WA"=>"Washington","WI"=>"Wisconsin","WV"=>"West Virginia","WY"=>"Wyoming");
//insert to database
//$error_car= 'false';


if(isset($_POST['submit']) || isset($_POST['submit']) ){

$_POST['vid'] = empty($_POST['vid']) ? '597' : $_POST['vid'];
$_POST['sid'] = empty($_POST['sid']) ? '1111' : $_POST['sid'];



	if(trim($_POST['element_4']) == ''){
		$err['element_4'] = 'Please Select Type of Car Loan';
	}
	if(trim($_POST['first_name']) == ''){
		$err['first_name'] = 'Please Enter First Name';
	}
	if(trim($_POST['last_name']) == ''){
		$err['last_name'] = 'Please Enter Last Name';
	}

	if(trim($_POST['phone']) == '' || strlen(trim($_POST['phone'])) < 10){
		$err['phone'] = 'Please Enter valid phone';
	}elseif(!preg_match('/^1?[2-9]{1}[0-9]{9}$/', trim($_POST['phone']))){
		$err['phone'] = 'Please Enter valid Phone';
	}


	if(trim($_POST['email']) == '' ){
		$err['email'] = 'Please Enter Email';
	}elseif(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", trim($_POST['email'])) && trim($_POST['email']) != ""){
		$err['email'] = 'Please Enter valid Email';
	}

	if(trim($_POST['zip']) == '' || strlen(trim($_POST['zip'])) < 5 || !preg_match( '/^[\-+]?[0-9]*\.?[0-9]+$/', trim($_POST['zip']))){
		$err['zip'] = 'Please Enter valid Zip';
	}
	if(trim($_POST['city']) == ''){
		$err['city'] = 'Please Enter City';
	}
	if(trim($_POST['state']) == ''){
		$err['state'] = 'Please Enter State';
	}
	if(trim($_POST['address']) == ''){
		$err['address'] = 'Please Enter Address';
	}

	if(trim($_POST['element_4']) == '4'){	//	FOR NEW CAR
		if(trim($_POST['make']) == ''){
			$err['make'] = 'Please Select Make';
		}
		if(trim($_POST['model']) == ''){
			$err['model'] = 'Please Select Model';
		}
		if(trim($_POST['trim']) == ''){
			$err['trim'] = 'Please Select Trim';
		}
	}


	if(empty($err)){
function curlposting($url , $xml , $header , $buffersize = 60){
			$ch = curl_init();
			$curl_start_time = time();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, $buffersize);
			if(!empty($header))curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
			$data = curl_exec($ch);
			curl_close($ch);
			return $data;
		}

		$sql = "insert into autoapplication set source ='1',
					subid='".$_GET['sid']."',
					fname='".$_POST['first_name']."',
					lname='".$_POST['last_name']."',
					email='".$_POST['email']."',
					phone='".$_POST['phone']."',
					ltype='".$_POST['element_4']."',
					ip='".$_SERVER['REMOTE_ADDR']."',
					address='".$_POST['address']."',
					city='".$_POST['city']."',
					state='".strtoupper($_POST['state'])."',
					zip='".$_POST['zip']."',
					make='".$_POST['make']."',
					model='".$_POST['model']."',
					trim='".$_POST['trim']."',
					bankruptcy='".$_POST['bankruptcy']."',
					cosigner='".$_POST['cosigner']."',
					add_date=now()
				";
		$res = mysql_query($sql);


		$live_url = 'https://crm.axiombpm.com/leadsystem/short_form';
		//$live_url = 'https://192.168.4.166/leadsystem/short_form';
		//$car_live_url = 'http://192.168.4.166/leadsystem/vendor_curl';
		$data =  'lead_mode=1'

		.'&vendor_id='.$_POST['vid']
		.'&sub_id='.$_POST['sid'] // 123
		.'&first_name='.$_POST['first_name']
		.'&last_name='.$_POST['last_name']
		.'&email='.$_POST['email']
		.'&phone='.$_POST['phone']
		.'&address='.$_POST['address']
		.'&city='.$_POST['city']
		.'&state='.strtoupper($_POST['state'])
		.'&zip='.$_POST['zip']
		.'&ipaddress='.$_SERVER['REMOTE_ADDR']
		.'&url='.$_SERVER["SERVER_NAME"]
		;
		
		if(trim($_POST['element_4']) == '4'){
			$long_url = 'https://crm.axiombpm.com/leadsystem/vendor_curl';
			$car_data = $data;
			$car_data	.='&car_year='.date('Y')
			.'&make='.$_REQUEST['make']
			.'&model='.$_REQUEST['model']
			.'&trim='.$_REQUEST['trim'];
	
	
	
			 $long_res = curlposting($long_url,$car_data.'&lead_type=4',$header,'120');
			$car_mailmessage = "<br><b> CAR : </b></br>";
			$car_mailmessage .= "<b>Post URL : </b>".$long_url."<br>";
			$car_mailmessage .= "<b>Post Request : </b><pre>".htmlspecialchars($car_data."&lead_type=4", ENT_QUOTES)."</pre><br>";
			$car_mailmessage .= '<b>Post Response</b><pre>' . htmlspecialchars(html_entity_decode($long_res), ENT_QUOTES) . ' </pre>'; 
			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$to = 'leads@incedebrands.com' . ', ';
			$subject=$_SERVER['HTTP_REFERER'];
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			mail($to,$subject,$mailmessage . $car_mailmessage,$headers);
		}

		

	 $res = curlposting($live_url,$data.'&lead_type=2',$header,'60');
	 $mailmessage = "<b>Post URL : </b>".$live_url."<br>";
	 $mailmessage .= "<b>Post Request : </b><pre>".htmlspecialchars($data."&lead_type=2", ENT_QUOTES)."</pre><br>";
	 $mailmessage .= '<b>Post Response</b><pre>' . htmlspecialchars(html_entity_decode($res), ENT_QUOTES) . '</pre>';
	 preg_match("/<Error>(.*)<\/Error>/", $res, $error_res);
	 $headers  = 'MIME-Version: 1.0' . "\r\n";
	 $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	 $to = 'leads@incedebrands.com' . ', ';
	 $subject=$_SERVER['HTTP_REFERER'];
	 $headers .= "MIME-Version: 1.0\r\n";
	 $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	 mail($to, $subject, $mailmessage, $headers);
	 $data= str_replace('vendor_id=','vid=',str_replace('sub_id=','sid=',$data));

		$location = "https://www.web2carz.com/bad-credit-auto-loan-application?w2caf=da420a854646e9ab&subid=".$_GET['sid']."&firstName=".$_POST['first_name']."&lastName=".$_POST['last_name']."&email=".$_POST['email']."&homePhone=".$_POST['phone']
		."&address=".$_POST['address']
		."&city=".$_POST['city']
		."&state=".$_POST['state']
		."&zip=".$_POST['zip']
		;
		header("location:".$location);exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CARZLOAN : make finance easy</title>
<link rel="shortcut icon" href="/favicon.png">
	<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript"
		src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript"
		src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<!--MOHAN-->
	<script type="text/javascript" src="js/general.js"></script>
	<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript"
		src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css"
		href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript">
$(document).ready(function() {
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, "Only letters please"); 
/* function phoneUS (value)
  {
   var respo= $.ajax({
           url: 'check_phone.php',
           type: 'POST',
           async: false,
           data: "phone=" + value + "&checking=true"
        }).responseText;
		
        if(respo=="Valid") return true; else return false;
     
  }
  function validatezip(valuezip){
   var respo= $.ajax({
	       url: "check_zip.php",
	       type: 'POST',
	       datatype:'json',
	       async: false,
	       data: "zip=" + valuezip + "&checking=true"
	    }).responseText;
		//getQueryStringVariable('zip');
		//$("#zc").val(value);
	    var data = jQuery.parseJSON(respo);
	    $("[name=city]").val(data.city);
	    $("[name=state]").val(data.state);
	    if(data.city){
	           return true;
	   }else{
		return false;		
	  }
  }
  */
  	function zip(){
				var zip='';
					var respo = $.ajax({
						url : "check_zip.php",
						type : 'POST',
						datatype : 'json',
						async : false,
						data : "zip=" + $("#zip").val() + "&checking=true"
					}).responseText;
					var data = jQuery.parseJSON(respo);
					$("[name=city]").val(data.city);
					$("[name=state]").val(data.state);
					if (data.city) {   
					zip ='true';
					
						return true;
					} else {
					
					   //$('#zip').removeClass('valid').addClass('errorloan');
                         $('#zip').after('<span id="zip_error" class="error">Enter Valid zip</span>');
					     $('.zip_error').show();
						return false;
					}
		}

function phoneUS() {
		var phone='';
		if ($("#phone").val().length == 10) {
					var respo = $.ajax({
						url : "check_phone.php",
						type : 'POST',
						async : false,
						data : "phone=" + $("#phone").val()  + "&checking=true"
					}).responseText;
					if (respo == "Valid"){
				
					
						return true;
					}
						else{
						$('#phone').after('<span id="phone_error" class="error">Enter Valid Phone</span>');
						$('.phone_error').show();
						return false;
						}
						}else{
						return false;
						}
						}
  //var phonezip =$("#form_2").validate();
	$('#saveForm').click(function() {
		$("#form_2").validate({
		rules: {
		 first_name: { required: true,lettersonly: true},
		 last_name: { required: true,lettersonly: true, notEqual: "#first_name" }
		    },
			 messages: {
			 first_name: {
       required: "Enter First Name",
	   lettersonly: "Please Enter Only Letter"
     },
     last_name: {
       required: "Enter Last Name",
	   lettersonly: "Please Enter Only Letter",
       notEqual: "FirstName and LastName Must be Different"
     }
	 },
			submitHandler: function(form){
			//$("#clock").show();
			var  zip1=zip();
            //setTimeout(function() {}, 2000);			
			var  phone1 = phoneUS();
            if(zip1==true && phone1==true){
			   form.sumbit();
			   }
			   else{
	        	   return false;
	           }
	     }
	   });
											
		});
		
		});
</script>

	<!--MOHAN-->
	<link rel="stylesheet" type="text/css"
		href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox();
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 600,
		fitToView	: false,

		autoSize	: false,
		 helpers 	: { 
			   overlay: {
			   opacity: 0.6
			   
			   } 
			  },
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none'
	});
		$("#contact").submit(function() { return false; });
		});
	</script>
	<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}

#dropcontentsubject {
	width: 230px;
	font-weight: bold;
}

.dropcontent {
	width: 230px;
	height: 210px;
	padding: 3px;
	display: block;
}

.error {
	margin: 0px 0px 0px 5px;
}
</style>
	<link href="css/carzloan.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/crawler.js">
/* Text and/or Image Crawler Script v1.5 (c)2009-2011 John Davenport Scheuer
   as first seen in http://www.dynamicdrive.com/forums/
   username: jscheuer1 - This Notice Must Remain for Legal Use
   updated: 4/2011 for random order option, more (see below)
*/

</script>

	<!-- End Piwik Tracking Code -->

</head>

<body onload="MM_preloadImages('images/applynow-r.png')">
	<table width="100%" border="0" align="center" cellpadding="0"
		cellspacing="0">
		<tr>
			<td height="110" align="center" valign="top"
				background="images/topbg.jpg" style="background-repeat: repeat-x"><table
					width="994" border="0" cellspacing="0" cellpadding="0">
					<tr>
        <td width="310" rowspan="2" align="left" valign="top"><a href="index.php"><img src="images/logo.png" alt="logo" width="310" height="110" border="0" /></a></td>
        <td style="height:30;" align="right" valign="middle" class="blackitalic">Auto Loans, Used Car Loans and Auto Loan Refinancing</td>
      </tr>
      <tr>
        <td  align="right" valign="middle" style="float: right; padding: 14px 0px 0px;height:0px;">
		   <a href="index.php" class="toplinkhover">Home</a>&nbsp;&nbsp;   |   &nbsp;&nbsp;
		   <a href="car_application.php" title="" class="toplinkhover" id="">Car Loan Application</a>  &nbsp;&nbsp;|  &nbsp;&nbsp;
		   <a href="auto_application.php" title="" class="toplinkhover" id="auto_application">Car Insurance</a>  &nbsp;&nbsp;|&nbsp;&nbsp;
		   <a href="about_us.php" title="" class="toplinkhover various fancybox.iframe" id="aboutus">About Us</a>&nbsp;&nbsp;   |   &nbsp;&nbsp; 
		   <a href="blog.php" title="" class="toplinkhover various fancybox.iframe" id="blog">Blog</a>&nbsp;&nbsp;   |   &nbsp;&nbsp;
		   <a href="contact_us.php" class="toplinkhover">Contact Us</a>
        
		</td>
      </tr>
				</table></td>
		</tr>
		<tr>
			<td height="524" align="center" valign="top"
				background="images/bannerbg.jpg" style="background-repeat: repeat-x"><table
					width="994" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="289" align="left" valign="top"><table width="100%"
								border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="right"><img src="images/leftmanutopline.jpg"
										width="1" height="31" /></td>
								</tr>
								<tr>
									<td align="left" class="headpointbg">Real Rates In Seconds</td>
								</tr>
								<tr>
									<td class="headpointbg">Multiple No Obligation Offers<br /></td>
								</tr>
								<tr>
									<td class="headpointbg">Nationwide Coverage</td>
								</tr>
								<tr>
									<td class="headpointbg">No Social Security # Needed!</td>
								</tr>
								<tr>
									<td class="headpointbg">Hassle Free, Simple Process</td>
								</tr>
								<tr>
									<td height="254" align="left" valign="top" bgcolor="#313131"><table
											width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="20">&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td align="left" valign="top" class="whitetext12size"><div
														align="justify">
														Let banks and credit unions battle it out to get you great
														rates on Auto Financing for new and used auto loans. You
														get free access to great deals in real time!<br /> <br />
														Carzloan.com is the Nation's Leading Source for Auto
														Loans! We will instantly match you with the right lender,
														and you'll be approved immediately!<br /> <br /> Remember
														this is a Free Car Loanservice and there is no obligation.
													</div></td>
											</tr>
											<tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											</tr>
										</table></td>
								</tr>
								<tr>
									<td height="57" align="center" valign="middle"><img
										src="images/freequickandeasy.png" width="289" height="31" /></td>
								</tr>
								<tr>
									<td align="left" valign="top"><table width="100%" border="0"
											cellspacing="0" cellpadding="0">
											<tr>
												<td width="1" bgcolor="#e5e5e5"><img src="images/blank.gif"
													width="1" height="1" /></td>
												<td width="287" align="left" valign="top" bgcolor="#fbfbfb"><table
														width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="28">&nbsp;</td>
															<td height="33">&nbsp;</td>
															<td width="28">&nbsp;</td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td width="230" height="32" align="left" valign="top"
																background="images/testimonialheading.jpg"
																style="background-repeat: no-repeat">&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<td><img src="images/blank.gif" width="1" height="1" /></td>
															<td height="10" align="left" valign="top"><img
																src="images/blank.gif" width="1" height="1" /></td>
															<td><img src="images/blank.gif" width="1" height="1" /></td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td align="left" valign="top"
																background="images/testimoniallogobg.gif"
																style="background-repeat: no-repeat"><marquee
																	scrollamount="3" direction="up" width="230"
																	height="472" onmouseover="this.scrollAmount=0"
																	onmouseout="this.scrollAmount=3">
																<table width="100%" border="0" cellspacing="0"
																	cellpadding="0">
																	<tr>
																		<td align="left" valign="top"><table width="100%"
																				border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;Thank you very much
																						for your excellent service. You made buying a new
																						vehicle virtually stress free.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Sandra, MDe</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left" valign="top">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;Thank you very much
																						for all your attention. Usually as soon as people
																						hear I have no credit they don't care. Thank you
																						again for all your interest and help.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Kristine, CA</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left" valign="top"><table width="100%"
																				border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;This was a wonderful
																						experience! I had confidence walking into the
																						dealership and knowing I was in control. I didn't
																						have to sit and wait on the edge of my seat to see
																						what they would be &quot;able&quot; to offer me or
																						if they could do anything at all. I am telling all
																						my friends and family about you and what a great
																						deal you found for us to start over with! Thank
																						you so much!&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Mike and Brenda</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left" valign="top"><table width="100%"
																				border="0" cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;Thank you for
																						checking up with me, your service has performed
																						flawlessly. I had dealers coming to me, working to
																						get my business. It's rare when a service works as
																						well or better than advertised. I will be using
																						you for all future vehicle purchases!&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- James</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;I would just like to
																						say Thank You to everyone who took the time to
																						look over my application and respond so quickly.
																						That shows that you really care about people and
																						you believe in helping them get a second
																						chance.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Earlene</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;Thanks a lot. I mean
																						really thanks. Just when I'd about given up, here
																						you are, and I really appreciate your continuing
																						efforts. I love it, and I'm going to call right
																						now and tell all my friends and relatives about
																						you and your service.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Sylviann</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;I purchased the
																						exact vehicle we've been looking for! We are
																						extremely excited and very pleased. We've bounced
																						from dealer to dealer with no success until
																						contacting you.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Shamonique</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;I just want to touch
																						bases with you and thank you for referring me to
																						Turnpike Ford. They were able to put me in a car
																						and make the whole encounter very enjoyable. I
																						have referred a number of friends to them. I want
																						to thank you, again.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Wanda</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;Thank you very much
																						for all your attention. Usually as soon as people
																						hear I have no credit they don't care. Thank you
																						again for all your interest and help.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Crystal</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;We are extremely
																						grateful and appreciative for the fast and highly
																						professional service you accorded us. Your loan
																						specialists were fast and pleasant to deal with.
																						The lender you referred us to provided the
																						solution we were looking for and we got the car we
																						wanted. Undoubtedly, this was the best auto
																						finance experience we have ever had. We will
																						definitely recommend your services to anyone
																						looking to buy a car.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Jeff and Arlene</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;I would like to say
																						a big Thank You to all the guys at Carzloan who
																						processed my application and responded with
																						lightning speed. Thank you for caring about me and
																						giving me a second chance.&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Eugene</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;One of your dealers
																						called me roughly one week ago and told me he
																						could help me buy a car. After completing the
																						application, I was approved and bought a Mustang
																						5.0 convertible. I am so impressed with your
																						service given that I recently filed for
																						bankruptcy. Please accept my sincere thanks!&quot;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Terrence</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&quot;My wife and I would
																						like to thank Carzloan for getting us a car in
																						less than 3 HOURS! Other companies couldn&rsquo;t
																						help us, but Carzloan found us financing in
																						MINUTES! We picked out the car WE WANTED and were
																						done! Oh, and my wife says Hallelujah. <strong>Your
																							favorite and life long customers</strong>.&rdquo;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Glenn and Natia
																						R.</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&ldquo;I tried Carzloan
																						thinking they would be just like all the other bad
																						credit auto loan companies out there…all talk.
																						Well, I&rsquo;m sure glad I tried it. They
																						referred me to a great dealership that took the
																						time to understand my situation, got me the car
																						and car loan I wanted and a great deal. Thank
																						you.&rdquo;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Michael K.</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&ldquo;Carzloan had an
																						offer of car financing for me, yes me who has very
																						bad credit…within 2 hours, we signed the auto
																						loan papers and I drove away. I have NEVER, NEVER,
																						NEVER had such an experience buying a car. Thanks
																						again Carzloan.&rdquo;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Sue N.</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&ldquo;I just wanted to
																						thank you for sending me to the right people to
																						get my new car. My experience with the
																						participating Carzloan dealership was very good, I
																						mean excellent. Everyone there was kind and very
																						professional. I send special thanks to the finance
																						and sales department. Thank you Carzloan for
																						making my life better. I have a car that I am very
																						happy with. Thank you.&rdquo;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Edwin O.</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&ldquo;I just wanted thank
																						you for your service. I went yesterday to the
																						participating Carzloan dealership in NY and now I
																						have a car loan and a car. They were great. Keep
																						up the good work! Thank you.&rdquo;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Teresa V.</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																	<tr>
																		<td align="left"><table width="100%" border="0"
																				cellspacing="0" cellpadding="0">
																				<tr>
																					<td width="22" align="left" valign="top"><img
																						src="images/testimonialicon.png" width="12"
																						height="17" /></td>
																					<td align="left" valign="top"
																						class="testimonialtext">&ldquo;Hi there! I just
																						wanted to say thank you! Carzloan got us approved
																						for a no credit auto loan and in the vehicle we
																						wanted with no hassle. The dealership was amazing
																						and we would recommend them and Carzloan to
																						everyone we know! Thanks SO much.&rdquo;</td>
																				</tr>
																				<tr>
																					<td align="left" valign="top">&nbsp;</td>
																					<td height="25" align="left" valign="top"
																						class="testimonialorrangetext">- Janet K.</td>
																				</tr>
																			</table></td>
																	</tr>
																	<tr>
																		<td align="left"><img
																			src="images/testimonialdevider.jpg" width="230"
																			height="2" /></td>
																	</tr>
																	<tr>
																		<td align="left">&nbsp;</td>
																	</tr>
																</table>
																</marquee></td>
															<td>&nbsp;</td>
														</tr>
														<tr>
															<td>&nbsp;</td>
															<td height="29">&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
													</table></td>
												<td width="1" bgcolor="#e5e5e5"><img src="images/blank.gif"
													width="1" height="1" /></td>
											</tr>
										</table></td>
								</tr>
							</table></td>
						<td width="503" height="896" align="left" valign="top"
							background="images/loanapplicationformbg.jpg"
							style="background-repeat: no-repeat"><table width="100%"
								border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20">&nbsp;</td>
									<td height="896" align="left" valign="top"><form id="form_2"
											name="form_2" method="post" action="">
											<input type="hidden" name="vid"
												value="<?php echo (isset($_REQUEST['vid'])?$_REQUEST['vid']:'');?>"
												id="vid" /> <input type="hidden" name="sid" id="sid"
												value="<?php echo (isset($_REQUEST['sid'])?$_REQUEST['sid']:'');?>" />

											<table width="100%" border="0" cellspacing="0"
												cellpadding="0">
												<tr>
													<td height="35" align="left">&nbsp;</td>
												</tr>
												<tr>
													<td height="45" align="left" valign="top"
														class="formheading">Final Approval Process</td>
												</tr>
												<tr>
													<td align="left" valign="top" class="graytext14">Welcome <strong style="color: darkorange;"><?php echo $_GET['first_name']; ?>
													</strong> ! Please fill in your details below</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
												</tr>
												<tr>
													<td height="22" align="left" valign="top" class="formtext">Type
														of Car Loan</td>
												</tr>
												<tr>
													<td id="li_4"
														class="<?php if($err['element_4'] != '')echo "error"; ?>"
														height="35" align="left" valign="top"><select
														class="inputmanu" id="element_4" name="element_4">
															<option value="4"
															<? if($_POST['element_4'] == '4' || $_GET['car_loan_type'] == '4' ) { echo 'selected="selected"';}?>>Purchase
																a New Car</option>
															<option value="2"
															<? if($_POST['element_4'] == '2' || $_GET['car_loan_type'] == '2' ) { echo 'selected="selected"';}?>>Purchase
																a Used Car</option>
															<option value="3"
															<? if($_POST['element_4'] == '3' || $_GET['car_loan_type'] == '3' ) { echo 'selected="selected"';}?>>Refinance
																Your Car</option>
													</select> <?php if($err['element_4'] != '') { ?>
														<p style="color: red;" class="error">
														<?php echo $err['element_4'];?>
														</p> <?php }  ?>
													</td>
												</tr>
												<tr>
													<td height="22" align="left" valign="top" class="formtext">First
														Name</td>
												</tr>
												<tr>
													<td height="45" align="left" valign="top"><input
														name="first_name" type="text" class="input"
													 id="first_name" maxlength="40"
														value="<? if (isset($_REQUEST['first_name'])) { echo $_REQUEST['first_name'];} else {  echo $first_name;} ?>" />
														<?php if($err['first_name'] != '') { ?>
														<p style="color: red;" class="error">
														<?php echo $err['first_name'];?>
														</p> <?php }  ?>
												
												</tr>
												</td>
												<tr>
													<td height="22" align="left" valign="top" class="formtext">Last
														Name</td>
												</tr>
												<tr>
													<td height="45" align="left" valign="top"><input
														name="last_name" type="text" 
														class="input" id="last_name" maxlength="40"
														value="<? if (isset($_REQUEST['last_name'])) { echo $_REQUEST['last_name'];} else {  echo $last_name;} ?>" />
														<?php if($err['last_name'] != '') { ?>
														<p style="color: red;" class="error">
														<?php echo $err['last_name'];?>
														</p> <?php }  ?>
													</td>
												</tr>

												<tr>
													<td height="22" align="left" valign="top" class="formtext">Email</td>
												</tr>
												<tr>
													<td height="45" align="left" valign="top"><input
														name="email" type="text" title="Enter valid email"
														class="input emailvalidate required" id="email"
														value="<? if (isset($_REQUEST['email'])) { echo $_REQUEST['email'];} else {  echo $email;} ?>" />
														<?php if($err['email'] != '') { ?>
														<p style="color: red;" class="error">
														<?php echo $err['email'];?>
														</p> <?php }  ?>
													</td>
												</tr>
												<tr>
													<td height="22" align="left" valign="top" class="formtext">Phone</td>
												</tr>
												<tr>
													<td class="<?php if($err['phone'] != '')echo "error"; ?>"
														height="45" align="left" valign="top"><input name="phone"
														type="text" maxlength="10" minlength="10"
														title="Enter valid phone" class="number required input"
														id="phone"
														value="<? if (isset($_POST['phone'])) { echo $_POST['phone'];} else {  echo $_GET['phone'];} ?>" />

														
														<?php if($err['phone'] != '') { ?>
														<p style="color: red;" class="error">
														<?php echo $err['phone'];?>
														</p> <?php }  ?>
													</td>
												</tr>
												<tr>
													<td height="22" align="left" valign="top" class="formtext">Address</td>
												</tr>
												<tr>
													<td height="45" align="left" valign="top"><input
														name="address" type="text" class="input required"
														title="Enter address" id="address"
														value="<? if (isset($_REQUEST['address'])) { echo $_REQUEST['address'];} else {  echo $address;} ?>" />
														<?php if($err['address'] != '') { ?>
														<p style="color: red;" class="error">
														<?php echo $err['address'];?>
														</p> <?php }  ?>
													</td>
												</tr>
											<tr>
													<td height="22" align="left" valign="top" class="formtext">Zip</td>
												</tr>
												<tr>
													<td height="45" align="left" valign="top"><input name="zip"
																	type="text" maxlength="5" minlength="5"
																	title="Enter valid zip" class="number required input"
																	id="zip" 
																	value="<? if (isset($_REQUEST['zip'])) { echo $_REQUEST['zip'];} else {  echo $zip;} ?>" />
																	
																	
																	<?php if($err['zip'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['zip'];?>
																	</p> <?php }  ?>
													</td>
												</tr>
												<input name="city" id="city" type="hidden" value="<? if (isset($_REQUEST['city'])) { echo $_REQUEST['city'];} else {  echo $city;} ?>">
											<input name="state" id="state" type="hidden" value="<? if (isset($_REQUEST['state'])) { echo $_REQUEST['state'];} else {  echo $state;} ?>">

												<!--
												<tr>
													<td align="left" valign="top"><table width="100%"
															border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="22" align="left" valign="top"
																	class="formtext">City</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top" class="formtext">State</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top" class="formtext">Zip</td>
															</tr>
															<tr>

																<td height="45" align="left" valign="top"><input
																	name="city" type="text" class="input required"
																	title="Enter city" id="city"
																	style="height: 24px; width: 140px;"
																	value="<? if (isset($_REQUEST['city'])) { echo $_REQUEST['city'];} else {  echo $city;} ?>" />
																	<?php if($err['city'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['city'];?>
																	</p> <?php }  ?>
																</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top"><select name="state"
																	title="Select state" class="required inputsmall"
																	id="state">
																	<?php 
                                                           foreach($STATE as $k => $v){
					                                                $sel=($k==$state)?"selected":"";
					                                       echo '<option value="'.$k.'" '.$sel.' >'.$v.'</option>';
				                                                   }?>
																</select> <?php if($err['state'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['state'];?>
																	</p> <?php }  ?>
																</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top"><input name="zip"
																	type="text" maxlength="5" minlength="5"
																	title="Enter valid zip" class="number required input"
																	id="zip" style="height: 24px; width: 140px;"
																	value="<? if (isset($_REQUEST['zip'])) { echo $_REQUEST['zip'];} else {  echo $zip;} ?>" />
																	
																	
																	<?php if($err['zip'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['zip'];?>
																	</p> <?php }  ?>
																</td>
															</tr>
														</table></td>
												</tr>
!-->
												<tr>
													<td align="left" valign="top" id="car_li"><table
															width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="22" align="left" valign="top"
																	class="formtext">Make</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top" class="formtext">Model</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top" class="formtext">Trim</td>
															</tr>
															<tr>
																<td height="45" align="left" valign="top"><select
																	name="make" class="required inputsmall"
																	title="Select make" id="make">
																</select> <?php if($err['make'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['make'];?>
																	</p> <?php }  ?>
																</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top"><select name="model"
																	title="Select model" class="required inputsmall"
																	id="model">
																	<option value="">--Select--</option>
																</select> <?php if($err['model'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['model'];?>
																	</p> <?php }  ?>
																</td>
																<td align="left" valign="top">&nbsp;</td>
																<td align="left" valign="top"><select name="trim"
																	title="Select trim" class="required inputsmall"
																	id="trim">
																	<option value="">--Select--</option>
																</select> <?php if($err['trim'] != '') { ?>
																	<p style="color: red;" class="error">
																	<?php echo $err['trim'];?>
																	</p> <?php }  ?>
																</td>
															</tr>
														</table></td>
												</tr>
												<tr>
													
												</tr>
												<tr>
													<td height="30" align="left" valign="top"><table
															width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="25" align="left"><input type="checkbox"
																	name="element_5_1" id="element_5_1" class="required"
																	checked="yes" /></td>
																<td align="left" class="whitetext12size">I have read the
																	<a href="privacy.php" class="various fancybox.iframe">Privacy Policy</a> and State Law Disclosures</td>
															</tr>
														</table></td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
												</tr>
												<tr>
													<td height="54" align="center" valign="middle"
														background="images/getapprovedbg.png"
														style="background-repeat: no-repeat"><input name="submit"
														value="1" type="hidden"> <input name="submit"
															type="submit" value="" class="btm_getapproved"
															id="saveForm" />
													
													</td>
												</tr>
												<tr>
													<td align="left">&nbsp;</td>
												</tr>
											</table>
										</form></td>
									<td width="20">&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
									<td class="blacktext14"><div align="justify">
											After you submit this car loan form, you will be presented
											with your car loan options and interest rates.<br /> <br />
											Your Car Loan is approved, regardless of your credit! The
											nation's leading Source for all of your auto loan needs.<br />
											<br /> Just complete our FREE, NO HASSLE online AUTO LOANS
											inquiry...and you'll be rolling tomorrow!
										</div></td>
									<td>&nbsp;</td>
								</tr>
							</table></td>
						<td width="202" align="left" valign="top"><table width="100%"
								border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td align="right"><img src="images/rightmanutopline.jpg"
										width="1" height="31" /></td>
								</tr>
								<tr>
									<td class="smallheadpointbg">Services at your doorsteps</td>
								</tr>
								<tr>
									<td class="smallheadpointbg">Most competitive rates</td>
								</tr>
								<tr>
									<td class="smallheadpointbg">Hassle free documentation</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top" class="whitetext18"><div
											align="justify">Find the Vehicle You Want Preferred pricing
											and fast, easy financing</div></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top" class="whitetext14"><div
											align="justify">We're here to help you get the automobile you
											want, and the financing you deserve.</div></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td align="left" valign="top"><img
										src="images/leftmanucarinsurance.jpg" width="202" height="174" />
									</td>
								</tr>
								<tr>
									<td valign="middle" height="61" align="center"><img width="202"
										height="50" src="images/bestreate.png">
									
									</td>
								</tr>
								<tr>
									<td align="left" valign="top">
									<div class="we-can-help-box">
<div class="we-can-help-box-top">
<div class="we-can-help-box-top-img"><img src="images/car-icon.png"></div>
We can help you<br>rebuild your<br>good credit.
</div>
<div class="we-can-help-box-bottom"> out what types of loans you can get if you've got good or excellent credit.</div>
</div>
<div class="we-can-help-box">
<div class="we-can-help-box-top">
<div class="we-can-help-box-top-img"><img src="images/car-icon.png"></div>
Bad Credit?&nbsp;NO PROBLEM! get<br>an instant autoloan.
</div>
<div class="we-can-help-box-bottom"> out what types of loans you can get if you've got good or excellent credit.</div>
</div>
<div class="we-can-help-box">
<div class="we-can-help-box-top">
<div class="we-can-help-box-top-img"><img src="images/car-icon.png"></div>
Get Approved<br>easy, simple and<br>secure.
</div>
<div class="we-can-help-box-bottom"> out what types of loans you can get if you've got good or excellent credit.</div>
</div>
<div class="we-can-help-box-top-img" style="padding:0px 0px 0px 11px;"><img src="images/leftmanugetapprovedcarimg.jpg"></div>


									</td>
								</tr>
							</table></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td align="center" valign="top" class="contantbottomline">&nbsp;</td>
		</tr>
		<tr>
			<td height="106" align="center" valign="middle" bgcolor="#212121"><table
					width="994" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="38" align="left" valign="middle"><img
							src="images/leftarrow.png" width="38" height="42" /></td>
						<td width="15" align="left" valign="middle">&nbsp;</td>
						<td align="center" valign="middle"><table width="100%" border="0"
								cellspacing="0" cellpadding="0">
								<tr>
									<td align="left" valign="middle"><script type="text/javascript">
marqueeInit({
	uniqueid: 'mycrawler',
	style: {
		'padding': '0px',
		'width': '888px'
	},
	inc: 8, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 2,
	neutral: 50,
	savedirection: true
});
</script>



										<div class="marquee" id="mycrawler2">
											<a href="car_application.php"><img
												src="images/carlogo/acura.png" border="0" /> </a> <a
												href="car_application.php"><img
												src="images/carlogo/alfaromeo.png" border="0" /> </a> <a
												href="car_application.php"><img
												src="images/carlogo/amgeneral.png" border="0" /> </a> <a
												href="car_application.php"><img
												src="images/carlogo/astronmartin.png" border="0" /> </a> <a
												href="car_application.php"><img
												src="images/carlogo/audi.png" border="0" /> </a> <a
												href="car_application.php"><img
												src="images/carlogo/bentley.png" border="0" /> </a> <a
												href="car_application.php"><img src="images/carlogo/bmw.png"
												border="0" /> </a> <a href="car_application.php"><img
												src="images/carlogo/buick.png" border="0" /> </a> <a
												href="car_application.php"><img
												src="images/carlogo/cadillac.png" border="0" /> </a>
										</div> <script type="text/javascript">
marqueeInit({
	uniqueid: 'mycrawler2',
	style: {
		'padding': '0px',
		'width': '100px',
		'height': '80px'
	},
	inc: 8, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 2,
	neutral: 50,
	savedirection: true,
	random: true
});
</script></td>
								</tr>
							</table></td>
						<td width="15" align="right" valign="middle">&nbsp;</td>
						<td width="38" align="right" valign="middle"><img
							src="images/rightarrow.png" width="38" height="42" /></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td height="100" align="center" valign="middle"><table width="994"
					border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td align="left" class="blacktext"><a href="index.php"
							class="bottomlinkhover">Home</a>&nbsp;&nbsp; |&nbsp;&nbsp; <a
							href="car_application.php" class="bottomlinkhover">Car Loan
								Application</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a
							href="auto_application.php" class="bottomlinkhover">Car Insurance</a>&nbsp;&nbsp;
							|&nbsp;&nbsp; <a href="privacy.php"  class="bottomlinkhover  various fancybox.iframe" id="privacy">Privacy Policy</a>
						 &nbsp;&nbsp; | &nbsp;&nbsp;<a
							href="http://managesubscriber.com/" target="_blank"
							class="bottomlinkhover">Unsubscribe</a></td>
						<td>&nbsp;</td>
						<td width="110" align="right"><img src="images/bbb.jpg" width="90"
							height="34" /></td>
						<td width="76" align="right"><img src="images/verisigrr.jpg"
							width="56" height="34" /></td>
						<td width="109" align="right"><img src="images/truste.jpg"
							width="89" height="34" /></td>
					</tr>
				</table></td>
		</tr>
		<tr>
			<td height="40" align="center" valign="top" bgcolor="#e86006"
				class="copyrighttext">Copyright &copy; 2013	 Carzloan.com - All
				Rights Reserved</td>
		</tr>
	</table>
</body>
</html>

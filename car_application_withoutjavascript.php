<?php
require("config.php");
error_reporting(0);
$STATE = array(""=>"--Select--","AL"=>"Alabama","AK"=>"Alaska","AZ"=>"Arizona","AR"=>"Arkansas","CA"=>"California","CO"=>"Colorado","CT"=>"Connecticut","DE"=>"Delaware","DC"=>"District of Columbia","FL"=>"Florida","GA"=>"Georgia","HI"=>"Hawaii","ID"=>"Idaho","IL"=>"Illinois","IN"=>"Indiana","IA"=>"Iowa","KS"=>"Kansas","KY"=>"Kentucky","LA"=>"Louisiana","ME"=>"Maine","MD"=>"Maryland","MA"=>"Massachusetts","MI"=>"Michigan","MN"=>"Minnesota","MS"=>"Mississippi","MO"=>"Missouri","MT"=>"Montana","NE"=>"Nebraska","NV"=>"Nevada","NH"=>"New Hampshire","NJ"=>"New Jersey","NM"=>"New Mexico","NY"=>"New York","NC"=>"North Carolina","ND"=>"North Dakota","OH"=>"Ohio","OK"=>"Oklahoma","OR"=>"Oregon","PA"=>"Pennsylvania","RI"=>"Rhode Island","SC"=>"South Carolina","SD"=>"South Dakota","TN"=>"Tennessee","TX"=>"Texas","UT"=>"Utah","VT"=>"Vermont","VA"=>"Virginia","WA"=>"Washington","WI"=>"Wisconsin","WV"=>"West Virginia","WY"=>"Wyoming");
//insert to database	

if(isset($_POST['submit']) || isset($_POST['submit']) ){
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
	$to = 'varsha.hassani@axiombpm.com,mahesh@axiombpm.com,leads@incedebrands.com' . ', ';
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
	$to = 'varsha.hassani@axiombpm.com,mahesh@axiombpm.com,leads@incedebrands.com' . ', ';
	 $subject=$_SERVER['HTTP_REFERER'];
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	 mail($to, $subject, $mailmessage, $headers);
	$data= str_replace('vendor_id=','vid=',str_replace('sub_id=','sid=',$data));
//print_r($car_mailmessage);exit;

		$location = "https://www.web2carz.com/bad-credit-auto-loan-application?w2caf=da420a854646e9ab&subid=".$_GET['sub_id']."&firstName=".$_POST['first_name']."&lastName=".$_POST['last_name']."&email=".$_POST['email']."&homePhone=".$_POST['phone']
					."&address=".$_POST['address']
					."&city=".$_POST['city']
					."&state=".$_POST['state']
					."&zip=".$_POST['zip']
		;
		header("location:".$location);exit;		
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
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CARZLOAN : make finance easy</title>
<link rel="shortcut icon" href="/favicon.png" >
	<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<!--MOHAN-->
	<script type="text/javascript" src="js/general.js"></script>
	<script>
		!window.jQuery && document.write('<script src="jquery-1.4.3.min.js"><\/script>');
	</script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script  type="text/javascript">
$(document).ready(function() {
	//alert("first")
	$('#saveForm').click(function() {//alert('dfd');
		$("#form_2").validate({
rules: {
				zip: { validateZip : true },
		        phone: { phoneUS : true }
		    }
			
		});
		$("#form_2").submit();
	});

	jQuery.validator.addMethod("phoneUS",function(value,element){
        var respo= $.ajax({
           url: 'check_phone.php',
           type: 'POST',
           async: false,
           data: "phone=" + value + "&checking=true"
        }).responseText;
        if(respo=="Valid") return true; else return false;
       },"Please specify a valid phone number");
	jQuery.validator.addMethod("validateZip",function(value,element){
	    var respo= $.ajax({
	       url: "check_zip.php",
	       type: 'POST',
	       datatype:'json',
	       async: false,
	       data: "zip=" + value + "&checking=true"
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
	},"Please specify a valid zip code")		
});
</script>

	<!--MOHAN-->
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<script type="text/javascript">
		$(document).ready(function() {
			/*
			*   Examples - various
			*/

			$("#aboutus").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

			$("#blog").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$("#contactus").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
			
			$("#privacy").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
	</script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
#dropcontentsubject{
width: 230px;
font-weight: bold;
}

.dropcontent{
width: 230px;
height: 210px;
padding: 3px;
display:block;
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
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="110" align="center" valign="top" background="images/topbg.jpg" style="background-repeat:repeat-x"><table width="994" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="310" rowspan="2" align="left" valign="top"><a href="index.php"><img src="images/logo.png" alt="logo" width="310" height="110" border="0" /></a></td>
        <td height="62" align="right" valign="middle" class="blackitalic">Auto Loans, Used Car Loans, and Auto Loan Refinancing</td>
      </tr>
      <tr>
        <td height="48" align="right" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td>&nbsp;</td>
            <td align="right" class="toplink"><a href="index.php" class="toplinkhover">Home</a></td>
            <td class="toplinkdevider">&nbsp;</td>
            <td width="150" align="right" class="toplink"><a href="car_application.php" class="toplinkhover">Car Loan Application</a></td>
            <td class="toplinkdevider">&nbsp;</td>
            <td width="101" align="right" class="toplink"><a href="auto_application.php" class="toplinkhover">Car Insurance</a></td>
			<td class="toplinkdevider">&nbsp;</td>
            <td width="65" align="right" class="toplink"><a href="#inline1" title="CARZLOAN" class="toplinkhover" id="aboutus">About Us</a>
			<div style="display: none;">
                <div align="justify" id="inline1" style="width:700px;height:400px;overflow:auto;"><br />
                  <span class="steporrange">CARZLOAN   |</span> About Us<br />
                  <br />
                  <span class="orrangetextbold">CARZLOAN.com</span> is one of largest and leading auto car finance industry. We have been servicing the auto finance market for many years across the globe. Our founding team comprises of service and result oriented people with a vast experience in auto industry as well as ecommerce.<br />
                  <br />
                  Our staff is committed and devoted to always keep your needs in mind first. They strive to deliver the best, and our quotes are designed specially to match your needs. We are aimed to provide you with the lowest and most competitive rates of auto loan, auto insurance, and auto warranty quotes.<br />
                  <br />
                  We honor our privacy and hence our systems are highly secure and we guarantee that your details would be maintained in confidentiality. In case if you desire not to take a quote from us, we would not be pestering you with numerous phone calls or emails. As we appreciate and value your privacy.<br />
                  <br />
                  With a perfect blend of hard work, commitment, quality, superior auto coverage, competitively low price, we deliver the best!<br />
                  <br />
                  <span class="orrangetextbold">CARZLOAN.com has 4 Simple Steps to Get a Car Loan...</span><br />
                  <span class="steptext">-------------------------------------------------------------------------------------------------------------------------------------------------------------------------</span><br />
                  <br />
                  <span class="steporrange">Step 1: Complete the application</span><br />
                  Fill in all the required information and submit your request.<br />
                  You will create a unique ID and passcode for your security.<br />
                  <br />
                  <span class="steporrange">Step 2: Receive a decision</span><br />
                  Most applications will receive a decision within 60 seconds.<br />
                  If your decision is not ready within 60 seconds, you will be notified via email when your decision is ready.<br />
                  <br />
                  <span class="steporrange">Step 3: Ready to buy</span><br />
                  Approved applicants will receive a list of financing options.<br />
                  You will be contacted by one of our loan representatives within one business day to verify your identity and advise you of the next steps to complete your loan.<br />
                  <br />
                  <span class="steporrange">Step 4: Closing the deal</span><br />
                  Your loan representative will prepare a loan package that includes all the necessary documents for your signature.<br />
                  We'll send your package to you electronically or via express delivery. Just get everything signed and send it back using the appropriate method (electronically or pre-paid envelope). Notary may be required.<br />
                  We'll verify the documents and fund your loan quickly.<br />
                  <br />
                  How is CARZLOAN.com different than most other auto loan companies? </div>
              </div>
            </td>
            <td class="toplinkdevider">&nbsp;</td>
            <td width="28" align="right"><a href="#inline2" title="CARZLOAN" class="toplinkhover" id="blog">Blog</a>
              <div style="display: none;">
                <div align="justify" id="inline2" style="width:700px;height:400px;overflow:auto;"><br />
                  <span class="steporrange">CARZLOAN   |</span><span class="toplink"> Blog</span><br />
                  <br />
                  <span class="orrangetextbold">This page is under construction... </span><br />
                </div>
              </div></td>
            <td class="toplinkdevider">&nbsp;</td>
            <td width="80" align="right"><a href="contact_us.php" title="CARZLOAN" class="toplinkhover">Contact Us</a>
              <div style="display: none;">
                <div align="justify" id="inline3" style="width:700px;height:400px;overflow:auto;"><br />
                  <span class="steporrange">CARZLOAN   |</span><span class="toplink"> Contact Us</span><br />
                  <table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10">&nbsp;</td>
    <td width="640" height="290" background="images/contact-us-bg.jpg" style="background-repeat:no-repeat"><form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="20" height="20">&nbsp;</td>
          <td width="180" height="20" align="left" class="formtext">&nbsp;</td>
          <td width="20" align="left">&nbsp;</td>
          <td width="390" align="left" class="formtext">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="23" align="left" class="steptext">FIRST NAME</td>
          <td align="left">&nbsp;</td>
          <td align="left" class="steptext">LAST NAME</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left"><input name="First Name" type="text" id="First Name" size="20" /></td>
          <td align="left">&nbsp;</td>
          <td align="left"><input name="Last Name" type="text" id="Last Name" size="20" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="23" align="left" class="steptext">PHONE</td>
          <td align="left">&nbsp;</td>
          <td align="left" class="steptext">EMAIL</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left"><input name="Phone" type="text" id="Phone" size="20" /></td>
          <td align="left">&nbsp;</td>
          <td align="left"><input name="Email" type="text" id="Email" size="20" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td height="23" align="left" class="steptext">CITY</td>
          <td align="left">&nbsp;</td>
          <td align="left" class="steptext">ZIP CODE</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left"><input name="City" type="text" id="City" size="20" /></td>
          <td align="left">&nbsp;</td>
          <td align="left"><input name="Zip Code" type="text" id="Zip Code" size="20" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
          <td align="left">&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="30" align="left" valign="top"><input type="checkbox" name="checkbox" id="checkbox" /></td>
              <td class="privacy">i have read the <span class="privacyblack">Privacy Policy</span> and State Law Disclosures.</td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td colspan="3" align="left" valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td height="40" colspan="3" align="left" valign="middle"><a href="#"><img src="images/applynow.png" width="139" height="32" border="0" id="Image1" onmouseover="MM_swapImage('Image1','','images/applynow-r.png',1)" onmouseout="MM_swapImgRestore()" /></a></td>
        </tr>
      </table>
    </form></td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
                  <br />
                </div>
              </div></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="524" align="center" valign="top" background="images/bannerbg.jpg" style="background-repeat:repeat-x"><table width="994" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="289" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><img src="images/leftmanutopline.jpg" width="1" height="31" /></td>
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
            <td class="headpointbg">No Social Security#Needed!</td>
          </tr>
          <tr>
            <td class="headpointbg">Hassle Free, Simple Process</td>
          </tr>
          <tr>
            <td height="254" align="left" valign="top" bgcolor="#313131"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="20">&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td align="left" valign="top" class="whitetext12size"><div align="justify">Let banks and credit unions battle it out to get you great rates on Auto Financing for new and used auto loans. You get free access to great deals in real time!<br />
                  <br />
                  Carzloan.com is the Nation's Leading Source for Auto Loans! We will instantly match you with the right lender, and you'll be approved immediately!<br />
                  <br />
                  Remember this is a Free Car Loanservice and there is noobligation.</div></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td height="57" align="center" valign="middle"><img src="images/freequickandeasy.png" width="289" height="31" /></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1" bgcolor="#e5e5e5"><img src="images/blank.gif" width="1" height="1" /></td>
                <td width="287" align="left" valign="top" bgcolor="#fbfbfb"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="28">&nbsp;</td>
                    <td height="33">&nbsp;</td>
                    <td width="28">&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td width="230" height="32" align="left" valign="top"  background="images/testimonialheading.jpg" style="background-repeat:no-repeat">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><img src="images/blank.gif" width="1" height="1" /></td>
                    <td height="10" align="left" valign="top"><img src="images/blank.gif" width="1" height="1" /></td>
                    <td><img src="images/blank.gif" width="1" height="1" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top" background="images/testimoniallogobg.gif" style="background-repeat:no-repeat"><marquee scrollamount="3" direction="up" width="230" height="472" onmouseover="this.scrollAmount=0" onmouseout="this.scrollAmount=3">
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;Thank you very much for your excellent service. You made buying a new vehicle virtually stress free.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Sandra, MDe</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left" valign="top">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;Thank you very much for all your attention. Usually as soon as people hear I have no credit they don't care. Thank you again for all your interest and help.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Kristine, CA</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;This was a wonderful experience! I had confidence walking into the dealership and knowing I was in control. I didn't have to sit and wait on the edge of my seat to see what they would be &quot;able&quot; to offer me or if they could do anything at all. I am telling all my friends and family about you and what a great deal you found for us to start over with! Thank you so much!&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Mike and Brenda</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;Thank you for checking up with me, your service has performed flawlessly. I had dealers coming to me, working to get my business. It's rare when a service works as well or better than advertised. I will be using you for all future vehicle purchases!&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- James</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;I would just like to say Thank You to everyone who took the time to look over my application and respond so quickly. That shows that you really care about people and you believe in helping them get a second chance.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Earlene</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;Thanks a lot. I mean really thanks. Just when I'd about given up, here you are, and I really appreciate your continuing efforts. I love it, and I'm going to call right now and tell all my friends and relatives about you and your service.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Sylviann</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;I purchased the exact vehicle we've been looking for! We are extremely excited and very pleased. We've bounced from dealer to dealer with no success until contacting you.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Shamonique</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;I just want to touch bases with you and thank you for referring me to Turnpike Ford. They were able to put me in a car and make the whole encounter very enjoyable. I have referred a number of friends to them. I want to thank you, again.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Wanda</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;Thank you very much for all your attention. Usually as soon as people hear I have no credit they don't care. Thank you again for all your interest and help.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Crystal</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;We are extremely grateful and appreciative for the fast and highly professional service you accorded us. Your loan specialists were fast and pleasant to deal with. The lender you referred us to provided the solution we were looking for and we got the car we wanted. Undoubtedly, this was the best auto finance experience we have ever had. We will definitely recommend your services to anyone looking to buy a car.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Jeff and Arlene</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;I would like to say a big Thank You to all the guys at Carzloan who processed my application and responded with lightning speed. Thank you for caring about me and giving me a second chance.&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Eugene</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;One of your dealers called me roughly one week ago and told me he could help me buy a car. After completing the application, I was approved and bought a Mustang 5.0 convertible. I am so impressed with your service given that I recently filed for bankruptcy. Please accept my sincere thanks!&quot;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Terrence</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&quot;My wife and I would like to thank Carzloan for getting us a car in less than 3 HOURS! Other companies couldn&rsquo;t help us, but Carzloan found us financing in MINUTES! We picked out the car WE WANTED and were done! Oh, and my wife says Hallelujah. <strong>Your favorite and life long customers</strong>.&rdquo;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Glenn and Natia R.</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&ldquo;I tried Carzloan thinking they would be just like all the other bad credit auto loan companies out there…all talk. Well, I&rsquo;m sure glad I tried it. They referred me to a great dealership that took the time to understand my situation, got me the car and car loan I wanted and a great deal. Thank you.&rdquo;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Michael K.</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&ldquo;Carzloan had an offer of car financing for me, yes me who has very bad credit…within 2 hours, we signed the auto loan papers and I drove away. I have NEVER, NEVER, NEVER had such an experience buying a car. Thanks again Carzloan.&rdquo;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Sue N.</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&ldquo;I just wanted to thank you for sending me to the right people to get my new car. My experience with the participating Carzloan dealership was very good, I mean excellent. Everyone there was kind and very professional. I send special thanks to the finance and sales department. Thank you Carzloan for making my life better. I have a car that I am very happy with. Thank you.&rdquo;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Edwin O.</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&ldquo;I just wanted thank you for your service. I went yesterday to the participating Carzloan dealership in NY and now I have a car loan and a car. They were great. Keep up the good work! Thank you.&rdquo;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Teresa V.</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td width="22" align="left" valign="top"><img src="images/testimonialicon.png" width="12" height="17" /></td>
                    <td align="left" valign="top" class="testimonialtext">&ldquo;Hi there! I just wanted to say thank you! Carzloan got us approved for a no credit auto loan and in the vehicle we wanted with no hassle. The dealership was amazing and we would recommend them and Carzloan to everyone we know! Thanks SO much.&rdquo;</td>
                  </tr>
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                    <td height="25" align="left" valign="top" class="testimonialorrangetext">- Janet K.</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left"><img src="images/testimonialdevider.jpg" width="230" height="2" /></td>
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
                <td width="1" bgcolor="#e5e5e5"><img src="images/blank.gif" width="1" height="1" /></td>
              </tr>
            </table></td>
          </tr>
          </table></td>
        <td width="503" height="896" align="left" valign="top" background="images/loanapplicationformbg.jpg" style="background-repeat:no-repeat"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="20">&nbsp;</td>
            <td height="896" align="left" valign="top"><form id="form_2" name="form_2" method="post" action="">
<input type="hidden" name="vid" value="<?php echo (isset($_REQUEST['vid'])?$_REQUEST['vid']:'');?>" id="vid" /> 
		<input type="hidden" name="sid" id="sid" value="<?php echo (isset($_REQUEST['sid'])?$_REQUEST['sid']:'');?>" />
		
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="35" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top" class="formheading">Final Approval Process</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="graytext14">Welcome <strong style="color:darkorange;"><?php echo $_GET['first_name'].'&nbsp;'.$_GET['last_name']; ?></strong> ! Please fill in your details below</td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Type of Car Loan</td>
                </tr>
                <tr>
                  <td height="35" align="left" valign="top"><select class="inputmanu" id="element_4" name="element_4">
                    <option value="4" <? if($_POST['element_4'] == '4' || $_GET['car_loan_type'] == '4' ) { echo 'selected="selected"';}?> >Purchase a New Car</option>
                    <option value="2" <? if($_POST['element_4'] == '2' || $_GET['car_loan_type'] == '2' ) { echo 'selected="selected"';}?> >Purchase a Used Car</option>
                    <option value="3" <? if($_POST['element_4'] == '3' || $_GET['car_loan_type'] == '3' ) { echo 'selected="selected"';}?> >Refinance Your Car</option>
                  </select>
				  
				  <?php if($err['element_4'] != '') { ?>
					<p class="error"><?php echo $err['element_4'];?> </p>
					<?php }  ?>
					</td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">First Name</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="first_name" type="text" class="required input" title="Enter first name" id="first_name" value="<? if (isset($_POST['first_name'])) { echo $_POST['first_name'];} else {  echo $_GET['first_name'];} ?>"/>
				  </td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Last Name</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="last_name" type="text" title="Enter last name" class="required input" id="last_name" value="<? if (isset($_POST['last_name'])) { echo $_POST['last_name'];} else {  echo $_GET['last_name'];} ?>" />
				  </td>
                </tr>
                
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Email</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="email" type="text" title="Enter valid email" class="input email required" id="email" value="<? if (isset($_POST['email'])) { echo $_POST['email'];} else {  echo $_GET['email'];} ?>" /></td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Phone</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="phone" type="text" maxlength="10" minlength="10" title="Enter valid phone" class="number required input" id="phone" value="<? if (isset($_POST['phone'])) { echo $_POST['phone'];} else {  echo $_GET['phone'];} ?>" /></td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Address</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="address" type="text" class="input required" title="Enter address" id="address" value="<? if (isset($_POST['address'])) { echo $_POST['address'];} else {  echo $_GET['address'];} ?>" /></td>
                </tr>
                <tr>
                  <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="22" align="left" valign="top" class="formtext">City</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top" class="formtext">State</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top" class="formtext">Zip</td>
                    </tr>
                    <tr>
                    
 <td height="45" align="left" valign="top"><input name="city" type="text" class="input required" title="Enter city" id="city" style="height:24px;width:140px;"/></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><select name="state" title="Select state" class="required inputsmall" id="state">
					  <? foreach($STATE as $key => $value){ ?>
						<option value="<?=$key?>" <?=(($_POST['state']==$key) ? 'selected' : '')?> >
						<?=$value?>
						</option>
						<? } ?>
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><input name="zip" type="text" maxlength="5" minlength="5" title="Enter valid zip" class="number required input" id="zip" style="height:24px;width:140px;" value="<? if (isset($_POST['zip'])) { echo $_POST['zip'];} else {  echo $_GET['zip'];} ?>"/></td>
                    </tr>
                  </table></td>
                </tr>
                
                <tr>
                  <td align="left" valign="top" id="car_li"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="22" align="left" valign="top" class="formtext">Make</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top" class="formtext">Model</td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top" class="formtext">Trim</td>
                    </tr>
                    <tr>
                      <td height="45" align="left" valign="top"><select name="make" class="required inputsmall" title="Select make" id="make"> </select>
					  </td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><select name="model" title="Select model" class="required inputsmall" id="model"> </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><select name="trim" title="Select trim" class="required inputsmall" id="trim"> </select></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Terms &amp; Condition</td>
                </tr>
                <tr>
                  <td height="30" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="25" align="left"><input type="checkbox" name="element_5_1" id="element_5_1" class="required" checked="yes"/></td>
                      <td align="left" class="whitetext12size">I have read the Privacy Policy and State Law Disclosures</td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td height="54" align="center" valign="middle" background="images/getapprovedbg.png" style="background-repeat:no-repeat">
				  <input name="submit" value="1" type="hidden">
				  <input name="Get Approved" type="submit" value="" class="btm_getapproved" id="saveForm" /></td>
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
            <td class="blacktext14"><div align="justify">After you submit this car loan form, you will be presented with your car loan options and interest rates.<br />
              <br />
              Your Car Loan is approved, regardless of your credit! The nation's leading Source for all of your auto loan needs.<br />
              <br />
              Just complete our FREE, NO HASSLE online AUTO LOANS inquiry...and you'll be rolling tomorrow!</div></td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
        <td width="202" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right"><img src="images/rightmanutopline.jpg" width="1" height="31" /></td>
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
            <td align="left" valign="top" class="whitetext18"><div align="justify">Find the Vehicle You Want Preferred pricing and fast, easy financing</div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" class="whitetext14"><div align="justify">We're here to help you get the automobile you want, and the financing you deserve.</div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top"><img src="images/leftmanucarinsurance.jpg" width="202" height="174" /></td>
          </tr>
          <tr>
            <td valign="middle" height="61" align="center"><img width="202" height="50" src="images/bestreate.png"></td>
          </tr>
          <tr>
            <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="1" bgcolor="#e5e5e5"><img src="images/blank.gif" width="1" height="1" /></td>
                <td width="16" align="left" valign="top" bgcolor="#fbfbfb">&nbsp;</td>
                <td width="176" align="left" valign="top" bgcolor="#fbfbfb"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="23">&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="176" height="130" align="left" valign="top" background="images/leftmanustepbgimg.jpg" style="background-repeat:no-repeat"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="60" align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="steporrange">We can help you<br />
                          rebuild your<br />
                          good credit.</td>
                        </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="2" align="left" valign="top" class="steptext"><div align="justify">Find out what types of loans you can get if you've got good or excellent credit.</div></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td><img src="images/leftmanustepdeviderimg.jpg" width="184" height="2" /></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="176" height="130" align="left" valign="top" background="images/leftmanustepbgimg.jpg" style="background-repeat:no-repeat"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="60" align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="steporrange">Bad Credit?<br />
                          NO PROBLEM! get<br />
                          an instant autoloan.</td>
                        </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="2" align="left" valign="top" class="steptext"><div align="justify">Having bad credit in today’s world can make life challenging in many ways.</div></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td><img src="images/leftmanustepdeviderimg.jpg" width="184" height="2" /></td>
                    </tr>
                  <tr>
                    <td>&nbsp;</td>
                    </tr>
                  <tr>
                    <td width="176" height="130" align="left" valign="top" background="images/leftmanustepbgimg.jpg" style="background-repeat:no-repeat"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="60" align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top" class="steporrange">Get Approved<br />
                          easy, simple and<br />
                          secure.</td>
                        </tr>
                      <tr>
                        <td align="left" valign="top">&nbsp;</td>
                        <td align="left" valign="top">&nbsp;</td>
                        </tr>
                      <tr>
                        <td colspan="2" align="left" valign="top" class="steptext"><div align="justify">Our Free and secure on line application will only take you minutes to fill out.</div></td>
                        </tr>
                      </table></td>
                    </tr>
                  <tr>
                    <td><img src="images/leftmanustepdeviderimg.jpg" width="184" height="2" /></td>
                    </tr>
                  <tr>
                    <td align="center" valign="top"><img src="images/leftmanugetapprovedcarimg.jpg" width="177" height="117" /></td>
                    </tr>
                  </table></td>
                <td width="10" align="left" valign="top" bgcolor="#fbfbfb">&nbsp;</td>
                <td width="1" bgcolor="#e5e5e5"><img src="images/blank.gif" width="1" height="1" /></td>
                </tr>
              </table></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" valign="top" class="contantbottomline">&nbsp;</td>
  </tr>
  <tr>
    <td height="106" align="center" valign="middle" bgcolor="#212121"><table width="994" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="38" align="left" valign="middle"><img src="images/leftarrow.png" width="38" height="42" /></td>
        <td width="15" align="left" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="middle">

<script type="text/javascript">
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



<div class="marquee" id="mycrawler2"> <a href="car_application.php"><img src="images/carlogo/acura.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/alfaromeo.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/amgeneral.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/astronmartin.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/audi.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/bentley.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/bmw.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/buick.png" border="0" /></a> <a href="car_application.php"><img src="images/carlogo/cadillac.png" border="0" /></a></div>

<script type="text/javascript">
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
        <td width="38" align="right" valign="middle"><img src="images/rightarrow.png" width="38" height="42" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="100" align="center" valign="middle"><table width="994" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" class="blacktext"><a href="index.php" class="bottomlinkhover">Home</a>&nbsp;&nbsp;   |&nbsp;&nbsp; <a href="car_application.php" class="bottomlinkhover">Car Loan Application</a>&nbsp;&nbsp;   |   &nbsp;&nbsp;<a href="auto_application.php" class="bottomlinkhover">Car Insurance</a>&nbsp;&nbsp;   |&nbsp;&nbsp; <a href="#inline4" title="CARZLOAN" class="bottomlinkhover" id="privacy">Privacy Policy</a>
          <div style="display: none;">
            <div align="justify" id="inline4" style="width:700px;height:400px;overflow:auto;"><br />
              <span class="steporrange">CARZLOAN   |</span><span class="toplink"> Privacy Policy</span><br />
              <br />
              <span class="toplink">The following statement discloses the privacy practices of CARZLOAN.COM Because CARZLOAN.COM wants to demonstrate its commitment to consumer privacy, we have agreed to disclose our information and security practices.</span><br />
              <br />
              <span class="orrangetextbold">Acceptance of CARZLOAN.COM Privacy Policy</span><br />
              By using CARZLOAN.COM's services or web sites, you signify your agreement to the terms and conditions of CARZLOAN.COM's Privacy Policy. If you do not consent to these terms and conditions, are not a US resident, or are under 18 years of age, please do not use the site or CARZLOAN.COM's services.<br />
              <br />
              <span class="orrangetextbold">When you just visit one of our sites:</span><br />
              We use IP addresses and cookies to analyze trends, administer the site, track user's movement, and gather broad demographic information. IP addresses and cookies are not linked to personally identifiable information.<br />
              <br />
              <span class="orrangetextbold">When you provide us with information:</span><br />
              At three places on our loan application we ask visitors to opt in:<br />
              1) Consent to contact: We ask for consent to follow up with visitors regarding their application or partially completed application.<br />
              2) Consent to seek loan approval: We ask for permission to pull credit reports and search for an auto loan approval with banks on our customer's behalf.<br />
              3) Third party consent: We ask for consent to provide customer information to third parties, which we feel offer goods or services customers may be interested in, outside of the parameters of obtaining an auto loan.<br />
              <br />
              We use this information to evaluate your applications, locate an appropriate lender, provide you with high quality service, prevent fraud and, with your consent, inform you of offers for other CARZLOAN.COM services offered by third parties. We may also use this information to confirm your identity when you call us to inquire about your accounts. We also ask for information from our visitors at other locations on our web site. This is considered consensually given information and subject to the conditions of this privacy policy.<br />
              <br />
              <span class="orrangetextbold">Credit Reports and Other Uses of Information</span><br />
              In applying for credit, you agree that we may request consumer credit reports from one or more credit reporting agencies in connection with your application and the administration of such application. You also authorize us to exchange credit information concerning you or your use of the Account with (and answer questions and requests from) others, such as merchants, other lenders and credit reporting agencies.<br />
              <br />
              CARZLOAN.COM does not knowingly offer its products and services to minors. Similarly, CARZLOAN.COM does not collect information about children. Our application approval process is designed to identify applications submitted by children and to prevent their use of CARZLOAN.COM websites.<br />
              <br />
              <span class="orrangetextbold">Access to Account Information &amp; Correction of Error Questions</span><br />
              CARZLOAN.COM is committed to customer service and privacy. If you have any questions, comments or concerns regarding our Privacy Policy and its implementation, please do not hesitate to e-mail us at info@carzloan.com<br />
            </div>
          </div>
          &nbsp;&nbsp;   |   &nbsp;&nbsp;<a href="http://managesubscriber.com/" target="_blank" class="bottomlinkhover">Unsubscribers</a></td>
        <td>&nbsp;</td>
        <td width="110" align="right"><img src="images/bbb.jpg" width="90" height="34" /></td>
        <td width="76" align="right"><img src="images/verisigrr.jpg" width="56" height="34" /></td>
        <td width="109" align="right"><img src="images/truste.jpg" width="89" height="34" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="40" align="center" valign="top" bgcolor="#e86006" class="copyrighttext">Copyright &copy; 2012 Carzloan.com, - All Rights Reserved</td>
  </tr>
</table>
</body>
</html>

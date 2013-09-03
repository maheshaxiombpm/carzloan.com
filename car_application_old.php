<?php
require("config.php");
error_reporting(0);
$STATE = array(""=>"~~Select~~","AL"=>"Alabama","AK"=>"Alaska","AZ"=>"Arizona","AR"=>"Arkansas","CA"=>"California","CO"=>"Colorado","CT"=>"Connecticut","DE"=>"Delaware","DC"=>"District of Columbia","FL"=>"Florida","GA"=>"Georgia","HI"=>"Hawaii","ID"=>"Idaho","IL"=>"Illinois","IN"=>"Indiana","IA"=>"Iowa","KS"=>"Kansas","KY"=>"Kentucky","LA"=>"Louisiana","ME"=>"Maine","MD"=>"Maryland","MA"=>"Massachusetts","MI"=>"Michigan","MN"=>"Minnesota","MS"=>"Mississippi","MO"=>"Missouri","MT"=>"Montana","NE"=>"Nebraska","NV"=>"Nevada","NH"=>"New Hampshire","NJ"=>"New Jersey","NM"=>"New Mexico","NY"=>"New York","NC"=>"North Carolina","ND"=>"North Dakota","OH"=>"Ohio","OK"=>"Oklahoma","OR"=>"Oregon","PA"=>"Pennsylvania","RI"=>"Rhode Island","SC"=>"South Carolina","SD"=>"South Dakota","TN"=>"Tennessee","TX"=>"Texas","UT"=>"Utah","VT"=>"Vermont","VA"=>"Virginia","WA"=>"Washington","WI"=>"Wisconsin","WV"=>"West Virginia","WY"=>"Wyoming");

if(isset($_POST['submit']) || isset($_POST['submit']) ){	
//echo "submited";
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
// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
//insert to database	
$sql = "insert into autoapplication set source ='1',
					subid='".$_GET['subid']."',
					fname='".$_POST['element_1_1']."',
					lname='".$_POST['element_1_2']."',
					email='".$_POST['element_2']."',
					phone='".$_POST['element_3']."',
					ltype='".$_POST['element_4']."',
					ip='".$_SERVER['REMOTE_ADDR']."',
					address='".$_POST['address']."',
					city='".$_POST['city']."',
					state='".strtoupper($_POST['state'])."',
					zip='".$_POST['zip']."',
					yearsAtResidence='".$_POST['yearsAtResidence']."',
					rentOrOwn='".$_POST['rentOrOwn']."',
					monthlyPayment='".addslashes($_POST['monthlyPayment'])."',
					workPhone='".addslashes($_POST['workPhone'])."',
					employer='". addslashes( $_POST['employer'])."',
					jobTitle='".addslashes($_POST['jobTitle'])."',
					yearsAtEmployer='".$_POST['yearsAtEmployer']."',
					monthlyIncome='".addslashes($_POST['monthlyIncome'])."',
					bankruptcy='".$_POST['bankruptcy']."',
					cosigner='".$_POST['cosigner']."',
					add_date=now()
				";
		$res = mysql_query($sql);
			
//	START - POSTING DATA TO LEADSYSTEM
			$live_url = 'https://crm.axiombpm.com/leadsystem/short_form';
			$car_live_url = 'https://crm.axiombpm.com/leadsystem/vendor_curl';
			$header[] = 'Content-Type: application/x-www-form-urlencoded';
			
			$data = 	'lead_type=2'
						.'&vendor_id=597'
						.'&sub_id=005'//.$_POST['sub_id']
						.'&first_name='.$_POST['element_1_1']
						.'&last_name='.$_POST['element_1_2']
						.'&email='.$_POST['element_2']
						.'&phone='.$_POST['element_3']
						.'&address='.$_POST['address']
						.'&city='.$_POST['city']
						.'&state='.strtoupper($_POST['state'])
						.'&zip='.$_POST['zip']
						.'&ipaddress='.$_SERVER['REMOTE_ADDR']
						;
			$car_data = 'lead_mode=1'
						.'&lead_type=4'
						.'&vendor_id=597'
						.'&sub_id=005'//.$_POST['sub_id']
						.'&first_name='.$_POST['element_1_1']
						.'&last_name='.$_POST['element_1_2']
						.'&email='.$_POST['element_2']
						.'&phone='.$_POST['element_3']
						.'&address='.$_POST['address']
						.'&city='.$_POST['city']
						.'&state='.strtoupper($_POST['state'])
						.'&zip='.$_POST['zip']
						.'&car_year=2011'
						.'&make='.$_POST['make']
						.'&model='.$_POST['model']
						.'&trim='.$_POST['trim']
						.'&gender=0'//.$_POST['gender']
						.'&dob=01/01/1986'//.$_POST['dob']
						.'&ipaddress='.$_SERVER['REMOTE_ADDR']
						;
	
//		echo $data . '<br>' . $car_data;exit;
			
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
				
			$res = curlposting($live_url,$data,$header,'60');
			$mailmessage = "<b>Post URL : </b>".$live_url."<br>";
			$mailmessage .= "<b>Post Request : </b><pre>".htmlspecialchars($data, ENT_QUOTES)."</pre><br>";
			$mailmessage .= '<b>Post Response</b><pre>' . htmlspecialchars(html_entity_decode($res), ENT_QUOTES) . '</pre>';
			preg_match("/<Error>(.*)<\/Error>/", $res, $error_res);
			
			if($_POST['element_4'] == '4'){
				$res = curlposting($car_live_url,$car_data,$header,'60');
				$car_mailmessage = "<br><b> CAR : </b></br>";
				$car_mailmessage .= "<b>Post URL : </b>".$live_url."<br>";
				$car_mailmessage .= "<b>Post Request : </b><pre>".htmlspecialchars($car_data, ENT_QUOTES)."</pre><br>";
				$car_mailmessage .= '<b>Post Response</b><pre>' . htmlspecialchars(html_entity_decode($res), ENT_QUOTES) . ' </pre>';
				preg_match("/<Error>(.*)<\/Error>/", $res, $car_error_res);
			}
			
			
				mail("leads@incedebrands.com",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"], $mailmessage . $car_mailmessage,$headers);
		
//Redirect to w2c
		$location = "https://www.web2carz.com/bad-credit-auto-loan-application?w2caf=da420a854646e9ab&subid=".$_GET['subid']."&firstName=".$_POST['element_1_1']."&lastName=".$_POST['element_1_2']."&email=".$_POST['element_2']."&homePhone=".$_POST['element_3']
					."&address=".$_POST['address']
					."&city=".$_POST['city']
					."&state=".$_POST['state']
					."&zip=".$_POST['zip']
					."&yearsAtResidence=".$_POST['yearsAtResidence']
					."&rentOrOwn=".$_POST['rentOrOwn']
					."&monthlyPayment=".addslashes($_POST['monthlyPayment'])
					."&workPhone=".addslashes($_POST['workPhone'])
					."&employer=". addslashes( $_POST['employer'])
					."&jobTitle=".addslashes($_POST['jobTitle'])
					."&yearsAtEmployer=".$_POST['yearsAtEmployer']
					."&monthlyIncome=".addslashes($_POST['monthlyIncome'])
					."&bankruptcy=".$_POST['bankruptcy']
					."&cosigner=".$_POST['cosigner']
		;
		header("location:".$location);exit;		
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CARZLOAN : make finance easy</title>
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
			
		});
		$("#form_2").submit();
	});

			
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
<script type="text/javascript">

/***********************************************
* ProHTML Ticker script- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

var tickspeed=7000 //ticker speed in miliseconds (2000=2 seconds)
var enablesubject=1 //enable scroller subject? Set to 0 to hide

if (document.getElementById){
document.write('<style type="text/css">\n')
document.write('.dropcontent{display:none;}\n')
document.write('</style>\n')
}

var selectedDiv=0
var totalDivs=0

function contractall(){
var inc=0
while (document.getElementById("dropmsg"+inc)){
document.getElementById("dropmsg"+inc).style.display="none"
inc++
}
}


function expandone(){
var selectedDivObj=document.getElementById("dropmsg"+selectedDiv)
contractall()
document.getElementById("dropcontentsubject").innerHTML=selectedDivObj.getAttribute("subject")
selectedDivObj.style.display="block"
selectedDiv=(selectedDiv<totalDivs-1)? selectedDiv+1 : 0
setTimeout("expandone()",tickspeed)
}

function startscroller(){
while (document.getElementById("dropmsg"+totalDivs)!=null)
totalDivs++
expandone()
if (!enablesubject)
document.getElementById("dropcontentsubject").style.display="none"
}

if (window.addEventListener)
window.addEventListener("load", startscroller, false)
else if (window.attachEvent)
window.attachEvent("onload", startscroller)
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-34665264-1']);
  _gaq.push(['_setDomainName', 'carzloan.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://autoleadjunction.com/track/" : "http://autoleadjunction.com/track/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 2);
piwikTracker.trackPageView();
piwikTracker.enableLinkTracking();
} catch( err ) {}
</script><noscript><p><img src="http://autoleadjunction.com/track/piwik.php?idsite=2" style="border:0" alt="" /></p></noscript>
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
                <td align="left" valign="top" class="whitetext12size"><div align="justify">Let banks and credit unions battle it out to get you great rates on Auto Financing for new and used auto loans. We're putting the power into your hands. You get free access to great deals in real time!<br />
                  <br />
                  After you submit this car loan form, you will be presented with your car loan options and interest rates.<br />
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
                    <td width="230" height="36" align="left" valign="top"  background="images/categoryheading.jpg" style="background-repeat:no-repeat">&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><img src="images/blank.gif" width="1" height="1" /></td>
                    <td height="10" align="left" valign="top"><img src="images/blank.gif" width="1" height="1" /></td>
                    <td><img src="images/blank.gif" width="1" height="1" /></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top"><div id="dropcontentsubject"></div>
                      <div id="dropmsg0" class="dropcontent" subject="">
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• research by car make</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• research by category</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• car reviews and photos</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• car buying tips</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• sell my car</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• car videos</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• consumer car reviews</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• used cars for bad credit</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• rent to own loans</a><br />
                        </div>
                      </div>
                      <div id="dropmsg1" class="dropcontent" subject="">
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• car forum</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• buy here pay here loans</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• private party car loans</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• auto loan refinance</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• new car internet prices</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• used cars for sale</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• new cars for sale</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• research used cars</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• bad credit car loans</a><br />
                        </div>
                      </div>
                      <div id="dropmsg2" class="dropcontent" subject="">
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• bad credit car loan refinance</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• used car photo lot</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• sell your car</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• automotive knowledgebase</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• canada car loan</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• dealer reviews</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• car loans</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="loan_application.php" class="categorylinkhover">• auto insurance</a><br />
                        </div>
                      </div></td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td align="left" valign="top">&nbsp;</td>
                    <td>&nbsp;</td>
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
                    <td align="left" valign="top" background="images/testimoniallogobg.gif" style="background-repeat:no-repeat"><marquee scrollamount="3" direction="up" width="230" height="190" onmouseover="this.scrollAmount=0" onmouseout="this.scrollAmount=3">
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
                          <td align="left">&nbsp;</td>
                        </tr>
                        <tr>
                          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
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
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="35" align="left">&nbsp;</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top" class="formheading">Final Approval Process</td>
                </tr>
                <tr>
                  <td align="left" valign="top" class="graytext14">Welcome <strong style="color:darkorange;"><?php echo $_GET['fname'].'&nbsp;'.$_GET['lname']; ?></strong> ! Please fill in your details below</td>
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
                  <td height="45" align="left" valign="top"><input name="element_1_1" type="text" class="required input" id="element_1_1" value="<? if (isset($_POST['element_1_1'])) { echo $_POST['element_1_1'];} else {  echo $_GET['fname'];} ?>"/>
				  </td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Last Name</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="element_1_2" type="text" class="required input" id="element_1_2" value="<? if (isset($_POST['element_1_2'])) { echo $_POST['element_1_2'];} else {  echo $_GET['lname'];} ?>" />
				  </td>
                </tr>
                
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Email</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="element_2" type="text" class="input email required" id="element_2" value="<? if (isset($_POST['element_2'])) { echo $_POST['element_2'];} else {  echo $_GET['email'];} ?>" /></td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Phone</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="element_3" type="text" maxlength="10" minlength="10" class="number required input" id="element_3" value="<? if (isset($_POST['element_3'])) { echo $_POST['element_3'];} else {  echo $_GET['phone'];} ?>" /></td>
                </tr>
                <tr>
                  <td height="22" align="left" valign="top" class="formtext">Address</td>
                </tr>
                <tr>
                  <td height="45" align="left" valign="top"><input name="address" type="text" class="input required" id="address" value="<? if (isset($_POST['address'])) { echo $_POST['address'];} else {  echo $_GET['address'];} ?>" /></td>
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
                      <td height="45" align="left" valign="top"><input name="city" type="text" class="input required" id="city" style="height:24px;width:140px;" value="<? if (isset($_POST['city'])) { echo $_POST['city'];} else {  echo $_GET['city'];} ?>"/></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><select name="state" class="required inputsmall" id="state">
					  <? foreach($STATE as $key => $value){ ?>
						<option value="<?=$key?>" <?=(($_POST['state']==$key) ? 'selected' : '')?> >
						<?=$value?>
						</option>
						<? } ?>
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><input name="zip" type="text" maxlength="5" minlength="5" class="number required input" id="zip" style="height:24px;width:140px;" value="<? if (isset($_POST['zip'])) { echo $_POST['zip'];} else {  echo $_GET['zip'];} ?>"/></td>
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
                      <td height="45" align="left" valign="top"><select name="make" class="required inputsmall" id="make">
                      </select>
					  </td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><select name="model" class="required inputsmall" id="model">
                      </select></td>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><select name="trim" class="required inputsmall" id="trim">
                      </select></td>
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
				  <input name="Get Approved" type="submit" class="btm_getapproved" id="saveForm" /></td>
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
            <td class="blacktext14"><div align="justify">Your Car Loan is approved, regardless of your credit! The nation's leading Source for all of your auto loan needs.<br />
              <br />
              Carzloan.com is the Nation's Leading Source for Auto Loans! We will instantly match you with the right lender, and you'll be approved immediately!<br />
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
		'width': '888px',
	},
	inc: 8, //speed - pixel increment for each iteration of this marquee's movement
	mouse: 'cursor driven', //mouseover behavior ('pause' 'cursor driven' or false)
	moveatleast: 2,
	neutral: 50,
	savedirection: true
});
</script>



<div class="marquee" id="mycrawler2"> <a href="loan_application.php"><img src="images/carlogo/acura.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/alfaromeo.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/amgeneral.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/astronmartin.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/audi.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/bentley.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/bmw.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/buick.png" border="0" /></a> <a href="loan_application.php"><img src="images/carlogo/cadillac.png" border="0" /></a></div>

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

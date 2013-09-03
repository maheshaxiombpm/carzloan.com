<?php
//If the form is submitted
if(isset($_POST['submit'])) {

//Check to make sure that the name field is not empty
	if(trim($_POST['subject']) == '') {
		$hasError = true;
	} else {
		$subject = trim($_POST['subject']);
	}
	
	//Check to make sure that the name field is not empty
	if(trim($_POST['contactname']) == '') {
		$hasError = true;
	} else {
		$name = trim($_POST['contactname']);
	}

	//Check to make sure that the subject field is not empty
	if(trim($_POST['phone']) == '') {
		$hasError = true;
	} else {
		$phone = trim($_POST['phone']);
	}

	//Check to make sure sure that a valid email address is submitted
	if(trim($_POST['email']) == '')  {
		$hasError = true;
	} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['message']) == '') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['message']));
		} else {
			$comments = trim($_POST['message']);
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$emailTo = 'mohan@incedebrands.com'; //Put your own email address here
		$body = "Subject: $subject \n\nName: $name \n\nEmail: $email \n\nPhone: $phone \n\nComments:\n $comments";
		$headers = 'From: Carzloan.com <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
		$emailSent = true;
	}
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
	<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.pack.js" type="text/javascript"></script>
	<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
	<link rel="stylesheet" href="css/screen.css" type="text/css" media="screen" />
	
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
$(document).ready(function(){
jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-z]+$/i.test(value);
}, ""); 
	// validate signup form on keyup and submit
	var validator = $("#contactform").validate({
		rules: {
			contactname: {
				required: true,
				minlength: 5,
				lettersonly:true
			},
			email: {
				required: true,
				email: true
			},
			phone: {
				required: true,
				minlength: 10,
				digits: true
			},
			message: {
				required: true,
				minlength: 10
			}
		},
		messages: {
			contactname: {
				required: "Please enter your name",
				minlength: jQuery.format("Please enter at least {0} characters"),
				lettersonly:"Please enter Only letters"
			},
			email: {
				required: "Please enter a valid email address",
				minlength: "Please enter a valid email address"
			},
			subject: {
				required: "You need to enter a subject!",
				minlength: jQuery.format("Enter at least {0} characters")
			},
			message: {
				required: "You need to enter a message!",
				minlength: jQuery.format("Enter at least {0} characters")
			}
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			label.addClass("checked");
		}
	});
});
</script>
</head>

<body onload="MM_preloadImages('images/applynow-r.png')">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="110" align="center" valign="top" background="images/topbg.jpg" style="background-repeat:repeat-x"><table width="994" border="0" cellspacing="0" cellpadding="0">
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
            <td class="headpointbg">No Social Security # Needed!</td>
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
                  Remember this is a Free Car Loanservice and there is no obligation.</div></td>
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
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• research by car make</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• research by category</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• car reviews and photos</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• car buying tips</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• sell my car</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• car videos</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• consumer car reviews</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• used cars for bad credit</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• rent to own loans</a><br />
                        </div>
                      </div>
                      <div id="dropmsg1" class="dropcontent" subject="">
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• car forum</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• buy here pay here loans</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• private party car loans</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• auto loan refinance</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• new car internet prices</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• used cars for sale</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• new cars for sale</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• research used cars</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• bad credit car loans</a><br />
                        </div>
                      </div>
                      <div id="dropmsg2" class="dropcontent" subject="">
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• bad credit car loan refinance</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• used car photo lot</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• sell your car</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• automotive knowledgebase</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• canada car loan</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• dealer reviews</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• car loans</a><br />
                        </div>
                        <div align="justify" class="categorylinkbg"> <a href="car_application.php" class="categorylinkhover">• auto insurance</a><br />
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
            <td height="896" align="left" valign="top">
			<!--contact form-->
			<div id="contactWrapper" role="form">
	
		<h1 role="heading">Send us a message</h1>

		<?php if(isset($hasError)) { //If errors are found ?>
			<p class="error">Please check if you've filled all the fields with valid information and try again. Thank you.</p>
		<?php } ?>

		<?php if(isset($emailSent) && $emailSent == true) { //If email is sent ?>
			<div class="success">
				<p><strong>Email Successfully Sent!</strong></p>
				<p>Thank you for using our contact form <strong><?php echo $name;?></strong>! Your email was successfully sent and we 'll be in touch with you soon.</p>
			</div>
		<?php } ?>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" id="contactform">
			<div class="stage clear">
				<label for="name"><strong>Subject: <em>*</em></strong></label>
				
				<select name="subject" id="subject">
				<option value="General">General</option>
				<option value="Abuse">Abuse</option>
				<option value="Inquiry">Inquiry</option>
				</select>
			</div>

			
			<div class="stage clear">
				<label for="name"><strong>Name: <em>*</em></strong></label>
				<input type="text" name="contactname" id="contactname" value="" class="required" role="input" aria-required="true" />
			</div>

			<div class="stage clear">
				<label for="email"><strong>Email: <em>*</em></strong></label>
				<input type="text" name="email" id="email" value="" class="required email" role="input" aria-required="true" />
			</div>

			<div class="stage clear">
				<label for="phone"><strong>Phone: <em>*</em></strong></label>
				<input type="text" name="phone" id="phone" value="" class="required" role="input" aria-required="true" maxlength="10"/>
			</div>

			<div class="stage clear">
				<label for="message"><strong>Message: <em>*</em></strong></label>
				<textarea rows="8" name="message" id="message" class="required" role="textbox" aria-required="true"></textarea>
			</div>
								
			<p class="requiredNote"><em>*</em> Denotes a required field.</p>
			
			<input type="submit"  name="submit" id="submitButton"  value=""/>
		</form>
		
	</div>
			<!--contact form-->
			</td>
            <td width="20">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td class="blacktext14"><div align="justify">Let banks and credit unions battle it out to get you great rates on Auto Financing for new and used auto loans. We're putting the power into your hands. You get free access to great deals in real time!<br />
              <br />
              After you submit this car loan form, you will be presented with your car loan options and interest rates.<br />
              <br />
              Remember this is a Free Car Loan service and there is noobligation.</div></td>
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
            <td align="left" valign="top" class="whitetext14"><div align="justify">Now is the time to move on that new or used car. Don't let our great rates2 pass you by!</div></td>
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
    <td height="106" align="center" valign="middle" bgcolor="#212121"><table width="994" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="38" align="left" valign="middle"><img src="images/leftarrow.png" width="38" height="42" /></td>
        <td width="15" align="left" valign="middle">&nbsp;</td>
        <td align="center" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle"><script type="text/javascript">
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
        <td align="left"  class="blacktext"><a href="index.php" class="bottomlinkhover">Home</a>&nbsp;&nbsp;   |&nbsp;&nbsp; <a href="car_application.php" class="bottomlinkhover">Car Loan Application</a>&nbsp;&nbsp;   |   &nbsp;&nbsp;<a href="auto_application.php" class="bottomlinkhover">Car Insurance</a>&nbsp;&nbsp;   |&nbsp;&nbsp; <a href="privacy.php"  class="bottomlinkhover  various fancybox.iframe" id="privacy">Privacy Policy</a>
         
          &nbsp;&nbsp;   |   &nbsp;&nbsp;<a href="unsubscribe.php" class="bottomlinkhover">Unsubscribe</a></td>
        <td>&nbsp;</td>
        <td width="110" align="right"><img src="images/bbb.jpg" width="90" height="34" /></td>
        <td width="76" align="right"><img src="images/verisigrr.jpg" width="56" height="34" /></td>
        <td width="109" align="right"><img src="images/truste.jpg" width="89" height="34" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="40" align="center" valign="top" bgcolor="#e86006" class="copyrighttext">Copyright &copy; 2013 Carzloan.com - All Rights Reserved</td>
  </tr>
</table>
</body>
</html>

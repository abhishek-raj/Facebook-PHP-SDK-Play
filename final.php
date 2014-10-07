<?php
/********************************************************************************************************************
Made By-Abhishek Raj
*********************************************************************************************************************/
?>
<?php
	/*************************************************************************************************************************/
	session_start();
	require_once("autoload.php");
	//Facebook PHP SDK
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookSession;
	//App Access Token
	$AppID = app_ID; 
	$AppToken = app_secret_token;
	//Page Access Token
	$pageAccessToken = page_access_token;
	$config = FacebookSession::setDefaultApplication($AppID, $AppToken); //Configuration of the app
	$facebookSession = new FacebookSession($pageAccessToken); //Facebook Session Object
	$userID = user_id; //Facebook User ID i.e. Abhishek Raj
	$pageID = page_id; //Facebook Page ID
	$message = ''; //Main message to post
	//Configuration of the Connection Complete
	/*************************************************************************************************************************/
	
?>
<?php
	/*************************************************************************************************************************/
	//Server side CAPTCHA configuration
 	require_once('recaptchalib.php');
 	$privatekey = captcha_private_key; //CAPTCHA private key
 	if($_POST)
 	{
 	$resp = recaptcha_check_answer ($privatekey, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
 	//Response of the CAPTCHA test
  	if (!$resp->is_valid)
  	{
  		//CATCHA test failed
  		$message = $_POST['status']; //Set message to the input message for easy access
  		echo "CAPTCHA incorrect. Try again.";
  	}
  	else
  	{//Start of Else
  	/*************************************************************************************************************************/
?>

<?php

	/*************************************************************************************************************************/
	//Checking if status is already given
	if(isset($_POST['status']))
	{
		$message = $_POST['status'];
		$args = array(
				'message'       => $message
				
			);
		//Message formation complete
		$facebookRequest = new FacebookRequest($facebookSession , 'POST', "/$pageID/feed", $args); //Facebook Request Object
		$post = $facebookRequest->execute()->getGraphObject(); //Actual Posting.
		$postID = $post->getProperty('id');
		echo "<a target='_blank' href='http://facebook.com/$postID'>Posted. Goto Status.$postID</a><br>"; //Link to the status
	}
	/************************************************************************************************************************/

?>
<?php
//End of Else
	}
	}
?>




<html>
<head>
<title>
Hello World
</title>
</head>


<body>
<h1>Hello World</h1>
<hr>


<!--The actual form for posting the status-->
<form method="post" id="sendStatus">
<label>Message: </label><br>
<textarea name="status" cols="60" rows="5"><?php echo $message;?></textarea><br>
<!--CAPTCHA client side-->
<?php
	require_once('recaptchalib.php');
	$publickey = public_key; //Public key of CAPTCHA
	echo recaptcha_get_html($publickey);
?>
<!--CAPTCHA client side over-->
<input class="submit" type="submit" value="Post">
</form>
<!--Form complete-->
<hr>

</body>
</html>
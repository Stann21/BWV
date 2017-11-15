<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require_once ('vendor/autoload.php');

if (isset($_POST['submit'])) {
	//Make an activation number, random and 32 characters.
	$hash = md5( rand(0,1000) );

	//Set a temporary password
	$password = rand(1000,5000);

	//Get email
	$email = $_POST['email'];

	//PHPMailer Object
	$mail = new PHPMailer;

	//From email address and name
	$mail->From = "stangloudemans@hotmail.com";
	$mail->FromName = "Stan Gloudemans";

	//To address and name
	$mail->addAddress($email, "Stan");

	//Address to which recipient will reply
	$mail->addReplyTo("stanlgoudemans@hotmail.com", "Reply");

	//Send HTML or Plain Text email
	$mail->isHTML(true);

	$mail->Subject = "Welcome to Blue Whale Ventures";
	$mail->Body = "<style>
    @import url('https://fonts.googleapis.com/css?family=Open+Sans');

    *{
        font-family: 'Open Sans', sans-serif;
    }

    a{
        text-decoration: none;
        color: #0099ff;
    }

    .inlineTable {
        display: inline-block;
    }

    .container {
        padding: 20px;
        background-color: #F4F7F8;
    }

    input[type=text], input[type=submit] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    input[type=checkbox] {
        margin-top: 16px;
    }

    input[type=submit] {
        background-color: #0099ff;
        border-radius: 6px 0px 0px 6px;
        color: white;
        border: none;
    }

    input[type=submit]:hover {
        opacity: 0.8;
    }

    img{
        float: right;
        width: 90px;
        margin-right:35px;
    }

    ul{
        list-style: none;
        color:#535353
    }
</style>
<body>

    <div class='container' style='padding: 20px;background-color: #F4F7F8;'>
        <img src='http://www.purplebirds.nl/BWV/images/logo.png' style='float: right;width: 90px;margin-right: 35px;'>
        <h2>Welcome to Blue Whale Ventures</h2>
        <p>We created an account for the webapplication from PreXLR program. By pressing on the button below you can activate your account, then you can login with the account details in this mail.</p>

    </div>


    <div class='container' style='background-color: white;padding: 20px;'>
		<a href='https://www.purplebirds.nl/BWV/includes/activation.inc.php?hash=$hash'>
            <input type='submit' value='Activate account' style='width: 100%;padding: 12px 20px;margin: 8px 0;display: inline-block;border: none;box-sizing: border-box;background-color: #0099ff;border-radius: 6px 0px 0px 6px;color: white;'>
        </a>
        <ul class='inlineTable' style='list-style: none;color: #535353;display: inline-block;'>
            <li><b>Account details</b></li>
            <li>Username: $email</li>
            <li>Password: $password</li>
            <p></p>
            <li>We recommend changing your account details as soon as possible.</li>
        </ul>
    </div>


    <div class='container' style='padding: 20px;background-color: #F4F7F8;'>
            <ul class='inlineTable' style='list-style: none;color: #535353;display: inline-block;'>
                <li><b>BW VENTURES</b></li>
                <li>European Business Centre Eindhoven</li>
                <li>Luchthavenweg 81</li>
                <li>5657 EA Eindhoven</li>
            </ul>

            <ul class='inlineTable' style='list-style: none;color: #535353;display: inline-block;'>
                <li><b>T</b> +31 6 41 80 60 52</li>
                <li><b>E</b> <a href='mailto:info@bwventures.nl' style='text-decoration: none;color: #0099ff;'>info@bwventures.nl</a></li>
                <li><b>KVK</b> 66606470</li>
                <li><b>BTW</b> NL856628384B01</li>
            </ul>
    </div>";
	$mail->AltBody = "This is the plain text version of the email content";
	
	//Check email
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo "<div class='col-xs-12 paddingreset'><p class='text-center extrabold'>";
			echo "Geen geldig emailadres ingevoerd.";
		echo "</p></div>";
	}
	elseif(!$mail->send()) 
	{
		echo "<div class='col-xs-12 paddingreset'><p class='text-center extrabold'>";
			echo "Mailer Error: " . $mail->ErrorInfo;
		echo "</p></div>";
	} 
	else 
	{
	$first = 'John';
	$last = 'Doe';
	$company = 'John Doe Inc.';
	$pwd = $password;
	$lan = 'EN';
	$group = '1';
	$pp = 'user.png';
	$activated = '1';
	
	//Hashing the password
	$hashedPWD = password_hash($pwd, PASSWORD_DEFAULT);
	//Insert the user into the database
	$sql = "INSERT INTO users (user_first, user_last, user_email, user_company, user_pwd, user_lan, user_groups, user_profilepicture, user_hash, user_activated) VALUES ('$first', '$last', '$email', '$company', '$hashedPWD', '$lan', '$group', '$pp', '$hash', '$activated');";
	mysqli_query($conn, $sql);

		echo "<div class='col-xs-12 paddingreset'><p class='text-center extrabold'>";
			echo "Message has been sent successfully";
		echo "</p></div>";
	}
}
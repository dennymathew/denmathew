<?php

ini_set('display_errors', '1');
// Owner's Email Address
$siteOwnersEmail = 'akshayvenugopal007@gmail.com';

if ($_POST) {

    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));
    $error_flag = 0;

    // Check Name
    if (strlen($name) < 2) {
        $error['name'] = "Please enter your name.";
        $error_flag = 1;
    }
    // Check Email
    if (!preg_match('/^[a-z0-9&\'\.\-_\+]+@[a-z0-9\-]+\.([a-z0-9\-]+\.)*+[a-z]{2}/is', $email)) {
        $error['email'] = "Please enter a valid email address.";
        $error_flag = 1;
    }
    // Check Message
    if (strlen($contact_message) < 15) {
        $error['message'] = "Please enter your message. It should have at least 15 characters.";
        $error_flag = 1;
    }
    // Subject
    if ($subject == '') {$subject = "Contact Form Submission";}

    // Set Message
    $message = "Email from: " . $name . "<br />Email address: " . $email . "<br />Message: <br />" . $contact_message . "<br /> ----- <br /> This email was sent from your site's contact form. <br />";

    // Set From: header
    $from = $name . " <" . $email . ">";

    // Email Headers
    $headers = "From: " . $from . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

    if ($error_flag == 0) {

		ini_set("sendmail_from", $siteOwnersEmail); // for windows server
		$mail = mail($siteOwnersEmail, $subject, $message, $headers);
        if ($mail) {
            echo "OK";
        } else {
            echo "Something went wrong. Please try again later.";
        }

    } # end if - no validation error

    else {

        $response = (isset($error['name'])) ? $error['name'] . "<br /> \n" : null;
        $response .= (isset($error['email'])) ? $error['email'] . "<br /> \n" : null;
        $response .= (isset($error['message'])) ? $error['message'] . "<br />" : null;

        echo $response;

    } # end if - there was a validation error

}

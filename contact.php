<?php 

//configure
$from = 'Portfolio contact page <demo@domain.com>';
$sendTo = 'Demo contact form <demo@domain.com>';
$subject = 'New message from contact form';
$fields = array('name' => 'Name', 'surname' => 'Surname', 'phone' => 'Phone', 'email' => 'Email', 'message' => 'Message'); //array variable name => Text to appear in the email;
$okMessage = 'Thanks for getting in contact, your form has been submitted successfully. I will get back to you as soon as possible!';
$errorMessage = 'There was an error while submitting the form. Please try again later.';

//sendind protocol

try
{
	$emailText = "You have a new message from contact form\n=============================\n";

	foreach ($_POST as $key => $value) {

		if (isset($fields[$key])) {
			$emailText .= "$fields[$key]: $value\n";
		}
	}

	$headers = array('Content-Type: text/html; charset="UTF-8";',
		'From: ' . $from,
		'Reply-To: ' . $from,
		'Return-Path: ' . $from,
	);

	mail($sendTo, $subject, $emailText, implode("\n", $headers));

	$responseArray = array('type' => 'success', 'message' => $okMessage);
}
catch (\Exception $e)
{
	$responseArray = array('type' => 'danger', 'message' => $errorMessage);
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	$encoded = json_encode($responseArray);

	header('Content-Type: application/json');

	echo $encoded;
}
else {
	echo $responseArray['message'];
}
?>
<?php

header("Content-type: text/plain; charset=utf-8");


include("createrepo.confs.php");


if (!preg_match('/^[a-zA-Z0-9]+$/', $_GET["registereduser"])) {
	echo "Pay atention to the authorized user provided\n";
	return;
}

if ($registered_user == "YOURAUTHORIZEDUSER" || $_GET["registereduser"] != $registered_user) {
	echo "Please, make a correct configuration in the script. Problem in the registered user.\n";
	return;
}

if (!preg_match('/^[a-zA-Z0-9_]+$/', $_GET["projname"])) {
	echo "Problem in the project name.\n";
	return;
}

$project_name = $_GET["projname"];


if ($github_credential == "USERNAME:PASSWORD") {
	echo "Please, make a correct configuration in the script. Problem in the github credentials.\n";
	return;
}

if (!preg_match('/^[a-zA-Z0-9:]+$/', $github_credential)) {
	echo "Invalid format in the configuration.\n";
	return;
}

$parameters = '{"name":"' . $project_name . '"}';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.github.com/user/repos");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $github_credential);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POSTFIELDS, $parameters);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; eN-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
$results = curl_exec($ch);
$response_obj = json_decode($results);

//echo $results;
echo respondsToCli($response_obj);

function respondsToCli($obj) {
	$to_echo = "";
	$success = see_if_succeed($obj);
	if ($success == 0) {

		// The first line to be outputed is the "execution code". 0 for success, 1 to something else.
		$to_echo .= "0" . "\n";

		// The second and third line outputs the user name and e-mail, that is required for local github repository configurations
		GLOBAL $github_credential;
		
		$user_data_json = get_github_user_data($github_credential);
		$user_data = json_decode($user_data_json);

		// Second line: the user name
		$to_echo .= $user_data->name . "\n";

		// Third line: the e-mail
		$to_echo .= $user_data->email . "\n";

		// And finally, the fourth line, outputs the real github user
		$user_and_password = explode(":", $github_credential);
		$github_user = $user_and_password[0];
		$to_echo .= $github_user;
		
	} else {
		$to_echo .= "1\n";
		$to_echo .= $obj->message;
	}

	return $to_echo;
}

function see_if_succeed($obj) {
	if (isset($obj->id)) {
		return 0; // Success
	} else {
		return 1; // Some error
	}
}

function get_github_user_data($github_credential) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.github.com/users/danilocgsilva");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERPWD, $github_credential);
	curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; eN-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
	$results = curl_exec($ch);
	return $results;
}

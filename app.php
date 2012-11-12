<?php

class App {
	// chop off the sub-domain
	static public $server, $subdomain, $localFWServerLabel, $localFWServerPrefix, $isDev, $killPhrase, $adServer, $useNewTags, $iframeStyle, $mmms, $nielsen;
	
	static public function init() {
		$host = $_SERVER['HTTP_HOST'];
		self::$server = substr($host, strpos($host, '.')+1);
		self::$subdomain = substr($host, 0, strpos($host, '.'));
		self::$isDev = (strpos(self::$server, 'static') === 0);
		self::$localFWServerLabel = (self::$isDev) ? 'Dev' : 'Test';
		self::$localFWServerPrefix = (self::$isDev) ? 'dev-' : 'test-';
		self::$killPhrase = "";
		self::$useNewTags = false;
		// self::$iframeStyle = ' marginwidth="3" marginheight="3" style="margin:0px; padding:0; border: 1px solid #ccc; "';
		self::$iframeStyle = ' marginwidth="0" marginheight="0" style="margin:0px; padding:0; border: 0px solid #ccc; "';
		// self::$adServer = 'st1.' . $server;
		self::$mmms = false;
		self::$nielsen = false;
	}
	
	static public function getDefault($param, $altValue) {
		return (isset($_GET[$param])) ? $_GET[$param] : $altValue;
	}

	static public function getDefaultFWServer($subdomain='') {
		return $subdomain . self::$localFWServerPrefix . "adsafeprotected.com:8080";
	}

	static public function getBoilerplate($title=false) {
		$visibleTitle = ($title) ? "<h2>$title</h2>" : '';

		return <<< BOIL

<!DOCTYPE HTML>
<html>
<head>
	<title>$title</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> -->
	<script src="jquery-1.7.1.min.js"></script>
	<link href="style.css" rel="stylesheet">
</head>
<body>

	$visibleTitle


BOIL;


	}
	
	static public function getBoilerplateClose() {
		return <<< BOIL

</body>
</html>	
		
BOIL;
	}

	static public function getNav($pages, $default) {

		$result = '<ul class="menu">';
		$p = App::getDefault('p', $default);

		foreach($pages as $key => $label) {
			$fore = ($key == $p) ? '<span>' : "<a href='./?p=$key'>";
			$aft = ($key == $p) ? '</span>' : "</a>";
			$result .= "<li>$fore$label$aft</li>";
		}
		$result .= '</ul>';

		return $result;
	}
}

App::init();

// session set-up
// for this to work, I'll probably have to pass the session id down through the iframe chain
/*
$sessionDomain = "." . App::$server;
session_name('AdSafe JS Test Session');
session_id($sessionId);
session_set_cookie_params(0, '/', $sessionDomain);
session_start();
*/

// HELPERS

function __autoload($class_name) {
    include "classes/$class_name.php";
}


function pp($obj) {
	echo "<pre>";
	print_r($obj);
	echo "</pre>";
}

function startsWith($haystack, $needle) {
	$length = strlen($needle);
	return (substr($haystack, 0, $length) === $needle);
}
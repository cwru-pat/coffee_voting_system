<?php
require_once "private/site.php";

require_once "private/templates/header.php";
require_once "private/templates/navbar.php";

if (!$user->isAdmin() || !$user->isLoggedIn()) {
?>
	
	<div class="container">
		<h1>Invalid access.</h1>
	</div>
	
<?php
	include_once "private/templates/footer.php";
	die();
}
?>

<div class="container">
	<div class="page-header">
		<h1>Import/Expire Papers</h1>
	</div>
	<div>
<?php
		echo "<p>Starting paper import/expire tasks. To automate this, set up a cron job, similar to</p>\n";
		echo "<pre>\n 0 0,21,22 * * * " . __DIR__ .  "/private/coffee_cron.sh > " . __DIR__ . "/private/log/cron.log\n</pre>\n";
		echo "<p>which will run at midnight, 9 pm, and 10 pm daily and save the output to a log file.</p>\n\n";
		require_once "private/cronjob.php";
?>
	</div>
</div>
<br>
<?php
require_once "private/templates/footer.php";

<?php

$page_id = "page_votes";
$mathjax = true;

require_once "private/site.php";

require_once "private/templates/header.php";
require_once "private/templates/navbar.php";

// jumbotron is only content
require_once "private/templates/jumbotron.php";
?>
<script type="text/javascript" src="<?php print path(); ?>js/toggle.js"></script>
<div class="container">
	<div class="text-center input-daterange hidden" id="datepick-votes" style="float: none;">
		
		<div class="cal-panel panel panel-success"> 
			<div class="panel-heading">
				<h3 class= "panel-title"> Start Date</h3>
			</div>
			<div class="panel-body">
				<div class="date-start cal-input" id="votes-datepick-start"></div>
			</div>
		</div>

		<div class="cal-panel panel panel-success"> 
			<div class="panel-heading">
				<h3 class= "panel-title"> End Date</h3>
			</div>
			<div class="panel-body">
				<div class="date-end cal-input" id="votes-datepick-end"></div>
			</div>
		</div>

	</div>
</div>

<?php
require_once "private/templates/footer.php";
?>
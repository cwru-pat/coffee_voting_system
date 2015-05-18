<?php

$page_id = "page_me";

require_once("private/site.php");

require_once("private/templates/header.php");
require_once("private/templates/navbar.php");
?>
<div class="container">
  <div class="page-header">
    <h1>My Votes</h1>
  </div>
<?php

if($user->isLoggedIn()) {
	$userId = $user->id();
	$query = "SELECT votes.value, papers.title,  votes.date FROM votes JOIN papers ON votes.paperID=papers.id WHERE userId = ? ORDER BY votes.date DESC";
	$result = $coffee_conn->boundQuery($query, array('s', &$userId));?>

<table class="table table-striped table-hover table-bordered">
			<?php foreach($result as $row) {?>
				<tr>
				<?php foreach($row as $element) {
					?>
					<td><?php print $element;?> </td>
				<?php
					}?>
				</tr>
			<?php }?>
		</table><?php
	
} else {
	?><h4> Please <a href='#'>sign in</a> before you can view your votes! </h4><?php
}
?>

</div>

<?php

require_once("private/templates/footer.php");

?>

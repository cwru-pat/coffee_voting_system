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
		$query = "SELECT votes.value, papers.title, votes.date, votes.paperID FROM votes JOIN papers ON votes.paperID=papers.id WHERE userId = ? ORDER BY votes.date DESC";
		$result = $coffee_conn->boundQuery($query, array('s', &$userId));?>

		<table class="table table-striped table-hover table-bordered table-condensed">
			<tr> 
				<th>Paper Name</th>
				<th> Rating</th>
				<th>Date</th>
			</tr>
			<?php foreach($result as $row) {?>
			<tr>

				<td><a href="<?php print path(); ?>post.php?post-id=<?php print $row['paperID']; ?>"><?php print format_arxiv_title_bare($row['title']); ?></a></td>
				<td class="rating"><?php print $row['value'];?></td>
				<td><?php $tdate=explode(" ",$row['date']); print $tdate[0];?></td>
				
			</tr>
			<?php }?>
		</table><?php

	} else {
		?><h4> Please <a href="<?php print path() ?>login.php">sign in</a> before you can view your votes! </h4><?php
	}
	?>

</div>

<?php

require_once("private/templates/footer.php");

?>
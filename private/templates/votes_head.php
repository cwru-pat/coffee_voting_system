<?php
$votes = array();
if($user->isLoggedIn()) {
	$userId = $user->id();
	$query = "SELECT * FROM votes WHERE userId = ?";
	$result = $coffee_conn->boundQuery($query, array('s', &$userId));

	$votes = array();
	foreach($result as $row) {
		$votes[$row["paperId"]] = $row["value"];
	}
}
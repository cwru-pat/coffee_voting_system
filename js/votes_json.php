<?php

require_once("../private/site.php");
$coffee_conn->setDebug(FALSE);

$paper_meeting_times = get_adjacent_meeting_times("end", TRUE /* Get *only* meeting times where papers will be discussed */);
$prev_time = date("Y-m-d H:i", $paper_meeting_times["prev"]);
$next_time = date("Y-m-d H:i", $paper_meeting_times["next"]);
$query = "SELECT papers.id, papers.title, papers.authors, papers.abstract, SUM(votes.value) AS value
          FROM papers
          JOIN votes ON papers.id=votes.paperid 
          WHERE votes.date BETWEEN ? AND ?
          GROUP BY papers.id ORDER BY value DESC";
$result = $coffee_conn->boundQuery($query, array('ss', &$prev_time, &$next_time));

return json_encode($result);

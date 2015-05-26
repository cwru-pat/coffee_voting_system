<?php

$arxivs = $config->get("arxivs");
$timestamp = $params->getDate();
$date = date("Y-m-d", $timestamp);
$begin_date = $date . " 00:00:00";
$end_date = $date . " 23:59:59";

//$votes is defined in jumbotron.php didn't want to repeat code

$user_papers = $coffee_conn->boundQuery(
    "SELECT * FROM papers WHERE subject = 'users' AND date BETWEEN ? AND ?",
    array('ss', &$begin_date, &$end_date)
  );
if(count($user_papers)) {
  array_unshift($arxivs, "users");
}

foreach($arxivs as $arxiv) {
?>
<div class="panel panel-info arxiv">
  <div class="panel-heading toggle arxiv">
    <h3 class="panel-title"><span class='hidden-sm hidden-xs'>Papers from</span> <?php print $arxiv; ?></h3>
  </div>
  <div class="panel-body arxiv">
    <ul class="feed list-group">
    <?php
      $papers = $coffee_conn->boundQuery(
          "SELECT * FROM papers WHERE subject = ? AND date BETWEEN ? AND ?",
          array('sss', &$arxiv, &$begin_date, &$end_date)
        );

      if(count($papers) == 0) {
        print "<p>No papers in this section today!</p>";
      } else {
        foreach($papers as $paper) {
          ?>
          <li class='article list-group-item' id='article-<?php print $paper->id; ?>'>
            <?php include "paper.php"; ?>
          </li>
          <?php
        }
      }
    ?>
    </ul>
  </div>
</div>
<?php
}

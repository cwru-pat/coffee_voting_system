<?php

$arxivs = $config->get("arxivs");
$timestamp = $params->getDate();
$date = date("Y-m-d", $timestamp);

foreach($arxivs as $arxiv) {
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Papers from <?php print $arxiv; ?></h3>
  </div>
  <div class="panel-body">
    <ul>
    <?php
      $query = "SELECT * FROM papers WHERE subject = '$arxiv' AND date BETWEEN '{$date} 00:00:00' AND '{$date} 23:59:59'";
      $result = $coffee_conn->dbQuery($query);
      foreach($result as $paper) {
        print "<li>";
        print "<h4>" . format_arxiv_title($paper->title) . "</h4>";
        print "<h5>" . ($paper->authors) . "</h5>";
        print "<p>" . ($paper->abstract) . "</p>";
        print "</li>";
      }
    ?>
    </ul>
  </div>
</div>
<?php
}

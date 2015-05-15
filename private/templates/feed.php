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
    <ul class="feed">
    <?php
      $query = "SELECT * FROM papers WHERE subject = '$arxiv' AND date BETWEEN '{$date} 00:00:00' AND '{$date} 23:59:59'";
      $result = $coffee_conn->dbQuery($query);
      foreach($result as $paper) {
        ?>
        <li class='article' id='article-<?php print $paper->id; ?>' paperId='<?php print $paper->id; ?>' >
          <h4><?php print format_arxiv_title($paper->title); ?></h4>
          <h5><?php print $paper->authors; ?></h5>
          <button type="button" class="btn btn-xs btn-success btn-upvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Increase Rating">
            <span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>
          </button>
          <button type="button" class="btn btn-xs btn-danger btn-downvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Decrease Rating">
            <span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>
          </button>
          <span class='article-messages' id='article-<?php print $paper->id; ?>-messages'></span>
          <p><?php print $paper->abstract; ?></p>
        </li>
        <?php
      }
    ?>
    </ul>
  </div>
</div>
<?php
}

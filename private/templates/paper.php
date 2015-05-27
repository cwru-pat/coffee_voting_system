<?php
/*
 * This file expects a $paper array to be set in the current scope, eg a result returned from boundQuery.
 */
?>
<h4><?php print format_arxiv_title($paper["title"]); ?></h4>
<h5><?php print format_arxiv_authors($paper["authors"]); ?></h5>
<div class="article-button-holder" data-paperid="<?php print $paper["id"]; ?>">
<a role="button" href="#" class="btn btn-xs btn-success btn-upvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Increase Rating">
  <span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>
</a>
<a role="button" href="#" class="btn btn-xs btn-danger btn-downvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Decrease Rating">
  <span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>
</a>
<?php if(isset($votes[$paper["id"]])) { ?>
  <?php if($votes[$paper["id"]] > 0) { ?>
    <span class='article-messages bg-success' id='article-<?php print $paper["id"]; ?>-messages'>
    <?php print "Rated: +" . $votes[$paper["id"]]; ?>
  <?php } else { ?>
    <span class='article-messages bg-danger' id='article-<?php print $paper["id"]; ?>-messages'>
    <?php print "Rated: " . $votes[$paper["id"]]; ?>
  <?php } ?>
  </span>
<?php } else { ?>
  <span class='article-messages ' id='article-<?php print $paper["id"]; ?>-messages'>&nbsp;</span>
<?php } ?>
</div>
<p>
  <?php
    if($paper["subject"] == "users") {
      print $paper["abstract"];
    } else {
      print o($paper["abstract"]);
    }
  ?>
</p>

<?php
/*
 * This file expects a $paper array to be set in the current scope, eg a result returned from boundQuery.
 */
$votes = get_votes();

if ($user->isLoggedIn() && $user->id() == $paper["authors"]) {
    $isCreator = true;
} else {
    $isCreator = false;
}

// Title
print "<h4>";
if ($user->isAdmin() || $isCreator) {
    print '<a role="button"'
          . ' href="' . path() . 'add?post-id='.$paper['id'].'"'
          . ' class="pull-right btn btn-info btn-xs"'
          . ' data-toggle="tooltip"'
          . ' data-placement="bottom"'
          . ' title="Edit">';
    print '<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>';
    print '</a>';
}
print format_arxiv_title($paper["title"]);
print "</h4>";

// Authors
print "<h5>";
print format_arxiv_authors($paper["authors"]);
print "</h5>";

// Buttons
?>
<div class="article-button-holder" data-paperid="<?php print $paper["id"]; ?>">
    <a role="button" href="#" class="btn btn-xs btn-success btn-upvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Increase Rating">
        <span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>
    </a>
    <a role="button" href="#" class="btn btn-xs btn-danger btn-downvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Decrease Rating">
        <span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>
    </a>
    <?php
    if (isset($votes[$paper["id"]])) {
        if ($votes[$paper["id"]] > 0) :
        ?>
            <span class='article-messages bg-success' id='article-<?php print $paper["id"]; ?>-messages'>
                <?php print "Rated: +" . $votes[$paper["id"]]; ?>
            </span>
        <?php
        else :
        ?>
            <span class='article-messages bg-danger' id='article-<?php print $paper["id"]; ?>-messages'>
                <?php print "Rated: " . $votes[$paper["id"]]; ?>
            </span>
        <?php
        endif;
    } else {
        ?>
            <span class='article-messages ' id='article-<?php print $paper["id"]; ?>-messages'>&nbsp;</span>
        <?php
    }
    ?>
</div>

<p>
    <?php
    if ($paper["subject"] == "users") {
        print $paper["abstract"];
    } else {
        print o($paper["abstract"]);
    }
    ?>
</p>

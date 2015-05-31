<?php

$timestamp = $params->getDate();
$date = date("Y-m-d", $timestamp);
$begin_date = $date . " 00:00:00";
$end_date = $date . " 23:59:59";
$votes = get_votes();

$arxivs = get_variable("arxivs");
array_unshift($arxivs, "users"); // add "users"

foreach ($arxivs as $arxiv) :
?>
<div class="panel panel-info arxiv">
    <div class="panel-heading toggle arxiv">
        <h3 class="panel-title">
            <span class='hidden-sm hidden-xs hidden-md'>Papers from</span>
            <?php print $arxiv; ?>
        </h3>
    </div>
    <div class="panel-body arxiv">
        <ul class="feed list-group">
        <?php
            $papers = $coffee_conn->boundQuery(
                "SELECT * FROM papers WHERE subject = ? AND date BETWEEN ? AND ?",
                array('sss', &$arxiv, &$begin_date, &$end_date)
            );
            if (count($papers) == 0) {
                print "<li class='list-group-item'>No papers in this section today!</li>";
            } else {
                foreach ($papers as $paper) {
                    print "<li class='article list-group-item' id='article-" . $paper['id'] . "'>";
                    include "paper.php";
                    print "</li>";
                }
            }
        ?>
        </ul>
    </div>
</div>
<?php
endforeach;

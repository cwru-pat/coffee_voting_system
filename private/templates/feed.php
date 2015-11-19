<?php

$timestamp = $params->getDate();
$date = date("Y-m-d", $timestamp);
$begin_date = $date . " 00:00:00";
$end_date = $date . " 23:59:59";
$votes = get_votes();

$arxivs = get_variable("arxivs");
array_unshift($arxivs, "users"); // add "users"
$q_params=$arxivs;
array_push($q_params, $begin_date, $end_date);
$q_num=count($q_params);
$r_params=array();

foreach ($arxivs as $arxiv) :
?>
<div class="panel panel-info arxiv">
    <div class="panel-heading toggle arxiv">
        <h3 class="panel-title">
            <span class='hidden-sm hidden-xs hidden-md'>Papers from</span>
            <span class= "cookieTitle"> <?php print $arxiv; ?></span>
        </h3>
    </div>
    <div class="panel-body arxiv">
        <ul class="feed list-group">
        <?php
            $papers = $coffee_conn->boundQuery(
                "SELECT * FROM papers WHERE subject = ? AND date BETWEEN ? AND ? ORDER BY id",
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

?>
<div class="panel panel-info arxiv">
    <div class="panel-heading toggle arxiv">
        <h3 class="panel-title">
            <span class='hidden-sm hidden-xs hidden-md'>Papers from</span>
            <span class= "cookieTitle">other</span>
        </h3>
    </div>
    <div class="panel-body arxiv">
        <ul class="feed list-group">
        <?php
            for($i=0;$i<$q_num;$i++) {
                $r_params[] = & $q_params[$i];
            }
            array_unshift($r_params,str_pad('',$q_num,'s'));
            $papers = $coffee_conn->boundQuery(
                "SELECT * FROM papers WHERE subject NOT IN (".str_pad('',2*($q_num-2)-1,'?,').") AND date BETWEEN ? AND ?",$r_params
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

<div class="panel panel-info arxiv">
    <div class="panel-heading toggle arxiv">
        <h3 class="panel-title">
            <span class='hidden-sm hidden-xs hidden-md'>Papers from</span>
            <span class= "cookieTitle">sna-rx.IV</span>
        </h3>
    </div>
    <div class="panel-body arxiv">
        <ul class="feed list-group">
        <?php
            $papers = $coffee_conn->boundQuery(
                "SELECT * FROM papers WHERE subject = 'sna-rx.IV' AND date BETWEEN ? AND ? ORDER BY id",
                array('ss', &$begin_date, &$end_date)
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
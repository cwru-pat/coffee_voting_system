<!-- Main jumbotron for a primary marketing message or call to action -->
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

$query="SELECT votes.paperId, votes.userId, votes.value FROM votes";
$result = $coffee_conn->dbQuery($query);
$paper_votes=array();
foreach($result as $row){
	$paper_votes[$row->paperId][$row->userId]=$row->value;
}


?>
<div class="jumbotron">
	<div class="container">
		<h2>CWRU PAT Coffee Agenda</h2>
		<p>Tuesdays | 11am-12noon</p>

		<ul class="feed">
			<?php
			$query = "SELECT papers.id, papers.title, papers.authors, papers.abstract, SUM(votes.value) AS value FROM papers JOIN votes ON papers.id=votes.paperid AND votes.date > '2015-05-05 02:00:00' GROUP BY papers.id ORDER BY value DESC";
			$result = $coffee_conn->dbQuery($query);
			foreach($result as $paper) {
				?>
				<li class='article' id='article-<?php print $paper->id; ?>' paperId='<?php print $paper->id; ?>' >

					<div class="panel panel-default">
						<div class="panel-heading voted-paper">
							<div class="vote-float-left col-sm-1">
								<?php 
								if($paper->value > 0) { ?>
									<span class='article-messages-voted bg-success' id='article-<?php print $paper->id; ?>-messages-voted'> <?php print "+" . $paper->value; ?> </span>
								<?php 
								} else { ?>
									<span class='article-messages-voted bg-danger' id='article-<?php print $paper->id; ?>-messages-voted'> <?php print $paper->value; ?> </span>
								<?php 
								} ?>
								</div>
								<button type="button" class="btn btn-lg abstract-btn col-sm-1" id="article-<?php print $paper->id?>">Abs.</button>
								<div class="title-and-name col-sm-10">
							<h4>
								<?php print format_arxiv_title($paper->title); ?> 
							</h4>
							<p><?php
								foreach($paper_votes[$paper->id] as $user_l=>$votes_l) {
									print $user_l;?>
									<sup><?php
									if($votes_l>0) {
										?>+<?php print $votes_l;
									} else {
										print $votes_l;
									}?></sup>
								 <?php 
								}?>
							</p>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="panel-body voted-paper" style="display: none;" id="article-<?php print $paper->id?>">
							<h4><?php print $paper->authors; ?></h4>
							<div class="article-button-holder voted" paperId='<?php print $paper->id; ?>'>
								<button type="button" class="btn btn-xs btn-success btn-upvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Increase Rating">
									<span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>
								</button>
								<button type="button" class="btn btn-xs btn-danger btn-downvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Decrease Rating">
									<span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>
								</button>
								<?php 
								if(isset($votes[$paper->id])) { ?>
									<?php 
									if($votes[$paper->id] > 0) { ?>
										<span class='article-messages bg-success' id='article-voted-<?php print $paper->id; ?>-messages'> <?php print "Rated: +" . $votes[$paper->id]; ?> </span>
											<?php 
									} else { ?>
										<span class='article-messages bg-danger' id='article-voted-<?php print $paper->id; ?>-messages'> <?php print "Rated: " . $votes[$paper->id]; ?> </span>
											<?php 
									} 
								} else { ?>
									<span class='article-messages' id='article-<?php print $paper->id; ?>-messages'></span>
									<?php
								} ?>
							</div>
							<p> <?php print $paper->abstract ?></p>
						</div>
					</div>
				</li>
				<?php
			} ?>
		</ul>
	</div>
</div>

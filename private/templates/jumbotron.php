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

$query = "SELECT votes.paperId, votes.userId, votes.value FROM votes";
$result = $coffee_conn->dbQuery($query);
$paper_votes = array();
foreach($result as $row){
	$paper_votes[$row->paperId][$row->userId]=$row->value;
}


?>
<div class="jumbotron">
	<div class="container">
		<h2>CWRU PAT Coffee Agenda</h2>
		<p>Tuesdays | 11am-12noon</p>

		<div class="list-group voted-abstracts">
			<?php
			$query = "SELECT papers.id, papers.title, papers.authors, papers.abstract, SUM(votes.value) AS value FROM papers JOIN votes ON papers.id=votes.paperid AND votes.date > '2015-05-05 02:00:00' GROUP BY papers.id ORDER BY value DESC";
			$result = $coffee_conn->dbQuery($query);
			foreach($result as $paper) {
				?>
					<div class="list-group-item voted paper-listing">
						
						<h4>
						<?php 
							if($paper->value > 0) { ?>
								<span class='label label-success vote-label' id='article-<?php print $paper->id; ?>-messages-voted'> <?php print "+" . $paper->value; ?> </span>
							<?php } else { ?>
								<span class='label label-danger vote-label' id='article-<?php print $paper->id; ?>-messages-voted'> <?php print $paper->value; ?> </span>
							<?php } 
							$voted_title=format_arxiv_title_voted($paper->title);
							if(is_array($voted_title)){ ?>
								<span class="paper-title-voted"><?php print $voted_title[0]; ?></span> 
							<?php } else { ?>
								<span class="paper-title-voted"><?php print $voted_title ?></span> 
							<?php }?>
						</h4>

						<div class="btn-group voted paper" role="group">
							<?php if(is_array($voted_title)){
								print $voted_title[1] . $voted_title[2];
							}?>
							<button type="button" class="btn btn-default btn-xs voted-btn abstract-showhide" data-paperid="<?php print $paper->id?>" id="article-<?php print $paper->id?>-button">Abstract</button>
						</div>

						<span class="user-voters"><?php
							foreach($paper_votes[$paper->id] as $user_l => $votes_l) {?>
								<span class="user-sup"> <?php print $user_l;?>
									<sup><?php
									if($votes_l>0) {
										?>+<?php print $votes_l;
									} else {
										print $votes_l;
									}?>
									</sup>
								</span>
							 <?php 
							}?>
						</span>

						<div class="voted-paper-abstract" style="display: none;" id="article-<?php print $paper->id?>-abstract">
							<h5><?php print $paper->authors; ?></h5>
							<div class="article-button-holder voted">
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
									<span class='article-messages' id='article-voted-<?php print $paper->id; ?>-messages'>&nbsp;</span>
									<?php
								} ?>
							</div>
							<?php print $paper->abstract ?>
						</div>

					</div><!-- end #list-group-item -->
				<?php // end foreach
			} ?>
		</div><!-- end #list-group -->

	</div>
</div>

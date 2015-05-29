<!-- Main jumbotron for a primary marketing message or call to action -->
<?php
require_once('private/templates/votes_head.php');

$query = "SELECT * FROM votes ORDER BY paperId, date DESC;";
$result = $coffee_conn->dbQuery($query);
$paper_votes = array();
foreach($result as $row){
	$paper_votes[$row->paperId][$row->userId] = array(
		"value" => $row->value,
		"date" => strtotime($row->date)
		);
}


?>
<div class="jumbotron">
	<div class="container">
		<h2>CWRU PAT Coffee Agenda</h2>
		<p>
			<?php
				$meeting_time_ends = get_meeting_timestamps("end");
				$meeting_time_starts = get_meeting_timestamps("start");
				for($i=0; $i<count($meeting_time_ends); $i++) {
					if($i>0) print " | "; 
					if(!$meeting_time_starts[$i]["papers_only"]) {
						print "<span class='old-vote' data-toggle='tooltip' data-placement='bottom' title='No paper discussion'>";
					} else {
						print "<span>";
					}
					print date("l\s H:i", $meeting_time_starts[$i]["timestamp"]);
					print date(" - H:i", $meeting_time_ends[$i]["timestamp"]);

/*					if(!$meeting_time_starts[$i]["papers_only"]) {
						print "*";
					}*/
					print "</span>";
				}
			?>
		</p>

		<div class="list-group voted-abstracts">
			<?php
			$paper_meeting_times = get_adjacent_meeting_times("end", TRUE /* Get *only* meeting times where papers will be discussed */);
			$prev_time = date("Y-m-d H:i", $paper_meeting_times["prev"]);
			$next_time = date("Y-m-d H:i", $paper_meeting_times["next"]);
			$query = "SELECT papers.id, papers.title, papers.authors, papers.abstract, SUM(votes.value) AS value
								FROM papers
								JOIN votes ON papers.id=votes.paperid 
								WHERE votes.date BETWEEN ? AND ?
								GROUP BY papers.id ORDER BY value DESC";
			$result = $coffee_conn->boundQuery($query, array('ss', &$prev_time, &$next_time));
			foreach($result as $paper) {
				?>
					<div class="list-group-item voted paper-listing">
						
						<h4 class="voted-title">
							<?php if($paper["value"] > 0) { ?>
								<span class='label label-success vote-label' id='article-<?php print $paper["id"]; ?>-messages-voted'>
									<?php print "+" . $paper["value"]; ?>
								</span>
							<?php } else { ?>
								<span class='label label-danger vote-label' id='article-<?php print $paper["id"]; ?>-messages-voted'>
									<?php print $paper["value"]; ?>
								</span> 
							<?php } ?>
							<button type="submit" class="vote-bump btn btn-xs btn-warning" title="Bump to Next Meeting" data-toggle="modal" data-target="#bumpModal" data-toggle-tip="tooltip" data-placement="bottom" data-paperid="<?php print $paper["id"]; ?>">
								<span class="glyphicon glyphicon-share-alt" data-paperid="<?php print $paper["id"]; ?>"></span>
							</button>
							<?php
									$voted_title=format_arxiv_title_voted($paper["title"]);
									if(is_array($voted_title)){
							?>
								<span class="paper-title-voted"><?php print $voted_title[0]; ?></span> 
							<?php } else { ?>
								<span class="paper-title-voted"><?php print $voted_title ?></span> 
							<?php }?>
						</h4>

						<div class="btn-group voted paper" role="group">
							<?php if(is_array($voted_title)){
								print $voted_title[1] . $voted_title[2];
							}?>
							<a role="button" href="#" class="btn btn-default btn-xs voted-btn abstract-showhide" data-paperid="<?php print $paper["id"]; ?>" id="article-<?php print $paper["id"]; ?>-button" title="Toggle Abstract" data-toggle="button" data-toggle-tip="tooltip" data-container="body" data-placement="bottom">Abstract</a>
							<?php if($user->isAdmin()||($user->isLoggedIn() && $user->id()==$paper["authors"])) { ?>
								<a role="button" href="<?php print path()?>add.php?post-id=<?php print $paper['id']?>" class="btn btn-default btn-xs voted-btn" data-toggle="tooltip" data-placement="bottom" title="Edit" data-container="body">
      						<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
    						</a>
							<?php } ?>
						</div>

						<span class="user-voters"><?php
							foreach($paper_votes[$paper["id"]] as $user_id => $votes_data) {?>
								<span class='user-sup <?php print ($votes_data["date"]<$paper_meeting_times["prev"]) ? "old-vote" : ""; print ($user_id=="bump")?"text-warning":""; ?>'>
								<?php print $user_id;?>
									<sup><?php
									if($votes_data["value"]>0) {
										?>+<?php print $votes_data["value"];
									} elseif($votes_data["value"]<0) {
										print $votes_data["value"];
									} else {
										print "&nbsp;";
									}?>
									</sup>
								</span>
							 <?php 
							}?>
						</span>

						<div class="voted-paper-abstract" style="display: none;" id="article-<?php print $paper["id"]; ?>-abstract">
							<h5><?php print format_arxiv_authors($paper["authors"]); ?></h5>
							<div class="article-button-holder voted" data-paperid="<?php print $paper["id"]; ?>">
								<a role="button" href="#" class="btn btn-xs btn-success btn-upvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Increase Rating">
									<span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>
								</a>
								<a role="button" href="#" class="btn btn-xs btn-danger btn-downvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Decrease Rating">
									<span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>
								</a>
								<?php if(isset($votes[$paper["id"]])) { ?>
									<?php if($votes[$paper["id"]] > 0) { ?>
										<span class='article-messages bg-success' id='article-voted-<?php print $paper["id"]; ?>-messages'>
											<?php print "Rated: +" . $votes[$paper["id"]]; ?>
										</span>
									<?php } else { ?>
										<span class='article-messages bg-danger' id='article-voted-<?php print $paper["id"]; ?>-messages'>
											<?php print "Rated: " . $votes[$paper["id"]]; ?>
										</span>
									<?php } ?>
								<?php } else { ?>
									<span class='article-messages' id='article-voted-<?php print $paper["id"]; ?>-messages'>&nbsp;</span>
								<?php } ?>
							</div>
							<?php print $paper["abstract"]; ?>
						</div>

					</div><!-- end #list-group-item -->
				<?php // end foreach
			} ?>
		</div><!-- end #list-group -->
  	<p>
			<em>
				Showing votes from <?php print $prev_time; ?> to <?php print $next_time; ?> |
				Next meeting is <?php
				$adjacent_meetings = get_adjacent_meeting_times("start", FALSE, time());
				print date("l M jS, H:i a", $adjacent_meetings["next"]);
			?>.</em>
		</p>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="bumpModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <a role="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <?php if($user->isLoggedIn()) {?>

        <h4 class="modal-title" id="BumpLabel">Bump this article to the next meeting?</h4>
      </div>
      <div class="modal-body">
        <button type="submit" tabindex="1" class="btn btn-primary btn-block bump-btn bump-no"  data-bump="0" data-dismiss="modal" title="Remove bump" data-toggle="tooltip" data-placement="top" data-container="body">No! Don't bump it!</button>
        <button type="submit" tabindex="1" class="btn btn-warning btn-block bump-btn bump-yes" data-bump="1" data-dismiss="modal" data-toggle="tooltip" data-placement="bottom" data-container="body" title="Paper will apear next meeting">Bump it to the next meeting!</button>
      </div>
      <?php } else {?>
      <h4 class="modal-title" id="myModalLabel">You must sign in to do this!</h4>
      </div>
      <div class="modal-body">
        <form action="<?php print path(); ?>login.php" method="POST">
          <button type="submit" class="btn btn-success btn-block btn-lg">Sign in</button>
        </form>
      </div>
        <?php } ?>
    </div>
  </div>
</div>

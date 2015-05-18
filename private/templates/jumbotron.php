<!-- Main jumbotron for a primary marketing message or call to action -->

	<div class="jumbotron">
		<div class="container">
			<h2>CWRU PAT Coffee Agenda</h2>
			<p>Tuesdays | 11am-12noon</p>

			<ul class="feed">
				<?php
				$query = "SELECT papers.id, papers.title, papers.authors, SUM(votes.value) AS value FROM papers JOIN votes ON papers.id=votes.paperid AND votes.date > '2015-05-05 02:00:00' GROUP BY papers.id ORDER BY votes.value DESC";
				$result = $coffee_conn->dbQuery($query);
				foreach($result as $paper) {
					?>
					<li class='article' id='article-<?php print $paper->id; ?>' paperId='<?php print $paper->id; ?>' >

						<h4>
							<?php if($paper->value > 0) { ?>
							<span class='article-messages-voted bg-success' id='article-<?php print $paper->id; ?>-messages-voted'>
								<?php print "+" . $paper->value; ?>
								<?php 
							} else { 
								?>
								<span class='article-messages-voted bg-danger' id='article-<?php print $paper->id; ?>-messages-voted'>
									<?php print $paper->value; ?>
									<?php 
								} 
								?>
							</span>
							
							<!-- <button type="button" class="btn btn-xs btn-success btn-upvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Increase Rating">
								<span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>
							</button>
							<button type="button" class="btn btn-xs btn-danger btn-downvote" aria-label="Left Align" data-toggle="tooltip" data-placement="bottom" title="Decrease Rating">
								<span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>
							</button> -->

							<?php print format_arxiv_title($paper->title); ?>
						</h4>
						<h5><?php print $paper->authors; ?></h5>

					</li>
					<?php
				}
				?>
			</ul>

		</div>
	</div>

<?php 
	$paper_meeting_times = get_adjacent_meeting_times("end", true /* Get *only* meeting times where papers will be discussed */);
    $prev_time = date("Y-m-d H:i", $paper_meeting_times["prev"]);
?>

<div class="list-group-item">
    <div class="input-group input-daterange" id="datepick">
	    	<input type="text" id="datepick-start" class="form-control input-list toggle cal-input" readonly  data-toggle="tooltip" data-placement="top" title="Enter Date">
	    	<span class="input-group-addon">-</span>
	    	<input type="text" id="datepick-end" class="form-control input-list toggle cal-input" readonly  data-toggle="tooltip" data-placement="top" title="Enter Date">
	    	<span class="input-group-btn hidden-sm"  data-toggle="tooltip" data-placement="top" title="View all papers since the last meeting" data-container="body">
	    		<button class="btn btn-success" type="button" id="send-date" onclick="setDateRange2(new Date('<?php echo $prev_time;?>'),new Date())">
	    			<span class="fa fa-calendar-plus-o"></span>
	    		</button>
	    	</span>
	</div>
</div>
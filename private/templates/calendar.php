<?php 
	$paper_meeting_times = get_adjacent_meeting_times("end", true, time());
	/* Get meeting times for the upcoming one */
	$day = 24*60*60;
    $prev_time = date("c", $paper_meeting_times["prev"]+$day);
    $next_time = date("c", $paper_meeting_times["next"]);
?>


    <div class="input-group input-daterange hidden-sm hidden-md" id="datepick">
	    	<input type="text" id="datepick-start" class="form-control toggle cal-input cal-select format-long date-start" readonly  data-toggle="tooltip" data-trigger="hover" title="Enter Start Date">
	    	<span class="input-group-addon">-</span>
	    	<input type="text" id="datepick-end" class="form-control toggle cal-input cal-select format-long date-end" readonly  data-toggle="tooltip" data-trigger="hover" title="Enter End Date">
	    	<span class="input-group-btn hidden-sm"  data-toggle="tooltip" data-placement="top" title="View all papers since the last meeting" data-container="body">
	    		<button class="btn btn-success" type="button" id="send-date-long" onclick="setDateRange2(new Date('<?php echo $prev_time;?>'),new Date('<?php echo $next_time;?>'))">
	    			<span class="fa fa-calendar-plus-o"></span>
	    		</button>
	    	</span>
	</div>
	<div class="input-group input-daterange hidden-xs hidden-lg" id="datepick-short">
	    	<input type="text" id="datepick-start-short" class="form-control toggle cal-input cal-select format-short date-start" readonly  data-toggle="tooltip" data-trigger="hover" title="Enter Start Date">
	    	<span class="input-group-addon">-</span>
	    	<input type="text" id="datepick-end-short" class="form-control toggle cal-input cal-select format-short date-end" readonly  data-toggle="tooltip" data-trigger="hover" title="Enter End Date">
	    	<span class="input-group-btn hidden-sm"  data-toggle="tooltip" data-placement="top" title="View all papers since the last meeting" data-container="body">
	    		<button class="btn btn-success" type="button" id="send-date-short" onclick="setDateRange2(new Date('<?php echo $prev_time;?>'),new Date('<?php echo $next_time;?>'))">
	    			<span class="fa fa-calendar-plus-o"></span>
	    		</button>
	    	</span>
	</div>

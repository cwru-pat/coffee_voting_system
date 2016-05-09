<?php 
    $paper_meeting_times = get_adjacent_meeting_times("end", true, time());
    /* Get meeting times for the upcoming one */
    $day = 24*60*60;

    $prev_meeting = date("Y-m-d", $paper_meeting_times["prev"]+$day);
    $next_meeting = date("Y-m-d", $paper_meeting_times["next"]);

    $today = date("Y-m-d");

    $prev_date = date("Y-m-d", $params->getStartDate()-$day);
    $next_date = date("Y-m-d", $params->getEndDate()+$day);

?>
    <div class="input-group input-daterange hidden-sm hidden-xs" id="datepick">
        <input type="text" id="datepick-start" class="form-control toggle cal-input cal-select format-short date-start" readonly data-toggle="tooltip" data-trigger="hover" title="Choose Start Date">
        <span class="input-group-addon">-</span>
        <input type="text" id="datepick-end" class="form-control toggle cal-input cal-select format-short date-end" readonly data-toggle="tooltip" data-trigger="hover" title="Choose End Date">
    </div>

    <div class="input-group input-group-sm input-daterange hidden-md hidden-lg" id="datepick-short">
        <input type="text" id="datepick-start-short" class="form-control toggle cal-input cal-select format-short date-start" readonly  data-toggle="tooltip" data-trigger="hover" title="Choose Start Date">
        <span class="input-group-addon">-</span>
        <input type="text" id="datepick-end-short" class="form-control toggle cal-input cal-select format-short date-end" readonly  data-toggle="tooltip" data-trigger="hover" title="Choose End Date">
    </div>

    <div class="btn-group btn-group-sm btn-group-justified" id="datepick-quicknav">
        <a href="?ds=<?php echo o($prev_date); ?>&amp;de=<?php echo o($prev_date); ?>" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="View papers from previous day" data-container="body">
            <span class="fa-stack fa">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-step-backward fa-stack-1x"></i>
            </span>
        </a>
        <a href="?ds=<?php echo o($prev_meeting); ?>&amp;de=<?php echo o($next_meeting); ?>" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="View all papers since the last meeting" data-container="body">
            <span class="fa-stack fa">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-users fa-stack-1x"></i>
            </span>
        </a>
        <a href="?ds=<?php echo o($today); ?>&amp;de=<?php echo o($today); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="View papers from today" data-container="body">
            <span class="fa-stack fa">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-calendar fa-stack-1x"></i>
            </span>
        </a>
        <a href="?ds=<?php echo o($next_date); ?>&amp;de=<?php echo o($next_date); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="View papers from next day" data-container="body">
            <span class="fa-stack fa">
                <i class="fa fa-square-o fa-stack-2x"></i>
                <i class="fa fa-step-forward fa-stack-1x"></i>
            </span>
        </a>
    </div>

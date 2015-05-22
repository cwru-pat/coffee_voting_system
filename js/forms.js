
function addDatePicker(parentSelector, properties, id) {

  // some defaults
  if(!properties.hasOwnProperty("day")) properties.day = "mon";
  if(!properties.hasOwnProperty("start")) properties.start = "10:30";
  if(!properties.hasOwnProperty("end")) properties.end = "11:30";
  if(!properties.hasOwnProperty("papers")) properties.papers = true;

  var dayId = "day-picker-id-"+id;
  var startTimeId = "start-time-picker-id-"+id;
  var endTimeId = "end-time-picker-id-"+id;
  var discussionId = "is-paper-discussion-picker-id-"+id;

  $(parentSelector).append(
    "<div class='list-group-item coffee-meeting-time-picker form-inline' id='coffee-meeting-time-picker-id-"+id+"'>"
      + "<a role=button href='#' class='pull-right remove-meeting' id='remove-meeting-time-picker-id-"+id+"'>"
      +   "<span class='text-danger glyphicon glyphicon-remove'></span>"
      + "</a>"
      + "<select id='"+dayId+"' class='meetingDay' placeholder='Select a day...'></select>"
      + "From <input type='time' class='meetingStartTime' id='"+startTimeId+"' value='" + properties.start + "'>"
      + " to <input type='time' class='meetingEndTime' id='"+endTimeId+"' value='" + properties.end + "'>"
      + " <label for='"+discussionId+"' style='font-weight:normal;'>Is for paper discussion: </label>"
      + "<input type='checkbox' class='meetingIsDiscussion' id='"+discussionId+"' "+(properties.papers ? "checked" : "")+">"
    + "</div>"
  );

  var $select = $("#day-picker-id-" + id).selectize({
    valueField: 'value',
    labelField: 'name',
    options: [
      {value: "mon", name: 'Monday'},
      {value: "tue", name: 'Tuesday'},
      {value: "wed", name: 'Wednesday'},
      {value: "thu", name: 'Thursday'},
      {value: "fri", name: 'Friday'},
    ],
  });
  var selectize = $select[0].selectize;
  selectize.setValue(properties.day, true);

  $("#remove-meeting-time-picker-id-"+id).on("click", function() {
    event.preventDefault();
    $("#coffee-meeting-time-picker-id-"+id).remove();
    parseFormDates();
  });

}

function parseFormDates()
{
  console.log("Parsing dates...");
  var meetings = [];
  $(".coffee-meeting-time-picker").each(function(index, value) {
    meetings.push({
      day: $(this).children('.meetingDay').val(),
      start: $(this).children('.meetingStartTime').val(),
      end: $(this).children('.meetingEndTime').val(),
      papers: $(this).children('.meetingIsDiscussion').prop('checked')
    });
  });

  console.log("Using meeting information:", meetings);
  $('#admin_date_selectors_dates').val(JSON.stringify(meetings));
}

$(document).ready(function() {

  $("#meeting_add").on("click", function(event) {
    event.preventDefault();
    var id = 0;
    while($('#coffee-meeting-time-picker-id-'+id).length) id++; // get a unique id
    addDatePicker("#admin_date_selectors", {}, id);
    parseFormDates();
  });

  var dates = $('#admin_date_selectors_dates').val();
  try{
    if(dates) {
      dates = $.parseJSON(dates);
    } else {
      dates = false;
    }
  } catch(err) {
    console.log(err);
    dates = false;
  }

  if(dates && !$.isEmptyObject(dates)) {
    console.log("Proessed dates: ", dates);
    for(var n in dates) {
      var properties = dates[n];
      addDatePicker("#admin_date_selectors", properties, n);
    }
  } else {
    $('#admin_date_selectors_dates').val(JSON.stringify({}));
  }

  $("#admin_date_selectors").on("change", function(event) {
    parseFormDates();
  });

});

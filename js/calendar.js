$(document).ready(function() {

$('#datepick').datepicker({
    todayHighlight: true,
    endDate: "05/19/2015",
    startDate: "05/01/2015",
    todayBtn: "linked",
    toggleActive: false,
  });

$('#datepick').datepicker('setDate',"05/19/2015");
	
})

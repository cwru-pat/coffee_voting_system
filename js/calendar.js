$(document).ready(function() {

today =new Date();
sday= new Date(today.setMonth(today.getMonth()-3));

$('#datepick').datepicker({
    todayHighlight: true,
    startDate: sday,
    todayBtn: "linked",
    keyboardNavigation: false,
  });

	$('#datepick').datepicker('update', urlToDate());
	$('#datepick').datepicker('setEndDate', new Date());//because of odd bug

$('#datepick').datepicker().on('changeDate', function(){
 	date=$('#datepick').datepicker('getDate');
	window.location =  window.location.protocol+'//'+window.location.host +window.location.pathname+"?d="+date.getFullYear()+"-"+(date.getMonth()+1)+"-"+(date.getDate())
});

})

function parse(val) {
    var result = false;//"Not found",
    var tmp = [];
	window.location.search.substr(1).split("&").forEach(function(item) {
        tmp = item.split("=");
    	if (tmp[0] === val){
    	   result = decodeURIComponent(tmp[1]).replace(/\-/g,"/");
           console.log(result);
    	}
	});
    return result;
}

function urlToDate() {
	var dstring=parse('d');
	var date=new Date(dstring);
	if(dstring===false){
		date=new Date();
	}
	return date;
}
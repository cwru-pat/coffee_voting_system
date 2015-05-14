
$(document).ready(function() {
  
  var up = '<button type="button" class="btn btn-xs btn-success" aria-label="Left Align">';
  up += '<span class="glyphicon glyphicon-align-left glyphicon-thumbs-up" aria-hidden="true"></span>';
  up += '</button>';
  
  var down = '<button type="button" class="btn btn-xs btn-danger" aria-label="Left Align">';
  down += '<span class="glyphicon glyphicon-align-left glyphicon-thumbs-down" aria-hidden="true"></span>';
  down += '</button>';

  $("li.article").prepend(down).prepend(up);

});

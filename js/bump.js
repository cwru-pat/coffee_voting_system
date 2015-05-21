
function display_rate_json(span, json) {
  span.text("");

  if(json.hasOwnProperty("success")) {
    span.append(json.success);
  } else if(json.hasOwnProperty("error")) {
    span.append(json.error);
  } else {
    span.append("Unexpected error.");
  }

  if(json.hasOwnProperty("value")) {
    value = json.value;
    span.removeClass("bg-danger").removeClass("bg-success");
    if(value > 0) {
      span.append(" Rating: +" + json.value);
      span.addClass("bg-success");
    }
    if(value < 0) {
      span.append(" Rating: " + json.value);
      span.addClass("bg-danger");
    }
  }
}

$(document).ready(function() {

  $("bump-btn-broke").each(function(index) {//so it doesn't work yet
    var paperId = this.getAttribute('data-paperid');
    var bump = this.getAttribute('data-bump');

    $(this).on("click", function() {
      var ajaxData = {
        dataType: "json",
        method: "POST",
        url: "js/bump.php",
        data: { paperId: paperId, bump: bump }
      };
      console.log("Bumped ", ajaxData);
      $.ajax(ajaxData).done(function( json ) {
        console.log("Recieved from server: ", json);
        if(bump){
          $('#voted-title'+paperId).setClass()
        }
      }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( "Error submitting vote.", textStatus, errorThrown );
      });
    });

    $(this).children(".btn-downvote").on("click", function() {
      var ajaxData = {
        dataType: "json",
        method: "POST",
        url: "js/rate.php",
        data: { paperId: paperId, value: -1 }
      };
      console.log("Voting down; ", ajaxData);
      $.ajax(ajaxData).done(function( json ) {
        console.log("Recieved from server: ", json);
        display_rate_json($("#article-" + paperId + "-messages"), json);
        display_rate_json($("#article-voted-" + paperId + "-messages"), json);
      }).fail(function( jqXHR, textStatus, errorThrown ) {
        console.log( "Error submitting vote.", textStatus, errorThrown );
      });
    });
  });

});

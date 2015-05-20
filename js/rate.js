
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

  $("div.article-button-holder").each(function(index) {
    var paperId = this.getAttribute('data-paperId');

    $(this).children(".btn-upvote").on("click", function() {
      console.log("Voting up: " + paperId);
      $.ajax({
        dataType: "json",
        method: "POST",
        url: "js/rate.php",
        data: { paperId: paperId, value: 1 }
      }).done(function( json ) {
        console.log("Recieved from server: ", json);
        display_rate_json($("#article-" + paperId + "-messages"), json);
        display_rate_json($("#article-voted-" + paperId + "-messages"), json);
      });
    });

    $(this).children(".btn-downvote").on("click", function() {
      console.log("Voting down: " + paperId);
      $.ajax({
        dataType: "json",
        method: "POST",
        url: "js/rate.php",
        data: { paperId: paperId, value: -1 }
      }).done(function( json ) {
        console.log("Recieved from server: ", json);
        display_rate_json($("#article-" + paperId + "-messages"), json);
        display_rate_json($("#article-voted-" + paperId + "-messages"), json);
      });
    });
  });

});

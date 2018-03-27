
function displayRateJson(span, json) {
  span.text('');

  if (json.hasOwnProperty('success')) {
    span.append(json.success);
  } else if (json.hasOwnProperty('error')) {
    if (json.hasOwnProperty('login')) {
      $('#bumpModal').modal();
    }
    span.append(json.error);
    span.addClass('bg-danger');
  } else {
    span.append('Unexpected error.');
  }

  if (json.hasOwnProperty('value')) {
    value = json.value;
    span.removeClass('bg-danger').removeClass('bg-success');
    if (value > 0) {
      span.append(' Rating: +' + json.value);
      span.addClass('bg-success');
    }
    if (value < 0) {
      span.append(' Rating: ' + json.value);
      span.addClass('bg-danger');
    }
  }
}

function voteOnPaper(paperId, value) {
  var ajaxData = {
    dataType: 'json',
    method: 'POST',
    url: 'js/rate.php',
    data: {paperId: paperId, value: value}
  };
  console.log('Voting '+ value + '; ', ajaxData);
  $.ajax(ajaxData).done(function(json) {
    console.log('Recieved from server: ', json);
    displayRateJson($('span[data-paperid="'+ paperId +'"]'), json);
    displayRateJson($('#article-' + paperId + '-messages'), json);
    displayRateJson($('#article-voted-' + paperId + '-messages'), json);
  }).fail(function(jqXHR, textStatus, errorThrown) {
    console.log('Error submitting vote.', textStatus, errorThrown, jqXHR);
  });
}

$(document).ready(function() {

  $('div.article-button-holder').each(function(index) {
    var paperId = this.getAttribute('data-paperid');

    $(this).children('.btn-upvote').on('click', function(event) {
      event.preventDefault();
      voteOnPaper(paperId,1)
    });

    $(this).children('.btn-downvote').on('click', function(event) {
      event.preventDefault();
      voteOnPaper(paperId,-1)
    });
  });

});

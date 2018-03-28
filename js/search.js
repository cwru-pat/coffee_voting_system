
function formatSearchResults(xml) {
  let html = $.map($('entry', xml), function(val, i) {
    let importButtonText = '';
    let voteButtonText = '';
    if (isLoggedIn) {
      importButtonText =
          '<a href="#" id="search-result-import-' +
            i +
          '" type="button" class="btn btn-default">' +
          '<span class="glyphicon glyphicon-import"></span>' +
          ' Import ' +
          '</a>';
      voteButtonText =
          '<a href="#" id="search-result-vote-up-' +
            i +
          '" type="button" class="btn btn-default">' +
          '<span class="glyphicon glyphicon-thumbs-up"></span>' +
          '</a>' +
          '<a href="#" id="search-result-vote-down-' +
            i +
          '" type="button" class="btn btn-default">' +
          '<span class="glyphicon glyphicon-thumbs-down"></span>' +
          '</a>';
    }
    return '<li id="search-result-item-' + i + '">' +
      $('title', val).text() +
      '<div class="btn-group btn-group-xs" role="group">' +
        importButtonText +
        '<a href="' +
          $('id', val).text() +
          '" type="button" class="btn btn-default">' +
          '<span class="glyphicon glyphicon-share"></span>' +
          ' View on arXiv ' +
        '</a>' +
        voteButtonText +
      '</div>' +
      '<span id="search-result-vote-' + i +
        '" class="article-messages">' +
      '</span>' +
      '</li>';
  }).join('');

  function importFromSearch(val, i, vote) {
    const idPattern = /http\:\/\/arxiv\.org\/abs\//i;
    const arxivId = $('id', val).text().replace(idPattern, '');
    const arxivCategory = $('category', val).attr('term');
    const data = {
      'import-id': removeNewlines($('id', val).text()),
      'title': removeNewlines(
        $('title', val).text() +
        ' (arxiv:' + arxivId + ' [' + arxivCategory + '])'),
      'authors': removeNewlines($('author', val).text()), // could be improved
      'abstract': removeNewlines($('summary', val).text()),
      'section': removeNewlines(arxivCategory),
      'arxivId': arxivId,
    };
    console.log('Importing paper...', data);
    const ajaxData = {
      url: 'js/import.php',
      type: 'POST',
      dataType: 'json',
      data: data,
      success: function(json) {
        console.log(json);
        if (json.hasOwnProperty('errors') || !json.hasOwnProperty('postId')) {
          console.log(json.errors);
          $('#search-result-import-' + i)
            .html('<i class="fa fa-times-circle"></i> Import failed!');
        } else {
          $('#search-result-vote-' + i).attr('data-paperid', json.postId);
          $('#search-result-import-' + i).off();
          $('#search-result-import-' + i).on('click', function(e) {
            e.preventDefault();
            document.location.href = 'post?post-id=' + json.postId;
          });
          $('#search-result-import-' + i)
            .html('<i class="fa fa-check-circle"></i> View Paper.');
          $('#search-result-import-' + i).addClass('btn-success');
          if ((typeof vote == 'number') && vote) {
            voteOnPaper(json.postId, vote);
          }
        }
      },
      error: function(err) {
        $('#search-result-import-' + i)
          .html('<i class="fa fa-times-circle"></i> Import failed!');
        console.log(err);
      },
    };
    $.ajax(ajaxData);
  }

  if (!html) {
    html = '<li>No results found!</li>';
  }

  hideSearchSpinner();
  $('#arxiv_search_results')
    .html('<ul class="list-unstyled">' + html + '</ul>');

  $.map($('entry', xml), function(val, i) {
    $('#search-result-import-' + i).on('click', function(e) {
      e.preventDefault();
      importFromSearch(val, i);
    });
    $('#search-result-vote-up-' + i).on('click', function(e) {
      e.preventDefault();
      importFromSearch(val, i, 1);
    });
    $('#search-result-vote-down-' + i).on('click', function(e) {
      e.preventDefault();
      importFromSearch(val, i, -1);
    });
  });
}

function performSearch(value) {
  const order = $('#arxiv_search_order').val();
  $.ajax({
    url: 'https://export.arxiv.org/api/query',
    type: 'GET',
    dataType: 'xml',
    data: {
      'search_query': value,
      'sortBy': order,
      'start': 0,
      'max_results': 10,
    },
    success: function(xml) {
      formatSearchResults(xml);
    },
  });
}

function showSearchSpinner() {
  $('#arxiv_search_spinner')
    .html('<i class="fa fa-spinner fa-pulse"></i>');
}

function hideSearchSpinner() {
  $('#arxiv_search_spinner')
    .html('<i class="fa fa-check-circle-o"></i>');
}

$(document).ready(function() {
  $('#arxiv_search').typeWatch({
    callback: performSearch,
    wait: 250,
    captureLength: 0,
  });

  $('#arxiv_search').on('input', showSearchSpinner);

  $('#arxiv_search_order_relevance').on('click', function(e) {
    e.preventDefault();
    $('#arxiv_search_order').val('relevance');
    $('#arxiv_search_order_text').text('relevance');
    performSearch(
        $('#arxiv_search').val()
    );
  });

  $('#arxiv_search_order_lastUpdatedDate').on('click', function(e) {
    e.preventDefault();
    $('#arxiv_search_order').val('lastUpdatedDate');
    $('#arxiv_search_order_text').text('date');
    performSearch(
        $('#arxiv_search').val()
    );
  });

  $('#searchModal').on('shown.bs.modal', function() {
    $('#arxiv_search').focus();
  });
});

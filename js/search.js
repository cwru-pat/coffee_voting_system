
function format_search_results(xml) {
  var html = $.map( $("entry", xml), function(val, i) {
    return "<li>"
            + $("title", val).text()
            + " <div class='btn-group btn-group-xs' role='group'>"
            +   "<a href='post.php?import-id=" + $("id", val).text() + "' type='button' class='btn btn-default'>"
            +     "<span class='glyphicon glyphicon-import'></span>"
            +     " Import "
            +   "</a>"
            +   "<a href='" + $("id", val).text() + "' type='button' class='btn btn-default'>"
            +     "<span class='glyphicon glyphicon-share'></span>"
            +     " View on arXiv "
            +   "</a>"
            + "</div>"
            + "</li>";
  }).join("");
  if(!html) {
    html = "<li>No results found!</li>";
  }
  $("#arxiv_search_results").html("<ul>" + html + "</ul>");
}

function perform_search(value) {
  var order = $("#arxiv_search_order").val();
  $.ajax({
    url: 'https://export.arxiv.org/api/query',
    type: 'GET',
    dataType: 'xml',
    data: {
      search_query: value,
      sortBy: order,
      start: 0,
      max_results: 10
    },
    success: function(xml) {
      format_search_results(xml);
    },
  });
}

$(document).ready(function() {
  $("#arxiv_search").typeWatch({
      callback: perform_search,
      wait: 250,
      captureLength: 2
  });
  $("#arxiv_search_order").on("input", function(e) {
    perform_search(
      $('#arxiv_search').val()
    );
  });
  $('#searchModal').on('shown.bs.modal', function(e) {
    $('#arxiv_search').focus();
  })
});

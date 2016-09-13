$(document).ready(function() {
  $panelHash = window.location.hash.split('-')[1];
  $('.panel-heading.arxiv').each(function(key, value) {

    $(this).parent().children('.panel-body').attr('id', 'panel-body-' + key);
    $(this).parent().attr('id', 'panel-' + key);

    var panelHeadingText = $('.cookieTitle', value).text().trim();
    if (toggleGetCookie(panelHeadingText) == 'true' && $panelHash != key) {
      toggleState = '';
      $('#panel-body-' + key).slideToggle(0, 'swing');
    } else {
      toggleState = 'active';
    }

    $('#arxiv-toggle-list').append(
      '<a role="button" href="#panel-' +
      key + '"' +
      ' class="btn btn-default btn-info btn-lg ' +
      ' section-toggle-button ' +
      toggleState +
      '" id="toggle-item-' +
      key +
      '" data-toggle="button">' +
      $(this).children('h3').html().trim() +
      '</a>'
    );

    $('#toggle-item-' + key).on('click', function() {
      $('#panel-body-' + key).slideToggle(0, 'swing');
      if (!$(this).hasClass('active')) {
        window.location.hash = $(this).attr('href');
        history.pushState('', document.title,
            window.location.pathname + window.location.search);
      }
    });

    $(this).on('click', function() {
      $('#panel-body-' + key).slideToggle(0, 'swing');
      $('#toggle-item-' + key).toggleClass('active');
    });

    $(window).on('beforeunload', function() {
      var isActivePanel = $('#toggle-item-' + key).hasClass('active');
      toggleSetCookie(panelHeadingText, !isActivePanel, 100);
    });
  });

  if (toggleGetCookie('updated') == 'true') {
    toggleState = '';
    $('em#UPDATED').each(function() {
      $(this).parent().parent().slideToggle(0, 'swing');
    });
  } else {
    toggleState = 'active';
  }

  $('#arxiv-toggle-list').append(
      '<a role="button"' +
      ' class="btn btn-default btn-default btn-xs ' +
      toggleState +
      '" id="updated-showhide"' +
      ' data-toggle="button">' +
      '<span class="hidden-sm hidden-xs hidden-md">Show/hide</span>' +
      '<span class= "cookieTitle"> updated </span>' +
      '<span class="hidden-sm hidden-xs hidden-md">papers</span>' +
      '</a>'
    );

  $('#updated-showhide').on('click', function() {
    $('em#UPDATED').each(function() {
      $(this).parent().parent().slideToggle(0, 'swing');
      var isHidden = $('#updated-showhide').hasClass('active');
      toggleSetCookie('updated', isHidden, 100);
    });
  });

  $('.abstract-showhide').each(function() {
    $(this).on('click', function() {
      $('#article-' + $(this).attr('data-paperId') + '-abstract')
        .slideToggle(150, 'swing');
    });
  });

  $('.icn-btn').hover(function() {
    $(this).children().toggleClass('fa-spin');
  });

  $('.icn-btn').on('click', function() {
    $('.input-daterange').toggleClass('hidden');
    var isHidden = $('.input-daterange').hasClass('hidden');
    toggleSetCookie('votes_cal', isHidden, 100);
  });

  if (toggleGetCookie('votes_cal') == 'false') {
    $('.input-daterange').toggleClass('hidden');
  }
});

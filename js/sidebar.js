$(document).ready(function() {

  $('[data-clampedwidth]').each(function() {
    var elem = $(this);
    var parentPanel = elem.data('clampedwidth');
    var resizeFn = function () {
      var sideBarNavWidth = $(parentPanel).width() - parseInt(elem.css('paddingLeft')) - parseInt(elem.css('paddingRight')) - parseInt(elem.css('marginLeft')) - parseInt(elem.css('marginRight')) - parseInt(elem.css('borderLeftWidth')) - parseInt(elem.css('borderRightWidth'));
      elem.css('width', sideBarNavWidth);
    };

    resizeFn();
    $(window).resize(resizeFn);
  });
  var bodyheight=$("#leftCol").offset();
  $('#arxiv-toggle-list').affix({
    offset: {
      top: bodyheight.top-80
    }
  });

  var $body   = $(document.body);
  var navHeight = $('.navbar').outerHeight(true);

  $body.scrollspy({
    target: '#leftCol',
    offset: navHeight
  });

  $('.abstract-showhide').each(function(){
      $(this).on('mouseup',function(){
        var bodyheight=whynowork();
        bodyheight+=$("#leftCol").offset().top;
        $('#arxiv-toggle-list').affix({
          offset: {
            top: bodyheight-80
          }
        });
      });
    });
});

function whynowork(){
  abs_off=0;
  var pid
  $('.abstract-showhide.active').each(function(){
    pid=$(this).data('paperid');
    abs_off+=$('#article-' + pid + '-abstract').height();

  });
  return abs_off;
}

 /**/
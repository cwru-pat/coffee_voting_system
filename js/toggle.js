$(document).ready(function() {
  $(".panel-heading.arxiv").each(function(key, value) {

    $(this).parent().children(".panel-body").attr("id","panel-body-" + key);
    $(this).parent().attr("id","panel-" + key);

    if(toggle_getCookie($(value).children('h3').text().trim())=="true") {
      toggle_state="";
      $('#panel-body-'+key).slideToggle(0,"swing");
    } else {
      toggle_state="active";
    }

    $('#arxiv-toggle-list').append(
      '<a role="button" href="#panel-'
      + key +'"'
      + ' class="btn btn-default btn-info btn-lg '
      + ' section-toggle-button '
      + toggle_state
      +'" id="toggle-item-'
      + key 
      + '" data-toggle="button">'
      + $(this).children("h3").html().trim()
      + '</a>'
    );

    $('#toggle-item-'+key).on("click",function() {
      $("#panel-body-"+key).slideToggle(0,"swing");
      toggle_setCookie($(value).children('h3').text().trim(),$(this).hasClass('active'),100);
      if(!$(this).hasClass("active")) {
        window.location.hash = '';
        window.location.hash = $(this).attr("href");
      }
    });

    $(this).on("click",function() {
      $listitem=$('#toggle-item-'+key);
      $listitem.toggleClass('active');
      $("#panel-body-" + key).slideToggle(0,"linear");
      toggle_setCookie($(value).children('h3').text().trim(),!$listitem.hasClass('active'),100);
    });
  });

  $(".abstract-showhide").each(function() {
    $(this).on("click",function() {
      $("#article-" + $(this).attr("data-paperId") + "-abstract").slideToggle(150,"swing")
    });
  });

    window.location.hash="_";
});


function toggle_setCookie(c_name,value,exdays)
{
  var exdate=new Date();
  exdate.setDate(exdate.getDate() + exdays);
  var c_value=value + "; expires="+exdate.toUTCString();
  document.cookie=c_name + "=" + c_value;
}

function toggle_getCookie(c_name)
{
  var carr=document.cookie.split(";");
  var name=c_name+"="
  for (i=0;i<carr.length;i++)
  {
    c=carr[i];
    while(c.charAt(0)==' ')
      c=c.substring(1);
    if (c.indexOf(name)==0)
      return c.substring(name.length);
  }
}


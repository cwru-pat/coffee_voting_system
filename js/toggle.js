$(document).ready(function() {
	$(".panel-heading.arxiv").each(function(key, value) {

		$(this).parent().children(".panel-body").addClass("panel-body-" + key);

		if(toggle_getCookie($(value).text().trim())=="true") {
			$('#toggle-content ul').append('<li id="toggle-list-item"><label><input type="checkbox" checked="checked" class="toggle" id="toggle-checkbox-'+key+'"> '+ $(this).text().trim() + '</label></li>');
				//<label class="option" for="toggle-checkbox-'+key+'"> ' + $(this).text().trim() + '</label></li>');
		} else {
			$('#toggle-content ul').append('<li id="toggle-list-item"><label><input type="checkbox" class="toggle" id="toggle-checkbox-'+key+'"> ' + $(this).text().trim() + '</label></li>');
				//<label class="option" for="toggle-checkbox-'+key+'"> ' + $(this).text().trim() + '</label></li>');
			$('.panel-body-'+key).slideToggle(0,"swing");
		}

		$('#toggle-checkbox-'+key).on("click",function() {
			$(".panel-body-"+key).slideToggle(0);
			$checkbox=$('#toggle-checkbox-'+key);
			toggle_setCookie($(value).text().trim(),$checkbox.prop('checked'),100);
		});

		$(this).on("click",function() {
			$checkbox=$('#toggle-checkbox-'+key);
			$checkbox.prop('checked',!$checkbox.prop("checked"));
			$(".panel-body-" + key).slideToggle(0,"swing");
			toggle_setCookie($(value).text().trim(),$checkbox.prop('checked'),100);
		});
	});
	
	$("button.abstract-btn").each(function() {
		$(this).on("click",function() {
			$('.panel-body#'+ $(this).attr("id")).slideToggle(150,"swing");
		});
	});
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


$(document).ready(function() {
	$(".panel-heading").each(function(key, value) {
	
	$(this).parent().children(".panel-body").addClass("panel-body-" + key);

		if(0==1) {

		} else {
			$('#toggle-content ul').append('<li id="toggle-list-item"><input type="checkbox" id="toggle-checkbox-'+key+'"><label class="option" for="toggle-checkbox-'+key+'"> ' + $(this).text() + '</label></li>');
			$('.panel-body-'+key).slideToggle(0,"swing");
		}

		$('#toggle-checkbox-'+key).on("click",function() {
			$(".panel-body-"+key).slideToggle(0);
		 });
		$(this).on("click",function() {
			$checkbox=$('#toggle-checkbox-'+key)
			$checkbox.prop('checked',!$checkbox.prop("checked"));
			$(".panel-body-" + key).slideToggle(0,"swing");
		});
	});
});



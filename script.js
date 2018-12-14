jQuery(document).ready(function ($) {


	$('#categoriePost option').on('click', function () {

		var postData = {
			action: 'chooseCategoryPostAjax',
			data: $(this).attr('data-type')
		}

		$.ajax({
			type: "POST",
			data: postData,
//			dataType: "json",
			url: arpAjax.ajaxurl,
			success: function (response) {				
//				console.log(response);
				$('#arp_post').html(response);
			}
		});

	});
	
	$('#navPaginationAjax .number').live('click', function () {
		
		var postData = {
			action: 'paginationPostAjax',
			data: $(this).text()
		}
		
		$.ajax({
			type: "POST",
			data: postData,
//			dataType: "json",
			url: arpAjax.ajaxurl,
			success: function (postData) {				
				console.log(postData);
				
			}
		});
		

	});
	
	
});

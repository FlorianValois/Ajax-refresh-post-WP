jQuery(document).ready(function ($) {


	$('#categoriePost option').on('click', function () {

		var postData = {
			action: 'updatePostAjax',
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
	
});

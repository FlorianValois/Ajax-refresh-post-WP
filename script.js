jQuery(document).ready(function ($) {


	$('#categoriePost option').on('click', function () {

		$('#categoriePost option').removeClass('active');
		$(this).addClass('active');

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
				$('#arp_post').html(response);
			}
		});

	});

	$('#navPaginationAjax .number').live('click', function () {

		var categorySelected = $('#categoriePost').find('option.active').attr('data-type');
		var number = $(this).attr('data-page');
		
		$('#navPaginationAjax .number').removeClass('active');
		$(this).addClass('active');

		var json = {
			catSelect: categorySelected,
			number: number
		}

		var postData = {
			action: 'paginationPostAjax',
			data: json
		}

		$('#arp_post').html('<img src="/wp-content/plugins/ajax-refresh-post/img/loading.gif" alt />');
		
		$.ajax({
			type: "POST",
			data: postData,
			//			dataType: "json",
			url: arpAjax.ajaxurl,
			success: function (response) {


				$('#arp_post').html(response);
			}
		});


	});


});

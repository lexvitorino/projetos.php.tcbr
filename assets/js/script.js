function selectClient(obj) {
	var id = $(obj).attr("data-id");
	var name = $(obj).html();

	$('.searchresults-clients').hide();
	$('#search_clients').val(name);
	$('#search_clients').attr('data-id', id);
	$('#id_client').attr('value', id);
};

$(function(){

	$('#certificate_url').on('change', function(){
		$('#certificates-img').hide();
	});

	$('.tabitem').on('click', function() {
		
		$('.activetab').removeClass('activetab');
		$(this).addClass('activetab');

		var item = $('.activetab').index();
		$('.tabbody').hide();
		$('.tabbody').eq(item).show();

	});

	$('#search').on('focus', function(){
		$(this).animate({
			width:'300px'
		}, 'fast');
	});

	$('#search').on('blur', function(){
		if($(this).val() == '') {
			$(this).animate({
				width:'100px'
			}, 'fast');
		}

		setTimeout(function() {
			$('.searchresults').hide();
		}, 500);
	});

	$('#search').on('keyup', function(){
		
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if (datatype != '') {
			$.ajax({
				url: BASE_URL+'/ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json){
					if( $('.searchresults').length == 0) {
						$('#search').after('<div class="searchresults"></div>');
					}
					$('.searchresults').css('left', $('#search').offset().left+'px');
					$('.searchresults').css('top', $('#search').offset().top+$('#search').height()+3+'px');

					var html = '';
					for(var i in json) {
						html += '<div class="si"><a href="'+json[i].link+'">'+json[i].name+'</a></div>';
					}

					$('.searchresults').html(html);
					$('.searchresults').show();
				}
			});
		}
	});

	$('#search_clients').on('keyup', function(){
		
		var datatype = $(this).attr('data-type');
		var q = $(this).val();

		if (datatype != '') {
			$.ajax({
				url: BASE_URL+'/ajax/'+datatype,
				type:'GET',
				data:{q:q},
				dataType:'json',
				success:function(json){
					if( $('.searchresults-clients').length == 0) {
						$('#search_clients').after('<div class="searchresults-clients"></div>');
					}
					$('.searchresults-clients').css('left', $('#search_clients').offset().left+'px');
					$('.searchresults-clients').css('top', $('#search_clients').offset().top+$('#search_clients').height()+3+'px');

					var html = '';
					for(var i in json) {
						html += '<div class="si"><a href="javascript:;" onclick="selectClient(this)" data-id="'+json[i].id+'">'+json[i].name+'</a></div>';
					}

					$('.searchresults-clients').html(html);
					$('.searchresults-clients').show();
				}
			});
		}

	});

});
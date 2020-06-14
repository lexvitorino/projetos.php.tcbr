$('input[name=address_zipcode]').on('blur', function(){
	var cep = $(this).val();
	$.ajax({
		url:'http://api.postmon.com.br/v1/cep/'+cep,
		type:'GET',
		dataType:'json',
		success: function(json) {
			if(typeof json.cep != 'undefined') {
				$('input[name=address]').val(json.logradouro);
				$('input[name=address_neighb]').val(json.bairro);
				$('input[name=address_city]').val(json.cidade);
				$('input[name=saddress_state]').val(json.estado);
				$('input[name=address_country]').val('BRASIL');
			}
		}
	});
});
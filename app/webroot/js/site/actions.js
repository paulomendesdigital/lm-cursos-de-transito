$(document).ready(function(){
	$('.popup-flash-container').find('.button-close').on('click',function(){
        $(this).closest('.popup-flash-container').remove();
    });
});

function getModuleCourseCityOptionsTrigger(){

    function enableMatricula() {
        $(".btn-matricula").removeAttr("disabled");
    }
    function disableMatricula() {
        $(".btn-matricula").attr("disabled", "disabled");
    }


    $("[data-toggle='course-module-state']").on('change',function(){
		var select_state = $(this);
		var course_scope = $(select_state).closest('form').find('[data-toggle="course-scope"]').val();
		var promotion_div = $(select_state).closest('form').find('.promotion-price');		
		var course_id = $(select_state).closest('form').find("[data-toggle='course-id-input']").val();
		var button = $(select_state).closest('form').find(':submit');

		switch (course_scope){
			case course_scopes['Municipal'].toString():				
				var select_city = $(select_state).closest('form').find("[data-toggle='course-module-city']");
				if($(select_state).prop('selectedIndex') > 0){
					var state_id = $(select_state).val();					
					$.get('/courses/ajax_getModuleCourseOptions/'+course_id+'/'+state_id,function(data){
						if(data){
							$(select_city).html(data);
						}else{
							$(select_city).html('<option value="">Selecione o município</option>');
						}
					});					
				}else{	
					$(select_city).html('<option value="">Selecione o município</option>');	


					$.get('/courses/ajax_getModuleCourseTableDefault/'+course_id,function(data){
						if(data){
							$('.modules-container').html(data);
						}
					});	

					$(promotion_div).addClass('hidden');

				}
				break;
			case course_scopes['Estadual'].toString():
				if($(select_state).prop('selectedIndex') > 0){
					disableMatricula();

					$.get('/courses/ajax_getModuleCourseTable/'+course_id+'/' + $(select_state).val(),function(data){
						if(data){

							var tableData = $('<div>' + data + '</div>').find('.modules-table-container');
							var formData  = $('<div>' + data + '</div>').find('#additional-form');
							if (tableData.length) {
								$('.modules-container').html(tableData);
							}

							if (order_in_school) {
                                $(promotion_div).addClass('hidden');
								disableMatricula();
                                button.hide();
                                $('.only_school').removeClass('hidden');
                                $('#additional-form-container').html('');
                            } else {
                                button.show();
                                $('.only_school').addClass('hidden');
                                if (formData.length) {
                                    $('#additional-form-container').html(formData);
                                } else {
                                    $('#additional-form-container').html('');
                                }

                                $(promotion_div).find('[data-toggle="promotional-price"]').html('R$ ' + promotional_price);
                                $(promotion_div).find('[data-toggle="promotional-installment"]').html('R$ ' + installment_price);
                                $(promotion_div).removeClass('hidden');
                            }
						}else{
							$.get('/courses/ajax_getModuleCourseTableDefault/'+course_id,function(data){
								if(data){
									$('.modules-container').html(data);
								}
							});
							$(promotion_div).addClass('hidden');
						}

                    	enableMatricula();
					});

				}else{
                    disableMatricula();

                    $('#additional-form-container').html('');
                    button.html('MATRICULE-SE');

					$.get('/courses/ajax_getModuleCourseTableDefault/'+course_id,function(data){
						if(data){
							$('.modules-container').html(data);
						}

                        enableMatricula();
					});
					$(promotion_div).addClass('hidden');
				}
				break;
		}
		
	});

	$("[data-toggle='course-module-city']").on('change',function(){
		var select_city = $(this);
		var select_state = $(select_city).closest('form').find("[data-toggle='course-module-state']");
		var course_id = $(select_city).closest('form').find("[data-toggle='course-id-input']").val();
		var promotion_div = $(select_city).closest('form').find('.promotion-price');
		if($(select_city).prop('selectedIndex') > 0){			
			$.get('/courses/ajax_getModuleCourseTable/'+course_id+'/' + $(select_state).val() + '/' + $(select_city).val(),function(data){
				if(data){
					$('.modules-container').html(data);
					$(promotion_div).find('[data-toggle="promotional-price"]').html('R$ ' + promotional_price);
                    $(promotion_div).find('[data-toggle="promotional-installment"]').html('R$ ' + installment_price);
					$(promotion_div).removeClass('hidden');
				}else{
					$.get('/courses/ajax_getModuleCourseTableDefault/'+course_id,function(data){
						if(data){
							$('.modules-container').html(data);
						}
					});
					$(promotion_div).addClass('hidden');
				}
			});
		}else{
			$.get('/courses/ajax_getModuleCourseTableDefault/'+course_id,function(data){
				if(data){
					$('.modules-container').html(data);
				}
			});
			$(promotion_div).addClass('hidden');
		}
	});
}

function initCartUI(){
	$('[data-toggle="remove-cart"]').on('click',function(){
		var cart_id = $(this).data('id');
		if(confirm("Deseja excluir o produto?")){
			$('body').addClass('loading');
			$.post( "/carts/ajax_delete", { id: cart_id})
			.done(function( data ) {
				$('body').removeClass('loading');
				if(data){
					//location.reload();
					window.location = "/carts";
				}else{
					alert("Erro ao excluir produto! Por favor, tente novamente.")
				}
			});
		}
	});
}

//carregar cidades pelo estado (campo unico no form)
$('select[data-toggle="returnState"]').on('change',function () {
    var state_id = $(this).val();
    if( state_id ){
        $('select[data-toggle="returnCity"]').html("<option>carregando...</option>");
        $.get('/cities/ajax_getCityOptionsByStateId/'+state_id,function(cities){
            if( cities ){
                $('select[data-toggle="returnCity"]').html( cities );
            }
        });
    }
});

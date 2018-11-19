 $(document).ready(function(){
    //Find Address

    //if($.trim($('input[data-toggle="returnAddress"]').val()) == ""){$('input[data-toggle="returnAddress"]').attr('disabled','disabled');}
    //if($.trim($('input[data-toggle="returnNeighborhood"]').val()) == ""){$('input[data-toggle="returnNeighborhood"]').attr('disabled','disabled');}
    //if($.trim($('input[data-toggle="returnCity"]').val()) == ""){$('input[data-toggle="returnCity"]').attr('disabled','disabled');}
    //if($.trim($('input[data-toggle="returnState"]').val()) == ""){$('select[data-toggle="returnState"]').attr('disabled','disabled');}
    //if($.trim($('input[data-toggle="returnNumber"]').val()) == ""){$('input[data-toggle="returnNumber"]').attr('disabled','disabled');}
    //if($.trim($('input[data-toggle="returnComplement"]').val()) == ""){$('input[data-toggle="returnComplement"]').attr('disabled','disabled');}

     $('input[data-mask="zipcode"]').change(function(){
        // Se o campo CEP não estiver vazio
        if($.trim($(this).val()) != ""){

            $('input[data-toggle="returnAddress"]').val('Aguarde...');

            $.getJSON("/find_ceps/find_ceps/index/"+$(this).val())
            .done(function(data){
                $('input[data-toggle="returnAddress"]').val(data.logradouro);
                $('input[data-toggle="returnNeighborhood"]').val(data.bairro);
                $('input[data-toggle="returnCity"]').val(data.cidade);
                $('select[data-toggle="returnState"]').val(data.uf);
                $('input[data-toggle="returnNumber"]').val("");
                $('input[data-toggle="returnComplement"]').val("");
                
                if($('select[data-toggle="returnState"]').length > 0){                    
                    $('select[data-toggle="returnState"]').val(data.uf_id);
                }

                if($('select[data-toggle="returnCity"]').length > 0){                    
                    $('select[data-toggle="returnCity"]').html(data.cidades);
                    $('select[data-toggle="returnCity"]').val(data.cidade_id);
                    $('select[data-toggle="returnCity"]').removeAttr('disabled');
                }

                $('input[data-toggle="returnAddress"]').removeAttr('disabled');
                $('input[data-toggle="returnNeighborhood"]').removeAttr('disabled');
                $('input[data-toggle="returnCity"]').removeAttr('disabled');
                $('select[data-toggle="returnState"]').removeAttr('disabled');
                $('input[data-toggle="returnNumber"]').removeAttr('disabled');
                $('input[data-toggle="returnComplement"]').removeAttr('disabled');

                $('input[data-toggle="returnNumber"]').focus();
            })
            .fail(function(data){
                
                $('input[data-toggle="returnAddress"]').val('');
                $('input[data-toggle="returnNeighborhood"]').val('');
                $('input[data-toggle="returnCity"]').val('');
                $('select[data-toggle="returnState"]').val('');                
                $('input[data-toggle="returnNumber"]').val("");
                $('input[data-toggle="returnComplement"]').val("");

                if($('select[data-toggle="returnCity"]').length > 0){                    
                    $('select[data-toggle="returnCity"]').val('');
                    $('select[data-toggle="returnCity"]').removeAttr('disabled');
                }

                //$('input[data-toggle="returnAddress"]').removeAttr('disabled');
                //$('input[data-toggle="returnNeighborhood"]').removeAttr('disabled');
                //$('input[data-toggle="returnCity"]').removeAttr('disabled');
                //$('select[data-toggle="returnState"]').removeAttr('disabled');
                //$('input[data-toggle="returnNumber"]').removeAttr('disabled');
                //$('input[data-toggle="returnComplement"]').removeAttr('disabled'); 

                $('input[data-toggle="returnAddress"]').focus();
            });
        }
    });
    //-- Find Address
 });

 jQuery(function($){
        $('input[data-mask="zipcode"]').mask("00.000-000");
        $('input[data-mask="zipcode-withoutautocomplete"]').mask("00.000-000");
        $('input[data-mask="cpf"]').mask("000.000.000-00");
        //$('input[data-mask="quota"]').mask("99999.99999999");
        $('input[data-mask="phone"]').mask("(00) 0000-0000");
        $('input[data-mask="date"]').mask("00/00/0000");
        $('input[data-mask="hour"]').mask("00:00");
        $('input[data-mask="weight"]').mask("0.000");
        $('input[data-mask="price_cifrao"]').maskMoney({showSymbol:true, symbol:"R$ ", decimal:",", thousands:"."});
        $('input[data-mask="price"]').mask('#0.00', {
            reverse: true,                 
        onKeyPress: function(cep,event,currentField,options){   
            var input = $(currentField)[0];
            if($(currentField).val().length > 4 && $(currentField).val().substr(0, 1)==0){            
                $(currentField).val($(currentField).val().substr(1, $(currentField).val().length));
            }
            if($(currentField).val().substr(0, 1)=='.'){
               $(currentField).val("0" + $(currentField).val());
            }

            //if($(currentField).val().length == 2 && $(currentField).val().indexOf('.') <= -1){            
                //$(currentField).val("0." +$(currentField).val());
            //}

            //if($(currentField).val().length == 1 && $(currentField).val().indexOf('.') <= -1){                        
                //$(currentField).val('0.0'+$(currentField).val());                                    
            //}     
        },     
        }).on('focus',function(){
            if(!$(this).val()){
                $(this).val('0.00'); 
                $(this).putCursorAtEnd();
            }
        }).on('change',function(){
            if($(this).val() && $(this).val().indexOf('.') <= -1){
                $(this).val($(this).val()+'.00');            
            }
        });
        $('input[data-mask="value"]').maskMoney();
        $('input[data-mask="price_discount"]').maskMoney();        

        var cellphonemaskoptions = {
            onKeyPress: function(cep, e, field, options){
                var masks = ['(00) 0000-00009', '(00) 00000-0009'];
                mask = cep.length>10 ? masks[1] : masks[0];                

                field.mask(mask, options);
            }
        };

        var cellphonemaskbehavior = function (val) {
            return val.replace(/\D/g, '').length > 10 ? '(00) 00000-0009' : '(00) 0000-00009';
        }

        $('input[data-mask="cellphone"]').mask(cellphonemaskbehavior,cellphonemaskoptions);

        $('input[data-mask="number"]').keypress(function(event) {
            var tecla = (window.event) ? event.keyCode : event.which;
            if ((tecla > 47 && tecla < 58)) return true;
            else {
                if (tecla != 8) return false;
                else return true;
            }
        });  
        
     });
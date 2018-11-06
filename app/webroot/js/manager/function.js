/* Suporte aos recursos visuais front-end */

$(document).ready(function(){

	$('a[data-toggle="btnStatus"]').click(function(){
        var id = $(this).attr('data-id');
        $('input[data-toggle="afferStatus"]').val(id);
        $('a[data-toggle="btnStatus"]').removeClass('btn-danger');
        $('a[data-toggle="btnStatus"]').removeClass('btn-success');
        if(id==0){
           $(this).addClass('btn-danger');
        }else{
            $(this).addClass('btn-success');
        }
    });

    $('a[data-toggle="btnStar"]').click(function(){
	    var id = $(this).attr('data-id');
	    $('input[data-toggle="afferStar"]').val(id);
        $('a[data-toggle="btnStar"]').removeClass('btn-danger');
	    $('a[data-toggle="btnStar"]').removeClass('btn-success');
        if(id==0){
	       $(this).addClass('btn-danger');
        }else{
            $(this).addClass('btn-success');
        }
	});

    $('a[data-toggle="addModuleDisciplineSlider"]').click(function(){
        var i = $('input[data-toggle="countModuleDisciplineSlider"]').val();
        i++;
        var html = '<div data-toggle="slider'+i+'"><h6 class="heading-hr"><small class="display-block"><a onclick="toggleModuleDisciplineSlider('+i+')" class="btn btn-link btn-icon btn-xs" title="Visualizar slider '+i+'"><i class="icon-eye text-primary"></i></a> <a onclick="removeModuleDisciplineSlider('+i+')" class="btn btn-link btn-icon btn-xs" title="Remover slider '+i+'"><i class="icon-remove3 text-danger"></i></a>  Cadastro de slider '+i+'</small></h6>'+
        '   <div data-toggle="formSlider'+i+'">'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplineSlider'+i+'Name" class="col-sm-2 control-label text-right">Nome</label>'+
            '      <div class="col-sm-10"><input name="data[ModuleDisciplineSlider]['+i+'][name]" class="form-control" data-mask="name" maxlength="255" type="text" id="ModuleDisciplineSlider'+i+'Name"></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '       <label for="ModuleDisciplineSlider'+i+'Text" class="col-sm-2 control-label text-right">Texto</label>'+
            '      <div class="col-sm-10"><textarea name="data[ModuleDisciplineSlider]['+i+'][text]" rows="5" cols="5" placeholder="If you want to add any info, do it here." class="elastic form-control ckeditor" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 102px;"></textarea></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplineSlider'+i+'Audio" class="col-sm-2 control-label text-right">Audio</label>'+
            '      <div class="col-sm-10"><input type="file" name="data[ModuleDisciplineSlider]['+i+'][audio]" class="form-control" id="ModuleDisciplineSlider'+i+'Audio"></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplineSlider'+i+'Position" class="col-sm-2 control-label text-right">Posição</label>'+
            '      <div class="col-sm-10"><input name="data[ModuleDisciplineSlider]['+i+'][position]" class="form-control" data-mask="position" type="number" id="ModuleDisciplineSlider'+i+'Position" required="required" value="'+i+'"></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplineSlider'+i+'Status" class="col-sm-2 control-label text-right">Status</label>'+
            '      <div class="col-sm-10"><select name="data[ModuleDisciplineSlider]['+i+'][status]" class="form-control" id="ModuleDisciplineSlider'+i+'Status">'+
            '        <option value="0">Inativo</option>'+
            '        <option value="1" selected="selected">Ativo</option>'+
            '        </select></div>'+
            '   </div>'+
        '   </div>'+
        '   </div>';
        
        $('div[data-alert="ModuleDisciplineSlider"]').remove();
        $('div[data-toggle="sliders"]').append(html);
        CKEDITOR.replace('data[ModuleDisciplineSlider]['+i+'][text]');
        $('input[data-toggle="countModuleDisciplineSlider"]').val(i++);
    });

    $('a[data-toggle="addModuleDisciplinePlayer"]').click(function(){
        var i = $('input[data-toggle="countModuleDisciplinePlayer"]').val();
        i++;
        var html = '<div data-toggle="player'+i+'"><h6 class="heading-hr"><small class="display-block"><a onclick="toggleModuleDisciplinePlayer('+i+')" class="btn btn-link btn-icon btn-xs" title="Visualizar vídeo '+i+'"><i class="icon-eye text-primary"></i></a> <a onclick="removeModuleDisciplinePlayer('+i+')" class="btn btn-link btn-icon btn-xs" title="Remover vídeo '+i+'"><i class="icon-remove3 text-danger"></i></a>  Cadastro de vídeo '+i+'</small></h6>'+
        '   <div data-toggle="formPlayer'+i+'">'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplinePlayer'+i+'Name" class="col-sm-2 control-label text-right">Nome</label>'+
            '      <div class="col-sm-10"><input name="data[ModuleDisciplinePlayer]['+i+'][name]" class="form-control" data-mask="name" maxlength="255" type="text" id="ModuleDisciplinePlayer'+i+'Name"></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '       <label for="ModuleDisciplinePlayer'+i+'EmbedPlayer" class="col-sm-2 control-label text-right">Embed do vídeo</label>'+
            '      <div class="col-sm-10"><textarea name="data[ModuleDisciplinePlayer]['+i+'][embed_player]" class="form-control" data-mask="embed_player" rows="3" id="ModuleDisciplinePlayer'+i+'EmbedPlayer"></textarea></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplinePlayer'+i+'Position" class="col-sm-2 control-label text-right">Posição</label>'+
            '      <div class="col-sm-10"><input name="data[ModuleDisciplinePlayer]['+i+'][position]" class="form-control" data-mask="position" type="number" id="ModuleDisciplinePlayer'+i+'Position" required="required"></div>'+
            '   </div>'+
            '   <div class="form-group">'+
            '      <label for="ModuleDisciplinePlayer'+i+'Status" class="col-sm-2 control-label text-right">Status</label>'+
            '      <div class="col-sm-10"><select name="data[ModuleDisciplinePlayer]['+i+'][status]" class="form-control" id="ModuleDisciplinePlayer'+i+'Status">'+
            '        <option value="0">Inativo</option>'+
            '        <option value="1" selected="selected">Ativo</option>'+
            '        </select></div>'+
            '   </div>'+
        '   </div>'+
        '   </div>';
        
        $('div[data-alert="ModuleDisciplinePlayer"]').remove();
        $('div[data-toggle="players"]').append(html);
        $('input[data-toggle="countModuleDisciplinePlayer"]').val(i++);
    });

    $('a[data-toggle="addQuestionAlternativeOption"]').click(function(){
        var i = $('input[data-toggle="countQuestionAlternativeOption"]').val();
        i++;
        var html = '<div data-toggle="alternative'+i+'">'+
            '   <div data-toggle="formAlternative'+i+'">'+
            '      <div class="row">'+
            '         <div class="col-md-8">'+
            '            <a onclick="removeQuestionAlternativeOption('+i+')" class="btn btn-link btn-icon btn-xs pull-left" title="Remover resposta '+i+'"><i class="icon-remove3 text-danger"></i></a>'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                <textarea name="data[QuestionAlternativeOption]['+i+'][name]" class="form-control" required data-mask="name" rows="3" id="QuestionAlternativeOption'+i+'Name"></textarea>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-2">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                   <select name="data[QuestionAlternativeOption]['+i+'][correct]" class="form-control" id="QuestionAlternativeOption'+i+'Correct">'+
            '                      <option value="0">Não</option>'+
            '                      <option value="1">Sim</option>'+
            '                   </select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-2">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                   <select name="data[QuestionAlternativeOption]['+i+'][status]" class="form-control" id="QuestionAlternativeOption'+i+'Status">'+
            '                      <option value="0">Inativo</option>'+
            '                      <option value="1" selected="selected">Ativo</option>'+
            '                   </select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '      </div>'+
            '   </div>'+
            '</div>';
        
        $('div[data-alert="QuestionAlternativeOption"]').remove();
        $('div[data-toggle="alternatives"]').append(html);
        $('input[data-toggle="countQuestionAlternativeOption"]').val(i++);
    });

    $('a[data-toggle="addModuleCourse"]').click(function(){
        var i = $('input[data-toggle="countModuleCourse"]').val();
        i++;

        var scope = $('input[data-toggle="scope"]').val();

        var options_state = $('select[data-reference="state0"] option');
        var values_state = $.map(options_state ,function(option) {return '<option value="'+option.value+'">'+option.text+'</option>';});

        var options_module = $('select[data-reference="module0"] option');
        var values_module = $.map(options_module ,function(option) {return '<option value="'+option.value+'">'+option.text+'</option>';});

        var html = '';

        html += '<div data-toggle="module'+i+'">';

            html += '<div data-toggle="formModule'+i+'">';
                html += '<div class="row">';
                    html += '<div class="col-md-5">'+
                                '<a onclick="removeModuleCourse('+i+')" class="btn btn-link btn-icon btn-xs pull-left" title="Remover módulo '+i+'"><i class="icon-remove3 text-danger"></i></a> '+
                                '<div class="form-group">'+
                                    '<div class="col-sm-10">'+
                                        '<select name="data[ModuleCourse]['+i+'][module_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'ModuleId" required="required">'+values_module+'</select>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';

                    if( scope != 'nacional' ){
                        if( scope == 'estadual' || scope == 'municipal' ){
                            if( scope == 'municipal' ){
                                html += '<div class="col-md-2">'+
                                    '<div class="form-group">'+
                                        '<div class="col-sm-10">'+
                                            '<select name="data[ModuleCourse]['+i+'][state_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'StateId" onchange="stateChange(this, \'ModuleCourse\','+i+')">'+values_state+'</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                                html += '<div class="col-md-3">'+
                                            '<div class="form-group">'+
                                                '<div class="col-sm-10">'+
                                                    '<select name="data[ModuleCourse]['+i+'][citie_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'CitieId">'+
                                                        '<option value="">Selecione o estado</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>';
                            }else{
                                html += '<div class="col-md-2">'+
                                    '<div class="form-group">'+
                                        '<div class="col-sm-10">'+
                                            '<select name="data[ModuleCourse]['+i+'][state_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'StateId" onchange="stateChange(this, \'ModuleCourse\','+i+')">'+values_state+'</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                            }
                        }
                    }

                    html += '<div class="col-md-2">'+
                                '<div class="form-group">'+
                                    '<div class="col-sm-10"><input name="data[ModuleCourse]['+i+'][position]" class="form-control" data-mask="module_id" type="number" id="ModuleCourse'+i+'Position" required="required"></div>'+
                                '</div>'+
                            '</div>';
                html += '</div>';
            html += '</div>';

        html += '</div>';

        var html2 = '<div data-toggle="module'+i+'">'+
            '   <div data-toggle="formModule'+i+'">'+
            '      <div class="row">'+
            '         <div class="col-md-5">'+
            '            <a onclick="removeModuleCourse('+i+')" class="btn btn-link btn-icon btn-xs pull-left" title="Remover módulo '+i+'"><i class="icon-remove3 text-danger"></i></a> '+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                  <select name="data[ModuleCourse]['+i+'][module_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'ModuleId" required="required">'+values_module+'</select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-2">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                  <select name="data[ModuleCourse]['+i+'][state_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'StateId" onchange="stateChange(this, \'ModuleCourse\','+i+')">'+values_state+'</select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-3">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                  <select name="data[ModuleCourse]['+i+'][citie_id]" class="form-control" data-mask="module_id" id="ModuleCourse'+i+'CitieId">'+
            '                     <option value="">Selecione o estado</option>'+
            '                  </select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-2">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10"><input name="data[ModuleCourse]['+i+'][position]" class="form-control" data-mask="module_id" type="number" id="ModuleCourse'+i+'Position" required="required"></div>'+
            '            </div>'+
            '         </div>'+
            '      </div>'+
            '   </div>'+
            '</div>';
        
        $('div[data-toggle="modules"]').append(html);
        $('input[data-toggle="countModuleCourse"]').val(i++);
    });

    $('a[data-toggle="addBooksCourse"]').click(function(){
        var i = $('input[data-toggle="countBooksCourse"]').val();
        i++;

        var scope = $('input[data-toggle="scope"]').val();

        var options_state = $('select[data-reference="state0"] option');
        var values_state = $.map(options_state ,function(option) {return '<option value="'+option.value+'">'+option.text+'</option>';});

        var html = '';

        html += '<div data-content="book-'+i+'" class="row">';
            html += '<div class="col-md-1">'+
                        '<a onclick="removeModuleCourse('+i+')" class="btn btn-link btn-icon btn-xs pull-left"><i class="icon-remove3 text-danger"></i></a> '+
                    '</div>';

            if( scope != 'nacional' ){
                if( scope == 'estadual' || scope == 'municipal' ){
                    if( scope == 'municipal' ){
                        html += '<div class="col-md-4">'+
                            '<div class="form-group">'+
                                '<div class="col-sm-10">'+
                                    '<select name="data[CourseBook]['+i+'][state_id]" class="form-control" id="CourseBook'+i+'StateId" onchange="stateChange(this, \'CourseBook\','+i+')">'+values_state+'</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                        html += '<div class="col-md-5">'+
                                    '<div class="form-group">'+
                                        '<div class="col-sm-10">'+
                                            '<select name="data[CourseBook]['+i+'][citie_id]" class="form-control" id="CourseBook'+i+'CitieId">'+
                                                '<option value="">Selecione o estado</option>'+
                                            '</select>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>';
                    }else{
                        html += '<div class="col-md-4">'+
                            '<div class="form-group">'+
                                '<div class="col-sm-10">'+
                                    '<select name="data[CourseBook]['+i+'][state_id]" class="form-control" data-mask="module_id" id="CourseBook'+i+'StateId" onchange="stateChange(this, \'CourseBook\','+i+')">'+values_state+'</select>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                    }
                }
            }

        html += '</div>';
        
        $('div[data-content="booksStates"]').append(html);
        $('input[data-toggle="countBooksCourse"]').val(i++);
    });

    $('a[data-toggle="addOrderCourse"]').click(function(){
        var i = $('input[data-toggle="countOrderCourse"]').val();
        i++;

        var options_state = $('select[data-reference="state"] option');
        var values_state = $.map(options_state ,function(option) {return '<option value="'+option.value+'">'+option.text+'</option>';});

        var options_course = $('select[data-reference="course"] option');
        var values_course = $.map(options_course ,function(option) {return '<option value="'+option.value+'">'+option.text+'</option>';});

        var html = '<div data-toggle="course'+i+'">'+
            '   <div data-toggle="formCourse'+i+'">'+
            '      <div class="row">'+
            '         <div class="col-md-7">'+
            '            <a onclick="removeOrderCourse('+i+')" class="btn btn-link btn-icon btn-xs pull-left" title="Remover curso '+i+'"><i class="icon-remove3 text-danger"></i></a>'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                  <select name="data[OrderCourse]['+i+'][course_id]" class="form-control" data-reference="course" id="OrderCourse'+i+'CourseId" required="required">'+values_course+'</select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-2">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                  <select name="data[OrderCourse]['+i+'][state_id]" class="form-control" data-mask="module_id" data-reference="state" onchange="stateChange(this, \'OrderCourse\', '+i+')" id="OrderCourse'+i+'StateId" required="required">'+values_state+'</select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '         <div class="col-md-3">'+
            '            <div class="form-group">'+
            '               <div class="col-sm-10">'+
            '                  <select name="data[OrderCourse]['+i+'][citie_id]" class="form-control" data-mask="module_id" id="OrderCourse'+i+'CitieId" required="required">'+
            '                     <option value="">Selecione o estado</option>                     '+
            '                  </select>'+
            '               </div>'+
            '            </div>'+
            '         </div>'+
            '      </div>'+
            '   </div>'+
            '</div>';
        
        $('div[data-toggle="courses"]').append(html);
        $('input[data-toggle="countOrderCourse"]').val(i++);
    });

    //carregar endereco pelo cep
    $('input[data-mask="zipcode"]').change(function() {
        
        $('input[data-toggle="returnAddress"]').val("carregando...");

        // Se o campo CEP não estiver vazio
        if ( $.trim($(this).val()) != "") {

            $.getJSON("/find_ceps/find_ceps/index/"+$(this).val())
            .done(function(data){

                $('input[data-toggle="returnAddress"]').val(data.logradouro);
                $('input[data-toggle="returnNeighborhood"]').val(data.bairro);

                var uf = data.uf;

                if( uf ){
                    $.get('/states/ajax_getStateIdByUf/'+uf,function(state_id){
                        if( state_id ){
                            $('select[data-toggle="returnState"]').val( state_id ).change() ;
                            $.get('/cities/ajax_getCityOptionsByStateId/'+state_id,function(cities){
                                if( cities ){
                                    $('select[data-toggle="returnCity"]').html( cities );

                                    var city = data.cidade;
                                    $.get('/cities/ajax_getCityIdByName/'+city+'/'+state_id,function(city_id){
                                        if( city_id ){
                                            $('select[data-toggle="returnCity"]').val( city_id ).change();
                                        }
                                    });
                                }
                            });
                        }
                    });
                }

                $('input[data-toggle="returnNumber"]').val("");
                $('input[data-toggle="returnComplement"]').val("");
                $('input[data-toggle="returnNumber"]').focus();
            })
            .fail(function(data){
                console.log(data);
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

                $('input[data-toggle="returnAddress"]').removeAttr('disabled');
                $('input[data-toggle="returnNeighborhood"]').removeAttr('disabled');
                $('input[data-toggle="returnCity"]').removeAttr('disabled');
                $('select[data-toggle="returnState"]').removeAttr('disabled');
                $('input[data-toggle="returnNumber"]').removeAttr('disabled');
                $('input[data-toggle="returnComplement"]').removeAttr('disabled'); 

                $('input[data-toggle="returnAddress"]').focus();
            });

            /*$.getScript("//cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep=" + $(this).val(), function() {
                if (resultadoCEP["resultado"]) {
                    // troca o valor dos elementos
                    $('input[data-toggle="returnAddress"]').val(unescape(resultadoCEP["tipo_logradouro"]) + " " + unescape(resultadoCEP["logradouro"]));
                    $('input[data-toggle="returnNeighborhood"]').val(unescape(resultadoCEP["bairro"]));
                    
                    var uf = unescape(resultadoCEP["uf"]);

                    if( uf ){
                        $.get('/states/ajax_getStateIdByUf/'+uf,function(state_id){
                            if( state_id ){
                                $('select[data-toggle="returnState"]').val( state_id ).change() ;
                                $.get('/cities/ajax_getCityOptionsByStateId/'+state_id,function(cities){
                                    if( cities ){
                                        $('select[data-toggle="returnCity"]').html( cities );

                                        var city = unescape(resultadoCEP["cidade"]);
                                        $.get('/cities/ajax_getCityIdByName/'+city+'/'+state_id,function(city_id){
                                            if( city_id ){
                                                $('select[data-toggle="returnCity"]').val( city_id ).change();
                                            }
                                        });
                                    }
                                });
                            }
                        });
                    }

                    $('input[data-toggle="returnNumber"]').val("");
                    $('input[data-toggle="returnComplement"]').val("");
                    $('input[data-toggle="returnNumber"]').focus();
                }
            });*/
        }
    });

    //carregar cidades pelo estado usando referencia
    $('select[data-toggle="returnState"]').on('change',function () {
        var reference = $(this).attr('data-reference');
                    
        var state_id = $(this).val();
        if( state_id ){
            console.log(reference);
            $('select[data-toggle="returnCity"][data-reference="'+reference+'"]').html("<option>carregando...</option>");
            $.get('/cities/ajax_getCityOptionsByStateId/'+state_id,function(cities){
                if( cities ){
                    $('select[data-toggle="returnCity"][data-reference="'+reference+'"]').html( cities );
                }
            });
        }
    });

    //carregar cidades pelo estado (campo unico no form)
    $('select[data-toggle="returnOneState"]').on('change',function () {
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

    //carregar cidades pelo estado (pagina course_states)
    $('select[data-toggle="returnCourseState"]').on('change',function () {
        //$('select[data-toggle="returnCity"]').html("<option>carregando...</option>");
                    
        var state_id = $('select[data-toggle="returnCourseState"]').val();

        if( state_id ){
            $.get('/cities/ajax_getCitiesForCourseTypes/'+state_id,function(cities){
                if( cities ){
                    $('div[data-toggle="returnCourseCity"]').html( cities );
                }
            });
        }
    });

    //carregar cidades pelo estado (pagina modules/manager_compose)
    $('select[data-toggle="returnCourseStateCompose"]').on('change',function () {
        
        $('select[data-toggle="returnCourseCity"]').html("<option>carregando...</option>");
                    
        var state_id = $('select[data-toggle="returnCourseStateCompose"]').val();
        var course_id = $('#ModuleCourseCourseId').val();
        var module_id = $('#ModuleCourseModuleId').val();

        if( state_id ){
            $.get('/course_states/ajax_getCitiesForCompose/'+state_id+'/'+course_id+'/'+module_id,function(cities){
                if( cities ){
                    $('div[data-toggle="returnCourseCity"]').html( cities );
                }
            });
        }
    });

    //select all checkboxes
    $("#select_all").change(function(){  //"select all" change 
        $(".inputCheckbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
    });

    //".checkbox" change 
    $('.inputCheckbox').change(function(){ 
        //uncheck "select all", if one of the listed checkbox item is unchecked
        if(false == $(this).prop("checked")){ //if this item is unchecked
            $("#select_all").prop('checked', false); //change "select all" checked status to false
        }
        //check "select all" if all checkbox items are checked
        if ($('.inputCheckbox:checked').length == $('.inputCheckbox').length ){
            $("#select_all").prop('checked', true);
        }
    });

    if( $('input[data-mask="slug"]').length > 0 ){
        $( "input[data-mask='slug']" ).keypress(function(event) {
            $('.slug').val( mask_slug($(this).val()) );
        });
        $( "input[data-mask='slug']" ).keydown(function(event) {
            $('.slug').val( mask_slug($(this).val()) );
        });
    }

    //máscara de cpf
    if( $('input[data-mask="cpf"]').length > 0 ){
        $('input[data-mask="cpf"]').mask("999.999.999-99");
    }

    //máscara de telefone
    if( $('input[data-mask="phone"]').length > 0 ){
        $('input[data-mask="phone"]').mask("(99) 9999-9999");
    }

    //máscara de celular
    if( $('input[data-mask="cellphone"]').length > 0 ) {
        var cellphonemaskoptions = {
            onComplete: function(cep, e, field, options){
                var masks = ['(00) 0000-00009', '(00) 00000-0009'];
                var mask = cep.length>10 ? masks[1] : masks[0];                

                field.mask(mask, options);
            }
        };

        var cellphonemaskbehavior = function (val) {
            return val.replace(/\D/g, '').length > 10 ? '(00) 00000-0009' : '(00) 0000-00009';
        }

        $('input[data-mask="cellphone"]').mask(cellphonemaskbehavior,cellphonemaskoptions);
    }

    //máscara de cep
    if( $('input[data-mask="zipcode"]').length > 0 ){
        $('input[data-mask="zipcode"]').mask("99.999-999");
    }

    //máscara de data
    if( $('input[data-mask="date"]').length > 0 ){
        $('input[data-mask="date"]').mask("99/99/9999");
    }
    
    //máscara de hora
    if( $('input[data-mask="hour"]').length > 0 ){
        $('input[data-mask="hour"]').mask("99:99");
    }

    //máscara de preços
    if( $('input[data-mask="price"]').length > 0 ){
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
    }

    //máscara de número
    if( $('input[data-mask="number"]').length > 0 ){
        $('input[data-mask="number"]').keypress(function(event) {
            var tecla = (window.event) ? event.keyCode : event.which;
            if ((tecla > 47 && tecla < 58)) return true;
            else {
                if (tecla != 8) return false;
                else return true;
            }
       });
    }
    
    $('a[data-toggle="editPassword"]').click(function(){
        if( $('input[id="UserPassword"]').attr('disabled') == 'disabled' ){
            $('input[id="UserPassword"]').removeAttr('disabled');
            $('input[id="UserPassword"]').val('');
        }else{
            $('input[id="UserPassword"]').attr('disabled',true);
        }
    });
    
    $('a[data-toggle="edit0Password"]').click(function(){
        if( $('input[id="User0Password"]').attr('disabled') == 'disabled' ){
            $('input[id="User0Password"]').removeAttr('disabled');
            $('input[id="User0Password"]').val('');
        }else{
            $('input[id="User0Password"]').attr('disabled',true);
        }
    });
});

function removeModuleDisciplineSlider(id){
    if (confirm('Tem certeza que deseja remover o slider '+id+'?')) {
        $('div[data-toggle="slider'+id+'"]').remove();
        $('input[data-toggle="countModuleDisciplineSlider"]').val(id-1);
    }
}

function toggleModuleDisciplineSlider(id){
    $('div[data-toggle="formSlider'+id+'"]').slideToggle();
}

function removeModuleDisciplinePlayer(id){
    if (confirm('Tem certeza que deseja remover o vídeo '+id+'?')) {
        $('div[data-toggle="player'+id+'"]').remove();
        $('input[data-toggle="countModuleDisciplinePlayer"]').val(id-1);
    }
}

function toggleModuleDisciplinePlayer(id){
    $('div[data-toggle="formPlayer'+id+'"]').slideToggle();
}

function removeModuleCourse(id){
    if (confirm('Tem certeza que deseja remover o módulo '+id+'?')) {
        $('div[data-toggle="module'+id+'"]').remove();
        $('input[data-toggle="countModuleCourse"]').val(id-1);
    }
}

function removeQuestionAlternativeOption(id){
    if (confirm('Tem certeza que deseja remover a resposta '+id+'?')) {
        $('div[data-toggle="alternative'+id+'"]').remove();
        $('input[data-toggle="countQuestionAlternativeOption"]').val(id-1);
    }
}

function removeOrderCourse(id){
    if (confirm('Tem certeza que deseja remover o curso '+id+'?')) {
        $('div[data-toggle="course'+id+'"]').remove();
        $('input[data-toggle="countOrderCourse"]').val(id-1);
    }
}

function mask_slug(val, replaceBy) {
    replaceBy = replaceBy || '-';
    var mapaAcentosHex    = { // by @marioluan and @lelotnk
        a : /[\xE0-\xE6]/g,
        A : /[\xC0-\xC6]/g,
        e : /[\xE8-\xEB]/g, // if you're gonna echo this
        E : /[\xC8-\xCB]/g, // JS code through PHP, do
        i : /[\xEC-\xEF]/g, // not forget to escape these
        I : /[\xCC-\xCF]/g, // backslashes (\), by repeating
        o : /[\xF2-\xF6]/g, // them (\\)
        O : /[\xD2-\xD6]/g,
        u : /[\xF9-\xFC]/g,
        U : /[\xD9-\xDC]/g,
        c : /\xE7/g,
        C : /\xC7/g,
        n : /\xF1/g,
        N : /\xD1/g,
    };

    for ( var letra in mapaAcentosHex ) {
        var expressaoRegular = mapaAcentosHex[letra];
        val = val.replace( expressaoRegular, letra );
    }
    val = val.toLowerCase();
    val = val.replace(/[^a-z0-9\-]/g, " ");
    val = val.replace(/ {2,}/g, " ");
    val = val.trim();
    val = val.replace(/\s/g, replaceBy);
    return val;
}

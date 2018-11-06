/* Realizar chamadas em ajax para back-end */
var completer = null;

$(document).ready(function() {
    $(".auto-complete").autocomplete({
        source: generateUrl(),
        minLength: 2, //This is the min amount of chars before auto complete kicks in
        autoFocus: true,
        type: 'json',
        select: function (event, ui) {
            $('#' + parent.completer.attr('data-id-map')).val(ui.item.id)
        }
    });

    $(".auto-select2").select2({
        minimumInputLength: 2,
		ajax: {
        	url: function() { return $(this).attr('data-url');},
			data: function(term, page) {
        		return 'term=' + term + '&page=' + page;
			},
			results: function(data, page, query) {
        		return data;
			},
			dataType: 'json',
            quietMillis: 200,
			cache: true
		},
		initSelection: function(element, callback) {
        	var data = {id: '', text: ''};
        	if ($(element).attr('data-initial')) {
        		data = JSON.parse($(element).attr('data-initial'));
			} else if ($(element).attr('data-initial-id') && $(element).attr('data-initial-text')) {
        		data = {id: $(element).attr('data-initial-id'), text: $(element).attr('data-initial-text')}
			} else if ($(element).attr('placeholder')) {
                data = {id: '', text: $(element).attr('placeholder')};
			}
			callback(data);
		},
        formatInputTooShort: 'Digite 2 ou mais caracteres.',
		formatSearching: 'Pesquisando...',
		formatNoMatches: 'Nenhum registro encontrado.'
	});
});

var generateUrl = function() {
    return function (request, response) {
        parent.completer = $(this.element);

        var url = parent.completer.attr('data-url') + '/term:%s',
            param_field = parent.completer.attr('data-param');

        url = url.replace('%s', encodeURIComponent(request.term));

        if (param_field !== undefined) {
            url += '/' + param_field + ':' + $('#' + param_field).val();
        }

        return $.get(url, response, 'json');
    };
};

function stateChange(select, model, id){

    var inputCity   = id != null ? $('select[name="data['+model+']['+id+'][citie_id]"]') : $('select[name="data['+model+'][citie_id]"]');
    var currentCity = inputCity.length ? inputCity.val() : '';

    if (select.value != '') {
        $.ajax({
            url: "/states/cities/" + select.value,
            beforeSend: function () {
                inputCity.find('option').remove();
                inputCity.append('<option value="">Carregando...</option>');
            },
            success: function (data) {
                inputCity.find('option').remove();
                inputCity.append(data);
                if (inputCity.find("option[value='" + currentCity + "']").length) {
                    inputCity.val(currentCity).change();
                }
            }
        });
    } else {
        inputCity.find('option').remove();
        inputCity.append('<option value="">Selecione</option>');
	}
}

function courseReportChange(select){

    var course_id = select.value;

    setScopeInReport(course_id);

    $.ajax({
        url: "/manager/courses/ajaxGetStatesOfCourse/"+course_id,
        beforeSend: function(){
            $('#ReportStateId').find('option').remove();
            $('#ReportStateId').append('<option value="">Carregando...</option>');

            $('#ReportCitieId').find('option').remove();
            $('#ReportCitieId').append('<option value="">Selecione</option>');
        },
        success: function(data){

            $('#ReportStateId').find('option').remove();
            $('#ReportStateId').append(data);
        }
    });
}

function stateReportChange(select){

    var course_id = $('#ReportCourseId').val();
    var state_id = select.value;

    $.ajax({
        url: "/course_states/ajax_getCitiesForReport/"+course_id+'/'+state_id,
        beforeSend: function(){
            $('#ReportCitieId').find('option').remove();
            $('#ReportCitieId').append('<option value="">Carregando...</option>');
        },
        success: function(data){

            $('#ReportCitieId').find('option').remove();
            $('#ReportCitieId').append(data);
            $('#ReportCitieId').val(6861);
            $('#ReportCitieId').change();
        }
    });
}

function setScopeInReport(course_id){
    $.ajax({
        url: "/manager/courses/ajaxGetScopeOfCourse/"+course_id,
        beforeSend: function(){
        },
        success: function(data){
            $('#ReportScope').val(data);
        }
    });
}

function courseChange(select, model, id){

	var inputState   = id != null ? $('select[name="data['+model+']['+id+'][state_id]"]') : $('select[name="data['+model+'][state_id]"]');
	var currentState = inputState.length ? inputState.val() : '';

    getScope( select.value );

	$.ajax({
	    url: "/manager/courses/ajaxGetStatesOfCourse/"+select.value,
	    beforeSend: function(){
			inputState.find('option').remove();
			inputState.append('<option value="">Carregando...</option>');
	    },
	    success: function(data){
			inputState.find('option').remove();
			inputState.append(data);
			if (inputState.find("option[value='" + currentState + "']").length) {
				inputState.val(currentState);
			}
			inputState.change();
	    }
	}); 
}

function getScope(course_id){
	$.ajax({
	    url: "/manager/courses/ajaxGetScopeOfCourse/"+course_id,
	    beforeSend: function(){
	    },
	    success: function(data){
	    	processScope(data);
	    }
	});
}

function processScope(scope) {
    if ( scope == 'estadual' ) {
        $('.state').show();
        $('.city').hide();
        $('select[data-reference="state"]').attr('required',true);
        $('select[data-reference="city"]').attr('required',false).val('');
    } else if( scope == 'municipal' ) {
        $('.state').show();
        $('.city').show();
        $('select[data-reference="state"]').attr('required',true);
        $('select[data-reference="city"]').attr('required',true);
    } else {
        $('.state').hide();
        $('.city').hide();
        $('select[data-reference="state"]').attr('required',false).val('');
        $('select[data-reference="city"]').attr('required',false).val('');
    }
}

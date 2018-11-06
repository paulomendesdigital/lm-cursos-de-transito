<?php /**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CitiesCourse Element View
 *
*/ ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title">Marque as Cidades Liberadas</h6>
	</div>
	<div class="panel-body" style="height: 500px; overflow-y: scroll;">
		<div class="row">
			<div class="col-md-5">
				<?php echo $this->Form->input('CourseCity.todas',array('type'=>'checkbox','id'=>'select_all','label'=>'Selecionar Todas'));?>
			</div>
			<div class="col-md-5">
				<?php echo $this->Form->input('CourseCity.price',array('data-mask'=>'price','label'=>false,'after'=>'<a href="javascript:void(0);" onclick="setPrice_all()"> Setar Preço Padrão para Todas</a>'));?>
			</div>
		</div>
		<?php $i=0; foreach($cities as $city):?>
			<div class="col-md-6 well">
				<div class="row">
					<div class="col-md-4">
						<input type="checkbox" name="data[CourseCity][<?php echo $i;?>][city_id]" id="select_all" value="<?php echo $city['City']['id'];?>" class="inputCheckbox" /> <?php echo $city['City']['name'];?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->input("CourseCity.{$i}.price",array('data-mask'=>'price','label'=>false, 'placeholder'=>'Preço por cidade', 'class'=>'form-control priceAll','div'=>false));?>
					</div>
					<div class="col-md-3">
						<?php $this->request->data['CourseCity'][$i]['status'] = isset($this->request->data['CourseCity'][$i]['status']) ? $this->request->data['CourseCity'][$i]['status'] : 1;?>
						<a class='btn <?php echo isset($this->request->data['CourseCity'][$i]['status']) ? $this->request->data['CourseCity'][$i]['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-status="inativo" data-item='<?php echo $i;?>' id='inativo-<?php echo $i;?>' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input("CourseCity.{$i}.status", array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['CourseCity'][$i]['status']) ? $this->request->data['CourseCity'][$i]['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-status="ativo" data-item='<?php echo $i;?>' id='ativo-<?php echo $i;?>' data-id='1' data-toggle='btnStatus'>Ativo</a>
					</div>
				</div>
			</div>
		<?php $i++; endforeach;?>
	</div>
</div>
<script>
	$(document).ready(function(){
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

        $('a[data-toggle="btnStatus"]').click(function(){
        	
        	var data_id = $(this).attr('data-id');
        	var id = $(this).attr('id');
        	var status = $(this).attr('data-status');
        	var item = $(this).attr('data-item');

        	$('input[name="data[CourseCity]['+item+'][status]"]').val(data_id);

	        //alert(data_id);
	        if( status == 'inativo' ){
	        	alert(item);
	        	$('#ativo-'+item).removeClass('btn-success');
	           $(this).addClass('btn-danger');
	        }else{
	        	alert(item);
	        	$('#inativo-'+item).removeClass('btn-danger');
	            $('#ativo-'+item).addClass('btn-success');
	        }
	    });
    });
    function setPrice_all(){
    	$('.priceAll').prop('value', $('#CourseCityPrice').val());
    }
</script>
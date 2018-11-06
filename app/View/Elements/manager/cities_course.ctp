<?php /**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CitiesCourse Element View
 *
*/ 
$tab = !isset($tab) ? '0' : $tab;
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title">
			<?php echo !isset($edit) ? 'Marque as Cidades a serem Liberadas' : 'Cidade Liberadas';?>
		</h6>
	</div>
	<div class="panel-body" style="height: 500px; overflow-y: scroll;">
		<div class="row">
			<?php if( !isset($edit) ):?>
			<div class="col-md-5 col-xs-12">
				<?php echo $this->Form->input('CourseCity.todas',array('type'=>'checkbox','id'=>"select_all-{$tab}",'label'=>'Selecionar Todas'));?>
			</div>
		<?php endif;?>
			<div class="col-md-5 col-xs-12">
				<?php echo $this->Form->input('CourseCity.price',array('class'=>'form-control','data-mask'=>'price','label'=>false,'after'=>'<a href="javascript:void(0);" onclick="setPrice_all()"> Setar Preço Padrão para Todas</a>'));?>
			</div>
		</div>
		<?php if( isset($cities) ): $i=0; $disabled = ''; foreach($cities as $city):?>
			<div class="col-md-6 well">
				<div class="row">
					<div class="col-md-4 col-xs-12">
						<?php if( isset($this->request->data['CourseCity'][$i]['id']) and !empty($this->request->data['CourseCity'][$i]['id']) ):?>
							<?php echo $this->Form->input("CourseCity.{$i}.id",array('type'=>'hidden','value'=>$this->request->data['CourseCity'][$i]['id']));?>
						<?php endif;?>
						<?php if( isset($this->request->data['CourseCity'][$i]['course_state_id']) and !empty($this->request->data['CourseCity'][$i]['course_state_id']) ):?>
							<?php echo $this->Form->input("CourseCity.{$i}.course_state_id",array('type'=>'hidden','value'=>$this->request->data['CourseCity'][$i]['course_state_id']));?>
						<?php endif;?>
						<?php if( isset($this->request->data['CourseCity'][$i]['city_id']) and $this->request->data['CourseCity'][$i]['city_id'] == $city['City']['id'] ):?>
							<div class="block-inner">
								<label class="checkbox-inline checkbox-success">
									<div class="checker">
										<span class="checked">
											<input type="checkbox" disabled=true checked="checked" name="" value="" class="styled" />
											<input type="hidden" name="data[CourseCity][<?php echo $i;?>][city_id]" value="<?php echo $city['City']['id'];?>" /> 
										</span>
									</div>
									<?php echo $city['City']['name'];?>
								</label>
							</div>
						<?php else: ?>
							<input type="checkbox" name="data[CourseCity][<?php echo $i;?>][city_id]" value="<?php echo $city['City']['id'];?>" class="inputCheckbox-<?php echo $tab;?>" /> <?php echo $city['City']['name'];?>
						<?php endif;?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->input("CourseCity.{$i}.price",array('data-mask'=>'price','label'=>false, 'placeholder'=>'Preço por cidade', 'class'=>'form-control priceAll','div'=>false));?>
					</div>
					<div class="col-md-3">
						<?php $this->request->data['CourseCity'][$i]['status'] = isset($this->request->data['CourseCity'][$i]['status']) ? $this->request->data['CourseCity'][$i]['status'] : 1;?>
						<a class='btn <?php echo isset($this->request->data['CourseCity'][$i]['status']) ? $this->request->data['CourseCity'][$i]['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-status="inativo" data-item='<?php echo $i;?>' id='inativo-<?php echo $tab;?>-<?php echo $i;?>' data-id='0' data-toggle='btn_Status'>Inativo</a>
                        <?php echo $this->Form->input("CourseCity.{$i}.status", array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['CourseCity'][$i]['status']) ? $this->request->data['CourseCity'][$i]['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-status="ativo" data-item='<?php echo $i;?>' id='ativo-<?php echo $tab;?>-<?php echo $i;?>' data-id='1' data-toggle='btn_Status'>Ativo</a>
					</div>
				</div>
			</div>
		<?php $i++; endforeach; endif;?>

		<!-- NOVAS ABAS, CASO EXISTA -->
		<?php if( isset($nCities) ): $i=0; $disabled = ''; foreach($nCities as $city):?>
			<div class="col-md-6 well">
				<div class="row">
					<div class="col-md-4 col-xs-12">
						<?php echo $this->Form->input("CourseCity.{$i}.course_state_id",array('type'=>'hidden','value'=>$course_type_id));?>
						<input type="checkbox" name="data[CourseCity][<?php echo $i;?>][city_id]" value="<?php echo $city['City']['id'];?>" class="inputCheckbox-<?php echo $tab;?>" /> <?php echo $city['City']['name'];?>
					</div>
					<div class="col-md-3">
						<?php echo $this->Form->input("CourseCity.{$i}.price",array('data-mask'=>'price','label'=>false, 'placeholder'=>'Preço por cidade', 'class'=>'form-control priceAll','div'=>false));?>
					</div>
					<div class="col-md-3">
						<?php $status = 1;?>
						<a class='btn <?php echo isset($status) ? $status == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-status="inativo" data-item='<?php echo $i;?>' id='inativo-<?php echo $tab;?>-<?php echo $i;?>' data-id='0' data-toggle='btn_Status'>Inativo</a>
                        <?php echo $this->Form->input("CourseCity.{$i}.status", array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($status) ? $status == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-status="ativo" data-item='<?php echo $i;?>' id='ativo-<?php echo $tab;?>-<?php echo $i;?>' data-id='1' data-toggle='btn_Status'>Ativo</a>
					</div>
				</div>
			</div>
		<?php $i++; endforeach; endif;?>
	</div>
</div>
<script>
	$(document).ready(function(){
		var nTab = '<?php echo $tab;?>';
		//select all checkboxes
	    $("#select_all-"+nTab).change(function(){  //"select all" change 
	        $(".inputCheckbox-"+nTab).prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
	    });

	    //".checkbox" change 
	    $('.inputCheckbox-'+nTab).change(function(){ 
	        //uncheck "select all", if one of the listed checkbox item is unchecked
	        if(false == $(this).prop("checked")){ //if this item is unchecked
	            $("#select_all-"+nTab).prop('checked', false); //change "select all" checked status to false
	        }
	        //check "select all" if all checkbox items are checked
	        if ($('.inputCheckbox-'+nTab+':checked').length == $('.inputCheckbox-'+nTab).length ){
	            $("#select_all-"+nTab).prop('checked', true);
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

        $('a[data-toggle="btn_Status"]').click(function(){
        	
        	var data_id = $(this).attr('data-id');
        	var id = $(this).attr('id');
        	var status = $(this).attr('data-status');
        	var item = $(this).attr('data-item');

        	$('input[name="data[CourseCity]['+item+'][status]"]').val(data_id);

	        if( status == 'inativo' ){
	        	$('#ativo-'+nTab+'-'+item).removeClass('btn-success');
	           $(this).addClass('btn-danger');
	        }else{
	        	$('#inativo-'+nTab+'-'+item).removeClass('btn-danger');
	            $('#ativo-'+nTab+'-'+item).addClass('btn-success');
	        }
	    });
    });
    function setPrice_all(){
    	$('.priceAll').prop('value', $('#CourseCityPrice').val());
    }
</script>
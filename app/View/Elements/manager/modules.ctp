<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Compose View
 *
*/ ?>

<?php if( !empty($modules) ):?>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->input('todas',array('type'=>'checkbox','id'=>"select_all-0",'label'=>'Selecionar Todos'));?>
		</div>
	</div>
	<?php $i=0; foreach ($modules as $key=>$value): ?>

		<div class="col-md-12">

			<input class="inputCheckbox-0" type="checkbox" name="data[Modules][<?php echo $i;?>][id]" value="<?php echo $key;?>" /> <?php echo $value;?>
			
		</div>

	<?php $i++; endforeach;?>
<?php endif;?>
<script>
	$(document).ready(function(){
		var nTab = '0';
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
	});
</script>
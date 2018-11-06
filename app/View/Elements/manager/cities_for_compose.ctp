<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Compose View
 *
*/ ?>

<?php if( !empty($courseState['CourseCity']) ):?>
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Form->input('todas',array('type'=>'checkbox','id'=>"select_all-0",'label'=>'Selecionar Todas'));?>
		</div>
	</div>
	<?php $i=0; foreach ($courseState['CourseCity'] as $city): ?>

		<div class="col-md-2">
			<?php if( in_array($city['City']['id'], $module_courses) ):?>
				<input class="inputCheckbox-0" type="checkbox" checked="checked" name="data[ModuleCourse][<?php echo $i;?>][citie_id]" value="<?php echo $city['City']['id'];?>" /> <?php echo $city['City']['name'];?>
			<?php else:?>
				<input class="inputCheckbox-0" type="checkbox" name="data[ModuleCourse][<?php echo $i;?>][citie_id]" value="<?php echo $city['City']['id'];?>" /> <?php echo $city['City']['name'];?>
			<?php endif;?>
			<?php 
			echo $this->Form->hidden("ModuleCourse.{$i}.course_id",array('value'=>$course_id));
			echo $this->Form->hidden("ModuleCourse.{$i}.state_id",array('value'=>$state_id));
			echo $this->Form->hidden("ModuleCourse.{$i}.module_id",array('value'=>$module_id));
			?>
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
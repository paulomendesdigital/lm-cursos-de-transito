<option value="">Selecione</option>
<?php foreach($courseState['CourseCity'] as $city):?>
	<option value="<?php echo $city['City']['id'];?>"><?php echo $city['City']['name'];?></option>
<?php endforeach;?>
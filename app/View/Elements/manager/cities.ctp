<option value="">Selecione</option>
<?php foreach($state['City'] as $city):?>
	<option value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
<?php endforeach;?>
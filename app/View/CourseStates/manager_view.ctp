<?php /**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseState View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Visualização do resultado</small></h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$courseState['CourseType']['id']);?>
        <?php echo $this->Html->addCrumb('Visualizar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="panel">
	<h3>Visualização dos dados</h3>

	<ul class="list-group">
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('id'); ?></strong></div> 
				<div class='col-md-10'><?php echo $courseState['CourseState']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Tipo de Curso'); ?></strong></div> 
				<div class='col-md-10'><?php echo $courseState['CourseType']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Estado'); ?></strong></div> 
				<div class='col-md-10'><?php echo $courseState['State']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Preço po Estado'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatPrice($courseState['CourseState']['price'], 'cifrao'); ?></div>
			</div>
		</li>

		<?php if(  $courseState['CourseState']['course_city_count'] > 0 ): ?>
			<li class='list-group-item'>
				<div class='row'>
					<div class='col-md-2 text-right'><strong><?php echo __('Nº de Cidades'); ?></strong></div> 
					<div class='col-md-10'><?php echo $courseState['CourseState']['course_city_count']; ?> <small> cidades liberadas</small></div>
				</div>
			</li>
		<?php endif; ?>

		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($courseState['CourseState']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($courseState['CourseState']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($courseState['CourseState']['modified']); ?></div>
			</div>
		</li>

		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Vendido apenas nas Auto-Escolas'); ?></strong></div> 
				<div class='col-md-10'><?php echo $courseState['CourseState']['order_in_school'] > 0 ? 'Sim' : 'Não'; ?></div> 
			</div>
		</li>

		<?php if(  $courseState['CourseType']['id'] == CourseType::RECICLAGEM ): ?>
			<li class='list-group-item'>
				<div class='row'>
					<div class='col-md-12 text-center'><strong>"Este é um curso de reciclagem e não possui divisão por cidades!"</strong></div> 
				</div>
			</li>
		<?php endif; ?>
	</ul>
</div>

<?php if ( !empty($courseState['CourseCity']) ): ?>
	<div class="panel">
		<h3><?php echo __('Cidades Liberadas'); ?></h3>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Preço por Cidade'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($courseState['CourseCity'] as $courseCity): ?>
					<tr>
						<td><?php echo h($courseCity['id']); ?></td>
						<td><?php echo $this->Utility->__LimitText($courseCity['City']['name']); ?></td>
						<td><?php echo $this->Utility->__FormatPrice($courseCity['price'], 'cifrao'); ?></td>
						<td><?php echo $this->Utility->__FormatStatus($courseCity['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($courseCity['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($courseCity['modified']); ?></td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	</div>
<?php endif; ?>

<?php if ( !empty($schools) ): ?>
	<div class="panel">
		<h3><?php echo __('Auto Escolas que vendem este curso'); ?></h3>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Telefone'); ?></th>
					<th><?php echo __('Endereço'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($schools as $school): ?>
					<tr>
						<td><?php echo h($school['School']['id']); ?></td>
						<td><?php echo h($school['School']['name']); ?></td>
						<td><?php echo h($school['School']['phone']); ?></td>
						<td><?php echo h($school['School']['full_address']); ?></td>
						<td><?php echo $this->Utility->__FormatStatus($school['School']['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($school['School']['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($school['School']['modified']); ?></td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	</div>
<?php endif; ?>
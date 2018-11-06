<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Module View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>
        <?php echo __($this->params['controller']);?> 
        <small>Visualização do resultado</small>
        </h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$moduleDiscipline['Module']['id']);?>
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
				<div class='col-md-10'><?php echo $moduleDiscipline['ModuleDiscipline']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Module'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Html->link($moduleDiscipline['Module']['name'], array('controller' => 'modules', 'action' => 'view', $moduleDiscipline['Module']['id'])); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
				<div class='col-md-10'><?php echo $moduleDiscipline['ModuleDiscipline']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('position'); ?></strong></div> 
				<div class='col-md-10'><?php echo $moduleDiscipline['ModuleDiscipline']['position']; ?></div>
			</div>
		</li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('discipline_code_id'); ?></strong></div>
                <div class='col-md-10'><?php echo isset($moduleDiscipline['DisciplineCode']) ? $moduleDiscipline['DisciplineCode']['code_name'] : ''; ?></div>
            </div>
        </li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($moduleDiscipline['ModuleDiscipline']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($moduleDiscipline['ModuleDiscipline']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($moduleDiscipline['ModuleDiscipline']['modified']); ?></div>
			</div>
		</li>
	</ul>
</div>

<!-- SLIDERS RELACIONADOS À DISCIPLINA / UNIDADE -->

<div class="panel">
	<h3><?php echo __('Related Module Discipline Sliders'); ?></h3>
	<?php if (!empty($moduleDiscipline['ModuleDisciplineSlider'])): ?>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($moduleDiscipline['ModuleDisciplineSlider'] as $moduleDisciplineSlider): ?>
					<tr>
						<td><?php echo h($moduleDisciplineSlider['id']); ?></td>
						<td><?php echo $this->Utility->__LimitText($moduleDisciplineSlider['name']); ?></td>
						<td><?php echo $this->Utility->__FormatStatus($moduleDisciplineSlider['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($moduleDisciplineSlider['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($moduleDisciplineSlider['modified']); ?></td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	<?php endif; ?>
</div>

<!-- VÍDEOS RELACIONADOS À DISCIPLINA / UNIDADE -->

<?php if (!empty($moduleDiscipline['ModuleDisciplinePlayer'])): ?>
	<div class="panel">
		<h3><?php echo __('Related Module Discipline Players'); ?></h3>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($moduleDiscipline['ModuleDisciplinePlayer'] as $moduleDisciplinePlayer): ?>
					<tr>
						<td><?php echo h($moduleDisciplinePlayer['id']); ?></td>
						<td><?php echo $this->Utility->__LimitText($moduleDisciplinePlayer['name']); ?></td>
						<td><?php echo $this->Utility->__FormatStatus($moduleDisciplinePlayer['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($moduleDisciplinePlayer['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($moduleDisciplinePlayer['modified']); ?></td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	</div>
<?php endif; ?>

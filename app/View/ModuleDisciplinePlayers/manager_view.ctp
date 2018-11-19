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
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>        <?php echo $this->Html->addCrumb('Visualizar cadastro', '');?>        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="panel">
	<h3>Visualização dos dados</h3>

	<ul class="list-group">
		<li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('id'); ?></strong></div> 
						<div class='col-md-10'><?php echo $moduleDisciplinePlayer['ModuleDisciplinePlayer']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module Discipline'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($moduleDisciplinePlayer['ModuleDiscipline']['name'], array('controller' => 'module_disciplines', 'action' => 'view', $moduleDisciplinePlayer['ModuleDiscipline']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $moduleDisciplinePlayer['ModuleDisciplinePlayer']['name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('embed_player'); ?></strong></div> 
						<div class='col-md-10'><?php echo $moduleDisciplinePlayer['ModuleDisciplinePlayer']['embed_player']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($moduleDisciplinePlayer['ModuleDisciplinePlayer']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('position'); ?></strong></div> 
						<div class='col-md-10'><?php echo $moduleDisciplinePlayer['ModuleDisciplinePlayer']['position']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($moduleDisciplinePlayer['ModuleDisciplinePlayer']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($moduleDisciplinePlayer['ModuleDisciplinePlayer']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related User Module Logs'); ?></h3>
	<?php if (!empty($moduleDisciplinePlayer['UserModuleLog'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th><?php echo __('Module Discipline Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($moduleDisciplinePlayer['UserModuleLog'] as $userModuleLog): ?>
		<tr>
		<td><?php echo h($userModuleLog['id']); ?></td>
		<td><?php echo h($userModuleLog['user_id']); ?></td>
		<td><?php echo h($userModuleLog['module_id']); ?></td>
		<td><?php echo h($userModuleLog['module_discipline_id']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($userModuleLog['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($userModuleLog['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'user_module_logs', 'action' => 'view', $userModuleLog['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'user_module_logs', 'action' => 'edit', $userModuleLog['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'user_module_logs', 'action' => 'delete', $userModuleLog['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $userModuleLog['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('User Module Log'), array('controller' => 'user_module_logs', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

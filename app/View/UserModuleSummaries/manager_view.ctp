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
						<div class='col-md-10'><?php echo $userModuleSummary['UserModuleSummary']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userModuleSummary['User']['name'], array('controller' => 'users', 'action' => 'view', $userModuleSummary['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userModuleSummary['Module']['name'], array('controller' => 'modules', 'action' => 'view', $userModuleSummary['Module']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module Discipline'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userModuleSummary['ModuleDiscipline']['name'], array('controller' => 'module_disciplines', 'action' => 'view', $userModuleSummary['ModuleDiscipline']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('desblock'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userModuleSummary['UserModuleSummary']['desblock']; ?></div>
						</div>
					</li>	</ul>
</div>


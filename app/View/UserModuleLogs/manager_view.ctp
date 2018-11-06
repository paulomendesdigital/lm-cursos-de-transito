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
						<div class='col-md-10'><?php echo $userModuleLog['UserModuleLog']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userModuleLog['User']['name'], array('controller' => 'users', 'action' => 'view', $userModuleLog['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userModuleLog['Module']['name'], array('controller' => 'modules', 'action' => 'view', $userModuleLog['Module']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module Discipline'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userModuleLog['ModuleDiscipline']['name'], array('controller' => 'module_disciplines', 'action' => 'view', $userModuleLog['ModuleDiscipline']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('model'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userModuleLog['UserModuleLog']['model']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modelid'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userModuleLog['UserModuleLog']['modelid']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('time'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userModuleLog['UserModuleLog']['time']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($userModuleLog['UserModuleLog']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($userModuleLog['UserModuleLog']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>


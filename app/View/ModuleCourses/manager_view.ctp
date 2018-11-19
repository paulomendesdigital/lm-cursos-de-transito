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
						<div class='col-md-10'><?php echo $moduleCourse['ModuleCourse']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($moduleCourse['Module']['name'], array('controller' => 'modules', 'action' => 'view', $moduleCourse['Module']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Course'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($moduleCourse['Course']['name'], array('controller' => 'courses', 'action' => 'view', $moduleCourse['Course']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Citie'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($moduleCourse['Citie']['name'], array('controller' => 'cities', 'action' => 'view', $moduleCourse['Citie']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('State'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($moduleCourse['State']['name'], array('controller' => 'states', 'action' => 'view', $moduleCourse['State']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('position'); ?></strong></div> 
						<div class='col-md-10'><?php echo $moduleCourse['ModuleCourse']['position']; ?></div>
						</div>
					</li>	</ul>
</div>


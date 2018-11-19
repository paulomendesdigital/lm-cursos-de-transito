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
						<div class='col-md-10'><?php echo $orderCourse['OrderCourse']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Order'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($orderCourse['Order']['id'], array('controller' => 'orders', 'action' => 'view', $orderCourse['Order']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Course'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($orderCourse['Course']['name'], array('controller' => 'courses', 'action' => 'view', $orderCourse['Course']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Citie'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($orderCourse['Citie']['name'], array('controller' => 'cities', 'action' => 'view', $orderCourse['Citie']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('State'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($orderCourse['State']['name'], array('controller' => 'states', 'action' => 'view', $orderCourse['State']['id'])); ?></div>
								</div>
							</li>	</ul>
</div>


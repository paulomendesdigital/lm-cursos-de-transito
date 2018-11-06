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
						<div class='col-md-10'><?php echo $userCertificate['UserCertificate']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userCertificate['User']['name'], array('controller' => 'users', 'action' => 'view', $userCertificate['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Course'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userCertificate['Course']['name'], array('controller' => 'courses', 'action' => 'view', $userCertificate['Course']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('course_name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userCertificate['UserCertificate']['course_name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('description'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userCertificate['UserCertificate']['description']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('start'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userCertificate['UserCertificate']['start']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('finish'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userCertificate['UserCertificate']['finish']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($userCertificate['UserCertificate']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($userCertificate['UserCertificate']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>


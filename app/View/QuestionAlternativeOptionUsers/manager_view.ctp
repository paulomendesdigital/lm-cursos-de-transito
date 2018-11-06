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
						<div class='col-md-10'><?php echo $questionAlternativeOptionUser['QuestionAlternativeOptionUser']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($questionAlternativeOptionUser['User']['name'], array('controller' => 'users', 'action' => 'view', $questionAlternativeOptionUser['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Question Alternative'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($questionAlternativeOptionUser['QuestionAlternative']['id'], array('controller' => 'question_alternatives', 'action' => 'view', $questionAlternativeOptionUser['QuestionAlternative']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Question Alternative Option'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($questionAlternativeOptionUser['QuestionAlternativeOption']['name'], array('controller' => 'question_alternative_options', 'action' => 'view', $questionAlternativeOptionUser['QuestionAlternativeOption']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('correct'); ?></strong></div> 
						<div class='col-md-10'><?php echo $questionAlternativeOptionUser['QuestionAlternativeOptionUser']['correct']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('sessionid'); ?></strong></div> 
						<div class='col-md-10'><?php echo $questionAlternativeOptionUser['QuestionAlternativeOptionUser']['sessionid']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionAlternativeOptionUser['QuestionAlternativeOptionUser']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionAlternativeOptionUser['QuestionAlternativeOptionUser']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>


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
						<div class='col-md-10'><?php echo $userQuestionOption['UserQuestionOption']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User Question'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userQuestionOption['UserQuestion']['id'], array('controller' => 'user_questions', 'action' => 'view', $userQuestionOption['UserQuestion']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Question Alternative Option User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userQuestionOption['QuestionAlternativeOptionUser']['id'], array('controller' => 'question_alternative_option_users', 'action' => 'view', $userQuestionOption['QuestionAlternativeOptionUser']['id'])); ?></div>
								</div>
							</li>	</ul>
</div>


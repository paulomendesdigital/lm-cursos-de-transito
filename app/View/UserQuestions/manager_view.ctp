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
						<div class='col-md-10'><?php echo $userQuestion['UserQuestion']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userQuestion['User']['name'], array('controller' => 'users', 'action' => 'view', $userQuestion['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('model'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userQuestion['UserQuestion']['model']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Module'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($userQuestion['Module']['name'], array('controller' => 'modules', 'action' => 'view', $userQuestion['Module']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('value_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userQuestion['UserQuestion']['value_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('value_result'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userQuestion['UserQuestion']['value_result']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('result'); ?></strong></div> 
						<div class='col-md-10'><?php echo $userQuestion['UserQuestion']['result']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($userQuestion['UserQuestion']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($userQuestion['UserQuestion']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related User Question Options'); ?></h3>
	<?php if (!empty($userQuestion['UserQuestionOption'])): ?>

<?php $icount = 1; foreach ($userQuestion['UserQuestionOption'] as $userQuestionOption): ?>
<div class="panel panel-default">
	<div class="panel-body">
		<h3><small>Pergunta <?php echo $icount;?></small></h3>
		<?php echo $userQuestionOption['QuestionAlternativeOptionUser']['QuestionAlternative']['text']; ?>
	</div>

	<div class="list-group">
		<?php 
		//Percorre as opções
		foreach ($userQuestionOption['QuestionAlternativeOptionUser']['QuestionAlternative']['QuestionAlternativeOption'] as $QuestionAlternativeOption):
			$i = '';
			if($QuestionAlternativeOption['correct']):
				//Se essa resposta for correta
				if($userQuestionOption['QuestionAlternativeOptionUser']['correct']):
					//Se o usuário acertou
					$i = '<i class="icon-checkmark3 alert-success" alt="Resposta Certa"></i> ';
				else:
					$i = '<i class="icon-checkmark3 alert-warning" alt="Resposta Certa"></i> ';
				endif;
			else:
				if($QuestionAlternativeOption['id'] == $userQuestionOption['QuestionAlternativeOptionUser']['question_alternative_option_id']):
					//Se é a resposta do usuário
					$i = '<i class="icon-close alert-danger" alt="Resposta Errada"></i> ';
				endif;
			endif;
		?>
		<span class="list-group-item"><?php echo $i.$QuestionAlternativeOption['name'];?></span>
		<?php endforeach; ?>
		<!-- <i class="icon-checkmark3 alert-success"></i> -->
	</div>
</div>
<?php $icount++; endforeach; ?>

	<?php endif; ?>
</div>

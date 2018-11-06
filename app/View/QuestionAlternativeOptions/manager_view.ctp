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
						<div class='col-md-10'><?php echo $questionAlternativeOption['QuestionAlternativeOption']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Question Alternative'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($questionAlternativeOption['QuestionAlternative']['id'], array('controller' => 'question_alternatives', 'action' => 'view', $questionAlternativeOption['QuestionAlternative']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $questionAlternativeOption['QuestionAlternativeOption']['name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('correct'); ?></strong></div> 
						<div class='col-md-10'><?php echo $questionAlternativeOption['QuestionAlternativeOption']['correct']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($questionAlternativeOption['QuestionAlternativeOption']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionAlternativeOption['QuestionAlternativeOption']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionAlternativeOption['QuestionAlternativeOption']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related Question Alternative Option Users'); ?></h3>
	<?php if (!empty($questionAlternativeOption['QuestionAlternativeOptionUser'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Question Alternative Id'); ?></th>
		<th><?php echo __('Question Alternative Option Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($questionAlternativeOption['QuestionAlternativeOptionUser'] as $questionAlternativeOptionUser): ?>
		<tr>
		<td><?php echo h($questionAlternativeOptionUser['id']); ?></td>
		<td><?php echo h($questionAlternativeOptionUser['user_id']); ?></td>
		<td><?php echo h($questionAlternativeOptionUser['question_alternative_id']); ?></td>
		<td><?php echo h($questionAlternativeOptionUser['question_alternative_option_id']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($questionAlternativeOptionUser['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($questionAlternativeOptionUser['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'question_alternative_option_users', 'action' => 'view', $questionAlternativeOptionUser['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'question_alternative_option_users', 'action' => 'edit', $questionAlternativeOptionUser['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'question_alternative_option_users', 'action' => 'delete', $questionAlternativeOptionUser['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $questionAlternativeOptionUser['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Question Alternative Option User'), array('controller' => 'question_alternative_option_users', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

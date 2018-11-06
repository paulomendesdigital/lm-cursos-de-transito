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
				<div class='col-md-10'><?php echo $questionAlternative['QuestionAlternative']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Module'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Html->link($questionAlternative['Module']['name'], array('controller' => 'modules', 'action' => 'view', $questionAlternative['Module']['id'])); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('text'); ?></strong></div> 
				<div class='col-md-10'><?php echo $questionAlternative['QuestionAlternative']['text']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($questionAlternative['QuestionAlternative']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionAlternative['QuestionAlternative']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionAlternative['QuestionAlternative']['modified']); ?></div>
			</div>
		</li>
	</ul>
</div>


<div class="panel">
	<h3><?php echo __('Related Question Alternative Options'); ?></h3>
	<?php if (!empty($questionAlternative['QuestionAlternativeOption'])): ?>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($questionAlternative['QuestionAlternativeOption'] as $questionAlternativeOption): ?>
					<tr>
						<td><?php echo h($questionAlternativeOption['id']); ?></td>
						<td><?php echo $this->Utility->__LimitText($questionAlternativeOption['name']); ?></td>
						<td><?php echo $this->Utility->__FormatStatus($questionAlternativeOption['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($questionAlternativeOption['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($questionAlternativeOption['modified']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'question_alternative_options', 'action' => 'view', $questionAlternativeOption['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
							<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'question_alternative_options', 'action' => 'edit', $questionAlternativeOption['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
							<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'question_alternative_options', 'action' => 'delete', $questionAlternativeOption['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $questionAlternativeOption['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Question Alternative Option'), array('controller' => 'question_alternative_options', 'action' => 'add', $questionAlternative['QuestionAlternative']['id']),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
        </div>
    </div>
</div>
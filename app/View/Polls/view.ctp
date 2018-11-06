<?php /**
 * @copyright Copyright 2017
 * @author Dayvison Silva - www.dayvisonsilva.com.br
 * Questionnaire View
 *
*/ ?><div class="page-header">
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
						<div class='col-md-10'><?php echo $questionnaire['Questionnaire']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $questionnaire['Questionnaire']['name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($questionnaire['Questionnaire']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionnaire['Questionnaire']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($questionnaire['Questionnaire']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related').' '.__('questions'); ?></h3>
	<?php if (!empty($questionnaire['Question'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('id'); ?></th>
		<th><?php echo __('questionnaire_id'); ?></th>
		<th><?php echo __('status'); ?></th>
		<th><?php echo __('created'); ?></th>
		<th><?php echo __('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($questionnaire['Question'] as $question): ?>
		<tr>
		<td><?php echo h($question['id']); ?></td>
		<td><?php echo h($question['questionnaire_id']); ?></td>
		<td><?php echo $this->Utility->__FormatStatus($question['status']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($question['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($question['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'questions', 'action' => 'view', $question['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'questions', 'action' => 'edit', $question['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'questions', 'action' => 'delete', $question['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $question['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('questions'), array('controller' => 'questions', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>
<div class="panel">
	<h3><?php echo __('Related').' '.__('responses'); ?></h3>
	<?php if (!empty($questionnaire['Response'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('id'); ?></th>
		<th><?php echo __('questionnaire_id'); ?></th>
		<th><?php echo __('question_id'); ?></th>
		<th><?php echo __('question_alternative_id'); ?></th>
		<th><?php echo __('created'); ?></th>
		<th><?php echo __('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($questionnaire['Response'] as $response): ?>
		<tr>
		<td><?php echo h($response['id']); ?></td>
		<td><?php echo h($response['questionnaire_id']); ?></td>
		<td><?php echo h($response['question_id']); ?></td>
		<td><?php echo h($response['question_alternative_id']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($response['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($response['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'responses', 'action' => 'view', $response['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'responses', 'action' => 'edit', $response['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'responses', 'action' => 'delete', $response['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $response['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('responses'), array('controller' => 'responses', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

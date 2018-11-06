<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Module View
 *
*/ ?>
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
		<?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$module['Module']['id']);?>
		<?php echo $this->Html->addCrumb('Visualizar cadastro', '');?>
		<?php echo $this->Html->getCrumbs(' ', 'Home');?> 
	</ul>
</div>

<div class="panel">
	<h3>Visualização dos dados</h3>
	<ul class="list-group">
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('id'); ?></strong></div> 
				<div class='col-md-10'><?php echo $module['Module']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Course Type'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Html->link($module['CourseType']['name'], array('controller' => 'course_types', 'action' => 'view', $module['CourseType']['id'])); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('is_introduction'); ?></strong></div> 
				<div class='col-md-10'><?php echo $module['Module']['is_introduction']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
				<div class='col-md-10'><?php echo $module['Module']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('text'); ?></strong></div> 
				<div class='col-md-10'><?php echo $module['Module']['text']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('value_time'); ?></strong></div> 
				<div class='col-md-10'><?php echo $module['Module']['value_time']; ?></div>
			</div>
		</li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('exam_discipline_code_id'); ?></strong></div>
                <div class='col-md-10'><?php echo isset($module['ExamDisciplineCode']['code_name']) ? $module['ExamDisciplineCode']['code_name'] : ''; ?></div>
            </div>
        </li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($module['Module']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($module['Module']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($module['Module']['modified']); ?></div>
			</div>
		</li>
	</ul>
</div>

<!-- CURSOS RELACIONADOS AO MÓDULO -->

<div class="panel">
	<h3><?php echo __('Related Module Courses'); ?></h3>
	<?php if (!empty($module['ModuleCourse'])): ?>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Course Id'); ?></th>
					<th><?php echo __('Citie Id'); ?></th>
					<th><?php echo __('State Id'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($module['ModuleCourse'] as $moduleCourse): ?>
					<tr>
						<td><?php echo h($moduleCourse['id']); ?></td>
						<td><?php echo h($moduleCourse['Course']['name']); ?></td>
						<td><?php echo isset($moduleCourse['Citie']['name']) ? h($moduleCourse['Citie']['name']) : ''; ?></td>
						<td><?php echo isset($moduleCourse['State']['name']) ? h($moduleCourse['State']['name']) : ''; ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'module_courses', 'action' => 'view', $moduleCourse['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
							<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'module_courses', 'action' => 'edit', $moduleCourse['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
							<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'module_courses', 'action' => 'delete', $moduleCourse['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $moduleCourse['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	<?php endif; ?>
</div>

<!-- DISCIPLINAS / UNIDADES RELACIONADAS AO MÓDULO -->

<div class="panel">
	<h3><?php echo __('Unidades deste módulo'); ?></h3>
	<?php if (!empty($module['ModuleDiscipline'])): ?>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Name'); ?></th>
                    <th><?php echo __('discipline_code_id'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($module['ModuleDiscipline'] as $moduleDiscipline): ?>
					<tr>
						<td><?php echo h($moduleDiscipline['id']); ?></td>
						<td><?php echo $this->Utility->__LimitText($moduleDiscipline['name']); ?></td>
                        <td><?php echo isset($moduleDiscipline['DisciplineCode']['code']) ? h($moduleDiscipline['DisciplineCode']['code']) : ''; ?></td>
						<td><?php echo $this->Utility->__FormatStatus($moduleDiscipline['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($moduleDiscipline['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($moduleDiscipline['modified']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'module_disciplines', 'action' => 'view', $moduleDiscipline['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
							<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'module_disciplines', 'action' => 'edit', $moduleDiscipline['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
							<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'module_disciplines', 'action' => 'delete', $moduleDiscipline['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $moduleDiscipline['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	<?php endif; ?>

	<div class="table-footer">
		<div class="table-actions">
			<?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Module Discipline'), array('controller' => 'module_disciplines', 'action' => 'add', $module['Module']['id']),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
			<?php echo $this->Html->link('<i class="icon-puzzle3"></i> '.__('Module Discipline'), array('controller' => 'module_disciplines', 'action' => 'index', $module['Module']['id']),array('escape'=>false,'class'=>'btn btn-sm btn-warning')); ?>
		</div>
	</div>
</div>

<!-- QUESTÕES / ALTERNATIVAS RELACIONADAS AO MÓDULO -->

<div class="panel">
	<h3><?php echo __('Related Question Alternatives'); ?></h3>
	<?php if (!empty($module['QuestionAlternative'])): ?>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Id'); ?></th>
					<th><?php echo __('Text'); ?></th>
					<th><?php echo __('Status'); ?></th>
					<th><?php echo __('Created'); ?></th>
					<th><?php echo __('Modified'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($module['QuestionAlternative'] as $questionAlternative): ?>
					<tr>
						<td><?php echo h($questionAlternative['id']); ?></td>
						<td><?php echo $this->Utility->__LimitText($questionAlternative['text']); ?></td>
						<td><?php echo $this->Utility->__FormatStatus($questionAlternative['status']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($questionAlternative['created']); ?></td>
						<td><?php echo $this->Utility->__FormatDate($questionAlternative['modified']); ?></td>
						<td class="actions">
							<?php //echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'question_alternatives', 'action' => 'view', $questionAlternative['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
							<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'question_alternatives', 'action' => 'edit', $questionAlternative['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
							<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'question_alternatives', 'action' => 'delete', $questionAlternative['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $questionAlternative['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
	<?php endif; ?>

	<div class="table-footer">
		<div class="table-actions">
			<?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Questões'), array('controller' => 'question_alternatives', 'action' => 'add', $module['Module']['id']),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
			<?php echo $this->Html->link('<i class="icon-question2"></i> '.__('Questões'), array('controller' => 'question_alternatives', 'action' => 'index', $module['Module']['id']),array('escape'=>false,'class'=>'btn btn-sm btn-success')); ?>
		</div>
	</div>
</div>

<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Course View
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
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>        <?php echo $this->Html->addCrumb('Visualizar cadastro', '');?>        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="panel">
	<h3>Visualização dos dados</h3>

	<ul class="list-group">
		<li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('id'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Course Type'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($course['CourseType']['name'], array('controller' => 'course_types', 'action' => 'view', $course['CourseType']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('firstname'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['firstname']; ?></div>
						</div>
					</li>
                    <li class='list-group-item'>
                        <div class='row'>
                            <div class='col-md-2 text-right'><strong><?php echo __('course_code_id'); ?></strong></div>
                            <div class='col-md-10'><?php echo isset($course['CourseCode']['code_name']) ? $course['CourseCode']['code_name'] : ''; ?></div>
                        </div>
                    </li>
                    <li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('text'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['text']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('description_certificate'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['description_certificate']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('is_module_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['is_module_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('max_time_module_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['max_time_module_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('value_module_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['value_module_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('qt_question_module_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['qt_question_module_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('is_module_block'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['is_module_block']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('is_course_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['is_course_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('max_time_course_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['max_time_course_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('value_course_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['value_course_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('qt_question_course_avaliation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['qt_question_course_avaliation']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('is_course_certificate'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['is_course_certificate']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('is_certificate_block'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['is_certificate_block']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('min_time'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['min_time']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('max_time'); ?></strong></div> 
						<div class='col-md-10'><?php echo $course['Course']['max_time']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($course['Course']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($course['Course']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($course['Course']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related Course Instructors'); ?></h3>
	<?php if (!empty($course['CourseInstructor'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Instructor'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($course['CourseInstructor'] as $courseInstructor): ?>
		<tr>
		<td><?php echo h($courseInstructor['id']); ?></td>
		<td><?php echo h($courseInstructor['Instructor']['name']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'course_instructors', 'action' => 'view', $courseInstructor['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'course_instructors', 'action' => 'edit', $courseInstructor['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'course_instructors', 'action' => 'delete', $courseInstructor['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $courseInstructor['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Course Instructor'), array('controller' => 'course_instructors', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>
<div class="panel">
	<h3><?php echo __('Related Forums'); ?></h3>
	<?php if (!empty($course['Forum'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Citie Id'); ?></th>
		<th><?php echo __('State Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($course['Forum'] as $forum): ?>
		<tr>
		<td><?php echo h($forum['id']); ?></td>
		<td><?php echo h($forum['Citie']['name']); ?></td>
		<td><?php echo h($forum['State']['name']); ?></td>
		<td><?php echo h($forum['User']['name']); ?></td>
		<td><?php echo $this->Utility->__LimitText($forum['name']); ?></td>
		<td><?php echo $this->Utility->__FormatStatus($forum['status']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($forum['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($forum['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'forums', 'action' => 'view', $forum['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'forums', 'action' => 'edit', $forum['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'forums', 'action' => 'delete', $forum['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $forum['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Forum'), array('controller' => 'forums', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>
<div class="panel">
	<h3><?php echo __('Related Module Courses'); ?></h3>
	<?php if (!empty($course['ModuleCourse'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th><?php echo __('Citie Id'); ?></th>
		<th><?php echo __('State Id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($course['ModuleCourse'] as $moduleCourse): ?>
		<tr>
		<td><?php echo h($moduleCourse['id']); ?></td>
		<td><?php echo h($moduleCourse['Module']['name']); ?></td>
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

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Module Course'), array('controller' => 'module_courses', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

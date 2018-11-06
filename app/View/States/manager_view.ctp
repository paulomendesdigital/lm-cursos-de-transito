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
						<div class='col-md-10'><?php echo $state['State']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $state['State']['name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('abbreviation'); ?></strong></div> 
						<div class='col-md-10'><?php echo $state['State']['abbreviation']; ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related Cities'); ?></h3>
	<?php if (!empty($state['City'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('State Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($state['City'] as $city): ?>
		<tr>
		<td><?php echo h($city['id']); ?></td>
		<td><?php echo h($city['state_id']); ?></td>
		<td><?php echo $this->Utility->__LimitText($city['name']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'cities', 'action' => 'view', $city['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'cities', 'action' => 'edit', $city['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'cities', 'action' => 'delete', $city['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $city['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('City'), array('controller' => 'cities', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>
<div class="panel">
	<h3><?php echo __('Related Forums'); ?></h3>
	<?php if (!empty($state['Forum'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Course Id'); ?></th>
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
	<?php foreach ($state['Forum'] as $forum): ?>
		<tr>
		<td><?php echo h($forum['id']); ?></td>
		<td><?php echo h($forum['course_id']); ?></td>
		<td><?php echo h($forum['citie_id']); ?></td>
		<td><?php echo h($forum['state_id']); ?></td>
		<td><?php echo h($forum['user_id']); ?></td>
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
	<?php if (!empty($state['ModuleCourse'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Module Id'); ?></th>
		<th><?php echo __('Course Id'); ?></th>
		<th><?php echo __('Citie Id'); ?></th>
		<th><?php echo __('State Id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($state['ModuleCourse'] as $moduleCourse): ?>
		<tr>
		<td><?php echo h($moduleCourse['id']); ?></td>
		<td><?php echo h($moduleCourse['module_id']); ?></td>
		<td><?php echo h($moduleCourse['course_id']); ?></td>
		<td><?php echo h($moduleCourse['citie_id']); ?></td>
		<td><?php echo h($moduleCourse['state_id']); ?></td>
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
<div class="panel">
	<h3><?php echo __('Related Order Courses'); ?></h3>
	<?php if (!empty($state['OrderCourse'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Order Id'); ?></th>
		<th><?php echo __('Course Id'); ?></th>
		<th><?php echo __('Citie Id'); ?></th>
		<th><?php echo __('State Id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($state['OrderCourse'] as $orderCourse): ?>
		<tr>
		<td><?php echo h($orderCourse['id']); ?></td>
		<td><?php echo h($orderCourse['order_id']); ?></td>
		<td><?php echo h($orderCourse['course_id']); ?></td>
		<td><?php echo h($orderCourse['citie_id']); ?></td>
		<td><?php echo h($orderCourse['state_id']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'order_courses', 'action' => 'view', $orderCourse['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'order_courses', 'action' => 'edit', $orderCourse['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'order_courses', 'action' => 'delete', $orderCourse['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $orderCourse['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Order Course'), array('controller' => 'order_courses', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

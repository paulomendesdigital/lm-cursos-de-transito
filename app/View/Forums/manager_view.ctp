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
						<div class='col-md-10'><?php echo $forum['Forum']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Course'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($forum['Course']['name'], array('controller' => 'courses', 'action' => 'view', $forum['Course']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Citie'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($forum['Citie']['name'], array('controller' => 'cities', 'action' => 'view', $forum['Citie']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('State'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($forum['State']['name'], array('controller' => 'states', 'action' => 'view', $forum['State']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($forum['User']['name'], array('controller' => 'users', 'action' => 'view', $forum['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
						<div class='col-md-10'><?php echo $forum['Forum']['name']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('forum_post_count'); ?></strong></div> 
						<div class='col-md-10'><?php echo $forum['Forum']['forum_post_count']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($forum['Forum']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($forum['Forum']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($forum['Forum']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related Forum Posts'); ?></h3>
	<?php if (!empty($forum['ForumPost'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('text'); ?></th>
		<th><?php echo __('Status'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($forum['ForumPost'] as $forumPost): ?>
		<tr>
		<td><?php echo h($forumPost['id']); ?></td>
		<td><?php echo h($forumPost['User']['name']); ?></td>
		<td><?php echo h($forumPost['text']); ?></td>
		<td><?php echo $this->Utility->__FormatStatus($forumPost['status']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($forumPost['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($forumPost['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'forum_posts', 'action' => 'view', $forumPost['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'forum_posts', 'action' => 'edit', $forumPost['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'forum_posts', 'action' => 'delete', $forumPost['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $forumPost['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Forum Post'), array('controller' => 'forum_posts', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

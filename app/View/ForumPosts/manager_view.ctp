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
						<div class='col-md-10'><?php echo $forumPost['ForumPost']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('Forum'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($forumPost['Forum']['name'], array('controller' => 'forums', 'action' => 'view', $forumPost['Forum']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($forumPost['User']['name'], array('controller' => 'users', 'action' => 'view', $forumPost['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('text'); ?></strong></div> 
						<div class='col-md-10'><?php echo $forumPost['ForumPost']['text']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($forumPost['ForumPost']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($forumPost['ForumPost']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($forumPost['ForumPost']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related Forum Post Comments'); ?></h3>
	<?php if (!empty($forumPost['ForumPostComment'])): ?>
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
	<?php foreach ($forumPost['ForumPostComment'] as $forumPostComment): ?>
		<tr>
		<td><?php echo h($forumPostComment['id']); ?></td>
		<td><?php echo h($forumPostComment['User']['name']); ?></td>
		<td><?php echo h($forumPostComment['text']); ?></td>
		<td><?php echo $this->Utility->__FormatStatus($forumPostComment['status']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($forumPostComment['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($forumPostComment['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'forum_post_comments', 'action' => 'view', $forumPostComment['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'forum_post_comments', 'action' => 'edit', $forumPostComment['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'forum_post_comments', 'action' => 'delete', $forumPostComment['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $forumPostComment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Forum Post Comment'), array('controller' => 'forum_post_comments', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

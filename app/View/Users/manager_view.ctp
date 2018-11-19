<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * User View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($titlePage);?> <small>Visualização do resultado</small></h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/'.$action);?>
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
				<div class='col-md-10'><?php echo $user['User']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Group'); ?></strong></div> 
				<div class='col-md-10'>
					<?php echo $user['Group']['name']; ?>
				</div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
				<div class='col-md-10'><?php echo $user['User']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('cpf'); ?></strong></div> 
				<div class='col-md-10'><?php echo $user['User']['cpf']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('username'); ?></strong></div> 
				<div class='col-md-10'><?php echo $user['User']['username']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('email'); ?></strong></div> 
				<div class='col-md-10'><?php echo $user['User']['email']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Postagens no Fórum'); ?></strong></div> 
				<div class='col-md-10'><?php echo $user['User']['forum_post_count']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('avatar'); ?></strong></div> 
				<div class='col-md-10'>
					<?php echo !empty($user['User']['avatar'])?$this->Html->image("/files/user/avatar/{$user['User']['id']}/thumb_{$user['User']['avatar']}",['class'=>'thumbnail']):''; ?>
				</div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('newsletter'); ?></strong></div> 
				<div class='col-md-10'><?php echo $user['User']['newsletter']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'>
					<?php echo $this->Utility->__FormatStatus($user['User']['status']);?>
				</div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'>
					<?php echo $this->Utility->__FormatDate($user['User']['created']); ?>
				</div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'>
					<?php echo $this->Utility->__FormatDate($user['User']['modified']); ?>
				</div>
			</div>
		</li>
		<?php if( isset($user['Instructor']) and !empty($user['Instructor']) ):?>
			<li class='list-group-item'>
				<div class='row'>
					<div class='col-md-2 text-right'><strong><?php echo __('Endereço'); ?></strong></div> 
					<div class='col-md-10'>
						<?php echo "{$user['Instructor'][0]['address']}, {$user['Instructor'][0]['number']} - {$user['Instructor'][0]['neighborhood']}, {$user['Instructor'][0]['City']['name']}"; ?>
					</div>
				</div>
			</li>
		<?php endif;?>
		<?php if( isset($user['Student']) and !empty($user['Student']) ):?>
			<li class='list-group-item'>
				<div class='row'>
					<div class='col-md-2 text-right'><strong><?php echo __('Endereço'); ?></strong></div> 
					<div class='col-md-10'>
						<?php echo $this->Utility->getStudentAddressString($user['Student'][0]);?>
					</div>
				</div>
			</li>
		<?php endif;?>
	</ul>
</div>

<?php if(isset($user['Instructor'][0]['DirectMessage']) and !empty($user['Instructor'][0]['DirectMessage'])):?>

	<div class="panel">
		<h3><?php echo __('Related Direct Messages'); ?></h3>
		<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
			<thead>
				<tr>
					<th><?php echo __('Mensagem recebida'); ?></th>
					<th><?php echo __('Mensagem enviada por'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($user['Instructor'][0]['DirectMessage'] as $directMessage): ?>
					<tr>
						<td><?php echo $this->Text->truncate($directMessage['text'],50); ?></td>
						<td><?php echo h($directMessage['User']['name']); ?></td>
						<td class="actions">
							<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'direct_messages', 'action' => 'answer', $directMessage['user_id'], $directMessage['instructor_id']), array('class' => 'btn btn-info btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Mensagens')); ?>
							<?php //echo $this->Html->link(__('<span class="icon-bubble4"></span>'), array('controller' => 'direct_messages', 'action' => 'answer', $directMessage['id']), array('class' => 'btn btn-success btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Responder Mensagem')); ?>
							<?php //echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'direct_messages', 'action' => 'delete', $directMessage['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $directMessage['id'])); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<tbody>
		</table>
		<div class="table-footer">
	        <div class="table-actions">
	            <?php //echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Direct Message'), array('controller' => 'direct_messages', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
	        </div>
	    </div>
	</div>
<?php endif; ?>

<?php if ( isset($user['ForumPostComment']) and !empty($user['ForumPostComment'])): ?>
	<div class="panel">
		<h3><?php echo __('Related Forum Post Comments'); ?></h3>
		<?php if (!empty($user['ForumPostComment'])): ?>
			<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
				<thead>
					<tr>
						<th><?php echo __('Id'); ?></th>
						<th><?php echo __('Forum Post Id'); ?></th>
						<th><?php echo __('Status'); ?></th>
						<th><?php echo __('Created'); ?></th>
						<th><?php echo __('Modified'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user['ForumPostComment'] as $forumPostComment): ?>
						<tr>
							<td><?php echo h($forumPostComment['id']); ?></td>
							<td><?php echo h($forumPostComment['forum_post_id']); ?></td>
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
	            <?php //echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Forum Post Comment'), array('controller' => 'forum_post_comments', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
            </div>
	    </div>
	</div>
<?php endif; ?>

<?php if ( isset($user['ForumPost']) and !empty($user['ForumPost'])): ?>
	<div class="panel">
		<h3><?php echo __('Related Forum Posts'); ?></h3>
		<?php if (!empty($user['ForumPost'])): ?>
			<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
				<thead>
					<tr>
						<th><?php echo __('Id'); ?></th>
						<th><?php echo __('Forum Id'); ?></th>
						<th><?php echo __('Status'); ?></th>
						<th><?php echo __('Created'); ?></th>
						<th><?php echo __('Modified'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user['ForumPost'] as $forumPost): ?>
						<tr>
							<td><?php echo h($forumPost['id']); ?></td>
							<td><?php echo h($forumPost['Forum']['name']); ?></td>
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
	            <?php //echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Forum Post'), array('controller' => 'forum_posts', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
            </div>
	    </div>
	</div>
<?php endif; ?>

<?php if ( isset($user['Forum']) and !empty($user['Forum'])): ?>
	<div class="panel">
		<h3><?php echo __('Related Forums'); ?></h3>
		<?php if (!empty($user['Forum'])): ?>
			<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
				<thead>
					<tr>
						<th><?php echo __('Id'); ?></th>
						<th><?php echo __('Course Id'); ?></th>
						<th><?php echo __('Citie Id'); ?></th>
						<th><?php echo __('State Id'); ?></th>
						<th><?php echo __('Name'); ?></th>
						<th><?php echo __('Status'); ?></th>
						<th><?php echo __('Created'); ?></th>
						<th><?php echo __('Modified'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user['Forum'] as $forum): ?>
						<tr>
							<td><?php echo h($forum['id']); ?></td>
							<td><?php echo h($forum['Course']['name']); ?></td>
							<td><?php echo h($forum['Citie']['name']); ?></td>
							<td><?php echo h($forum['State']['name']); ?></td>
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
	            <?php //echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('Forum'), array('controller' => 'forums', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
	        </div>
	    </div>
	</div>
<?php endif; ?>

<?php if ( isset($user['Order']) and !empty($user['Order'])): ?>
	<div class="panel well">
		<h3 class="bg-success text-center"><?php echo __('Related Orders'); ?></h3>
		<?php if (!empty($user['Order'])): ?>
			<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
				<thead>
					<tr>
						<th><?php echo __('Id'); ?></th>
						<th><?php echo __('Order Type Id'); ?></th>
						<th><?php echo __('Cursos'); ?></th>
						<th><?php echo __('Created'); ?></th>
						<th><?php echo __('Modified'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($user['Order'] as $order): ?>
						<tr>
							<td><?php echo h($order['id']); ?></td>
							<td><?php echo h($order['OrderType']['name']); ?></td>
							<td><?php echo $this->Utility->__ExtractCourses($order['OrderCourse']); ?></td>
							<td><?php echo $this->Utility->__FormatDate($order['created']); ?></td>
							<td><?php echo $this->Utility->__FormatDate($order['modified']); ?></td>
							<td class="actions">
								<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'orders', 'action' => 'view', $order['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
								<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'orders', 'action' => 'edit', $order['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
								<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'orders', 'action' => 'delete', $order['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $order['id'])); ?>
							</td>
						</tr>
						<tr>
							<td colspan="6">
								<?php if ( isset($order['UserModuleSummary']) and !empty($order['UserModuleSummary'])): ?>
									<div class="panel">
										<h3><?php echo __('Related User Module Summaries'); ?></h3>
										<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
											<thead>
												<tr>
													<th><?php echo __('Id'); ?></th>
													<th><?php echo __('Module Id'); ?></th>
													<th><?php echo __('Module Discipline Id'); ?></th>
													<th><?php echo __('Desbloqueado'); ?></th>
													<th class="actions"><?php echo __('Actions'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($order['UserModuleSummary'] as $userModuleSummary): ?>
													<tr>
														<td><?php echo h($userModuleSummary['id']); ?></td>
														<td><?php echo h($userModuleSummary['Module']['name']); ?></td>
														<td><?php echo h($userModuleSummary['ModuleDiscipline']['name']); ?></td>
														<td><?php echo $userModuleSummary['desblock']; ?></td>
														<td class="actions">
															<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'user_module_summaries', 'action' => 'view', $userModuleSummary['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
															<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'user_module_summaries', 'action' => 'edit', $userModuleSummary['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
															<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'user_module_summaries', 'action' => 'delete', $userModuleSummary['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $userModuleSummary['id'])); ?>
														</td>
													</tr>
												<?php endforeach; ?>
											<tbody>
										</table>
									</div>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td colspan="6">
								<?php if ( isset($order['UserModuleLog']) and !empty($order['UserModuleLog'])): ?>
									<div class="panel">
										<h3><?php echo __('Related User Module Logs'); ?></h3>
										<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
											<thead>
												<tr>
													<th><?php echo __('Id'); ?></th>
													<th><?php echo __('Module Id'); ?></th>
													<th><?php echo __('Module Discipline Id'); ?></th>
													<th><?php echo __('Created'); ?></th>
													<th><?php echo __('Modified'); ?></th>
													<th class="actions"><?php echo __('Actions'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($order['UserModuleLog'] as $userModuleLog): ?>
													<tr>
														<td><?php echo h($userModuleLog['id']); ?></td>
														<td><?php echo h($userModuleLog['Module']['name']); ?></td>
														<td><?php echo h($userModuleLog['ModuleDiscipline']['name']); ?></td>
														<td><?php echo $this->Utility->__FormatDate($userModuleLog['created']); ?></td>
														<td><?php echo $this->Utility->__FormatDate($userModuleLog['modified']); ?></td>
														<td class="actions">
															<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'user_module_logs', 'action' => 'view', $userModuleLog['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
															<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'user_module_logs', 'action' => 'edit', $userModuleLog['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
															<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'user_module_logs', 'action' => 'delete', $userModuleLog['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $userModuleLog['id'])); ?>
														</td>
													</tr>
												<?php endforeach; ?>
											<tbody>
										</table>
									</div>
								<?php endif; ?>
							</td>
						</tr>
						<tr>
							<td colspan="6">
								<?php if ( isset($order['UserQuestion']) and !empty($order['UserQuestion'])): ?>
									<div class="panel">
										<h3><?php echo __('Related User Questions'); ?></h3>
										<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
											<thead>
												<tr>
													<th><?php echo __('Id'); ?></th>
													<th><?php echo __('Avaliation'); ?></th>
													<th><?php echo __('Nota de corte'); ?></th>
													<th><?php echo __('Nota da Avaliação'); ?></th>
													<th><?php echo __('Situação'); ?></th>
													<th><?php echo __('Created'); ?></th>
													<th><?php echo __('Modified'); ?></th>
													<th class="actions"><?php echo __('Actions'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($order['UserQuestion'] as $userQuestion): ?>
													<tr>
														<td><?php echo h($userQuestion['id']); ?></td>
														<?php if($userQuestion['model']=='Module'):?>
															<td><?php echo h($userQuestion['Module']['name']); ?></td>
														<?php else:?>
															<td><?php echo h($userQuestion['Course']['name']); ?></td>
														<?php endif;?>
														<td><?php echo h($userQuestion['value_avaliation']); ?></td>
														<td><?php echo h($userQuestion['value_result']); ?></td>
														<td><?php echo $userQuestion['result'] == 0 ? 'Reprovado' : 'Aprovado'; ?></td>
														<td><?php echo $this->Utility->__FormatDate($userQuestion['created']); ?></td>
														<td><?php echo $this->Utility->__FormatDate($userQuestion['modified']); ?></td>
														<td class="actions">
															<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'user_questions', 'action' => 'view', $userQuestion['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
															<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'user_questions', 'action' => 'edit', $userQuestion['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
															<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'user_questions', 'action' => 'delete', $userQuestion['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $userQuestion['id'])); ?>
														</td>
													</tr>
												<?php endforeach; ?>
											<tbody>
										</table>
									</div>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				<tbody>
			</table>
		<?php endif; ?>
	</div>
<?php endif; ?>

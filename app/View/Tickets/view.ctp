<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Ticket View
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
						<div class='col-md-10'><?php echo $ticket['Ticket']['id']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('code'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['code']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('type'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['type']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('value'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['value']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('amount'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['amount']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('start'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['start']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('finish'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['finish']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($ticket['Ticket']['status']); ?></div>
						</div>
					</li><li class='list-group-item'>
								<div class='row'>
								<div class='col-md-2 text-right'><strong><?php echo __('User'); ?></strong></div> 
								<div class='col-md-10'><?php echo $this->Html->link($ticket['User']['name'], array('controller' => 'users', 'action' => 'view', $ticket['User']['id'])); ?></div>
								</div>
							</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('commission'); ?></strong></div> 
						<div class='col-md-10'><?php echo $ticket['Ticket']['commission']; ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($ticket['Ticket']['created']); ?></div>
						</div>
					</li><li class='list-group-item'>
						<div class='row'>
						<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
						<div class='col-md-10'><?php echo $this->Utility->__FormatDate($ticket['Ticket']['modified']); ?></div>
						</div>
					</li>	</ul>
</div>

<div class="panel">
	<h3><?php echo __('Related').' '.__('orders'); ?></h3>
	<?php if (!empty($ticket['Order'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('id'); ?></th>
		<th><?php echo __('client_id'); ?></th>
		<th><?php echo __('ticket_id'); ?></th>
		<th><?php echo __('method_id'); ?></th>
		<th><?php echo __('status'); ?></th>
		<th><?php echo __('created'); ?></th>
		<th><?php echo __('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($ticket['Order'] as $order): ?>
		<tr>
		<td><?php echo h($order['id']); ?></td>
		<td><?php echo h($order['client_id']); ?></td>
		<td><?php echo h($order['ticket_id']); ?></td>
		<td><?php echo h($order['method_id']); ?></td>
		<td><?php echo $this->Utility->__FormatStatus($order['status']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($order['created']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($order['modified']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'orders', 'action' => 'view', $order['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'orders', 'action' => 'edit', $order['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'orders', 'action' => 'delete', $order['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $order['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('orders'), array('controller' => 'orders', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>
<div class="panel">
	<h3><?php echo __('Related').' '.__('ticket_products'); ?></h3>
	<?php if (!empty($ticket['TicketProduct'])): ?>
	<table class="table table-striped table-hover table-condensed" cellpadding = "0" cellspacing = "0">
	<thead>
		<tr>
					<th><?php echo __('id'); ?></th>
		<th><?php echo __('ticket_id'); ?></th>
		<th><?php echo __('product_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
			<tbody>
	<?php foreach ($ticket['TicketProduct'] as $ticketProduct): ?>
		<tr>
		<td><?php echo h($ticketProduct['id']); ?></td>
		<td><?php echo h($ticketProduct['ticket_id']); ?></td>
		<td><?php echo h($ticketProduct['product_id']); ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('controller' => 'ticket_products', 'action' => 'view', $ticketProduct['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
				<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'ticket_products', 'action' => 'edit', $ticketProduct['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
				<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'ticket_products', 'action' => 'delete', $ticketProduct['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $ticketProduct['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		<tbody>
	</table>
<?php endif; ?>

	<div class="table-footer">
        <div class="table-actions">
            <?php echo $this->Html->link('<i class="icon-plus-circle"></i> '.__('ticket_products'), array('controller' => 'ticket_products', 'action' => 'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>        </div>
    </div>
</div>

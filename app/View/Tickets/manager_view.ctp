<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Ticket View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?><small>Visualização do resultado</small></h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
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
				<div class='col-md-10'><?php echo $ticket['Ticket']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('code'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['Ticket']['code']; ?></div>
			</div>
		</li>
		<li class='list-group-item hidden'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('type'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['Ticket']['type']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('value'); ?></strong></div> 
				<div class='col-md-10'><?php echo "{$ticket['Ticket']['value']} %"; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('amount'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['Ticket']['amount']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('start'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['Ticket']['start']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('finish'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['Ticket']['finish']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($ticket['Ticket']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Criado Por'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['User']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('commission'); ?></strong></div> 
				<div class='col-md-10'><?php echo $ticket['Ticket']['commission']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($ticket['Ticket']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($ticket['Ticket']['modified']); ?></div>
			</div>
		</li>
	</ul>
</div>
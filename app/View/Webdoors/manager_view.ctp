<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Webdoor View
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
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('name'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Link'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['url']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('target'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['target']; ?></div>
			</div>
		</li>
		<li class='list-group-item hidden'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('views'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['views']; ?></div>
			</div>
		</li>
		<li class='list-group-item hidden'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('clicks'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['clicks']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('start'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['start']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('finish'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['finish']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($webdoor['Webdoor']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('ordination'); ?></strong></div> 
				<div class='col-md-10'><?php echo $webdoor['Webdoor']['ordination']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($webdoor['Webdoor']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($webdoor['Webdoor']['modified']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-12 text-center'>
					<?php
	                if( !empty($webdoor['Webdoor']['image']) ){
	                    echo $this->Html->image("/files/webdoor/image/{$webdoor['Webdoor']['id']}/vga_{$webdoor['Webdoor']['image']}",['class'=>'img-responsive']);
	                }
	                ?>
				</div>
			</div>
		</li>
	</ul>
</div>


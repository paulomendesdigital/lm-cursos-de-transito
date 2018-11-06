<?php /**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseState View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Auto Escola <small>Visualização do resultado</small></h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar Auto Escolas'), '/manager/'.$this->params['controller'].'/index/');?>
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
				<div class='col-md-10'><?php echo $school['School']['id']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Tipo de Curso'); ?></strong></div> 
				<div class='col-md-10'><?php echo $school['School']['name']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Telefone'); ?></strong></div> 
				<div class='col-md-10'><?php echo $school['School']['phone']; ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('Endereço'); ?></strong></div> 
				<div class='col-md-10'><?php echo $school['School']['full_address']; ?></div>
			</div>
		</li>

        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('cod_cfc'); ?></strong></div>
                <div class='col-md-10'><?php echo $school['School']['cod_cfc']; ?></div>
            </div>
        </li>

		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('status'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatStatus($school['School']['status']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('created'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($school['School']['created']); ?></div>
			</div>
		</li>
		<li class='list-group-item'>
			<div class='row'>
				<div class='col-md-2 text-right'><strong><?php echo __('modified'); ?></strong></div> 
				<div class='col-md-10'><?php echo $this->Utility->__FormatDate($school['School']['modified']); ?></div>
			</div>
		</li>
	</ul>
</div>

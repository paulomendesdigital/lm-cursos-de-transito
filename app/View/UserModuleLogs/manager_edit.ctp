<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserModuleLog View
 *
*/ ?><div class="page-header">
    <div class="page-title">
        <h3>
        <?php echo __($this->params['controller']);?> 
                    <small>Editar cadastro</small>
                </h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>                    <?php echo $this->Html->addCrumb('Editar cadastro', '');?>                <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('UserModuleLog', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                	<?php
		 echo $this->Form->input('id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>__('id')));
		 echo $this->Form->input('user_id', array('class' => 'form-control', 'data-mask' => 'user_id', 'label'=>__('user_id')));
		 echo $this->Form->input('module_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>__('module_id')));
		 echo $this->Form->input('module_discipline_id', array('class' => 'form-control', 'data-mask' => 'module_discipline_id', 'label'=>__('module_discipline_id')));
		 echo $this->Form->input('model', array('class' => 'form-control', 'data-mask' => 'model', 'label'=>__('model')));
		 echo $this->Form->input('modelid', array('class' => 'form-control', 'data-mask' => 'modelid', 'label'=>__('modelid')));
		 echo $this->Form->input('time', array('class' => 'form-control', 'data-mask' => 'time', 'label'=>__('time')));
	?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
     <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>


<?php echo $this->Form->end(); ?>

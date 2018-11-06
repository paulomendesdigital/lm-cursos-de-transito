<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserQuestion View
 *
*/ ?><div class="page-header">
    <div class="page-title">
        <h3>
        <?php echo __($this->params['controller']);?> 
                    <small>Adicionar novo</small>
                </h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>                    <?php echo $this->Html->addCrumb('Adicionar novo', '');?>                <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('UserQuestion', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                	<?php
		 echo $this->Form->input('user_id', array('class' => 'form-control', 'data-mask' => 'user_id', 'label'=>__('user_id')));
		 echo $this->Form->input('model', array('class' => 'form-control', 'data-mask' => 'model', 'label'=>__('model')));
		 echo $this->Form->input('modelid', array('class' => 'form-control', 'data-mask' => 'modelid', 'label'=>__('modelid')));
		 echo $this->Form->input('value_avaliation', array('class' => 'form-control', 'data-mask' => 'value_avaliation', 'label'=>__('value_avaliation')));
		 echo $this->Form->input('value_result', array('class' => 'form-control', 'data-mask' => 'value_result', 'label'=>__('value_result')));
		 echo $this->Form->input('result', array('class' => 'form-control', 'data-mask' => 'result', 'label'=>__('result')));
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

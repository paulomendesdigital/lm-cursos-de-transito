<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Cart View
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

<?php echo $this->Form->create('Cart', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                	<?php
		 echo $this->Form->input('id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>__('id'), 'empty' => 'Selecione'));
		 echo $this->Form->input('product_id', array('class' => 'form-control', 'data-mask' => 'product_id', 'label'=>__('product_id'), 'empty' => 'Selecione'));
		 echo $this->Form->input('amount', array('class' => 'form-control', 'data-mask' => 'amount', 'label'=>__('amount'), 'empty' => 'Selecione'));
		 echo $this->Form->input('unitary_value', array('class' => 'form-control', 'data-mask' => 'unitary_value', 'label'=>__('unitary_value'), 'empty' => 'Selecione'));
		 echo $this->Form->input('unitary_discount', array('class' => 'form-control', 'data-mask' => 'unitary_discount', 'label'=>__('unitary_discount'), 'empty' => 'Selecione'));
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

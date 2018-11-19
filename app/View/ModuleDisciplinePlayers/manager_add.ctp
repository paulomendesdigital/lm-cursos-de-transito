<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDisciplinePlayer View
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

<?php echo $this->Form->create('ModuleDisciplinePlayer', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                	<?php
		 echo $this->Form->input('module_discipline_id', array('class' => 'form-control', 'data-mask' => 'module_discipline_id', 'label'=>__('module_discipline_id')));
		 echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
		 echo $this->Form->input('embed_player', array('class' => 'form-control', 'data-mask' => 'embed_player', 'label'=>__('embed_player')));

                                ?>

                                <div class='form-group'>

                                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>

                                    <div class='col-sm-10'>

                                        <a class='btn <?php echo isset($this->request->data['ModuleDisciplinePlayer']['status']) ? $this->request->data['ModuleDisciplinePlayer']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
<?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
<a class='btn <?php echo isset($this->request->data['ModuleDisciplinePlayer']['status']) ? $this->request->data['ModuleDisciplinePlayer']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>

                                    </div>

                                </div>

                                <?php

                                		 echo $this->Form->input('position', array('class' => 'form-control', 'data-mask' => 'position', 'label'=>__('position')));
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

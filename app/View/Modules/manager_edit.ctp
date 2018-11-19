
<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Module View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?><small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('Module', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
		        echo $this->Form->input('id');
                echo $this->Form->input('course_type_id', array('class' => 'form-control', 'data-mask' => 'course_type_id', 'label'=>__('course_type_id')));
                echo $this->Form->input('is_introduction', array('type' => 'checkbox','class' => 'switch', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_introduction', 'label'=> __('is_introduction')));
		        echo $this->Form->input('is_default', array('type' => 'checkbox','class' => 'switch', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'is_default', 'label'=> __('Módulo Padrão?')));
                echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
		        echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder', 'label'=>__('text')));
		        echo $this->Form->input('value_time', array('class' => 'form-control', 'data-mask' => 'value_time', 'label'=>__('value_time'),'after'=>'<p class="help-block">Cadastrar tempo total em horas.</p>'));
                echo $this->Form->input('exam_discipline_code_id', array('class' => 'form-control', 'empty' => ' ', 'label'=>__('exam_discipline_code_id')));
		        ?>
                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['Module']['status']) ? $this->request->data['Module']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['Module']['status']) ? $this->request->data['Module']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                    </div>
                </div>
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

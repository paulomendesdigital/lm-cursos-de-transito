<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Instructor View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('Instructor', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li><a href="#access" data-toggle="tab">Dados de Acesso</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php 
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('user_id');
                echo $this->Form->input('name', array('class'=>'form-control','label'=>__('name')));
                echo $this->Form->input('text', array('class'=>'form-control ckeditor', 'id'=>'ckfinder', 'label'=>__('text')));
                ?>
                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['Instructor']['status']) ? $this->request->data['Instructor']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('status', array('type'=>'hidden','data-toggle'=>'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['Instructor']['status']) ? $this->request->data['Instructor']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="access">
            	<?php 
                //echo $this->Form->hidden('User.id');
		        echo $this->Form->hidden('User.group_id');
		        echo $this->Form->input('User.name', array('class'=>'form-control','label'=>__('name'),'readonly'=>true));
                echo $this->Form->input('User.cpf',  array('class'=>'form-control','label'=>__('cpf'),'data-mask'=>'cpf'));
		        echo $this->Form->input('User.username',  array('class'=>'form-control','label'=>__('username'),'readonly'=>true));
                ?>
                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['User']['status']) ? $this->request->data['User']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('User.status', array('type'=>'hidden','data-toggle'=>'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['User']['status']) ? $this->request->data['User']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
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

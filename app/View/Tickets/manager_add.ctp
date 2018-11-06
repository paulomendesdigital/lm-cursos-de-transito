<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Ticket View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?><small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>
    </ul>
</div>

<?php echo $this->Form->create('Ticket', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li class=""><a href="#courses" data-toggle="tab">Cursos Excluídos deste Desconto</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
                echo $this->Form->hidden('user_id',['value'=>$this->Session->read('Auth.User.id')]);
                echo $this->Form->input('code', array('class'=>'form-control', 'label'=>__('code')));
                //echo $this->Form->input('type', array('class' => 'form-control', 'data-mask' => 'type', 'label'=>__('type'), 'empty' => 'Selecione'));
                echo $this->Form->input('value', array('class'=>'form-control','placeholder'=>'0.00', 'data-mask'=>'value', 'label'=>__('value') .' (%)', 'type' => 'text'));
                echo $this->Form->input('amount', array('class'=>'form-control','data-mask'=>'number', 'label'=>__('amount')));
                echo $this->Form->input('start', array('type'=>'text','class'=>'form-control','data-mask'=>'date','label'=>__('start')));
                echo $this->Form->input('finish', array('type'=>'text','class'=>'form-control','data-mask'=>'date','label'=>__('finish')));
                echo $this->Form->input('status', array('class'=>'form-control', 'label'=>__('status'), 'type' => 'checkbox', 'class' => 'switch', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não'));
                //echo $this->Form->input('user_id', array('class' => 'form-control', 'data-mask' => 'user_id', 'label'=>__('user_id'), 'empty' => 'Selecione'));
                echo $this->Form->input('commission', array('class'=>'form-control', 'label'=>__('commission')));
                ?>
            </div>
            <div class="tab-pane fade in" id="courses">
                <?php 
                echo $this->Form->input('Course', array(
                    'type' => 'select',
                    'multiple' => 'checkbox',
                    'options' => $courses,
                    'selected' => $this->Html->value('Course.Course'),
                ));?>
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

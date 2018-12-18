<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Order View
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

<?php echo $this->Form->create('Order', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li><a href="#options" data-toggle="tab">Cursos</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
                 echo $this->Form->input('id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>__('id')));
                 echo $this->Form->input('order_type_id', array('class' => 'form-control', 'data-mask' => 'order_type_id', 'label'=>__('order_type_id')));
                 echo $this->Form->input('user_id', array('class' => 'form-control', 'data-mask' => 'user_id', 'label'=>__('user_id')));
                ?>
            </div>

            <div class="tab-pane" id="options">
                <div class="row">
                    <div class="col-md-4"><h6>Curso</h6></div>
                    <div class="col-md-1"><h6>Estados</h6></div>
                    <div class="col-md-2"><h6>Cidades</h6></div>
                    <div class="col-md-2"><h6>Renach</h6></div>
                    <div class="col-md-1"><h6>Categoria</h6></div>
                    <div class="col-md-2"><h6>Valor</h6></div>
                </div>

                <div data-toggle="courses">
                    <?php foreach($this->request->data['OrderCourse'] as $key => $OrderCourse):?>
                        <div data-toggle="course<?php echo $key;?>">
                            <div data-toggle="formCourse<?php echo $key;?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <?php echo $this->Form->input('OrderCourse.'.$key.'.id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>false)); ?>
                                        <a onclick="removeOrderCourse(<?php echo $key;?>)" class="btn btn-link btn-icon btn-xs pull-left" title="Remover curso <?php echo $key;?>"><i class="icon-remove3 text-danger"></i></a>
                                        <?php echo $this->Form->input('OrderCourse.'.$key.'.course_id', array('type' => 'select','class' => 'form-control', 'label'=> false, 'options' => $courses, 'data-reference' => 'course')); ?>
                                    </div>
                                    
                                    <div class="col-md-1"><?php echo $this->Form->input('OrderCourse.'.$key.'.state_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false, 'div' => false, 'empty' => 'Selecione', 'data-reference' => 'state', 'onchange' => 'stateChange(this, \'OrderCourse\', '.$key.')')); ?></div>
                                    
                                    <div class="col-md-2"><?php echo $this->Form->input('OrderCourse.'.$key.'.citie_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>false, 'div' => false, 'options' => isset($OrderCourse['Citie']['id']) ? [$OrderCourse['Citie']['id'] => $OrderCourse['Citie']['name']]  : [] )); ?></div>
                                    
                                    <div class="col-md-2"><?php echo $this->Form->input('OrderCourse.'.$key.'.renach', array('class' => 'form-control', 'label'=>false, 'div' => false)); ?></div>
                                    
                                    <div class="col-md-1"><?php echo $this->Form->input('OrderCourse.'.$key.'.cnh_category', array('class' => 'form-control', 'label'=>false, 'div' => false, 'options' => $cnhCategories)); ?></div>
                                    
                                    <div class="col-md-2"><?php echo $this->Form->input('Order.value', array('class' => 'form-control', 'label'=>false, 'div' => false)); ?></div>
                                </div>
                             </div>
                        </div>
                    <?php endforeach;?>
                 </div>
                <a data-toggle="addOrderCourse" class="btn btn-icon btn-primary" title="Adicionar novo curso"><i class="icon-plus"></i></a>
                <input type="hidden" data-toggle="countOrderCourse" value="<?php echo count($this->request->data['OrderCourse']);?>">
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

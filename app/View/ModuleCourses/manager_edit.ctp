<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleCourse View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Módulos para: <b><?php echo $course['Course']['name'];?></b> <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Curso'), '/manager/courses/edit/'.$course['Course']['id']);?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('ModuleCourse', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
                 echo $this->Form->hidden('id');
                 echo $this->Form->input('course', array('class' => 'form-control', 'disabled' => true, 'value'=>$course['Course']['name'], 'label'=>__('module_id')));
                 echo $this->Form->input('module_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>__('module_id')));
                 echo $this->Form->input('course_id', array('type' => 'hidden', 'value' => $course['Course']['id']));

                if( $course['CourseType']['scope'] != CourseType::AMBITO_NACIONAL ){
                    echo $this->Form->input('state_id', array('empty'=>'Selecione','data-toggle'=>'returnOneState', 'class' => 'form-control', 'data-mask' => 'state_id', 'label'=>__('state_id')));
                }

                if( $course['CourseType']['scope'] == CourseType::AMBITO_MUNICIPAL ){
                    echo $this->Form->input('citie_id', array('data-toggle'=>'returnCity', 'class' => 'form-control', 'data-mask' => 'citie_id', 'label'=>__('citie_id')));
                }

                 echo $this->Form->input('position', array('class' => 'form-control', 'data-mask' => 'position', 'label'=>__('position')));
               ?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>


<?php echo $this->Form->end(); ?>

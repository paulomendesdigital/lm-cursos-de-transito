<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Compose View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Módulo <?php echo $module['Module']['name'];?></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
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
                echo $this->Form->input('ModuleCourse.modulo', array('label'=>'Módulo','class'=>'form-control', 'readonly'=>true,'value'=>$module['Module']['name']));        
                echo $this->Form->input('ModuleCourse.module_id', array('type'=>'hidden', 'value'=>$module['Module']['id']));		 
                echo $this->Form->input('ModuleCourse.course_id', array('class'=>'form-control','empty' =>'Selecione', 'options'=>$courses, 'required'=>true, 'label'=>__('name')));
		        
                if( $module['CourseType']['scope'] != CourseType::AMBITO_NACIONAL ){
                    echo $this->Form->input('ModuleCourse.state_id',  array('class'=>'form-control','empty' => 'Selecione','options'=>$states, 'data-toggle'=>'returnCourseStateCompose','label'=>__('Estados')));
                }
                ?>
                <?php if( $module['CourseType']['scope'] == CourseType::AMBITO_MUNICIPAL ):?>
                    <div class="row">
                        <div class="col-md-12" data-toggle="returnCourseCity"></div>
                    </div>
                <?php endif;?>
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

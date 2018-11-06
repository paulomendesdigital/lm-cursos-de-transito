<?php /**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseState View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$course_type_id);?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('CourseState', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

    <div class="block">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            </ul>
            <div class="tab-content with-padding">
                <div class="tab-pane fade in active" id="details">
                    <?php 
                    echo $this->Form->hidden('course_type_id', array('value'=>$course_type_id));
                    echo $this->Form->input('state_id', array('class'=>'form-control', 'data-toggle'=>'returnCourseState', 'label'=>__('Estado')));
                    echo $this->Form->input('price', array('class'=>'form-control','data-mask'=>'price','label'=>__('Preço do curso neste Estado')));
                    echo $this->Form->input('scheduling_link_detran', array('class'=>'form-control','label'=>__('Link de agendamento da Prova do Detran')));
                    echo $this->Form->input('status', array('type' => 'hidden', 'value' => 1));
                    echo $this->Form->input('order_in_school', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'order_in_school', 'label'=> ['text' => __('Vender apenas na Auto-Escola?'), 'class' => 'col-sm-2 control-label text-right'], 'divControls' => ['class' => 'col-sm-10'], 'helpBlock' => 'Vender este curso, no Estado selecionado, apenas nas auto-escolas?'));
                    echo $this->Form->input('description', array('class' => 'form-control ckeditor', 'id'=>'ckfinder1', 'label'=> 'Descrição'));
                    echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder2', 'label'=> 'Texto'));
                    ?>

                    <div class="row">
                        <div class="col-md-12" data-toggle="returnCourseCity"></div>
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
<?php echo $this->Form->end();

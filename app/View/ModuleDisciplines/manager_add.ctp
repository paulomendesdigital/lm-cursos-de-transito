<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDiscipline View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$module_id);?><?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('ModuleDiscipline', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <!-- <li><a href="#sliders" data-toggle="tab">Sliders</a></li>
            <li><a href="#players" data-toggle="tab">Vídeos</a></li> -->
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php 
                if( $module_id ){
                  echo $this->Form->input('module_id', array('type'=>'hidden','value'=>$module_id));
                  echo $this->Form->input('module', array('class'=>'form-control','disabled'=>true,'label'=>__('module_id'),'value'=>"{$module['CourseType']['name']} :: {$module['Module']['name']}",'type'=>'text'));
                  echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                  echo $this->Form->input('position', array('class' => 'form-control', 'value' => $module['Module']['module_discipline_count']+1, 'label'=>__('position')));
                }else{
                  echo $this->Form->input('module_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>__('module_id')));  
                  echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                  echo $this->Form->input('position', array('class' => 'form-control', 'data-mask' => 'position', 'label'=>__('position')));
                }
                echo $this->Form->input('value_time', array('class' => 'form-control', 'data-mask' => 'value_time', 'label'=>__('value_time'),'after'=>'<p class="help-block">Cadastrar tempo total em horas.</p>'));
                echo $this->Form->input('discipline_code_id', array('class' => 'form-control', 'empty' => ' ', 'label'=> __('discipline_code_id')));
                echo $this->Form->input('status', array('type' => 'hidden', 'value' => 1));
                ?>
            </div>
            <div class="tab-pane fade in" id="sliders">
                <div data-toggle="sliders">
                    <div data-alert="ModuleDisciplineSlider" class="alert alert-warning fade in block">
                        <i class="icon-info"></i> Não há Sliders cadastrados.
                    </div>
                 </div>
                 <a data-toggle="addModuleDisciplineSlider" class="btn btn-icon btn-primary" title="Adicionar novo slide"><i class="icon-plus"></i></a>
                 <input type="hidden" data-toggle="countModuleDisciplineSlider" value="1">
            </div>
            <div class="tab-pane fade in" id="players">
                <div data-toggle="players">
                    <div data-alert="ModuleDisciplinePlayer" class="alert alert-warning fade in block">
                        <i class="icon-info"></i> Não há Sliders cadastrados.
                    </div>
                 </div>
                 <a data-toggle="addModuleDisciplinePlayer" class="btn btn-icon btn-primary" title="Adicionar novo vídeo"><i class="icon-plus"></i></a>
                 <input type="hidden" data-toggle="countModuleDisciplinePlayer" value="1">
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

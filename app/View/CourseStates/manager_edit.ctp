<?php /**
 * @copyright Copyright 2018/2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseState View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$this->request->data['CourseState']['course_type_id']);?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('CourseState', array('class'=>'form-horizontal','role'=>'form','type'=>'file'));?>
    <div class="block">
        <div class="col-md-12">
            <?php 
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('course_type_id');
                echo $this->Form->hidden('state_id');
                echo $this->Form->input('state', array('type'=>'text','class'=>'form-control','disabled'=>true,'label'=>__('Estado'),'value'=>$states[$this->request->data['CourseState']['state_id']]));
                echo $this->Form->input('price', array('class'=>'form-control','data-mask'=>'price','label'=>__('Preço por Estado')));
                echo $this->Form->input('scheduling_link_detran', array('class'=>'form-control','label'=>__('Link de agendamento da Prova do Detran')));
                echo $this->Form->input('status', array('type' => 'hidden', 'value' => 1));
                echo $this->Form->input('order_in_school', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'order_in_school', 'label'=> ['text' => __('Vender apenas na Auto-Escola?'), 'class' => 'col-sm-2 control-label text-right'], 'divControls' => ['class' => 'col-sm-10'], 'helpBlock' => 'Vender este curso, no Estado selecionado, apenas nas auto-escolas?'));
                echo $this->Form->input('status', array('type' => 'checkbox','class' => 'switch switch-mini', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não', 'label'=> ['text' => __('Ativo'), 'class' => 'col-sm-2 control-label text-right'], 'divControls' => ['class' => 'col-sm-10']));
                echo $this->Form->input('description', array('class' => 'form-control ckeditor', 'id'=>'ckfinder1', 'label'=> 'Descrição'));
                echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder2', 'label'=> 'Texto'));
            ?>
        </div>
    </div>
    <!-- Form Actions -->
    <div class="form-actions text-right">
         <?php echo $this->Html->link('Cancelar', array('action' => 'index',$course_type_id), array('class' => 'btn btn-danger')); ?>
         <input type="submit" class="btn btn-primary" value="Salvar este Bloco" name="aplicar" >
        <input type="submit" class="btn btn-success" value="Finalizar">
    </div>
<?php echo $this->Form->end();?>

    <div class="block">
        <div class="tabbable">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#details" data-toggle="tab"><i class="icon-checkmark3"></i> Cidades Liberadas</a></li>
                <?php if( !empty($newCities) ): $tab=1;?>
                    <?php foreach( $newCities as $nCity ):?>
                        <li><a href="#tab-<?php echo $tab;?>" data-toggle="tab"><i class="icon-plus-circle"></i> Liberar Cidades</a></li>
                    <?php $tab++; endforeach;?>
                <?php endif;?> 
            </ul>
            <div class="tab-content with-padding">
                <div class="tab-pane fade in active" id="details">
                    <?php echo $this->Form->create('CourseState', array('class'=>'form-horizontal','role'=>'form','type'=>'file'));?>
                        <?php 
                            echo $this->Form->hidden('id');
                            echo $this->Form->hidden('course_type_id');
                            echo $this->Form->hidden('state_id');
                            echo $this->Form->input('price', array('type' => 'hidden', 'data-mask'=>'price'));
                            echo $this->Form->hidden('status');
                        ?>
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo $this->Element('manager/cities_course',['tab'=>'0','edit'=>true,'cities'=>$this->request->data['CourseCity']]);?>
                            </div>
                        </div>
                        <!-- Form Actions -->
                        <div class="form-actions text-right">
                             <?php echo $this->Html->link('Cancelar', array('action' => 'index',$course_type_id), array('class' => 'btn btn-danger')); ?>
                             <input type="submit" class="btn btn-primary" value="Salvar este Bloco" name="aplicar" >
                            <input type="submit" class="btn btn-success" value="Finalizar">
                        </div>
                    <?php echo $this->Form->end();?>
                </div>
                <?php $tab = 1; foreach( $newCities as $nCity ):?>
                    <div class="tab-pane fade in" id="tab-<?php echo $tab;?>">
                        <?php echo $this->Form->create('CourseState', array('class'=>'form-horizontal','role'=>'form','type'=>'file'));?>
                            <?php 
                                echo $this->Form->hidden('id');
                                echo $this->Form->hidden('course_type_id');
                                echo $this->Form->hidden('state_id');
                                echo $this->Form->input('price', array('type' => 'hidden', 'data-mask'=>'price'));
                                echo $this->Form->hidden('status');
                            ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $this->Element('manager/cities_course',['tab'=>$tab,'nCities'=>$nCity]);?>
                                </div>
                            </div>
                            <!-- Form Actions -->
                            <div class="form-actions text-right">
                                 <?php echo $this->Html->link('Cancelar', array('action' => 'index',$course_type_id), array('class' => 'btn btn-danger')); ?>
                                 <input type="submit" class="btn btn-primary" value="Salvar este Bloco" name="aplicar" >
                                <input type="submit" class="btn btn-success" value="Finalizar">
                            </div>
                        <?php echo $this->Form->end();?>
                    </div>
                <?php $tab++; endforeach;?>
            </div>
        </div>
    </div><!-- /block-->

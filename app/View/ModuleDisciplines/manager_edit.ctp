<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * ModuleDiscipline View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$this->request->data['ModuleDiscipline']['module_id']);?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('ModuleDiscipline', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details"  data-toggle="tab">Dados de cadastro</a></li>
            <li><a href="#sliders" data-toggle="tab">Sliders</a></li>
            <li><a href="#players" data-toggle="tab">Vídeos</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
               	<?php
                echo $this->Form->input('id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>__('id')));
                echo $this->Form->input('module_id', array('class' => 'form-control', 'data-mask' => 'module_id', 'label'=>__('module_id')));
                echo $this->Form->input('name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                echo $this->Form->input('position', array('class' => 'form-control', 'data-mask' => 'position', 'label'=>__('position')));
                echo $this->Form->input('value_time', array('class' => 'form-control', 'data-mask' => 'value_time', 'label'=>__('value_time'),'after'=>'<p class="help-block">Cadastrar tempo total em horas.</p>'));
                echo $this->Form->input('discipline_code_id', array('class' => 'form-control', 'empty' => ' ', 'label'=> __('discipline_code_id')));
                ?>
                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['ModuleDiscipline']['status']) ? $this->request->data['ModuleDiscipline']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['ModuleDiscipline']['status']) ? $this->request->data['ModuleDiscipline']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="sliders">
                <div data-toggle="sliders">
                    <?php $i=1; foreach ($this->request->data['ModuleDisciplineSlider'] as $key=>$ModuleDisciplineSlider):?>
                    <div data-toggle="slider<?php echo $i;?>">
                        <h6 class="heading-hr"><small class="display-block"><a onclick="toggleModuleDisciplineSlider(<?php echo $i;?>)" class="btn btn-link btn-icon btn-xs" title="Visualizar slider <?php echo $i;?>"><i class="icon-eye text-primary"></i></a> <a onclick="removeModuleDisciplineSlider(<?php echo $i;?>)" class="btn btn-link btn-icon btn-xs" title="Remover slider <?php echo $i;?>"><i class="icon-remove3 text-danger"></i></a> Cadastro de slider <?php echo $i;?></small></h6>
                        <div data-toggle="formSlider<?php echo $i;?>">
                            <?php
                            echo $this->Form->input('ModuleDisciplineSlider.'.$key.'.id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>__('id')));
                            echo $this->Form->input('ModuleDisciplineSlider.'.$key.'.name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                             echo $this->Form->input('ModuleDisciplineSlider.'.$key.'.text', array('class' => 'form-control ckeditor', 'label'=>__('text')));
                             echo $this->Form->input('ModuleDisciplineSlider.'.$key.'.audio', array('type' => 'file','class' => 'form-control', 'label'=>__('audio')));
                             echo $this->Form->input('ModuleDisciplineSlider.'.$key.'.position', array('class' => 'form-control', 'data-mask' => 'position', 'label'=>__('position')));
                             echo $this->Form->input('ModuleDisciplineSlider.'.$key.'.status', array('type' => 'select','class' => 'form-control', 'label'=> __('status'), 'options' => [0 => 'Inativo', 1 => 'Ativo']));
                             ?>
                             <script>
                                 var editor =
                                CKEDITOR.replace( 'data[ModuleDisciplineSlider]['<?php echo $key;?>'][text]', {
                                    toolbar: 'Page',
                                    width: '700',
                                    height: '280',
                                    filebrowserBrowseUrl : '/js/manager/ckfinder/ckfinder.html',
                                    filebrowserImageBrowseUrl : '/js/manager/ckfinder/ckfinder.html?type=Images',
                                    filebrowserFlashBrowseUrl : '/js/manager/ckfinder/ckfinder.html?type=Flash',
                                    filebrowserUploadUrl : '/js/manager/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                    filebrowserImageUploadUrl : '/js/manager/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                    filebrowserFlashUploadUrl : '/js/manager/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                                });
                             </script>
                         </div>
                    </div>
                    <?php $i++; endforeach;?>
                    <?php if(!$this->request->data['ModuleDisciplineSlider']): ?>
                        <div data-alert="ModuleDisciplineSlider" class="alert alert-warning fade in block">
                            <i class="icon-info"></i> Não há Sliders cadastrados.
                        </div>
                    <?php endif; ?>
                 </div>

                 <a data-toggle="addModuleDisciplineSlider" class="btn btn-icon btn-primary" title="Adicionar novo slide"><i class="icon-plus"></i></a>
                 <input type="hidden" data-toggle="countModuleDisciplineSlider" value="<?php echo count($this->request->data['ModuleDisciplineSlider']);?>">
            </div>
            <div class="tab-pane fade in" id="players">

                <div data-toggle="players">
                    <?php $i=1; foreach ($this->request->data['ModuleDisciplinePlayer'] as $key=>$ModuleDisciplinePlayer):?>
                    <div data-toggle="player<?php echo $i;?>">
                        <h6 class="heading-hr"><small class="display-block"><a onclick="toggleModuleDisciplinePlayer(<?php echo $i;?>)" class="btn btn-link btn-icon btn-xs" title="Visualizar vídeo <?php echo $i;?>"><i class="icon-eye text-primary"></i></a> <a onclick="removeModuleDisciplinePlayer(<?php echo $i;?>)" class="btn btn-link btn-icon btn-xs" title="Remover vídeo <?php echo $i;?>"><i class="icon-remove3 text-danger"></i></a> Cadastro de vídeo <?php echo $i;?></small></h6>
                        <div data-toggle="formPlayer<?php echo $i;?>">
                            <?php
                            echo $this->Form->input('ModuleDisciplinePlayer.'.$key.'.id', array('class' => 'form-control', 'data-mask' => 'id', 'label'=>__('id')));
                            echo $this->Form->input('ModuleDisciplinePlayer.'.$key.'.name', array('class' => 'form-control', 'data-mask' => 'name', 'label'=>__('name')));
                             echo $this->Form->input('ModuleDisciplinePlayer.'.$key.'.embed_player', array('class' => 'form-control', 'label'=>__('embed_player')));
                             echo $this->Form->input('ModuleDisciplinePlayer.'.$key.'.position', array('class' => 'form-control', 'data-mask' => 'position', 'label'=>__('position')));
                             echo $this->Form->input('ModuleDisciplinePlayer.'.$key.'.status', array('type' => 'select','class' => 'form-control', 'label'=> __('status'), 'options' => [0 => 'Inativo', 1 => 'Ativo']));
                             ?>
                         </div>
                    </div>
                    <?php $i++; endforeach;?>
                    <?php if(!$this->request->data['ModuleDisciplinePlayer']): ?>
                        <div data-alert="ModuleDisciplinePlayer" class="alert alert-warning fade in block">
                            <i class="icon-info"></i> Não há Sliders cadastrados.
                        </div>
                    <?php endif; ?>
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

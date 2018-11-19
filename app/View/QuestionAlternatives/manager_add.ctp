<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * QuestionAlternative View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index/'.$module_id);?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="callout callout-info fade in hidden-xs">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h5>Adicionar Questões para Simulados e Provas</h5>
    <p>As questões são vinculadas ao módulo específico e o sistema faz a escolha de qual exibir automaticamente e aleatóreamente na área do aluno.</p>
</div>

<?php echo $this->Form->create('QuestionAlternative', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados de cadastro</a></li>
            <li><a href="#options" data-toggle="tab">Respostas</a></li>
            <li><a href="#feedback" data-toggle="tab">Feedback</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php 
                echo $this->Form->hidden('urlReturn', ['value'=>$urlReturn]);
                if( empty($module) ){
                    echo $this->Form->input('module_id', ['class'=>'form-control','multiple'=>true,'required'=>true,'empty'=>'Selecione']);
                }else{
                    echo $this->Form->input('module_id', ['type'=>'hidden','value'=>$module['Module']['id']]);
                    echo $this->Form->input('module', ['type'=>'text','class'=>'form-control','disabled'=>true, 'value'=>"{$module['CourseType']['name']} :: {$module['Module']['name']}"]);
                }
		        echo $this->Form->input('text', ['class'=>'form-control ckeditor','id'=>'ckfinder','label'=>__('Pergunta?')]);
                ?>
                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['QuestionAlternative']['status']) ? $this->request->data['QuestionAlternative']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['QuestionAlternative']['status']) ? $this->request->data['QuestionAlternative']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="options">
                <div class="row">
                    <div class="col-md-8"><h6>Alternativa</h6></div>
                    <div class="col-md-2"><h6>Correta?</h6></div>
                    <div class="col-md-2"><h6>Status</h6></div>
                </div>

                <div data-toggle="alternatives">
                    <div data-alert="QuestionAlternativeOption" class="alert alert-warning fade in block">
                        <i class="icon-info"></i> Não há respostas cadastrados.
                    </div>
                 </div>
                <a data-toggle="addQuestionAlternativeOption" class="btn btn-icon btn-primary" title="Adicionar novo módulo"><i class="icon-plus"></i></a>
                <input type="hidden" data-toggle="countQuestionAlternativeOption" value="0">
            </div>
            <div class="tab-pane fade in active" id="feedback">
                <?php echo $this->Form->input('feedback', ['class'=>'form-control ckeditor', 'label'=>__('Feedback')]);?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" >
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>


<?php echo $this->Form->end(); ?>

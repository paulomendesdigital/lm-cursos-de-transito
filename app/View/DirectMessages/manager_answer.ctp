<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * DirectMessage View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Responder ao Aluno</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="block">
    <?php foreach($directMessages as $direct_message):?>
        <?php $author = $this->Utility->__getAuthor($direct_message['DirectMessage']['author']);?>
        <div class="panel panel-default paper-shadow" data-z="0.5" data-hover-z="1" data-animated="">
            <div class="panel-body">
                <div class="media v-middle">
                    <div class="media-left">
                         <?php 
                        if( $author == 'User' ){
                            echo $this->Utility->avatarUser($direct_message['User']['id'], $direct_message['User']['avatar'], 'media-object img-circle width-50');
                        }else{
                            echo $this->Utility->avatarUser($direct_message['Instructor']['User']['id'], $direct_message['Instructor']['User']['avatar'], 'media-object img-circle width-50');
                        }?>
                    </div>
                    <div class="media-body message">
                        <h4 class="text-subhead margin-none"><a href="#"><?php echo $direct_message[$author]['name'] ?></a></h4>
                        <p class="text-caption text-light"><i class="fa fa-clock-o"></i> <?php echo $this->Utility->clockTimeDiff($direct_message['DirectMessage']['diff']); ?></p>
                    </div>
                </div>
                <p><?php echo nl2br($direct_message['DirectMessage']['text']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php echo $this->Form->create('DirectMessage', array('class'=>'form-horizontal','role'=>'form'));?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados da mensagem</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php 
                echo $this->Form->hidden('user_id',['value'=>$user_id]);
                echo $this->Form->input('instructor_id', array('class' => 'form-control', 'data-mask' => 'instructor_id', 'label'=>__('instructor_id')));
		        echo $this->Form->input('text', array('class' => 'form-control ckeditor', 'id'=>'ckfinder', 'label'=>__('text')));
                echo $this->Form->input('view_user', array('type' => 'checkbox','class' => 'switch', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'view_user', 'label'=> __('view_user')));
                echo $this->Form->input('view_instructor', array('type' => 'checkbox','class' => 'switch', 'data-on' => 'success', 'data-off' => 'danger', 'data-on-label' => 'Sim', 'data-off-label' => 'Não','data-mask' => 'view_instructor', 'label'=> __('view_instructor')));
                ?>

                <div class='form-group'>
                    <label class='col-sm-2 control-label text-right'><?php echo __('status'); ?></label>
                    <div class='col-sm-10'>
                        <a class='btn <?php echo isset($this->request->data['DirectMessage']['status']) ? $this->request->data['DirectMessage']['status'] == 0 ? 'btn-danger' : '' : 'btn-danger'; ?> btn-sm' data-id='0' data-toggle='btnStatus'>Inativo</a>
                        <?php echo $this->Form->input('status', array('type' => 'hidden', 'data-toggle' => 'afferStatus'));?>
                        <a class='btn <?php echo isset($this->request->data['DirectMessage']['status']) ? $this->request->data['DirectMessage']['status'] == 1 ? 'btn-success' : '' : ''; ?> btn-sm' data-id='1' data-toggle='btnStatus'>Ativo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
    <input type="submit" class="btn btn-primary" value="Salvar" name="aplicar" />
    <input type="submit" class="btn btn-success" value="Finalizar" />
</div>


<?php echo $this->Form->end(); ?>

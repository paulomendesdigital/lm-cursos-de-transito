<?php /**
 * @copyright Copyright 2017
 * @author Dayvison Silva - www.dayvisonsilva.com.br
 * PollQuestion View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Questões da enquete "<?php echo $poll['Poll']['name'];?>" <small>Adicionar novo</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar Enquetes'), '/manager/'.$this->params['controller'].'/index/'.$poll['Poll']['id']);?>
        <?php echo $this->Html->addCrumb('Adicionar novo', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('PollQuestion', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados da Questão</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
                echo $this->Form->hidden('poll_id', array('value' => $poll['Poll']['id']));
                echo $this->Form->input('name', array('class' => 'form-control', 'label'=>__('name')));
               ?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <input type="submit" class="btn btn-success" value="Salvar">
</div>

<?php echo $this->Form->end(); ?>
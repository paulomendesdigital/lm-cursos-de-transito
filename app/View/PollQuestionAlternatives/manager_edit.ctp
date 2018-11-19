<?php /**
 * @copyright Copyright 2017
 * @author Dayvison Silva - www.dayvisonsilva.com.br
 * PollQuestion View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Alternativas "<?php echo $this->request->data['PollQuestion']['name'];?>" <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <?php echo $this->Html->link('<i class="icon-arrow-left"></i> Voltar para Questão', array('controller' => 'poll_questions', 'action' => 'edit', $this->request->data['PollQuestion']['id']), array('class' => 'btn btn-info', 'escape' => false)); ?>    
</div>

<?php echo $this->Form->create('PollQuestionAlternative', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados da Questão</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('poll_question_id');
                echo $this->Form->input('name', array('class' => 'form-control', 'label'=>__('name')));
               ?>
            </div>
        </div>
    </div>
</div><!-- /block-->

<!-- Form Actions -->
<div class="form-actions text-right">
    <?php echo $this->Html->link('Cancelar', array('action' => 'index'), array('class' => 'btn btn-danger')); ?>
    <input type="submit" class="btn btn-success" value="Finalizar">
</div>


<?php echo $this->Form->end(); ?>

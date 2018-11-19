<?php /**
 * @copyright Copyright 2017
 * @author Dayvison Silva - www.dayvisonsilva.com.br
 * PollQuestion View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>Questões da enquete "<?php echo $poll['Poll']['name'];?>" <small>Editar cadastro</small></h3>
    </div>
</div>
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar Enquetes'), '/manager/'.$this->params['controller'].'/index/'.$poll['Poll']['id']);?>
        <?php echo $this->Html->addCrumb('Editar cadastro', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<?php echo $this->Form->create('PollQuestion', array('class' => 'form-horizontal', 'role' => 'form', 'type' => 'file')); ?>

<div class="block">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#details" data-toggle="tab">Dados da Pergunta</a></li>
        </ul>
        <div class="tab-content with-padding">
            <div class="tab-pane fade in active" id="details">
                <?php
                echo $this->Form->hidden('id');
                echo $this->Form->hidden('poll_id', array('value' => $poll['Poll']['id']));
                echo $this->Form->input('name', array('class' => 'form-control', 'label'=>__('name')));
               ?>
               <div class="row">
               <div class="col-md-2">
                   <?php echo $this->Html->link(__('<span class="icon-plus"></span> alternativas'), 'javascript:void(0);', array('data-href'=>$this->Html->url(array('controller' => 'poll_question_alternatives', 'action' => 'add', $this->request->data['PollQuestion']['id'])),'class'=>'openPopup btn btn-icon btn-primary openPopup', 'escape' => false)); ?>
               </div>
               <div class="col-md-10">
                    <div class="table-responsive">
                        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
                            <thead>
                                <tr>
                                    <th>Alternativa</th>
                                    <th>status</th>
                                    <th class="actions"><?php echo __('Actions'); ?></th>
                                </tr>
                            </thead>
                            <tbody data-toggle="libraries">
                                <?php foreach ($this->request->data['PollQuestionAlternative'] as $pollQuestionAlternative):?>
                                    <tr data-id="library-<?php echo $pollQuestionAlternative['id'];?>">
                                        <td><?php echo $pollQuestionAlternative['name']; ?></td>
                                        <td><?php echo $this->Utility->__FormatStatus($pollQuestionAlternative['status']); ?></td>
                                        <td class="actions">
                                            <?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('controller' => 'poll_question_alternatives', 'action' => 'edit', $pollQuestionAlternative['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
                                            <?php //echo $this->Html->link(__('<span class="icon-remove3"></span>'), array('controller' => 'poll_question_alternatives', 'action' => 'delete', $pollQuestionAlternative['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $pollQuestionAlternative['id'])); ?>
                                            <?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('controller' => 'poll_question_alternatives','action' => 'delete', $pollQuestionAlternative['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $pollQuestionAlternative['id'])); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if(!$this->request->data['PollQuestionAlternative']):?>
                                    <tr>
                                        <td colspan="6">Não há alternativas cadastradas.</td>
                                    </tr>
                                <?php endif;?>
                            </tbody>
                        </table>
                    </div><!-- /table-responsive-->
                </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="pollQuestionAlternatives">
                
                <br><br>
                <?php echo $this->Html->link(__('<span class="icon-plus"></span>'), array('controller' => 'poll_question_alternatives', 'action' => 'add', $this->request->data['PollQuestion']['id']), array('class' => 'btn btn-icon btn-primary', 'escape' => false)); ?>
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

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">fechar</button>
                <h4 class="modal-title">Alternativa</h4>
            </div>
            <div class="modal-body" style="padding: 20px;">

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.openPopup').on('click',function(){
            var dataURL = $(this).attr('data-href');
            $('.modal-body').load(dataURL,function(){
                $('#myModal').modal({show:true});
                $("#PollQuestionManagerEditForm").attr("action", dataURL);
            });
        }); 
    });
</script>
<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * DirectMessage View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($this->params['controller']);?> <small>Lista de resultados</small></h3>
    </div>

    <div class="visible-xs header-element-toggle">
        <a class="btn btn-primary btn-icon collapsed" data-toggle="collapse" data-target="#header-buttons"><i class="icon-insert-template"></i></a>
    </div>

    <div class="header-buttons">
        <div class="collapse" id="header-buttons" style="height: 0px;">
            <div class="well">
                <?php echo $this->Html->link(__('<i class="icon-plus-circle"></i> Novo Registro'),array('action'=>'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>            </div>
        </div>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>   
    </ul>
</div>

<?php echo $this->Search->create(null, array('class' => '','role'=>'form')); ?> 
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <?php echo $this->Search->input('instructor', array('class' => 'form-control', 'placeholder'=>'Instrutor', 'empty' => 'Instrutor'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-5">
        <div class="form-group">
        <?php echo $this->Search->input('student', array('class' => 'form-control', 'placeholder'=>'Aluno', 'empty' => 'Aluno'));?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('view_instructor', array('class' => 'form-control'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('view_user', array('class' => 'form-control'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-1">
        <div class="form-group">
        <?php echo $this->Search->input('status', array('class' => 'form-control', 'placeholder'=>'Status'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('data_de', array('class' => 'form-control data', 'placeholder'=>'Data Inicial', 'data-mask' => 'date'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('data_ate', array('class' => 'form-control data', 'placeholder'=>'Data Final', 'data-mask' => 'date'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <button class="btn btn-default" type="submit">Buscar</button>
    </div>
</div>
<?php echo $this->Search->end(); ?>
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id',__('id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('user_id',__('user_id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('instructor_id',__('instructor_id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('text',__('text', true)); ?></th>
                <th><?php echo $this->Paginator->sort('view_instructor',__('view_instructor', true)); ?></th>
                <th><?php echo $this->Paginator->sort('view_user',__('view_user', true)); ?></th>
                <th><?php echo $this->Paginator->sort('status',__('status', true)); ?></th>
                <th><?php echo $this->Paginator->sort('created',__('created', true)); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($directMessages as $directMessage): ?>
            	<tr>
            		<td><?php echo $this->Html->link($directMessage['DirectMessage']['id'], ['action' => 'answer', $directMessage['DirectMessage']['user_id'], $directMessage['DirectMessage']['instructor_id']]); ?></td>
            		<td><?php echo h($this->Text->truncate($directMessage['User']['name'], 30)); ?></td>
            		<td><?php echo h($directMessage['Instructor']['name']); ?></td>
                    <td><?php echo $this->Html->link($this->Text->truncate($directMessage['DirectMessage']['text'],30), ['action' => 'answer',$directMessage['DirectMessage']['user_id'], $directMessage['DirectMessage']['instructor_id']]); ?></td>
                    <td><?php echo $this->Utility->__FormatQuestion($directMessage['DirectMessage']['view_instructor']); ?></td>
                    <td><?php echo $this->Utility->__FormatQuestion($directMessage['DirectMessage']['view_user']); ?></td>
            		<td><?php echo $this->Utility->__FormatStatus($directMessage['DirectMessage']['status']); ?></td>
            		<td><?php echo $this->Utility->__FormatDate($directMessage['DirectMessage']['created']); ?></td>
            		<td class="actions">
                        <?php echo $this->Html->link(__('<span class="icon-reply"></span>'), array('action' => 'answer', $directMessage['DirectMessage']['user_id'], $directMessage['DirectMessage']['instructor_id']), array('class' => 'btn btn-warning btn-xs', 'escape' => false, 'title' => 'Responder')); ?>
            			<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $directMessage['DirectMessage']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false, 'title' => 'Visualizar')); ?>
            			<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('action' => 'edit', $directMessage['DirectMessage']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'title' => 'Editar')); ?>
            			<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('action' => 'delete', $directMessage['DirectMessage']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'title' => 'Excluir'), __('Are you sure you want to delete # %s?', $directMessage['DirectMessage']['id'])); ?>
            		</td>
            	</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<script>
    $(document).ready(function() {
        $('.data').datepicker({
            dateFormat: 'dd/mm/yy'
        });
    });
</script>

<?php echo $this->Element('manager/pagination'); ?>

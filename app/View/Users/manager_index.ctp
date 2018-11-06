<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * User View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($titlePage);?> <small>Lista de resultados</small></h3>
    </div>

    <div class="visible-xs header-element-toggle">
        <a class="btn btn-primary btn-icon collapsed" data-toggle="collapse" data-target="#header-buttons"><i class="icon-insert-template"></i></a>
    </div>

    <div class="header-buttons">
        <div class="collapse" id="header-buttons" style="height: 0px;">
            <div class="well">
                <?php echo $this->Html->link(__('<i class="icon-plus-circle"></i> Cadastrar'),array('action'=>$action_add, $group_id),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
            </div>
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
        <div class="col-sm-12 col-md-1">
            <div class="form-group">
            <?php echo $this->Search->input('filterId', array('class' => 'form-control', 'placeholder'=>'Id'));?> 
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <div class="form-group">
            <?php echo $this->Search->input('filterName',array('class'=>'form-control','placeholder'=>'Nome'));?> 
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
            <?php echo $this->Search->input('filterCpf',array('class'=>'form-control','placeholder'=>'Cpf','data-mask'=>'cpf'));?> 
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
            <?php echo $this->Search->input('filterStatus',array('class'=>'form-control','placeholder'=>'Status'));?> 
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
                <th><?php echo $this->Paginator->sort('name',__('name', true)); ?></th>
                <th><?php echo $this->Paginator->sort('username',__('username', true)); ?></th>
                <th><?php echo $this->Paginator->sort('cpf',__('cpf', true)); ?></th>
                <th><?php echo $this->Paginator->sort('status',__('status', true)); ?></th>
                <th><?php echo $this->Paginator->sort('created',__('created', true)); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            	<tr>
            		<td><?php echo h($user['User']['id']); ?></td>
            		<td><?php echo $this->Utility->__LimitText($user['User']['name']); ?></td>
                    <td><?php echo h($user['User']['username']); ?></td>
            		<td><?php echo h($user['User']['cpf']); ?></td>
            		<td><?php echo $this->Utility->__FormatStatus($user['User']['status']); ?></td>
            		<td><?php echo $this->Utility->__FormatDate($user['User']['created']); ?></td>
            		<td class="actions">
                        <?php echo $this->params['action'] == 'manager_students' ? $this->Html->link(__('<span class="icon-bars"></span>'), array('controller'=>'user_questions','action'=>'dashboard', $user['User']['id']), array('class'=>'btn btn-warning btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Relatório de Desempenho')) : ''; ?>
                        <?php echo $this->params['action'] == 'manager_students' ? $this->Html->link(__('<span class="icon-cart-plus"></span>'), array('controller'=>'orders','action'=>'add', $user['User']['id']), array('class'=>'btn btn-success btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Matricular Aluno')) : ''; ?>
        				<?php echo $this->params['action'] != 'manager_index'    ? $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Histórico')) : ''; ?>
            			<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('action' => $action_edit, $user['User']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Editar conta')); ?>
            			<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Exluir conta'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
            		</td>
            	</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<?php echo $this->Element('manager/pagination'); ?>
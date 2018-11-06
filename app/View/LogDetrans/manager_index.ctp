<div class="page-header">
    <div class="page-title">
        <h3><?php echo __('Logs de Integração c/ Detrans');?><small>Lista de resultados</small></h3>
    </div>

    <div class="visible-xs header-element-toggle">
        <a class="btn btn-primary btn-icon collapsed" data-toggle="collapse" data-target="#header-buttons"><i class="icon-insert-template"></i></a>
    </div>

    <div class="header-buttons">
        <div class="collapse" id="header-buttons" style="height: 0px;">
            <div class="well">

            </div>
        </div>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__('Logs'), '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>   
    </ul>
</div>

<?php echo $this->Search->create(null, array('class' => 'form-inline','role'=>'form')); ?>
<div class="row">
    <div class="form-group col-md-2">
        <?php echo $this->Search->input('filterCpf', array('class' => 'form-control', 'placeholder'=>'CPF', 'label' => 'CPF:&nbsp;'));?>
    </div>
    <div class="form-group col-md-3">
        <?php echo $this->Search->input('filterMatricula', array('class' => 'form-control', 'placeholder'=>'Matrícula', 'label' => 'Matrícula:&nbsp;'));?>
    </div>
    <div class="form-group col-md-2">
        <?php echo $this->Search->input('filterIntegracao', array('class' => 'form-control', 'empty' => 'Todas', 'label' => 'Integração:&nbsp;'));?>
    </div>

    <div class="form-group col-md-2">
        <?php echo $this->Search->input('filterRotina', array('class' => 'form-control', 'empty' => 'Todas', 'label' => 'Rotina:&nbsp;'));?>
    </div>

    <button class="btn btn-default" type="submit">Buscar</button>
    <hr>
</div>
<?php echo $this->Search->end(); ?>
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id',__('id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('data_log',__('Data e Hora', true)); ?></th>
                <th><?php echo $this->Paginator->sort('integracao',__('Integração', true)); ?></th>
                <th><?php echo $this->Paginator->sort('rotina',__('Rotina', true)); ?></th>
                <th><?php echo $this->Paginator->sort('codigo_retorno',__('Código Retorno', true)); ?></th>
                <th><?php echo $this->Paginator->sort('mensagem_retorno',__('Mensagem Retorno', true)); ?></th>
                <th><?php echo $this->Paginator->sort('cpf',__('CPF', true)); ?></th>
                <th><?php echo $this->Paginator->sort('renach',__('RENACH', true)); ?></th>
                <th><?php echo $this->Paginator->sort('order_id',__('Matrícula', true)); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?php echo h($log['LogDetran']['id']); ?></td>
                    <td><?php echo $this->Time->format($log['LogDetran']['data_log'], '%d/%m/%G %H:%M:%S'); ?></td>
                    <td><?php echo isset($integracoes[$log['LogDetran']['integracao']]) ? $integracoes[$log['LogDetran']['integracao']] : '';?></td>
                    <td><?php echo isset($rotinas[$log['LogDetran']['rotina']]) ? $rotinas[$log['LogDetran']['rotina']] : '';?></td>
                    <td><?php echo h($log['LogDetran']['codigo_retorno']); ?></td>
                    <td><?php echo h($log['LogDetran']['mensagem_retorno']); ?></td>
                    <td><?php echo h($log['LogDetran']['cpf']); ?></td>
                    <td><?php echo h($log['LogDetran']['renach']); ?></td>
                    <td><?php echo $this->Html->link($log['LogDetran']['order_id'], ['controller' => 'orders', 'action' => 'view', $log['LogDetran']['order_id']]); ?></td>
                    <td class="actions">
                        <?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $log['LogDetran']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<?php echo $this->element('manager/pagination'); ?>

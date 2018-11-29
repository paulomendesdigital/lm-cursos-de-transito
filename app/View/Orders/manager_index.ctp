<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Order View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3><?php echo __($pageTitle);?>s <small>Lista de resultados</small></h3>
    </div>

    <div class="visible-xs header-element-toggle">
        <a class="btn btn-primary btn-icon collapsed" data-toggle="collapse" data-target="#header-buttons"><i class="icon-insert-template"></i></a>
    </div>

    <div class="header-buttons">
        <div class="collapse" id="header-buttons" style="height: 0px;">
            <div class="well">
                <?php echo $this->Html->link(__('<i class="icon-plus-circle"></i> Gerar '.$pageTitle),array('action'=>'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>            </div>
        </div>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($pageTitle).'s', '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>   
    </ul>
</div>

<?php echo $this->Search->create(null, array('class' => '','role'=>'form')); ?> 
<div class="row">
    <div class="col-sm-12 col-md-1">
        <div class="form-group">
        <?php echo $this->Search->input('filter_id', array('type' => 'text', 'class' => 'form-control', 'placeholder'=>'Id'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
        <?php echo $this->Search->input('filter_nome', array('class'=>'form-control', 'placeholder'=>'Nome do Aluno'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filter_cpf', array('class'=>'form-control', 'placeholder'=>'CPF', 'data-mask'=>'cpf'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filter_status_pagamento', array('class' => 'form-control', 'empty' => 'Status Pagamento'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('filter_data_de', array('class' => 'form-control data', 'placeholder'=>'Data Inicial', 'data-mask' => 'date'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('filter_data_ate', array('class' => 'form-control data', 'placeholder'=>'Data Final', 'data-mask' => 'date'));?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <?php echo $this->Search->input('filter_curso', array('class' => 'form-control', 'empty' => 'Curso', 'id' => 'ReportCourseId', 'onchange' => 'courseReportChange(this)'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Form->input('filter.filter_estado', array('options' => $states, 'label' => false, 'div' => false, 'class' => 'form-control', 'empty' => 'Estado do Curso', 'id' => 'ReportStateId', 'onchange' => 'stateReportChange(this)'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Form->input('filter.filter_cidade', array('options' => $cities, 'label' => false, 'div' => false, 'class' => 'form-control', 'empty' => 'Cidade do Curso','id' => 'ReportCitieId'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
            <?php echo $this->Search->input('filter_status_detran', array('class' => 'form-control', 'empty' => 'Status Detran'));?>
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <button class="btn btn-default" type="submit">Buscar</button>
        <button id="btnLimparFiltros" class="btn btn-default" type="button">Limpar Filtros</button>
    </div>
</div>
<?php echo $this->Search->end(); ?>
<hr>
<div class="table-responsive">
    <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('id',__('id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('order_type_id',__('status', true)); ?></th>
                <th><?php echo $this->Paginator->sort('user_id',__('Alunos', true)); ?></th>
                <th><?php echo $this->Paginator->sort('User.cpf',__('CPF', true)); ?></th>
                <th><?php echo $this->Paginator->sort('created',__('Data da '.$pageTitle, true)); ?></th>
                <th><?php echo $this->Paginator->sort('sender',__('Vendedor', true)); ?></th>
                <th><?php echo 'Curso(s)'; ?></th>
                <th><?php echo 'UF'; ?></th>
                <th><?php echo 'Cidade'; ?></th>
                <th>Status Detran</th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order):
                $aprovado = $order['OrderType']['id'] == 3 || $order['OrderType']['id'] == 4;
                $intCountCursos = count($order['OrderCourse']);
                $bolMultiplo    = $intCountCursos > 1;
                $strRowspan = $bolMultiplo ? (' rowspan="' . ($intCountCursos + 1) . '"') : '';
                ?>
            	<tr>
            		<td<?php echo $strRowspan?>><?php echo  $this->Html->link($order['Order']['id'], ['action' => 'view', $order['Order']['id']], ['data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Matrícula']); ?></td>
            		<td<?php echo $strRowspan?>><?php echo $order['OrderType']['name']; ?></td>
            		<td<?php echo $strRowspan?>><?php echo $this->Html->link($order['User']['name'], array('controller' => 'users', 'action' => 'view', $order['User']['id']),array('data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Histórico do Aluno')); ?></td>
                    <td<?php echo $strRowspan?> style="white-space: nowrap"><?php echo $this->Html->link($order['User']['cpf'], array('controller' => 'users', 'action' => 'view', $order['User']['id']),array('data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Histórico do Aluno')); ?></td>
                    <td<?php echo $strRowspan?>><?php echo $this->Utility->__FormatDate($order['Order']['created']); ?></td>
                <?php if ($bolMultiplo) { ?>
                </tr>
                <?php } ?>
                <?php foreach ($order['OrderCourse'] as $c => $course) { ?>
                <?php if ($bolMultiplo) { ?>
                <tr>
                <?php } ?>
                    <td>
                        <?php echo (!empty($order['Order']['sender']) ? $order['Order']['sender'] : 'LM'); ?>
                    </td>
                    <td><?php echo $course['Course']['name']?></td>
                    <td><?php echo isset($course['State']['abbreviation']) ? $course['State']['abbreviation'] : ''?></td>
                    <td><?php echo isset($course['Citie']['name']) ? $course['Citie']['name'] : ''?></td>
                    <td><?php echo $this->Utility->__StatusDetran($course)?></td>

                    <?php if ($c == 0) { ?>
            		<td class="actions text-right"<?php echo $strRowspan?>>
                        <?php
                            if ($aprovado) {
                                foreach ($order['OrderCourse'] as $course) {
                                    if ($course['Course']['course_type_id'] == CourseType::RECICLAGEM || $course['Course']['course_type_id'] == CourseType::ESPECIALIZADOS) {
                                        echo $this->Html->link(__('<span class="icon-connection"></span>'), array('action' => 'recomunicar', $order['Order']['id']), array('class' => 'btn btn-warning btn-xs btn-connection', 'escape' => false, 'data-toggle' => 'tooltip', 'data-original-title' => 'Atualizar Detran'));
                                        break;
                                    }
                                }
                            }
                        ?>

            			<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $order['Order']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Histórico da Matrícula')); ?>
            			<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('action' => 'edit', $order['Order']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false,'data-toggle'=>'tooltip', 'data-original-title'=>'Editar Matrícula')); ?>
            			<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('action' => 'delete', $order['Order']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false, 'data-toggle'=>'tooltip', 'data-original-title'=>'Excluir Matrícula'), __('Are you sure you want to delete # %s?', $order['Order']['id'])); ?>
            		</td>
            		<?php } ?>
                <?php if ($bolMultiplo) { ?>
                </tr>
                <?php } ?>
            <?php } //end foreach cursos ?>
            <?php if (!$bolMultiplo) { ?>
            	</tr>
            <?php } ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<script>
    $(document).ready(function() {
        $('.data').datepicker({
            dateFormat: 'dd/mm/yy'
        });
        $('#btnLimparFiltros').on('click', function() {
            var form = $(this).parents('form:first');
            form.find(':input').val('');
            form.submit();
        });
    });
</script>

<?php echo $this->Element('manager/pagination'); ?>

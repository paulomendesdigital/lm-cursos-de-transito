<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Module View
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
                <?php echo $this->Html->link(__('<i class="icon-plus-circle"></i> Novo Registro'),array('action'=>'add'),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
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
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
        <?php echo $this->Search->input('filterCourseType', array('class' => 'form-control'));?> 
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filterStatus', array('class' => 'form-control', 'placeholder'=>'Status'));?> 
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
                <th><?php echo $this->Paginator->sort('course_type_id',__('course_type_id', true)); ?></th>
                <th><?php echo $this->Paginator->sort('name',__('name', true)); ?></th>
                <th><?php echo $this->Paginator->sort('value_time',__('Qtde de Horas', true)); ?></th>
                <th><?php echo $this->Paginator->sort('module_discipline_count',__('Qtde de Unidades', true)); ?></th>
                <th><?php echo $this->Paginator->sort('question_alternative_count',__('Qtde de Questões', true)); ?></th>
                <th><?php echo $this->Paginator->sort('is_default',__('Módulo Padrão?', true)); ?></th>
                <th><?php echo $this->Paginator->sort('status',__('status', true)); ?></th>
                <th><?php echo $this->Paginator->sort('created',__('created', true)); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module): ?>
	<tr>
		<td><?php echo h($module['Module']['id']); ?></td>
		<td>
			<?php echo $this->Html->link($module['CourseType']['name'], array('controller' => 'course_types', 'action' => 'view', $module['CourseType']['id'])); ?>
		</td>
        <td><?php echo $this->Utility->__LimitText($module['Module']['name']); ?></td>
		<td class="text-center"><?php echo $module['Module']['value_time'] > 0 ? "{$module['Module']['value_time']}h" : "0"; ?></td>
        <td class="text-center"><?php echo h($module['Module']['module_discipline_count']); ?></td>
        <td class="text-center"><?php echo h($module['Module']['question_alternative_count']); ?></td>
        <td class="text-center"><?php echo $this->Utility->__FormatQuestion($module['Module']['is_default']); ?></td>
		<td class="text-center"><?php echo $this->Utility->__FormatStatus($module['Module']['status']); ?></td>
		<td><?php echo $this->Utility->__FormatDate($module['Module']['created']); ?></td>
		<td class="actions">

            <?php echo $this->Html->link(__('<span class="icon-book"></span>'), array('controller'=>'modules','action'=>'compose', $module['Module']['id']), array('class' => 'btn btn-success btn-xs tip', 'escape' => false,'data-original-title'=>'Add ao Curso/Estados/Cidades')); ?>
            
            <?php echo $this->Html->link(__('<span class="icon-puzzle3"></span>'), array('controller'=>'module_disciplines','action'=>'index', $module['Module']['id']), array('class' => 'btn btn-warning btn-xs tip', 'escape' => false,'data-original-title'=>'Unidades')); ?>

            <?php echo !$module['Module']['is_introduction'] ? $this->Html->link(__('<span class="icon-question2"></span>'), array('controller'=>'question_alternatives','action'=>'index', $module['Module']['id']), array('class' => 'btn btn-success btn-xs tip', 'escape' => false,'data-original-title'=>'Questões de Prova')) : $this->Html->link(__('<span class="icon-question2"></span>'), 'javascript:void(0);', array('class' => 'btn btn-default btn-xs', 'escape' => false)); ?>

			<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $module['Module']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>

			<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('action' => 'edit', $module['Module']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>

			<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('action' => 'delete', $module['Module']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $module['Module']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<?php echo $this->Element('manager/pagination'); ?>
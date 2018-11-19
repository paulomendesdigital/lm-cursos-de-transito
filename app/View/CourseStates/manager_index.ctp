<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseState View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>
        <?php echo __($this->params['controller']);?> 
        <small>Lista de resultados</small>
        </h3>
    </div>

    <div class="visible-xs header-element-toggle">
        <a class="btn btn-primary btn-icon collapsed" data-toggle="collapse" data-target="#header-buttons"><i class="icon-insert-template"></i></a>
    </div>

    <div class="header-buttons">
        <div class="collapse" id="header-buttons" style="height: 0px;">
            <div class="well">
                <?php echo $this->Html->link(__('<i class="icon-plus-circle"></i> Habilitar Novo Estado'),array('action'=>'add',$course_type_id),array('escape'=>false,'class'=>'btn btn-sm btn-info')); ?>
            </div>
        </div>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar Tipos de curso'), '/manager/course_types/index');?>
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
    <div class="col-sm-12 col-md-3 hidden">
        <div class="form-group">
        <?php echo $this->Search->input('filterCourseType', array('class' => 'form-control', 'placeholder'=>'Tipo de Curso'));?> 
        </div>
    </div>
    <div class="col-sm-12 col-md-3">
        <div class="form-group">
            <?php echo $this->Search->input('filterState', array('class' => 'form-control', 'placeholder'=>'Estado'));?> 
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
                <th><?php echo $this->Paginator->sort('course_type_id',__('Tipo de Curso', true)); ?></th>
                <th><?php echo $this->Paginator->sort('state_id',__('Estado', true)); ?></th>
                <th><?php echo $this->Paginator->sort('price',__('Valor por Estado', true)); ?></th>
                <th><?php echo $this->Paginator->sort('course_city_count',__('Nº de Cidades', true)); ?></th>
                <th><?php echo $this->Paginator->sort('order_in_school',__('Vendas em Auto-Escolas?', true)); ?></th>
                <th><?php echo $this->Paginator->sort('status',__('status', true)); ?></th>
                <th><?php echo $this->Paginator->sort('created',__('created', true)); ?></th>
                <th><?php echo $this->Paginator->sort('modified',__('modified', true)); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courseStates as $courseState): ?>
            	<tr>
            		<td><?php echo h($courseState['CourseState']['id']); ?></td>
                    <td><?php echo h($courseState['CourseType']['name']); ?></td>
                    <td><?php echo h($courseState['State']['name']); ?></td>
                    <td><?php echo $this->Utility->__FormatPrice($courseState['CourseState']['price'],'cifrao'); ?></td>
            		<td><?php echo h($courseState['CourseState']['course_city_count']); ?></td>
                    <td><?php echo $this->Utility->__FormatQuestion($courseState['CourseState']['order_in_school']); ?></td>
            		<td><?php echo $this->Utility->__FormatStatus($courseState['CourseState']['status']); ?></td>
            		<td><?php echo $this->Utility->__FormatDate($courseState['CourseState']['created']); ?></td>
            		<td><?php echo $this->Utility->__FormatDate($courseState['CourseState']['modified']); ?></td>
            		<td class="actions">
            			<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $courseState['CourseState']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
            			<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('action' => 'edit', $courseState['CourseState']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
            			<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('action' => 'delete', $courseState['CourseState']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $courseState['CourseState']['id'])); ?>
            		</td>
            	</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<?php echo $this->Element('manager/pagination'); ?>
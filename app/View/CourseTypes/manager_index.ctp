<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * CourseType View
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
    <div class="col-sm-12 col-md-1">
        <div class="form-group">
        <?php echo $this->Search->input('filter1', array('class' => 'form-control', 'placeholder'=>'Id'));?> 
        </div>
    </div>
    <div class="col-sm-12 col-md-2">
        <div class="form-group">
        <?php echo $this->Search->input('filter2', array('class' => 'form-control', 'placeholder'=>'Status'));?> 
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
                <th><?php echo $this->Paginator->sort('scope',__('scope', true)); ?></th>
                <th><?php echo $this->Paginator->sort('course_state_count',__('Nº de Estados', true)); ?></th>
                <th><?php echo $this->Paginator->sort('status',__('status', true)); ?></th>
                <th><?php echo $this->Paginator->sort('created',__('created', true)); ?></th>
                <th><?php echo $this->Paginator->sort('modified',__('modified', true)); ?></th>
                <th class="actions"><?php echo __('Actions'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($courseTypes as $courseType):?>
            	<tr>
            		<td><?php echo h($courseType['CourseType']['id']); ?></td>
                    <td><?php echo $this->Utility->__LimitText($courseType['CourseType']['name']); ?></td>
            		<td><?php echo $listScopes[$courseType['CourseType']['scope']]; ?></td>
            		<td><?php echo h($courseType['CourseType']['course_state_count']); ?></td>
                    <td><?php echo $this->Utility->__FormatStatus($courseType['CourseType']['status']); ?></td>
            		<td><?php echo $this->Utility->__FormatDate($courseType['CourseType']['created']); ?></td>
            		<td><?php echo $this->Utility->__FormatDate($courseType['CourseType']['modified']); ?></td>
            		<td class="actions">
                        <?php 

                        if( CourseType::AMBITO_ESTADUAL == $courseType['CourseType']['scope'] ){
                            echo $this->Html->link(__('<span class="icon-copy"></span>'), 'javascript:void(0);', array('data-href'=>$this->Html->url(array('controller' => 'modules', 'action' => 'get_modules', $courseType['CourseType']['id'], $courseType['CourseType']['scope'])),'class'=>'btn btn-primary btn-xs openPopup tip', 'style'=>'margin-right: 3px;', 'data-original-title'=>'Importar informações de outro Tipo de Curso', 'escape' => false));
                        }

                        if( empty($courseType['CourseState']) ):
                            echo $this->Html->link(__('<span class="icon-globe2"></span>'), array('controller'=>'course_states','action' => 'add', $courseType['CourseType']['id']), array('class' => 'btn btn-success btn-xs tip', 'data-original-title'=>'Habilitar Estados e Cidades', 'escape' => false));

                        else:
                            echo $this->Html->link(__('<span class="icon-globe2"></span>'), array('controller'=>'course_states','action' => 'index', $courseType['CourseType']['id']), array('class' => 'btn btn-warning btn-xs tip', 'data-original-title'=>'Listar Estados e Cidades', 'escape' => false));
                        endif;

                        ?>
            			<?php echo $this->Html->link(__('<span class="icon-eye"></span>'), array('action' => 'view', $courseType['CourseType']['id']), array('class' => 'btn btn-info btn-xs', 'escape' => false)); ?>
            			<?php echo $this->Html->link(__('<span class="icon-pencil"></span>'), array('action' => 'edit', $courseType['CourseType']['id']), array('class' => 'btn btn-primary btn-xs', 'escape' => false)); ?>
            			<?php echo $this->Form->postLink(__('<span class="icon-remove3"></span>'), array('action' => 'delete', $courseType['CourseType']['id']), array('class' => 'btn btn-danger btn-xs', 'escape' => false), __('Are you sure you want to delete # %s?', $courseType['CourseType']['id'])); ?>
            		</td>
            	</tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table-responsive-->

<?php echo $this->Element('manager/pagination'); ?>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">fechar</button>
                <h4 class="modal-title">Serão importados: Módulos / Disciplinas / Sliders / Questões</h4>
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
            });
        }); 
    });
</script>

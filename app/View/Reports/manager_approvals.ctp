<?php /**
 * @copyright Copyright 2017
 * @author Dayvison Silva - www.dayvisonsilva.com.br
 * Order View
 *
*/
?>
<div class="page-header">
    <div class="page-title">
        <h3>Relatórios de Aprovados</h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Relatórios de Aprovados'), '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>
    </ul>
</div>
<style>
    .radio{float: left; margin-right: 10px;}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-12">
            <?php echo $this->Form->create('Report', array('id'=>'reports-approvals', 'class'=>'form-horizontal', 'role'=>'form')); ?>

                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->input('course_id', array('type' => 'select','class' => 'form-control', 'options' => $courses,'label'=>false, 'empty' => 'Selecione o curso', 'required'=>true,'onchange'=>'courseReportChange(this)')); ?>
                            <?php echo $this->Form->input('scope', array('type' => 'hidden')); ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->input('state_id', array('class'=>'form-control','empty'=>'Estado','label'=>false,'onchange'=>'stateReportChange(this)'));?> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->input('citie_id', array('class'=>'form-control','empty'=>'Município','label'=>false));?> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->input('start', array('class'=>'form-control','data-mask'=>'date','placeholder'=>'De','label'=>false));?> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->input('finish', array('class'=>'form-control','data-mask'=>'date','placeholder'=>'Até', 'label'=>false));?> 
                        </div>
                    </div>
                    
                    <div class="col-sm-12 col-md-2">
                        <?php echo $this->Html->link(__('<i class="icon-search2 icon-white"></i> buscar', true), 'javascript:void(0);', array('id'=>'buscar','class' =>'btn btn-search btn-info', 'escape'=>false));?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-2">
                        <div class="form-group">
                            <?php echo $this->Form->radio('extension', array('AVL'=>'AVL','XLS'=>'XLS'));?> 
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-2">
                        <?php echo $this->Html->link(__('<i class="icon-download5 icon-white"></i> baixar', true), 'javascript:void(0);', array('id'=>'exportar','class' =>'btn btn-search btn-success', 'escape'=>false));?>
                    </div>
                </div>
                <div class="row">
                    <hr />
                </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#buscar").click(function(){
            $("input[name='data[Report][extension]']").attr("required", false);
            $("#reports-approvals").attr("action", "/manager/reports/approvals");
            $("#reports-approvals").submit();
        });
        $("#exportar").click(function(){
            $("#reports-approvals").attr("action", "/manager/reports/approvals/export");
            $("#reports-approvals").submit();
        });
    });
</script>

<?php if( !empty($reports) ):?>
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center"><?php echo count($reports);?> aprovados</h4>
        </div>
    </div>
    <div class="row">
        <hr />
    </div>
    <div class="table-responsive">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover table-condensed order">
            <thead>
                <tr>
                    <th>NOTA</th>
                    <th>ID</th>
                    <th>ALUNO</th>
                    <th nowrap="nowrap">INICIO DO CURSO</th>
                    <th nowrap="nowrap">FINAL DO CURSO</th>
                    <th>CPF</th>
                    <th>MUNICÍPIO</th>
                    <th>CURSO</th>
                    <th>SITUAÇÃO</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                	<tr>
                        <td><?php echo $report['UserCertificate']['score']; ?></td>
                		<td><?php echo $this->Utility->__MaskOrderId($report['User']['id']); ?></td>
                		<td><?php echo $report['User']['name']; ?></td>
                        <td><?php echo $this->Utility->__FormatDate($report['UserCertificate']['start'],'Normal'); ?></td>
                        <td><?php echo $this->Utility->__FormatDate($report['UserCertificate']['finish'],'Normal'); ?></td>
                        <td><?php echo $report['User']['cpf']; ?></td>
                        <td><?php echo $report['Order']['OrderCourse'][0]['Citie']['name']; ?></td>
                        <td><?php echo $report['Course']['name'] . ' ' .$report['Course']['firstname']; ?></td>
                        <td>APROVADO</td>
                	</tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div><!-- /table-responsive-->

    <?php //echo $this->element('manager/pagination'); ?>
<?php else:?>
    <div class="table-responsive">
        <div class="jumbotron">
            <h1>Olá <?php echo $this->Session->read('Auth.User.name');?> !</h1>
            <p>Faça um dos filtros acima para exibir o resultado desejado.</p>
        </div>
    </div>
<?php endif;?>
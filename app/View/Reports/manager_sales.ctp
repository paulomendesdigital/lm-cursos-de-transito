<div class="page-header">
    <div class="page-title">
        <h3>Relatórios de Vendas</h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Relatórios de Vendas'), '');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>
    </ul>
</div>
<style>
    .radio{float: left; margin-right: 10px;}
</style>

<?php echo $this->Form->create('Report', array('id'=>'reports-approvals', 'role'=>'form'));
$this->Form->inputDefaults(['div' => false]);
?>

    <div class="row">
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <label for="ReportStart">De: </label>
                <input type="date" name="data[Report][start]" class="form-control col-sm-9" required="required" id="ReportStart" value="<?php echo $this->request->data['Report']['start']?>" max="<?php echo date('Y-m-d')?>">
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <label for="ReportFinish">Até: </label>
                <input type="date" name="data[Report][finish]" class="form-control col-sm-9" required="required" id="ReportFinish" value="<?php echo $this->request->data['Report']['finish']?>" max="<?php echo date('Y-m-d')?>">
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <?php echo $this->Form->input('order_type_id', array('class'=>'form-control','empty'=>'Selecione', 'options' => $status, 'label'=> 'Status Pagamento:'));?>
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <?php echo $this->Form->input('course_id', array('type' => 'select','class' => 'form-control', 'options' => $courses, 'label'=> 'Curso:', 'empty' => 'Selecione', 'onchange'=>'courseReportChange(this)')); ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <?php echo $this->Form->input('state_id', array('class'=>'form-control','empty'=>'Selecione','label'=> 'Estado do Curso:','onchange'=>'stateReportChange(this)'));?>
            </div>
        </div>
        <div class="col-sm-12 col-md-2">
            <div class="form-group">
                <?php echo $this->Form->input('citie_id', array('class'=>'form-control','empty'=>'Selecione','label'=> 'Cidade do Curso:'));?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-2">
            <button type="submit" class="btn btn-search btn-success"><i class="icon-download5 icon-white"></i> Baixar Relatório em Excel</button>
        </div>
    </div>
    <div class="row">
        <hr/>
    </div>
    <div class="row">
        <div class="col-sm-offset-3 col-sm-6">
            <h4 class="text-center">Hoje</h4>
            <ul class="page-stats list-justified">
                <li class="bg-primary">
                    <div class="page-stats-showcase">
                        <span>Total</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['hoje']['total'], 'cifrao', true)?></h2>
                    </div>
                </li>
                <li class="bg-warning">
                    <div class="page-stats-showcase">
                        <span>Aguardando Pagamento</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['hoje']['aguardando'], 'cifrao', true)?></h2>
                    </div>
                </li>
                <li class="bg-success">
                    <div class="page-stats-showcase">
                        <span>Aprovado</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['hoje']['aprovado'], 'cifrao', true)?></h2>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <h4>Mês Atual</h4>
            <ul class="page-stats list-justified">
                <li class="bg-primary">
                    <div class="page-stats-showcase">
                        <span>Total</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['mes_atual']['total'], 'cifrao', true)?></h2>
                    </div>
                </li>
                <li class="bg-warning">
                    <div class="page-stats-showcase">
                        <span>Aguardando Pagamento</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['mes_atual']['aguardando'], 'cifrao', true)?></h2>
                    </div>
                </li>
                <li class="bg-success">
                    <div class="page-stats-showcase">
                        <span>Aprovado</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['mes_atual']['aprovado'], 'cifrao', true)?></h2>
                    </div>
                </li>
            </ul>
            <div class="graph-standard" id="chart1"></div>
        </div>
        <div class="col-sm-6">
            <h4>Mês Anterior</h4>
            <ul class="page-stats list-justified">
                <li class="bg-primary">
                    <div class="page-stats-showcase">
                        <span>Total</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['mes_anterior']['total'], 'cifrao', true)?></h2>
                    </div>
                </li>
                <li class="bg-warning">
                    <div class="page-stats-showcase">
                        <span>Aguardando Pagamento</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['mes_anterior']['aguardando'], 'cifrao', true)?></h2>
                    </div>
                </li>
                <li class="bg-success">
                    <div class="page-stats-showcase">
                        <span>Aprovado</span>
                        <h2><?php echo $this->Utility->__FormatPrice($arrDashboard['mes_anterior']['aprovado'], 'cifrao', true)?></h2>
                    </div>
                </li>
            </ul>
            <div class="graph-standard" id="chart2"></div>
        </div>
    </div>
<?php echo $this->Form->end(); ?>

<script>
    window.addEventListener('DOMContentLoaded', function () {

        Highcharts.setOptions({
            lang: {
                months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                weekdays: ['Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira','Quinta-feira', 'Sexta-feira', 'Sábado']
            }
        });

        Highcharts.chart('chart1', {
            title: {text: null},
            subtitle: {text: null},
            yAxis: {
                title: null,
                labels: {
                    formatter: function() {
                        return this.value;
                    }
                },
            },
            xAxis: {type: 'datetime'},
            series: [{
                showInLegend: false,
                name: 'Total de Vendas',
                data: <?php echo json_encode($arrDashboard['mes_atual']['por_dia']);?>
            }]

        });

        Highcharts.chart('chart2', {
            title: {text: null},
            subtitle: {text: null},
            yAxis: {
                title: null,
                labels: {
                    formatter: function() {
                        return this.value;
                    }
                },
            },
            xAxis: {type: 'datetime'},
            series: [{
                showInLegend: false,
                name: 'Total de Vendas',
                data: <?php echo json_encode($arrDashboard['mes_anterior']['por_dia']);?>
            }]

        });

    });
</script>

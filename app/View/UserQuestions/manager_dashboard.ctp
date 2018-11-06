<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * UserQuestion View
 *
*/ ?>
<div class="page-header">
    <div class="page-title">
        <h3>
        Relatório de Performance
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
        <?php echo $this->Html->addCrumb('Relatório de Performance');?>
        <?php echo $this->Html->getCrumbs(' ', 'Home');?>   
    </ul>
</div>

<?php echo $this->Search->create(null, array('class' => '','role'=>'form')); ?> 
<div class="row hidden">
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

<?php $colors = ['#669800', '#FF9837', '#FF0B64', '#98079A', '#6737FF', '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'];?>
<div class="row" style="margin-bottom: 50px;">
    <div class="col-md-12">
        <div class="col-md-6">
            <div id="user-questions-graph" class='graph' style="min-height: 300px; height: auto; border: 1px solid silver"></div>
        </div>
    </div>
</div><!-- /table-responsive-->
<script>
    <?php if(isset($userQuestions) && !empty($userQuestions)){ ?>
        $(function(){
            Highcharts.chart('user-questions-graph', {
                chart: {
                    type: 'column'
                },
                title: {
                    text:'Relatório de Performance'             
                },
                subtitle: {   
                    text:'Simulados / Prova Final'              
                },
                colors: ['#669800', '#FF9837', '#FF0B64', '#98079A', '#6737FF', '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'],
                xAxis: {            
                    categories: <?php echo $categories;?>,
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    minRange:   100,
                    max:        100,
                    title: {
                        text: 'Notas',                   
                    },
                    labels: {                   
                    },
                    tickInterval: 10,         
                },  
                legend: {
                    symbolHeight: 15,
                    symbolWidth: 15,
                    symbolRadius: 5,        
                }, 
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' + '<td style="padding:0"><b>{point.y:.1f}<!-- mm--></b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {          
                    column: {               
                        pointPadding: 0.2,
                        borderWidth: 0,                          
                    }
                },
                series: [
                    {
                        name: "Nota",
                        color: '#42a5f5',                  
                        data: <?php echo $data;?>
                    }
                ]
            });
        });
    <?php } ?>
</script>





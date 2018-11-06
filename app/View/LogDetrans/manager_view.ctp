<?php
?><div class="page-header">
    <div class="page-title">
        <h3>
        <?php echo __('Logs de Integração c/ Detrans');?>
        <small>Visualização do resultado</small>
        </h3>
    </div>
</div>

<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <?php echo $this->Html->addCrumb(__('Listar').' '.__($this->params['controller']), '/manager/'.$this->params['controller'].'/index');?>        <?php echo $this->Html->addCrumb('Visualizar cadastro', '');?>        <?php echo $this->Html->getCrumbs(' ', 'Home');?> 
    </ul>
</div>

<div class="panel">
	<h3>Visualização dos dados</h3>

	<ul class="list-group">
        <li class='list-group-item'>
            <div class='row'>
            <div class='col-md-2 text-right'><strong><?php echo __('id'); ?></strong></div>
            <div class='col-md-10'><?php echo $log['LogDetran']['id']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
            <div class='col-md-2 text-right'><strong><?php echo __('Data e Hora'); ?></strong></div>
            <div class='col-md-10'><?php echo $this->Utility->__FormatDate($log['LogDetran']['data_log']); ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
            <div class='col-md-2 text-right'><strong><?php echo __('Integração'); ?></strong></div>
            <div class='col-md-10'><?php echo $log['LogDetran']['integracao']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
            <div class='col-md-2 text-right'><strong><?php echo __('Rotina'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['rotina']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('Código de Retorno'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['codigo_retorno']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('Mensagem de Retorno'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['mensagem_retorno']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('cpf'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['cpf']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('RENACH'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['renach']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('CNH'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['cnh']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('Matrícula'); ?></strong></div>
                <div class='col-md-10'><?php echo $this->Html->link($log['LogDetran']['order_id'], ['controller' => 'orders', 'action' => 'view', $log['LogDetran']['order_id']]); ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('OrderCourseId'); ?></strong></div>
                <div class='col-md-10'><?php echo $log['LogDetran']['order_courses_id']; ?></div>
            </div>
        </li>
        <li class='list-group-item'>
            <div class='row'>
                <div class='col-md-2 text-right'><strong><?php echo __('Usuário'); ?></strong></div>
                <div class='col-md-10'>
                    <?php echo $this->Html->link($log['User']['name'], array('controller' => 'users', 'action' => 'view', $log['User']['id']),array('data-toggle'=>'tooltip', 'data-original-title'=>'Visualizar Histórico do Aluno')); ?>
                </div>
            </div>
        </li>
    </ul>
</div>

<?php
function arrayToList($arr, $bolFirst = true) {
    $list = [];
    foreach ($arr as $key => $val) {
        $list[$key] = is_array($val) ? arrayToList($val, false) : $val;
    }
    $list = array_filter($list);

    if ($bolFirst || count($list) > 1) {
        $strList = '<table class="table table-striped table-hover table-condensed">';
        foreach ($list as $key => $val) {
            if (is_numeric($key)) {
                $strList .= '<tr><td><pre>' . $val . '</pre></td></tr>';
            } else {
                $strList .= '<tr><th>' . $key . '</th><td><pre>' . $val . '</pre></td></tr>';
            }
        }
        $strList .= '</table>';
    } else {
        $val = reset($list);
        $strList = $bolFirst ? "<pre>$val</pre>" : $val;
    }
    return $strList;
}
?>

<div class="panel">
	<h3><?php echo __('Parâmetros Internos do Sistema'); ?></h3>
	<?php
        $arr = empty($log['LogDetran']['parametros']) ? null : json_decode($log['LogDetran']['parametros'], true);
        if (!empty($arr)) {
            echo '<table class="table table-striped table-hover table-condensed">';
            foreach ($arr as $key => $val) {
                echo '<tr><th>' . $key . '</th><td>' . $val . '</td></tr>';
            }
            echo '</table >';
        } else {
            echo 'Nenhum dado.';
        }
    ?>
</div>

<div class="panel">
    <h3><?php echo __('Dados Enviados'); ?></h3>
    <?php
    $arr = empty($log['LogDetran']['dados_enviados']) ? null : json_decode($log['LogDetran']['dados_enviados'], true);
    if (!empty($arr)) {
        if (is_array($arr)) {
            echo arrayToList($arr);
        } elseif (is_scalar($arr)) {
            echo $arr;
        }
    } else {
        echo 'Nenhum dado.';
    }
    ?>
</div>

<div class="panel">
    <h3><?php echo __('Dados Retornados'); ?></h3>
    <?php
    $arr = empty($log['LogDetran']['dados_retornados']) ? null : json_decode($log['LogDetran']['dados_retornados'], true);
    if (!empty($arr)) {
        if (is_array($arr)) {
            echo arrayToList($arr);
        } elseif (is_scalar($arr)) {
            echo $arr;
        }
    } else {
        echo 'Nenhum dado.';
    }
    ?>
</div>

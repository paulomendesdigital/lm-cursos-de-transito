<?php if (empty($arrData)) { ?>
<hr>
<div class="text-center">
<h6>Não há créditos de aula nesta matrícula.</h6>
<p>Verifique se os módulos do curso foram configurados com os códigos de disciplinas oficiais do DETRAN.</p>
</div>
<?php } else { ?>
<div style="overflow: auto">
<table class="table table-bordered table-responsive">
    <?php foreach ($arrData as $arrModule) {?>
    <tr>
        <td colspan="11">
            <h6><?php echo 'Módulo: ' . h($arrModule['Module']['name'])?> <span class="pull-right">Carga Horária Total: <?php echo $arrModule['Module']['value_time']?>h.</span></h6>
        </td>
    </tr>
    <tr>
        <th colspan="2" class="text-center">Registros de Estudo do Site</th>
        <th rowspan="2" class="text-center" colspan="2">Disciplina DETRAN</th>
        <th rowspan="2" class="text-center warning">Carga Horária<br>Realizada</th>
        <th colspan="3" class="text-center success">Crédito de Aula DETRAN</th>
        <th rowspan="2" class="text-center success">Acertos<br>Prova</th>
        <th rowspan="2" class="text-center">Transmitido</th>
    </tr>
    <tr>
        <th class="">Início</th>
        <th class="">Fim</th>
        <th class="success">Data</th>
        <th class="success">Início</th>
        <th class="success">Fim</th>
    </tr>
    <?php
        foreach ($arrModule['dates'] as $strDate => $arrDisciplines) {
            foreach ($arrDisciplines as $arrDiscipline) {
    ?>
        <tr>
            <td class=""><?php echo date_create($arrDiscipline['real_inicio_aula'])->format('d/m/y H:i')?></td>
            <td class=""><?php echo date_create($arrDiscipline['real_fim_aula'])->format('d/m/y H:i')?></td>
            <td class=""><?php echo h($arrDiscipline['discipline_code'])?></td>
            <td class=""><?php echo h($arrDiscipline['discipline_name'])?></td>
            <td class="warning"><?php echo $this->Utility->__FormatTime($arrDiscipline['time'])?></td>
            <td class="success"><?php echo date_create($strDate)->format('d/m/y')?></td>
            <td class="success"><?php echo date_create($arrDiscipline['inicio_aula'])->format('H:i')?></td>
            <td class="success"><?php echo date_create($arrDiscipline['fim_aula'])->format('H:i')?></td>
            <td class="success"><?php echo isset($arrDiscipline['acertos']) ? $arrDiscipline['acertos'] : ''?></td>
            <td class="text-center">
                <?php if ($arrDiscipline['count_sent'] > 0 || date_create($arrDiscipline['inicio_aula'])->format('Ymd') <= date('Ymd') && $arrModule['total'] >= $arrModule['Module']['value_time'] * 60) { ?>
                    <?php if ($arrDiscipline['count_sent'] == 0) {?>
                    <i class="icon icon-cancel text-danger" title="<?php echo $arrDiscipline['count_sent'] . '/' . $arrDiscipline['count_total']?>"></i>
                    <?php } elseif ($arrDiscipline['count_sent'] <  $arrDiscipline['count_total']) {?>
                    <i class="icon icon-warning text-warning" title="<?php echo $arrDiscipline['count_sent'] . '/' . $arrDiscipline['count_total']?>"></i>
                    <?php } else { ?>
                    <i class="icon icon-checkmark3 text-success" title="<?php echo $arrDiscipline['count_sent'] . '/' . $arrDiscipline['count_total']?>"></i>
                    <?php } ?>
                <?php } else { ?>
                    <i class="icon icon-clock text-info" title="Aguardando completar carga horária ou data de envio."></i>
                <?php } ?>
            </td>
        </tr>
        <?php } }?>
        <tr>
            <th colspan="4">Total Realizado:</th>
            <th class="warning"><?php echo $this->Utility->__FormatTime($arrModule['total'])?></th>
            <th colspan="5"></th>
        </tr>
    <?php }?>
</table>
</div>
<?php }?>
<hr>
<p><strong>Forma de cálculo dos créditos de aula:</strong></p>
<ul>
    <li>Os créditos de aula só serão enviados ao DETRAN após o aluno completar a carga horária do módulo.</li>
    <li>O Crédito de Aula é contabilizado pelo DETRAN pelo Horário de Início da Aula e o Horário do Fim da Aula.</li>
    <li>A partir do horário do primeiro registro de estudo do dia, o sistema irá calcular o horário do fim da aula, baseando-se na carga horária realizada pelo aluno.</li>
    <li>O horário de aula válido para o DETRAN é das <strong>6h até 22h</strong>.</li>
    <li>Quando o horário de aula no site for antes do período válido (de 0h até 5h59m), o crédito será computado no primeiro horário válido do respectivo dia.</li>
    <li>Quando o horário de aula no site for após o período válido (de 22h01m até 23h59m), o crédito será computado no primeiro horário válido no dia posterior.</li>
    <li>O sistema pode ajustar a faixa-horária que será enviada para o DETRAN para que as disciplinas não se sobreponham dentro do mesmo dia de aula.</li>

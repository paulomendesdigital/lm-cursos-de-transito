<STYLE type="text/css">
    .tableTd {
        border-width: 0.5pt;
        border: solid;
        white-space: nowrap;
        background: #ffb800;
        color: white;
    }
    .tableTfootTd {
        border-width: 0.5pt;
        border: solid;
        white-space: nowrap;
        background: #ffb800;
        color: white;
        font-weight: bolder;
    }
    .tableTdContent{
        border: thin solid;
        background: white;
        color: black;
        font-weight: normal;
    }
    #titles{
        font-weight: bolder;
    }
</STYLE>
<table>
    <tr>
        <td colspan="9"><b><h1 style="text-align: center;">Lista de Aprovados</h1><b></td>
    </tr>
    <tr>
        <td nowrap="nowrap" colspan="1"><b>Data da exportação:</b></td>
        <td colspan="8" style="text-align:left"><?php echo date("d/m/Y H:i:s"); ?></td>
    </tr>
    <tr>
        <td nowrap="nowrap" colspan="1"><b>Qtde de Aprovados:</b></td>
        <td colspan="8" style="text-align:left"><?php echo count($reports); ?></td>
    </tr>
    <tr>
        <td></td>
    </tr>
    <tr id="titles">
        <td class="tableTd"><?php echo __('NOTA', true);?></td>
        <td class="tableTd"><?php echo __('ID', true);?></td>
        <td class="tableTd"><?php echo __('ALUNO', true);?></td>
        <td class="tableTd"><?php echo __('INICIO DO CURSO', true);?></td>
        <td class="tableTd"><?php echo __('FINAL DO CURSO', true);?></td>
        <td class="tableTd"><?php echo __('CPF', true);?></td>
        <td class="tableTd"><?php echo __('MUNICÍPIO', true);?></td>
        <td class="tableTd"><?php echo __('CURSO', true);?></td>
        <td class="tableTd"><?php echo __('SITUAÇÃO', true);?></td>
        <!-- ########## FIM ##########-->
    </tr>
    <?php foreach ($reports as $report): 
        echo '<tr>';
            echo '<td class="tableTdContent">' . $report['UserCertificate']['score'] . '</td>';
            echo '<td class="tableTdContent">' . $this->Utility->__MaskOrderId($report['User']['id']) . '</td>';
            echo '<td class="tableTdContent">' . $report['User']['name'] . '</td>';
            echo '<td class="tableTdContent">' . $this->Utility->__FormatDate($report['UserCertificate']['start'],'Normal') . '</td>';
            echo '<td class="tableTdContent">' . $this->Utility->__FormatDate($report['UserCertificate']['finish'],'Normal') . '</td>';
            echo '<td class="tableTdContent">' . $report['User']['cpf'] . '</td>';
            echo '<td class="tableTdContent">' . $report['Order']['OrderCourse'][0]['Citie']['name'] . '</td>';
            echo '<td class="tableTdContent">' . $report['Course']['name'] . ' ' .$report['Course']['firstname'] . '</td>';
            echo '<td class="tableTdContent">APROVADO</td>';
         echo '</tr>';
    endforeach; ?>
</table>
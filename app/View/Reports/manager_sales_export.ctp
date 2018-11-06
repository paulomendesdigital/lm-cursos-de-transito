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
<table class="table table-striped table-hover table-condensed">
    <tr>
        <td colspan="15"><b><h1 style="text-align: center;">Relatório de Vendas</h1><b></td>
    </tr>
    <tr>
        <td nowrap="nowrap" colspan="1"><b>Data da exportação:</b></td>
        <td colspan="15" style="text-align:left"><?php echo date("d/m/Y H:i:s"); ?></td>
    </tr>
    <tr>
        <td nowrap="nowrap" colspan="1"><b>Período:</b></td>
        <td colspan="15" style="text-align:left">De <?php echo date('d/m/Y', strtotime($this->request->data['Report']['start']))?> até <?php echo date('d/m/Y', strtotime($this->request->data['Report']['finish']))?></td>
    </tr>
    <?php if(isset($this->request->data['Report']['order_type_id']) && !empty($this->request->data['Report']['order_type_id'])) {?>
    <tr>
        <td nowrap="nowrap" colspan="1"><b>Status Pagamento:</b></td>
        <td colspan="15" style="text-align:left"><?php echo $status[$this->request->data['Report']['order_type_id']]?></td>
    </tr>
    <?php } ?>
    <?php if(isset($this->request->data['Report']['course_id']) && !empty($this->request->data['Report']['course_id'])) {?>
    <tr>
        <td nowrap="nowrap" colspan="1"><b>Curso:</b></td>
        <td colspan="15" style="text-align:left"><?php echo $courses[$this->request->data['Report']['course_id']]?></td>
    </tr>
    <?php } ?>
    <tr>
        <td></td>
    </tr>
    <tr id="titles">
        <td class="tableTd">Número do Pedido</td>
        <td class="tableTd">Data do Pedido</td>
        <td class="tableTd">Forma de Pagamento</td>
        <td class="tableTd">Status do Pagamento</td>
        <td class="tableTd">Data do Pagamento</td>

        <td class="tableTd">Valor Total Produtos</td>
        <td class="tableTd">Valor Total Desconto</td>
        <td class="tableTd">Valor Total do Pedido</td>
        <td class="tableTd">Aluno</td>
        <td class="tableTd">CPF</td>
        <td class="tableTd">E-mail</td>
        <td class="tableTd">Auto Escola</td>

        <td class="tableTd">Curso</td>
        <td class="tableTd">Estado do Curso</td>
        <td class="tableTd">Cidade do Curso</td>
        <td class="tableTd">Preço Normal (Atual)</td>
        <td class="tableTd">Preço com Desconto (Atual)</td>
    </tr>
    <?php foreach ($dados as $row) {
        $numValorProdutos = isset($row['Order']['value']) ? $row['Order']['value'] : 0;
        $numValorDesconto = isset($row['Order']['value_discount']) ? $row['Order']['value_discount'] : 0;
        $numValorTotal    = $numValorProdutos - $numValorDesconto;
    ?>
    <tr>
        <td class="tableTdContent"><?php echo $row['Order']['id']?></td>
        <td class="tableTdContent"><?php echo date_create($row['Order']['created'])->format('d/m/Y H:i:s')?></td>
        <td class="tableTdContent"><?php echo isset($row['Order']['Method']['name']) ? $row['Order']['Method']['name'] : ''?></td>
        <td class="tableTdContent"><?php echo isset($row['Order']['OrderType']['name']) ? $row['Order']['OrderType']['name'] : ''?></td>
        <td class="tableTdContent"><?php echo isset($row['Order']['Payment'][0]['created']) ? date_create($row['Order']['Payment'][0]['created'])->format('d/m/Y H:i:s') : ''?></td>
        <td class="tableTdContent"><?php echo $numValorProdutos != 0 ? 'R$ ' . number_format($numValorProdutos, 2, ',', '.') : ''?></td>
        <td class="tableTdContent"><?php echo $numValorDesconto != 0 ? 'R$ ' . number_format($numValorDesconto, 2, ',', '.') : ''?></td>
        <td class="tableTdContent"><?php echo $numValorTotal != 0 ? 'R$ ' . number_format($numValorTotal, 2, ',', '.') : ''?></td>

        <td class="tableTdContent"><?php echo $row['Order']['User']['name']?></td>
        <td class="tableTdContent"><?php echo $row['Order']['User']['cpf']?></td>
        <td class="tableTdContent"><!--email_off--><?php echo $row['Order']['User']['email']?><!--/email_off--></td>
        <td class="tableTdContent"><?php echo isset($row['Order']['User']['School']['name']) ? $row['Order']['User']['School']['name'] : ''?></td>

        <td class="tableTdContent"><?php echo $row['Course']['name']?></td>
        <td class="tableTdContent"><?php echo isset($row['State']['abbreviation']) ? $row['State']['abbreviation'] : ''?></td>
        <td class="tableTdContent"><?php echo isset($row['Citie']['name']) ? $row['Citie']['name'] : ''?></td>
        <td class="tableTdContent">R$ <?php echo number_format($row['Course']['price'], 2, ',', '.')?></td>
        <td class="tableTdContent">R$ <?php echo number_format($row['Course']['promotional_price'], 2, ',', '.')?></td>

    </tr>
    <?php } ?>
</table>

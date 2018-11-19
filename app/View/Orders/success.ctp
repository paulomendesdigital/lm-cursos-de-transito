
<div id="success-buy" class="page">
    <div class="container">
        <?php echo $this->Utility->breadcumbs([
            'Início'            => ['controller' => 'pages', 'action' => 'index', 'prefixes' => false],
            'Compra Finalizada' => ['controller' => 'orders', 'action' => 'success', 'prefixes' => false]
        ]);
        ?>

        <h1>PEDIDO REALIZADO COM SUCESSO!</h1>

        <p class="pedido">O número do seu pedido é: <span><?php echo $order['Order']['id']?></span></p>

        <?php if ($this->Utility->__isBoleto($order['Method']['id'])) { ?>
            <?php if( !empty($order['Order']['payment_link_boleto']) ){?>
                <p>1.Clique no botão Gerar Boleto e uma nova janela será aberta. Neste momento você terá acesso ao boleto de pagamento.</p>
                <p>2. Imprima o boleto e pague-o em qualquer instituição bancária até a data de vencimento.</p>
                <a class="btn btn-checkout boleto" href="<?php echo $order['Order']['payment_link_boleto']?>" target="_blank" role="button"><i class="glyphicon glyphicon-barcode"></i> GERAR BOLETO</a>
            <?php }else{ ?>
                <p style="color: red; font-size: 16px;"><i class="glyphicon glyphicon-warning"></i> Não foi possível gerar seu boleto, entre em contato com o atendimento e informe o ocorrido passando o número do pedido!</p>
            <?php } ?>
        <?php } ?>

        <p>Você receberá uma cópia com detalhes do seu pedido por e-mail.</p>

        <a class="btn btn-checkout area-do-aluno" role="button" href="/meus-cursos"><i class="glyphicon glyphicon-log-in"></i> ÁREA DO ALUNO</a>

        <a class="continue" href="/">CONTINUAR NAVEGANDO</a>
    </div>
</div>

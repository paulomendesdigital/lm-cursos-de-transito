<script src="https://assets.pagar.me/pagarme-js/3.0/pagarme.min.js"></script>

<div id="finish-buy" class="page">
    <div class="container">
        <?php echo $this->Utility->breadcumbs([
            'Início'   => ['controller' => 'pages', 'action' => 'index', 'prefixes' => false],
            'Carrinho' => ['controller' => 'carts', 'action' => 'index', 'prefixes' => false],
            'Checkout' => ['controller' => 'orders', 'action' => 'payment', 'prefixes' => false]
        ]);
        ?>

        <h1>FINALIZE SUA COMPRA COM SEGURANÇA</h1>

        <div class="steps-timeline hidden-xs">
            <div class="steps-timeline-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation">
                        <div class="text-center">
                            <span class="diamante" title="Efetuar Login ou Cadastro"><i>1</i></span>
                            <span class="step-name">SEUS DADOS</span>
                        </div>
                    </li>
                    <li role="presentation">
                        <div class="text-center">
                            <span class="diamante" title="Pagamento"><i>2</i></span>
                            <span class="step-name">PAGAMENTO</span>
                        </div>
                    </li>
                    <li role="presentation">
                        <div class="text-center">
                            <span class="diamante" title="Resumo da Compra"><i>3</i></span>
                            <span class="step-name">RESUMO DA COMPRA</span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row">

            <div class="col-md-4 col-xs-12">
                <div class="step-block step-identification">

                    <?php echo $this->Element('site/payment/identification');?>

                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="step-block step-payment">
                    <h4 class="hidden-sm visible-xs">PAGAMENTO</h4>
                    <div class="cupom-block">
                        <?php echo $this->Element('site/payment/form-cupom');?>
                    </div>

                    <?php echo $this->Element('site/payment/form-payment');?>
                </div>
            </div>

            <div class="col-md-4 col-xs-12">
                <div class="step-block step-resume">
                    <?php echo $this->Element('site/payment/resumo');?>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    var checkout;
    window.addEventListener('DOMContentLoaded', function () {
        checkout = new Checkout(<?php echo isset($userValid) && $userValid ? 'true' : 'false'?>, '<?php echo Configure::read('Pagarme.encryption_key')?>', <?php echo $total?>);
    }, true);
</script>

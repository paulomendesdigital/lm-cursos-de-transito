<?php
echo $this->Form->create('Order',['url' => ['controller'=>'orders','action'=>'payment'], 'id' => 'payment-form']);

$sender = (!empty($sender) ? $sender : 'LM');
echo $this->Form->hidden('Order.sender', ['value' => $sender]);
?>

    <h5>Selecione a forma de pagamento:</h5>
    <div class="radio">
        <label for="paymentMethodCard">
            <input id="paymentMethodCard" class="payment-method" name="data[Order][payment_method]" type="radio" value="credit_card" required disabled>
            CARTÃO DE CRÉDITO
        </label>
    </div>

    <div class="payment-form-card hidden">
        <input id="inputCardHash" type="hidden" name="data[Order][card_hash]">
        <div class="form-group required form-group-card-number">
            <label for="inputCardNumber">Número do Cartão:</label>
            <div class="input-group">
                <input type="text" class="form-control" id="inputCardNumber" name="data[Order][card_number]" pattern="[0-9\s]*" maxlength="19" autocomplete="off">
                <div class="input-group-addon"><span class="card-brand payment-icon"></span></div>
            </div>
        </div>
        <div class="form-group required form-group-card-holder">
            <label for="inputCardHolder">Nome impresso no cartão:</label>
            <input type="text" class="form-control" id="inputCardHolder" name="data[Order][card_holder_name]" autocomplete="off">
        </div>
        <div class="row">
            <div class="form-group col-sm-5 required form-group-validade">
                <label for="inputCardMonth">Validade:</label>
                <input type="text" class="form-control" id="inputCardExpiration" name="data[Order][card_expiration_date]" placeholder="MM/AA" autocomplete="off">
            </div>
            <div class="form-group col-sm-7 required form-group-cvv">
                <label for="inputCardCVV">Código de Segurança:</label>
                <input type="text" class="form-control" name="data[Order][card_cvv]" id="inputCardCVV" maxlength="4" autocomplete="off">
            </div>
        </div>
        <div class="form-group required">
            <label for="inputParcelas">Número de Parcelas:</label>
            <select class="form-control" id="inputParcelas" name="data[Order][installments]">
                <option value=""></option>
                <option value="1">1x de R$ 129,99 sem juros</option>
            </select>
        </div>
    </div>

    <div class="radio">
        <label for="paymentMethodBoleto">
            <input id="paymentMethodBoleto" class="payment-method" name="data[Order][payment_method]" type="radio" required value="boleto" disabled>
            BOLETO BANCÁRIO
        </label>
    </div>

    <div class="payment-form-boleto hidden">
        <p>
            <span class="payment-icon icon-boleto"></span>
            Imprima o boleto depois de finalizar a compra
        </p>
    </div>
<?php echo $this->Form->end(); ?>

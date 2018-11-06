<h4 class="hidden-sm visible-xs">RESUMO DA COMPRA</h4>
<table class="table table-condensed">
    <thead>
    <tr>
        <th>CURSO</th>
        <th class="text-right">PREÇO</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($carts as $cart) {?>
        <tr>
            <td class="curso">
                <p><?php echo $cart['Course']['name']; ?></p>
                <ul>
                    <?php
                    if (isset($cart['City']['name']) && isset($cart['State']['abbreviation'])) {
                        echo '<li>' . $cart['City']['name'] . '-' . $cart['State']['abbreviation'] . '</li>';
                    } else {
                        echo isset($cart['State']['name']) ? '<li>' . $cart['State']['name'] .'</li>': '';
                        echo isset($cart['City']['name']) ? '<li>' . $cart['City']['name'] .'</li>': '';
                    }
                    ?>
                    <?php echo isset($cart['Cart']['renach']) ? '<li>RENACH: ' . $cart['Cart']['renach'] .'</li>': ''?>
                    <?php echo isset($cart['Cart']['cnh_category']) ? '<li>Categoria: ' . $cart['Cart']['cnh_category'] .'</li>': ''?>
                </ul>
            </td>
            <td class="text-right text-nowrap">R$ <?php echo number_format($cart['Cart']['unitary_value'], 2, ',', '.'); ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<p class="subtotal">SUBTOTAL: <span>R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></span></p>
<?php if ($discount > 0) { ?>
<p class="subtotal">DESCONTO: <span>- R$ <?php echo number_format($discount, 2, ',', '.'); ?></span></p>
<?php } ?>
<p class="total">TOTAL: <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span></p>
<p id="resumo-forma-pagamento" class="forma-pagamento"></p>

<button id="btn-finalizar" class="btn btn-checkout btn-finalizar" disabled>FINALIZAR COMPRA</button>

<p class="termos">Ao clicar em finalizar compra você estará aceitando os <a class="link-modal-termos" href="#" data-href="/termos-de-servico" data-toggle="modal" data-target="#modal-termos">termos</a> do contrato.</p>

<div class="modal fade bannerformmodal" tabindex="-1" role="dialog" id="modal-termos">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">Termos do Serviço</h5>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<?php if (isset($refresh)) { ?>
<script>checkout.setTotalAmount(parseFloat(<?php echo $total?>));</script>
<?php } ?>

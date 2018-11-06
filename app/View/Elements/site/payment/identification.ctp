<?php if (isset($userValid) && $userValid && isset($user['User'])) {?>

<?php if (isset($success) && $success) { ?>
<script>checkout.initStepPay(true);</script>
<?php } ?>

<h4 class="welcome">Olá, <span class="firstname"><?php echo $this->Utility->getFirstName($user['User']['name']) ?></span>!</h4>
<p>Preencha os dados de pagamento para finalizar o seu pedido.</p>
<p>&nbsp;</p>
<a class="payment-logout" href="/users/logout">Sair</a>

<?php } elseif (isset($user['User'])) { ?>

<h4>COMPLETE SEU CADASTRO</h4>

<div class="cadastro-block">
    <?php echo $this->Element('site/payment/form-cadastro');?>
</div>

<?php } else { ?>

<h4>JÁ É CADASTRADO?</h4>
<button class="btn btn-checkout btn-abrir-login">FAÇA SEU LOGIN</button>

<div class="login-block<?php echo isset($userAction) && $userAction == 'login' ? '' : ' hidden'?>">
    <?php echo $this->Element('site/payment/form-login');?>
</div>
<hr>

<h4>NÃO TEM CADASTRO?</h4>
<button class="btn btn-checkout btn-abrir-cadastro">CADASTRE-SE</button>

<div class="cadastro-block<?php echo isset($userAction) && $userAction == 'cadastro' ? '' : ' hidden'?>">
    <?php echo $this->Element('site/payment/form-cadastro');?>
</div>

<?php } ?>

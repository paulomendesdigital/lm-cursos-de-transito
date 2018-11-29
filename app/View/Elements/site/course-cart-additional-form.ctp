<?php
if (!$stateActive) {?>
    <p class="only_school"><strong>Este curso ainda não está disponível no seu estado. </strong></p>
    <p>Clique em <a href="javascript:smartsupp('chat:open');">Fale Conosco</a> para maiores informações.</p>
<?php } elseif ($order_in_school) { ?>
    <p class="only_school"><strong>Adquira este curso através da sua Autoescola ou <a href="javascript:smartsupp('chat:open');">Fale Conosco</a>.</strong></p>
<?php } else {

    if ($recycle && $state_id == 19) { //CURSO DE RECICLAGEM RIO DE JANEIRO ?>
        <div id="additional-form">
            <p>Preencha o formulário abaixo para validar a sua matrícula.</p>
            <?php if (isset($user) && $user) { ?>
                <?php echo $this->Form->hidden('Cart.cpf', ['value' => $user['cpf']]); ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <input type="text" value="<?php echo $user['cpf'] ?>" disabled>
                </div>
            <?php } else { ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <?php echo $this->Form->input('Cart.cpf', ['div' => false, 'label' => false, 'required' => true, 'maxlength' => 20, 'data-mask' => 'cpf', 'data-msg-required' => 'Digite o seu CPF.', 'data-rule-cpfbr="true"']); ?>
                </div>
            <?php } ?>
            <div class="form-element">
                <label>Formulário RENACH<span class="required">*</span></label>
                <?php echo $this->Form->input('Cart.renach', ['div' => false, 'label' => false, 'required' => true, 'placeholder' => 'RJ999999999', 'minlength' => 11, 'maxlength' => 11, 'style' => 'text-transform: uppercase;', 'data-msg-required' => 'Digite o seu RENACH.']); ?>
            </div>
            <div class="form-element">
                <label>Categoria da CNH<span class="required">*</span>
                    <a class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalCategoria"
                       href='javascript:void(0)'><i class="glyphicon glyphicon-question-sign"
                                                    aria-hidden="true"></i></a>
                </label>
                <?php echo $this->Form->input('Cart.cnh_category', ['div' => false, 'empty' => 'Selecione', 'options' => $cnh_categories, 'label' => false, 'required' => true, 'data-msg' => 'Selecione a categoria.']); ?>
                <p>Selecione a categoria da sua habilitação.</p>
            </div>
        </div>
    <?php } elseif (($recycle || $especializado) && $state_id == 26) { //CURSO DE RECICLAGEM OU ESPECIALIZADO DE SERGIPE ?>
        <div id="additional-form">
            <p>Preencha o formulário abaixo para validar a sua matrícula.</p>
            <?php if (isset($user) && $user) { ?>
                <?php echo $this->Form->hidden('Cart.cpf', ['value' => $user['cpf']]); ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <input type="text" value="<?php echo $user['cpf'] ?>" disabled>
                </div>
            <?php } else { ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <?php echo $this->Form->input('Cart.cpf', ['div' => false, 'label' => false, 'required' => true, 'maxlength' => 20, 'data-mask' => 'cpf', 'data-msg-required' => 'Digite o seu CPF.', 'data-rule-cpfbr="true"']); ?>
                </div>
            <?php } ?>
        </div>
    <?php } elseif ($recycle && $state_id == 2) { //CURSO DE RECICLAGEM DE ALAGOAS  ?>
        <div id="additional-form">
            <p>Preencha o formulário abaixo para validar a sua matrícula.</p>
            <?php if (isset($user) && $user) { ?>
                <?php echo $this->Form->hidden('Cart.cpf', ['value' => $user['cpf']]); ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <input type="text" value="<?php echo $user['cpf'] ?>" disabled>
                </div>
            <?php } else { ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <?php echo $this->Form->input('Cart.cpf', ['div' => false, 'label' => false, 'required' => true, 'maxlength' => 20, 'data-mask' => 'cpf', 'data-msg-required' => 'Digite o seu CPF.', 'data-rule-cpfbr="true"']); ?>
                </div>
            <?php } ?>
        </div>
    <?php } elseif ($recycle && $state_id == 16) { //CURSO DE RECICLAGEM DE PARANÁ  ?>
        <div id="additional-form">
            <p>Preencha o formulário abaixo para validar a sua matrícula.</p>

            <?php echo $this->Form->hidden('Cart.sender', ['value' => $sender]); ?>
            
            <?php if (isset($user) && $user) { ?>
                <?php echo $this->Form->hidden('Cart.cpf', ['value' => $user['cpf']]); ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <input type="text" value="<?php echo $user['cpf'] ?>" disabled>
                </div>
            <?php } else { ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <?php echo $this->Form->input('Cart.cpf', ['div' => false, 'label' => false, 'required' => true, 'maxlength' => 20, 'data-mask' => 'cpf', 'data-msg-required' => 'Digite o seu CPF.', 'data-rule-cpfbr="true"']); ?>
                </div>
            <?php } ?>

            <?php if (isset($user) && $user && isset($user['Student'][0]['birth']) && $user['Student'][0]['birth'] != '') { ?>
                <?php echo $this->Form->hidden('Cart.birth', ['value' => $user['Student'][0]['birth']]); ?>
                <div class="form-element">
                    <label>Data de Nascimento:<span class="required">*</span></label>
                    <input type="text" value="<?php echo $this->Utility->__FormatDate($user['Student'][0]['birth'], 'Normal') ?>" disabled>
                </div>
            <?php } else { ?>
                <div class="form-element">
                    <label>Data de Nascimento:<span class="required">*</span></label>
                    <?php echo $this->Form->input('Cart.birth', ['div' => false, 'label' => false, 'required' => true, 'data-mask' => 'date', 'data-rule-dateITA' => 'true']); ?>
                </div>
            <?php } ?>

            <div class="form-element">
                <label>Registro CNH<span class="required">*</span></label>
                <?php echo $this->Form->input('Cart.cnh', ['div' => false, 'label' => false, 'required' => true, 'minlength' => 5, 'maxlength' => 11, 'data-msg-required' => 'Digite o número da CNH.']); ?>
            </div>

        </div>
    <?php } elseif ($recycle && $state_id == 10) { //CURSO DE RECICLAGEM DE MARANHAO  ?>
        <div id="additional-form">
            <?php if (isset($user) && $user) { ?>
                <?php echo $this->Form->hidden('Cart.cpf', ['value' => $user['cpf']]); ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <input type="text" value="<?php echo $user['cpf'] ?>" disabled>
                </div>
            <?php } else { ?>
                <div class="form-element">
                    <label>CPF<span class="required">*</span></label>
                    <?php echo $this->Form->input('Cart.cpf', ['div' => false, 'label' => false, 'required' => true, 'maxlength' => 20, 'data-mask' => 'cpf', 'data-msg-required' => 'Digite o seu CPF.', 'data-rule-cpfbr="true"']); ?>
                </div>
            <?php } ?>
        </div>
    <?php }
} ?>

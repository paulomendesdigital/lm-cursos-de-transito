<?php if(!$this->Session->read('Ticket')){ ?>

    <p class="open-cupom" role="button" data-toggle="collapse" data-target="#cupom-collapse">Possui cupom de desconto? <i class="pull-right glyphicon glyphicon-menu-down"></i> </p>

    <div id="cupom-collapse" class="collapse<?php echo $this->request->is('post')? ' in' : ''?>">
        <?php
        echo $this->Form->create('Cart',['url' => ['controller'=>'carts','action'=>'add_ticket'], 'id' => 'cupom-form', 'default' => false]);
        ?>
        <div class="form-group form-group-cupom">
            <div class="input-group">
            <?php echo $this->Form->input('code',['div'=>false,'label'=>false, 'required' => true, 'class' => 'form-control', 'placeholder' => 'Digite o código do cupom', 'id' => 'inputCupom', 'disabled' => true]); ?>
            <button id="btnCupom" type="submit" class="btn btn-cupom" disabled>Usar Cupom</button>
            </div>
            <?php if (isset($message)) { ?>
                <span class="help-inline error-message"><?php echo $message ?></span>
            <?php } ?>
        </div>
        <?php echo $this->Form->end(); ?>
    </div>

<?php } else { ?>
    <p>Cupom Aplicado:</p>
    <?php echo $this->Form->create('Cart',['url'=>['controller'=>'carts','action'=>'remove_ticket'], 'id' => 'cupom-form']); ?>
    <?php echo $this->Form->hidden('code',['value'=>$this->Session->read('Ticket.code')]); ?>
    <p>
        <strong><?php echo $this->Session->read('Ticket.code')?></strong>
        <button type="submit" class="btn btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i> Remover Cupom</button>
    </p>
    <?php echo $this->Form->end(); ?>
<?php } ?>
<hr>

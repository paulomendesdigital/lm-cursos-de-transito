<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * NossaEquipe View
 *
*/ ?>
<div id='cart' class='page'>
    <div class='container'>
        <?php echo $this->Utility->breadcumbs([
            'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
            'Carrinho' => ['controller'=>'carts','action'=>'index','prefixes'=>false]
        ]);
        ?>
        <?php if( !empty($carts) ){?>
            <div class='table-lms-container table-cart-container'>
                <h3 class='table-title'>Cursos</h3>
                <div class='table-lms table-cart'>
                    <div class='table-header'>
                        <div class='table-row'>
                            <div class='table-cell'></div>
                            <div class='table-cell'>Curso</div>
                            <div class='table-cell'>Preço Normal</div>
                            <div class='table-cell'>Preço Promocional</div>
                            <div class='table-cell'>Excluir</div>
                        </div>
                    </div>
                    <div class='table-body'>
                        <?php foreach($carts as $cart){ ?>
                            <?php                                 
                                $price = !empty($cart['Cart']['unitary_discount']) ? $cart['Cart']['unitary_value'] : $cart['Course']['price'];                                
                                $promotional_price = !empty($cart['Cart']['unitary_discount']) ? $cart['Cart']['unitary_value'] - $cart['Cart']['unitary_discount'] : $cart['Course']['promotional_price'];
                            ?>
                            <div class='table-row'>
                                <div class='table-cell course-image-cell'>
                                    <span class='cell-label'>Imagem</span>
                                    <span class='cell-value'><figure class='course-image thumbnail'><?php echo $this->Html->image("/files/course/image/{$cart['Course']['id']}/{$cart['Course']['image']}"); ?></figure></span>
                                </div>
                                <div class='table-cell'>
                                    <span class='cell-label'>Curso</span>
                                    <div class='course-name cell-value'>
                                        <p><?php echo $cart['Course']['name']; ?></p>
                                        <ul class="list-unstyled">
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
                                    </div>
                                </div>
                                <div class='table-cell'>
                                    <span class='cell-label'>Preço Normal</span>
                                    <span class='cell-value old-price'>De: R$ <?php echo number_format($price, 2,',','.'); ?></span>
                                </div>
                                <div class='table-cell'>
                                    <span class='cell-label'>Preço Promocional</span>
                                    <span class='cell-value new-price'>Por: R$ <?php echo number_format($promotional_price, 2,',','.'); ?> à vista</span>
                                </div>
                                <div class='table-cell'>
                                    <span class='cell-label'>Remover</span>
                                    <span class='cell-value'>
                                        <?php echo $this->Html->link('<i class="fa fa-remove"></i>','javascript:void(0)',['escape'=>false,'class'=>'remove-button','data-toggle'=>'remove-cart','data-id'=>$cart['Cart']['id']]); ?>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <hr/>
            <div class='coupon-form'>
                <?php if(!$this->Session->read('Ticket')){ ?>
                    <?php echo $this->Form->create('Cart',['url'=>['controller'=>'carts','action'=>'add_ticket','prefixes'=>false]]); ?>
                        <div class='row-form-element'>
                            <div class='coupon-form-elements form-element'>                                        
                                <?php echo $this->Form->input('code',['div'=>false,'label'=>false]); ?>
                                <button type='submit' class='btn button btn-info'>Usar Cupom</button>
                            </div>
                        </div>
                    <?php echo $this->Form->end(); ?>
                <?php }else{ ?>                    
                    <?php echo $this->Form->create('Cart',['url'=>['controller'=>'carts','action'=>'remove_ticket','prefixes'=>false]]); ?>
                        <?php echo $this->Form->hidden('code',['value'=>$this->Session->read('Ticket.code')]); ?>
                        <div class='row-form-element'>
                            <div class='coupon-form-elements form-element'>                                                                       
                                <?php echo $this->Form->input('code_visible',['div'=>false,'label'=>false,'value'=>$this->Session->read('Ticket.code'),'disabled'=>true]); ?>
                                <button type='submit' class='btn button btn-info'>Remover Cupom</button>
                            </div>
                        </div>
                    <?php echo $this->Form->end(); ?>
                <?php } ?>
            </div>
            <hr/>
            <div class='next-step-form'>                
                <div class='row-form-element'>
                    <div class='form-element'>
                        <?php echo $this->Html->link('Avançar',['controller'=>'orders','action'=>'payment','prefixes'=>false],['class'=>'button btn btn-success btn-lg button-submit']); ?>                        
                    </div>
                </div>                
            </div>
        <?php }else{ ?>
            <?php echo $this->Html->link("Continuar Comprando",['controller'=>'pages', 'action'=>'index'],['class'=>'button btn green large']); ?>
        <?php } ?>
    </div>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function() {
        initCartUI();
    }, true);
</script>

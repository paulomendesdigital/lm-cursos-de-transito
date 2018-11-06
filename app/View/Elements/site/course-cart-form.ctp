<div class="buy-section<?php echo isset($class) ? ' ' . $class : ''?>">
    <?php echo $this->Form->create('Cart',['id' => 'cart-form', 'class' => 'cart-form', 'url' => ['controller'=>'carts','action'=>'add']]); ?>
    <?php echo $this->Form->input('course_id',['type'=>'hidden','data-toggle'=>'course-id-input', 'value'=>$course['Course']['id']]); ?>
    <?php echo $this->Form->input('course_scope',['type'=>'hidden','data-toggle'=>"course-scope",'value'=>$course['CourseType']['scope']]); ?>

    <div class="box">
        <?php switch ($course['CourseType']['scope']) {
            case $course_scopes['Municipal']: ?>
                <p>Selecione o <b>Estado</b> e <b>Município</b> abaixo no qual irá <b class='text-success'>trabalhar</b> para exibir o valor do curso.</p>
                <div class='row-form-element'>
                    <div class='form-element'>
                        <label>Estado<span class='required'>*</span></label>
                        <?php echo $this->Form->input('state_id',['empty'=>'Selecione o estado','required'=>true,'options'=>$states,'label'=>false,'div'=>false,'data-toggle'=>'course-module-state']); ?>
                    </div>
                </div>
                <div class='row-form-element'>
                    <div class='form-element'>
                        <label>Município<span class='required'>*</span></label>
                        <?php echo $this->Form->input('citie_id',['empty'=>'Selecione o município','required'=>true,'options'=>null,'label'=>false,'div'=>false,'data-toggle'=>'course-module-city']); ?>
                    </div>
                </div>
                <?php break; ?>
            <?php case $course_scopes['Estadual']: ?>
                <?php if ($currentCourseState) { ?>
                    <?php echo $this->Form->input('state_id',['type'=>'hidden', 'value' => $currentCourseState['State']['id']]); ?>
                <?php } else { ?>
                <p>Selecione o <b>Estado</b> abaixo no qual irá <b class='text-success'>estudar</b> para exibir o valor do curso.</p>
                <div class='row-form-element'>
                    <div class='form-element'>
                        <label>Estado<span class='required'>*</span></label>
                        <?php echo $this->Form->input('state_id',['empty'=>'Selecione o estado','required'=>true,'options'=>$states,'label'=>false,'div'=>false,'data-toggle'=>'course-module-state', 'data-msg' => 'Escolha o estado.']); ?>
                    </div>
                </div>
                <?php } ?>
                <?php break; ?>
        <?php } ?>

        <div id="additional-form-container" class="row-form-element">
            <?php echo $this->Element('site/course-cart-additional-form'); ?>
        </div>
    </div>
    <div class="box">
            <div class="promotion-price<?php if ($course['CourseType']['scope'] != $course_scopes['Nacional'] && !$currentCourseState) { echo ' hidden';}?>">
                <p class="old-price">De: <span>R$ <?php echo number_format($course['Course']['price'], 2,',','.'); ?></span> por</p>
                <p class="new-price"><span data-toggle='promotional-price'>R$ <?php echo number_format($course['Course']['promotional_price'], 2,',','.'); ?></span> à vista</p>
                <p class="ou">ou</p>
                <p class="preco parcelas">10x de <span data-toggle="promotional-installment">R$ <?php echo number_format($course['Course']['promotional_price'] / 10, 2, ',', '.')?></span></p>
                <p>sem juros no cartão</p>
            </div>

            <?php if ($stateActive && !$order_in_school) {?>
                <button type="submit" class="button btn-success btn-comprar" > Matricule - se</button >
            <?php } ?>

            <div class="formas-pagamento">
                <a data-toggle="collapse" href="#deposito-bancario" aria-expanded="false" aria-controls="collapseExample">Pagamento em Depósito Bancário?</a>
                <div class="collapse" id="deposito-bancario">
                    <p>Entre em contato para saber mais informações.</p>
                    <p>
                        (21) 97973-5951 (Tim)<br />
                        (21) 96428-8218 (Nextel)<br />
                        (21) 96475-7684 (Nextel)<br />
                        (21) 97455-3133 (Claro)<br />
                        (21) 96747-1988 (Vivo)<br />
                        (21) 3268-3204 Fixo <br />
                        (21) 3268-3207
                    </p>
                </div>
            </div>
        </div>
    <?php echo $this->Form->end(); ?>
</div>

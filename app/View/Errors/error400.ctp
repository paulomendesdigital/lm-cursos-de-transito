<div class="page-section-heading">
    <h2 class="text-display-1"><i class="fa fa-warning fa-fw"></i> Ooops!</h2>
    <!-- <p class="lead text-muted">Desculpe, a página solicitada não está disponível.</p> -->
    <p class="lead text-muted"><?php echo h($error->getMessage()); ?></p>
    <p class="lead text-muted">
    	<?php if( !strstr(h($error->getMessage()), 'correta dos slides!') ):?>
    		<?php echo $this->Html->link('voltar','javascript:void(0);',array('onclick'=>'javacript:history.back(-1)')); ?>
    	<?php else:?>
    		<?php echo $this->Html->link('voltar','javascript:void(0);',array('onclick'=>'javacript:history.back(-2)')); ?>
    	<?php endif;?>
    </p>
</div>
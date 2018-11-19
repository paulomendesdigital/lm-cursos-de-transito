<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<div class="item col-xs-12 col-md-3 col-sm-6 col-lg-4">
   <div class="panel panel-default paper-shadow" data-z="0.5">
      
      <div class="cover overlay cover-image-full hover">
         <span class="img icon-block height-100 bg-default"></span>
         <?php //echo $this->Html->link('<span class="v-center"><i class="fa fa-car"></i></span>', ['controller' => 'meus-cursos', 'action' => 'course', $order_course['OrderCourse']['token']], ['class' => 'padding-none overlay overlay-full icon-block bg-default', 'escape' => false]);?>
         <?php echo $this->Html->link($this->Html->image("/files/course/image/{$order_course['Course']['id']}/vga_{$order_course['Course']['image']}",['class'=>'img-circle']), ['controller' => 'meus-cursos', 'action' => 'course', $order_course['OrderCourse']['token']], ['class' => 'padding-none overlay overlay-full icon-block bg-default', 'escape' => false]);?>

         <?php echo $this->Html->link('<span class="v-center"><span class="btn btn-circle btn-white btn-lg"><i class="fa fa-graduation-cap"></i></span></span>', ['controller' => 'meus-cursos', 'action' => 'course', $order_course['OrderCourse']['token']], ['class' => 'overlay overlay-full overlay-hover overlay-bg-white', 'escape' => false]);?>
      </div>

      <div class="panel-body">
         <h4 class="text-headline margin-v-0-10">
            <?php echo $this->Html->link($order_course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $order_course['OrderCourse']['token']]);?>
         </h4>
      </div>
      <hr class="margin-none">
      <div class="panel-body">
         <p>
            <?php echo $this->Html->link('Ir para o curso', ['controller' => 'meus-cursos', 'action' => 'course', $order_course['OrderCourse']['token']], ['class' => 'btn btn-white btn-flat paper-shadow relative', 'data-z' => 0, 'data-hover' => 1, 'data-animated' => '']);?>
         </p>
         <?php if( !empty($order_course['OrderCourse']['renach']) ):?>
            <p class="text-right"><span><b>Renach:</b> <?php echo $order_course['OrderCourse']['renach'];?></span></p>
         <?php endif;?>
         <p class="text-right"><small><b>Data da Compra:</b> <?php echo $this->Utility->__FormatDate($order_course['Order']['created'],'Normal');?></small></p>
      </div>
   </div>
</div>
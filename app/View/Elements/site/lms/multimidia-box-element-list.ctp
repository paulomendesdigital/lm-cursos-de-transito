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
         <?php echo $this->Html->link($this->Html->image("/files/course_multimidia/image/{$midia['CourseMultimidia']['id']}/vga_{$midia['CourseMultimidia']['image']}",['class'=>'img-circle']), 'javascript:void(0);', ['class' => 'padding-none overlay overlay-full icon-block bg-default', 'escape' => false,'target'=>'_blank']);?>

         <?php echo $this->Html->link('<span class="v-center"><span class="btn btn-circle btn-white btn-lg"><i class="fa fa-book"></i></span></span>', ['controller'=>'sala-multimidia', 'action'=>'multimidia', $midia['CourseMultimidia']['id'], $token, $course_id], ['class' => 'overlay overlay-full overlay-hover overlay-bg-white', 'escape' => false]);?>
      </div>

      <div class="panel-body">
         <h4 class="text-headline margin-v-0-10">
            <?php echo $this->Html->link($midia['CourseMultimidia']['name'], ['controller'=>'sala-multimidia', 'action'=>'multimidia', $midia['CourseMultimidia']['id'], $token, $course_id], ['escape'=>false]);?>
         </h4>
      </div>
      <hr class="margin-none">
      <div class="panel-body">
         <?php echo $this->Html->link('Acessar conteúdo', ['controller'=>'sala-multimidia', 'action'=>'multimidia', $midia['CourseMultimidia']['id'], $token, $course_id], ['class' => 'btn btn-white btn-flat paper-shadow relative', 'data-z' => 0, 'data-hover' => 1, 'data-animated' => '','escape'=>false]);?>
      </div>
   </div>
</div>
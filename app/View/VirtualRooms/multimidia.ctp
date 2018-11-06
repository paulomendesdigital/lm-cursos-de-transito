<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>

<?php $course_name = isset($midia['Course']['name']) ? $midia['Course']['name'] : 'Curso';?>
<div class="container">
  <div class="page-section">
    <div class="row">
      <div class="col-md-12">
        <p class="text-light text-caption">
          <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'virtual_rooms', 'action' => 'index']); ?>
          <i class="fa fa-fw fa-angle-right"></i> <?php echo $this->Html->link($course_name, ['controller' => 'meus-cursos', 'action' => 'course', $token]); ?>
          <i class="fa fa-fw fa-angle-right"></i> <?php echo $this->Html->link('Sala Multimidia', ['controller' => 'sala-multimidia', 'action' => 'multimidias', $token, $course_id]); ?>
          <i class="fa fa-fw fa-angle-right"></i> <?php echo $midia['CourseMultimidia']['name'];?>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <?php echo $midia['CourseMultimidia']['text'];?>
      </div>
    </div>
  </div>
</div>
<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>

<?php $course_name = isset($midias[0]['Course']['name']) ? $midias[0]['Course']['name'] : 'Curso';?>
<div class="container">
  <div class="page-section">
    <div class="row">
      <div class="col-md-12">
        <p class="text-light text-caption">
          <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'virtual_rooms', 'action' => 'index']); ?>
          <i class="fa fa-fw fa-angle-right"></i> <?php echo $this->Html->link($course_name, ['controller' => 'meus-cursos', 'action' => 'course', $token]); ?>
          <i class="fa fa-fw fa-angle-right"></i> Sala Multimidia
        </p>
        
        <?php if( !empty($midias) ):?>
            <div class="row" data-toggle="isotope">
          <?php $i=0; foreach ($midias as $midia):?>
              <?php echo $this->Element('site/lms/multimidia-box-element-list', ['midia' => $midia, 'token'=>$token, 'course_id'=>$course_id]);?>
          <?php $i++; endforeach;?>
            </div>
        <?php else:?>
          <div class="row" data-toggle="isotope">
            <div class="panel-body text-center">
              <h4 class="text-headline"><i class="fa fa-fw fa-meh-o"></i> Não há itens no momento!</h4>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
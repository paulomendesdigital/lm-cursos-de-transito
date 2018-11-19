<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>

<?php $course_name = isset($libraries[0]['Course']['name']) ? $libraries[0]['Course']['name'] : 'Curso';?>
<div class="container">
  <div class="page-section">
    <div class="row">
      <div class="col-md-12">
        <p class="text-light text-caption">
          <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'virtual_rooms', 'action' => 'index']); ?>
          <i class="fa fa-fw fa-angle-right"></i> <?php echo $this->Html->link($course_name, ['controller' => 'meus-cursos', 'action' => 'course', $token]); ?>
          <i class="fa fa-fw fa-angle-right"></i> Biblioteca Virtual
        </p>
        
        <?php if( !empty($libraries) ):?>
            <div class="row" data-toggle="isotope">
          <?php $i=0; foreach ($libraries as $library):?>
              <?php echo $this->Element('site/lms/library-box-element-list', ['library' => $library]);?>
          <?php $i++; endforeach;?>
            </div>
        <?php else:?>
          <div class="row" data-toggle="isotope">
            <div class="panel-body text-center">
              <h4 class="text-headline"><i class="fa fa-fw fa-meh-o"></i> Não há livros cadastrados no momento!</h4>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
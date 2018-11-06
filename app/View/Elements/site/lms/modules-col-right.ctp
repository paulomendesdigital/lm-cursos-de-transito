<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<?php if( !empty($modules) ): $showLines = false; ?>
  <?php foreach ($modules as $module):?>
    <?php if( $module_discipline['Module']['id'] == $module['Module']['id'] ): ?>
      <?php $showLines = true;?>  
    <?php endif;?>
    <?php if( $showLines ):?>
      <?php echo $this->Element('site/lms/module-box-element-list', ['module' => $module, 'progress_in_module'=>false, 'in_column_right'=>true]);?>  
    <?php endif;?>
  <?php endforeach;?>
<?php endif;?>

<?php if( $course['Course']['is_course_avaliation'] ): //se o curso tem avaliação final?>

  <?php echo $this->Element('site/lms/avaliation-final', ['course'=>$course,'modules'=>$modules]);?>
 
<?php endif;?>

<?php if( $course['Course']['is_course_certificate'] ): //Se o curso tiver certficiado?>
 
  <?php if( empty($poll) ): //Se $poll for vazio é pq não existe avalicao cadastrada ou ele já respondeu.?>
   
    <?php echo $this->Element('site/lms/certificate-box-element-list', ['course'=>$course,'modules'=>$modules]);?>
 
  <?php else:?>
   
    <?php if( $course['Course']['avaliation']['show_certificate'] ):?>
      <?php echo $this->Element('site/lms/pesquisa-avaliacao-curso', ['course'=>$course,'modules'=>$modules, 'poll'=>$poll]);?>
    <?php endif;?>
 
  <?php endif;?>
<?php endif;?>
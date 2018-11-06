<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<div class="col-md-3">
   <h5 class="text-subhead-2 text-light">Meu bloco de anotações</h5>
   <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
      <div class="panel-body list-group">
         <div class="list-group list-group-menu">
            <?php //echo $this->Html->link('<i class="fa fa-fw fa fa-edit"></i> Abrir', 'javascript:void(0);', ['data-toggle'=>'modal', 'data-target'=>'formNotepadModal', 'escape' => false, 'class' => 'list-group-item']);?>
            <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#formNotepadModal">
              <i class="fa fa-fw fa fa-edit"></i> Abrir
            </button>
         </div>
      </div>
   </div>

   <h5 class="text-subhead-2 text-light">Mais sobre o curso</h5>
   <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
      <div class="panel-body list-group">
         <div class="list-group list-group-menu">
            <?php 
            $class_modulos    = strpos($_SERVER["REQUEST_URI"], 'meus-cursos')?'active':'';
            $class_forum      = strpos($_SERVER["REQUEST_URI"], 'foruns')?'active':'';
            $class_mensagem   = strpos($_SERVER["REQUEST_URI"], 'fale-com-instrutores')?'active':'';
            $class_progresso  = strpos($_SERVER["REQUEST_URI"], 'courso-progresso')?'active':'';
            $class_workbook   = strpos($_SERVER["REQUEST_URI"], 'apotilas')?'active':'';
            $class_libraries  = strpos($_SERVER["REQUEST_URI"], 'biblioteca-virtual')?'active':'';
            $class_multimidia = strpos($_SERVER["REQUEST_URI"], 'sala-multimidia')?'active':'';
            $class_equipe     = strpos($_SERVER["REQUEST_URI"], 'fale-com-equipe-multidisciplinar')?'active':'';
            ?>

            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-graduation-cap"></i> Módulos de estudo', ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]], ['escape' => false, 'class' => 'list-group-item '.$class_modulos.'']);?>
            
            <?php echo !empty($course['Course']['student_guide']) ? $this->Html->link('<i class="fa fa-fw fa fa-link"></i> Guia do Aluno', "/files/course/student_guide/{$course['Course']['id']}/{$course['Course']['student_guide']}", ['target'=>'_blank','escape' => false, 'class' => 'list-group-item']) : '';?>

            <?php echo !empty($course['Course']['navigability_guide']) ? $this->Html->link('<i class="fa fa-fw fa fa-link"></i> Guia de Navegabilidade', "/files/course/navigability_guide/{$course['Course']['id']}/{$course['Course']['navigability_guide']}", ['target'=>'_blank','escape' => false, 'class' => 'list-group-item']) : '';?>

            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-bookmark"></i> Apostilas do Curso', ['controller' => 'apostilas', 'action' => 'workbooks', $this->params['pass'][0], $course['Course']['id']], ['escape' => false, 'class' => 'list-group-item '.$class_workbook]);?>
            
            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-tasks"></i> Progresso do curso', ['controller' => 'curso-progresso', 'action' => 'course_progress', $this->params['pass'][0]], ['escape' => false, 'class' => 'list-group-item '.$class_progresso.'']);?>
            
            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-file-text"></i> Fórum Virtual', ['controller' => 'foruns', 'action' => 'index', $this->params['pass'][0]], ['escape' => false, 'class' => 'list-group-item '.$class_forum.'']);?>
            
            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-book"></i> Biblioteca Virtual', ['controller' => 'biblioteca-virtual', 'action' => 'libraries', $this->params['pass'][0], $course['Course']['id']], ['escape' => false, 'class' => 'list-group-item '.$class_libraries.'']);?>
            
            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-certificate"></i> Sala Multimídia', ['controller' => 'sala-multimidia', 'action' => 'multimidias', $this->params['pass'][0], $course['Course']['id']], ['escape' => false, 'class' => 'list-group-item '.$class_multimidia.'']);?>
            
            <?php 
            if(isset($course['CourseInstructor'][0]['token'])):
               echo $this->Html->link('<i class="fa fa-fw fa fa-envelope"></i> Fale com tutores', ['controller' => 'fale-com-instrutores', 'action' => 'view', $this->params['pass'][0], $course['CourseInstructor'][0]['token']], ['escape' => false, 'class' => 'list-group-item '.$class_mensagem.'']);
            endif;
            ?>
            <?php echo $this->Html->link('<i class="fa fa-fw fa fa-envelope"></i> Fale com a Equipe Multidisciplinar', ['controller' => 'fale-com-equipe-multidisciplinar', 'action' => 'contact_team', $this->params['pass'][0]], ['escape' => false, 'class' => 'list-group-item '.$class_equipe.'']);?>
         </div>
      </div>
   </div>
   
   <?php if( !isset($only_first_block) ):?>
   <h5 class="text-subhead-2 text-light">Tutor</h5>
   <?php foreach ($course['CourseInstructor'] as $course_instructor): ?>
      <?php if($course_instructor['Instructor']):?>
         <div class="panel panel-default" data-toggle="panel-collapse" data-open="true">
            <div id="instructor_<?php echo $course_instructor['Instructor']['id'];?>" class="collapse in">
               <div class="panel-body">
                  <div class="media v-middle">
                     <div class="media-left">
                        <?php echo $this->Utility->avatarUser($course_instructor['Instructor']['User']['id'], $course_instructor['Instructor']['User']['avatar'], 'width-60 img-circle');?>
                     </div>
                     <div class="media-body">
                        <h4 class="text-title margin-none"><?php echo $course_instructor['Instructor']['first_name'];?></h4>
                        <span class="caption text-light hidden">Biografia</span>
                     </div>
                  </div>
                  <br>
                  <div class="expandable expandable-indicator-white expandable-trigger hidden">
                     <div class="expandable-content">
                        <p><?php echo $course_instructor['Instructor']['text'];?></p>
                        <div class="expandable-indicator"><i></i></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <?php endif;?>
   <?php endforeach;?>
   <?php endif;?>
</div>
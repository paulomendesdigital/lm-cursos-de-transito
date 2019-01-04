<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Course View
 *
*/ ?>
<?php $btnAnswer = (!empty($btnAnswer) ? $btnAnswer : 'Responder Agora'); ?>

<?php echo $this->Html->script('jQuery-plugin-progressbar');?>
<div class="container">
   <div class="page-section">
      <div class="row">
        <div class="col-md-9">
          <p class="text-light text-caption">
            <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'virtual_rooms', 'action' => 'index']); ?>
            <i class="fa fa-fw fa-angle-right"></i><?php echo $course['Course']['name'];?> 
          </p>

          <?php echo $this->Session->flash(); ?>

         	<div class="page-section padding-top-none">
            <div class="media v-middle">
              <div class="media-body">
                
                <h1 class="text-display-1 margin-none"><?php echo $course['Course']['name'];?> 
                  <small><?php echo $course['Course']['firstname'];?></small>
                  <input type="hidden" id="token" value="<?php echo $token;?>" />
                </h1>
                <!-- <p class="text-subhead"></p>
                <div class="hidden-xs text-justify"><?php //echo $course['Course']['text'];?></div> -->
              </div>
            </div>
          </div>

          <h5 class="text-subhead-2 text-light margin-bottom-0">Módulos</h5>
          
          <?php if( !empty($modules) ): ?>
  			    <?php foreach ($modules as $module):?>
  			 		  <?php echo $this->Element('site/lms/module-box-element-list', ['module' => $module, 'progress_in_module'=>true]);?>  
  			    <?php endforeach;?>
  		    <?php endif;?>

          <?php if( $course['Course']['is_course_avaliation'] ):  //se o curso tem avaliação final?>

            <?php echo $this->Element('site/lms/avaliation-final', ['course'=>$course,'modules'=>$modules]);?>
            
          <?php endif;?>
          
          <?php if( $course['Course']['is_course_certificate'] ): //Se o curso tiver certficiado?>
            
            <?php if( empty($poll) ): //Se $poll for vazio é pq não existe avalicao cadastrada ou ele já respondeu.?>
              <?php echo $this->Element('site/lms/certificate-box-element-list', ['course'=>$course,'modules'=>$modules,'scheduling_link_detran'=>$scheduling_link_detran]);?>
            
            <?php else:?>
              
              <?php if( $course['Course']['avaliation']['show_certificate'] ):?>
                <?php

                echo $this->Element('site/lms/pesquisa-avaliacao-curso', ['course'=>$course,'btnAnswer'=>$btnAnswer,'modules'=>$modules, 'poll'=>$poll]);
                ?>
              <?php endif;?>
            
            <?php endif;?>
          <?php endif;?>
          
  	    </div>
        <?php echo $this->Element('site/lms/course-col-right');?>
      </div>
   </div>
</div>
<script src="//api.handtalk.me/plugin/latest/handtalk.min.js"></script>
<script>
  var ht = new HT({
    token: "9e7ceda432a7b5945f3422a319a8e2d3"
  });
</script>
<script>
$(".progress-bar1").loading();
</script>

<?php if( $course['Course']['face_recognition'] ):?>
  <script>
    if( $('#token').length ){
      var tokenCourse = $('#token').val();
      setInterval( 'changeBiometria(tokenCourse)', <?php echo Configure::read('Sistems.TimeForBiometriaFacial');?>);
    }
  </script>
<?php endif;?>

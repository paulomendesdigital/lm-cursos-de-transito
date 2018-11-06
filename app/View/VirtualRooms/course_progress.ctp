<?php echo $this->Html->script('jQuery-plugin-progressbar');?>

<div id='course-progress'>
  <?php /**
   * @copyright Copyright 2018
   * @author Ricardo Aranha - www.lmcursosdetransito.com.br
   * Course View
   *
  */ ?>
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
                  </h1>
                  
                </div>
              </div>
            </div>

            <h5 class="text-subhead-2 text-light">Módulos</h5>
            
            <?php if( !empty($modules) ):?>
    			    <?php foreach ($modules as $module):?>
    			 		  <?php echo $this->Element('site/lms/module-box-element-list', ['module' => $module, 'progress'=>true, 'page_progress'=>true]);?>  
    			    <?php endforeach;?>
    		    <?php endif;?>

            <?php if( $course['Course']['is_course_avaliation'] ): //se o curso tem avaliação final?>

              <?php echo $this->Element('site/lms/avaliation-final', ['course'=>$course,'modules'=>$modules]);?>
              
            <?php endif;?>
            
            <?php if( $course['Course']['is_course_certificate'] ): //Se o curso tiver certficiado?>

              <?php echo $this->Element('site/lms/certificate-box-element-list', ['course'=>$course,'modules'=>$modules]);?>
              
            <?php endif;?>
            
    	    </div>
          <?php echo $this->Element('site/lms/course-col-right');?>
        </div>
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
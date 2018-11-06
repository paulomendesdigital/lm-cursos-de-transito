<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>
<div class="container">
  <div class="page-section">
    <div class="row">
      <div class="col-md-12">
        <p class="text-light text-caption"><i class="fa fa-fw icon-dial-pad"></i> Meus Cursos</p>
        <?php if( !empty($order_courses) ):?>
            <div class="row" data-toggle="isotope">
          <?php $i=0; foreach ($order_courses as $order_course):?>
            <?php //echo $i > 0 ? "<div class='row'><div class='col-md-12'><hr class='thick-line margin-bottom-30' /></div></div>" : "";?>
              <?php echo $this->Element('site/lms/course-box-element-list', ['order_course' => $order_course]);?>
          <?php $i++; endforeach;?>
            </div>
        <?php else:?>
          <div class="row" data-toggle="isotope">
            <div class="panel-body text-center">
              <h4 class="text-headline"><i class="fa fa-fw fa-meh-o"></i> Não há cursos liberados no momento!</h4>
            </div>
          </div>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
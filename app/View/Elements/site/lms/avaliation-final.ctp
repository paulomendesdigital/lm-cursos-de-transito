<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<div class="panel panel-default curriculum open paper-shadow" data-z="0.5">
  <div class="panel-heading panel-heading-gray">
     <div class="media">
        <div class="media-left">
           <span class="icon-block img-circle half <?php echo $course['Course']['avaliation']['circle_box']; ?>"><i class="fa fa-align-justify"></i></span>
        </div>
        <div class="media-body">
           <h4 class="text-headline">Avaliação do curso</h4>
        </div>
     </div>
  </div>
  <div class="list-group collapse in">
    <div class="list-group-item media bg-grey-200 text-center" data-target="<?php echo $course['Course']['avaliation']['link_avaliation'];?>">
      <h3 class="text-grey-500"><i class="fa fa-fw <?php echo $course['Course']['avaliation']['icon_avaliation'];?>"></i> <?php echo $course['Course']['avaliation']['label_avaliation'];?></h3>
      <?php echo $course['Course']['avaliation']['message'];?>
    </div>
  </div>
</div>
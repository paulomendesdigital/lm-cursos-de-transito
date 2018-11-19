<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Popup Comunicado Element
 *
*/?>

<div class='popup-flash-container'>
  <div class='popup-flash-outer'>
    <div class='popup-flash success comunicado'>
      <div class='popup-flash-inner'>
        <a href='javascript:void(0)'>
          <i class='fa fa-close button-close'></i>
        </a>        
        <div class='content'>
          <div class='text'>
            <div class='title'><?php echo $this->Html->image( $imagem ,['class'=>'img-responsive']);?></div>          
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
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
        <p class="text-light text-caption"><i class="fa fa-fw icon-dial-pad"></i> Atendimento</p>
        <div class="row" data-toggle="isotope">
          <div class="col-md-12">
            <div class="jumbotron">
              <h1 class="display-4">Atendimento</h1>
                <?php if( $this->Session->read('Auth.User.School.phone') ):?>
                  <p class="lead">
                      Telefone: <?php echo $this->Session->read('Auth.User.School.phone');?>
                  </p>
                <?php endif;?>
                <?php if( $this->Session->read('Auth.User.School.full_address') ):?>
                  <p class="lead">
                      Endereço: <?php echo $this->Session->read('Auth.User.School.full_address');?>
                  </p>
                <?php endif;?>
              <hr class="my-4">
            </div>
          </div>
        </div>
    </div>
  </div>
</div>
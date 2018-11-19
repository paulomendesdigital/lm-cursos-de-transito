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
          <div class="col-md-6">
            <div class="jumbotron">
              <h1 class="display-4">Suporte Técnico</h1>
              <p class="lead" style="min-height: 95px;">A LM Cursos de Trânsito dispõe de suporte técnico pelo chat, e-mail e telefone com profissionais treinados e qualificados para atendê-lo sempre que for preciso.</p>
              
              <hr class="my-4">
              
              <p class="lead"><h4><i class="fa fa-fw fa-comment"></i> Chat de Atendimento</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>Segunda à Sexta, 08h às 20h </br>
                <i class="fa fa-fw fa-asterisk"></i>Sábado, 08h às 14h</br>
                <i class="fa fa-fw fa-asterisk"></i>Domingo, 08h às 12h
              </p>

              <p class="lead"><h4><i class="fa fa-fw fa-envelope"></i> E-mail</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>contato@lmcursosdetransito.com.br
              </p>

              <p class="lead"><h4><i class="fa fa-fw fa-phone-square"></i> Telefone e Whatsapp</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>(21) 3268-3204 </br>
                <i class="fa fa-fw fa-asterisk"></i>(21) 3268-3207</br>
                <i class="fa fa-fw fa-asterisk"></i>(21) 96415-0092
              </p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>Segunda à Sexta, 08h às 20h </br>
                <i class="fa fa-fw fa-asterisk"></i>Sábado, 08h às 14h</br>
                <i class="fa fa-fw fa-asterisk"></i>Domingo, 08h às 12h
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6">
            <div class="jumbotron" style="min-height: 681px;">
              <h1 class="display-4">Suporte Pedagógico</h1>
              <p class="lead">A LM Cursos de Trânsito dispõe de suporte pedagógico pelo chat, e-mail e telefone com Tutores que ajudará a estimular todo o seu potencial de aprendizagem e incentivará um melhor aproveitamento no curso. </p>
              
              <hr class="my-4">
              
              <p class="lead"><h4><i class="fa fa-fw fa-comment"></i> Chat de Atendimento</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>Segunda à sexta 08h às 17h
              </p>

              <p class="lead"><h4><i class="fa fa-fw fa-envelope"></i> E-mail</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>tutor@lmcursosdetransito.com.br
              </p>

              <p class="lead"><h4><i class="fa fa-fw fa-phone-square"></i> Telefone e Whatsapp</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>(21) 3268-3204 </br>
                <i class="fa fa-fw fa-asterisk"></i>(21) 3268-3207</br>
                <i class="fa fa-fw fa-asterisk"></i>(21) 96415-0092
              </p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-asterisk"></i>Segunda à Sexta, 08h às 17h
              </p>
              
              <p class="lead"><h4><i class="fa fa-fw fa-comment"></i> Fale com o tutor</h4></p>
              <p class="lead text-left margin-left-25">
                <i class="fa fa-fw fa-link"></i><?php echo $this->Html->link('Clique Aqui', ['controller' => 'meus-cursos', 'action' => 'index']);?><br />
                <i class="fa fa-fw fa-asterisk"></i>É preciso entrar no curso para falar com seu tutor.
              </p>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>

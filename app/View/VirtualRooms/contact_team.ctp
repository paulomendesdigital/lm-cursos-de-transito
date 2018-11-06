<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Index View
 *
*/ ?>
<?php $course_name = isset($course['Course']['name']) ? $course['Course']['name'] : 'Curso';?>
<div class="container">
  <div class="page-section">
    <div class="row">
      <div class="col-md-12">
        <p class="text-light text-caption">
          <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'virtual_rooms', 'action' => 'index']); ?>
          <i class="fa fa-fw fa-angle-right"></i> <?php echo $this->Html->link($course_name, ['controller' => 'meus-cursos', 'action' => 'course', $token]); ?>
          <i class="fa fa-fw fa-angle-right"></i> Fale com a equipe multidisciplinar
        </p>
      </div>
    </div>
    <div class="row">
      <div id='login-page' class="login page">
        <div id="content">
            <div class="container">
                <div class="lock-container col-md-9 col-xs-12">
                    <div class="panel panel-default text-center paper-shadow" data-z="0.5">
                        <h2 class="text-center margin-bottom-none">Fale com Nossa Equipe</h2>
                        <div class="panel-body text-left">
                            <?php echo $this->Session->flash(); ?>
                            <?php echo $this->Form->create('Contact', array('url'=>array('controller'=>'fale-com-equipe-multidisciplinar','action' => 'contact_team')));?>
                                <div class="form-group">
                                    <div class="form-control-material">
                                      <?php echo $this->Form->input('token',['type'=>'hidden','value'=>$token]); ?>
                                      <?php echo $this->Form->input('name',['placeholder'=>'Informe seu Nome completo','div'=>false,'label'=>false, 'class'=>'form-control', 'required'=>true]); ?>
                                      <label for="nome">Nome</label>                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-material">
                                      <?php echo $this->Form->input('phone',['placeholder'=>'Informe seu telefone','data-mask'=>'cellphone', 'div'=>false,'label'=>false, 'class'=>'form-control', 'required'=>true]); ?>
                                      <label for="nome">Telefone</label>                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-material">
                                      <?php echo $this->Form->input('email',['placeholder'=>'Informe seu email','div'=>false,'label'=>false, 'class'=>'form-control', 'required'=>true]); ?>
                                      <label for="nome">Email</label>                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-material">
                                      <?php echo $this->Form->input('subject',['placeholder'=>'Informe o assunto','div'=>false,'label'=>false, 'class'=>'form-control', 'required'=>true]); ?>
                                      <label for="nome">Assunto</label>                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-control-material">
                                      <?php echo $this->Form->input('message',['type'=>'textarea', 'placeholder'=>'Informe a mensagem','div'=>false,'label'=>false, 'class'=>'form-control textarea', 'required'=>true]); ?>
                                      <label for="nome">Mensagem</label>                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="text-right">
                                      <button type="submit" class="btn btn-primary">Enviar</button>                          
                                    </div>
                                </div>
                            <?php echo $this->Form->end();?>
                        </div>
                    </div>
                </div>
                <?php echo $this->Element('site/lms/course-col-right',['only_first_block'=>true]);?>
            </div>
        </div>
      </div>
      <script type="text/javascript">
          (function(){ 
            if( $('#ContactName').val() ){
              document.getElementById('ContactPhone').focus();
            }else{
              document.getElementById('ContactName').focus();
            }
          })();    
      </script>
    </div>
  </div>
</div>
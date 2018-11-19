<div class="container">
   <div class="page-section">
      <div class="row">
         <div class="col-md-9">

            <p class="text-light text-caption">
            <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
            <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]]); ?>
            <i class="fa fa-fw  fa-angle-right"></i>Fórum
          </p>
          <div class="page-section padding-top-none">
              <div class="media v-middle">
                  <div class="media-body">
                      <h1 class="text-display-1 margin-none"> Fórum</h1>
                      <p class="text-subhead text-light"><?php echo $course['Course']['name'];?> - <?php echo $course['Course']['firstname'];?></p>
                  </div>
                  <div class="media-right">
                      <?php echo $this->Html->link('<i class="fa fa-fw fa-plus"></i> Novo Tópico', ['action' => 'add', $this->params['pass'][0], $course['Course']['token']], ['data-z' => '0.5', 'data-hover-z' => 1, 'data-animated' => '', 'class' => 'btn btn-white paper-shadow relative', 'escape' => false]); ?>
                 </div>
              </div>
          </div>
          <?php echo $this->Session->flash(); ?>

          <div class="page-section padding-top-none">
            <div class="panel panel-default paper-shadow" data-z="0.5">
              <div class="panel-heading">
                <h4 class="text-headline">Novo Tópico</h4>
              </div>
              <div class="panel-body">
                <?php echo $this->Form->create('Forum', array('url'=>array('controller'=>'virtual_room_forums','action'=>'add',$this->params['pass'][0])));
                  echo $this->Form->hidden('course_id',['value'=>$course_id]);
                  echo $this->Form->hidden('citie_id',['value'=>$citie_id]);
                  echo $this->Form->hidden('state_id',['value'=>$state_id]);
                  echo $this->Form->hidden('idToken',['value'=>$idToken]);?>
                  <div class="form-group">
                      <label for="UserName" class="col-md-2 control-label">Nome do tópico</label>
                      <div class="col-md-12">
                          <div class="form-control-material">
                              <div class="input-group">
                                  <?php echo $this->Form->text('name', ['onFocus' => true, 'placeholder' => '', 'class' => 'form-control']);?>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12 text-right">
                      <button class="btn btn-primary" type="submit">Enviar <i class="fa fa-fw fa-plus"></i></button>
                    </div>
                  </div>
                <?php echo $this->Form->end();?>
              </div>
            </div>
          </div>
        </div>
       <?php echo $this->Element('site/lms/course-col-right');?>
      </div>
   </div>
</div>
<script type="text/javascript">
   $(document).ready(function(){
    $('#ForumName').focus();
   });
</script>
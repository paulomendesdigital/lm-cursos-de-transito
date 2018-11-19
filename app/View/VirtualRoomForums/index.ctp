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
                        <?php echo $this->Html->link('<i class="fa fa-fw fa-plus"></i> Novo Tópico', ['action' => 'add', $this->params['pass'][0]], ['data-z' => '0.5', 'data-hover-z' => 1, 'data-animated' => '', 'class' => 'btn btn-white paper-shadow relative', 'escape' => false]); ?>
                   </div>
                </div>
            </div>

            <div class="panel panel-default paper-shadow" data-z="0.5">
               <ul class="list-group">
                   <?php foreach ($forums as $forum):?>
                   <li class="list-group-item media v-middle">
                       <div class="media-left">
                           <div class="icon-block half img-circle bg-grey-300">
                               <i class="fa fa-file-text text-white"></i>
                           </div>
                       </div>
                       <div class="media-body">
                           <h4 class="text-subhead margin-none">
                              <?php echo $this->Html->link($forum['Forum']['name'], ['action' => 'posts', $this->params['pass'][0], $forum['Forum']['token']],['class' => 'link-text-color']); ?> <small class="text-light">Criado por <?php echo $forum['User']['name'];?></small>
                           </h4>
                           <div class="text-light text-caption">
                              <?php if(isset($forum['ForumPost'][0]['User']['name'])): ?>
                                 Ultima postagem <?php echo $this->Utility->avatarUser($forum['ForumPost'][0]['User']['id'], $forum['ForumPost'][0]['User']['avatar'], 'img-circle width-20');?> <?php echo $forum['ForumPost'][0]['User']['name']; ?>&nbsp; | <i class="fa fa-clock-o fa-fw"></i> há <?php echo $this->Utility->clockTimeDiff($forum['ForumPost'][0]['diff']); ?>
                              <?php endif; ?>
                           </div>
                       </div>
                       <div class="media-right">
                           <?php echo $this->Html->link('<i class="fa fa-comments fa-fw"></i> '.$forum['Forum']['forum_post_count'], ['action' => 'posts', $this->params['pass'][0], $forum['Forum']['token']],['class' => 'btn btn-white text-light', 'escape' => false]);?>
                       </div>
                   </li>
                   <?php endforeach;?>

               </ul>
           </div>

           <?php echo $this->Element('site/lms/pagination'); ?>
            
          </div>
         
         <?php echo $this->Element('site/lms/course-col-right');?>
      </div>
   </div>
</div>
<div class="container">
   <div class="page-section">

      <div class="row">
         <div class="col-md-9">
            <p class="text-light text-caption">
              <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
              <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]]); ?>
              <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link('Fórum', ['controller' => 'foruns', 'action' => 'index', $this->params['pass'][0]]); ?>
              <i class="fa fa-fw  fa-angle-right"></i><?php echo $forum['Forum']['name'];?> 
            </p>

            <?php echo $this->Session->flash(); ?>
            
            <div class="page-section padding-top-none">
                <div class="media v-middle">
                    <div class="media-body">
                        <h2><?php echo $forum['Forum']['name'];?></h2>
                        <p class="text-light text-caption">
                          Criado por <?php echo $this->Utility->avatarUser($forum['User']['id'], $forum['User']['avatar'], 'img-circle width-20');?> <?php echo $forum['User']['name'];?> &nbsp; | 
                          <i class="fa fa-clock-o fa-fw"></i> há <?php echo $this->Utility->clockTimeDiff($forum['Forum']['diff']); ?>
                        </p>
                    </div>
                    <div class="media-right">
                        <a href="#reply" data-z="0.5" data-hover-z="1" data-animated="" class="btn btn-white paper-shadow relative"><i class="fa fa-fw fa-reply"></i> Responder</a>
                   </div>
                </div>
            </div>

            <?php foreach ($forum_posts as $forum_post):?>
            <!-- Post -->
              <div class="media s-container">
                  <div class="media-left">
                      <div class="width-70 text-center">
                          <p><?php echo $this->Utility->avatarUser($forum_post['User']['id'], $forum_post['User']['avatar'], 'width-50');?></p>
                          <?php echo $forum_post['User']['group_id']!=4?'<b class="text-black">'.$forum_post['User']['Group']['name'].'</b>':''; ?>
                          <?php if($forum_post['User']['group_id']==4): ?>
                          <p class="text-caption text-light"><?php echo $forum_post['User']['forum_post_count']; ?> <?php echo $forum_post['User']['forum_post_count']>1?'posts':'post' ?></p>
                          <?php endif; ?>
                      </div>
                  </div>
                  <div class="media-body">
                      <div class="panel panel-default">
                          <div class="panel-body">
                              <div class="text-subhead-2">
                                <?php echo $forum_post['User']['name']; ?> 
                                <span class="text-caption text-light">
                                - há <?php echo $this->Utility->clockTimeDiff($forum_post['ForumPost']['diff']); ?>
                                </span>
                              </div>
                              <?php echo $forum_post['ForumPost']['text']; ?>
                          </div>
                          
                          <?php if($forum_post['User']['group_id']==4): ?>
                          <div class="panel-footer">
                            
                            <div data-id="form-<?php echo $forum_post['ForumPost']['id']; ?>" style="display: none;">
                              <?php echo $this->Form->create('ForumPostComment', array('url' => array('controller' => 'virtual_room_forums', 'action' => 'forum_post_comment',$this->params['pass'][0], $this->params['pass'][1])));?>
                                <input type="hidden" name="data[ForumPostComment][forum_post_id]" value="<?php echo $forum_post['ForumPost']['id']; ?>" />
                                <div class="form-group form-control-material">
                                    <textarea id="reply<?php echo $forum_post['ForumPost']['id']; ?>" name="data[ForumPostComment][text]" class="form-control" placeholder="Escreva sobre a resposta..."></textarea><span class="ma-form-highlight"></span><span class="ma-form-bar"></span><span class="ma-form-highlight"></span><span class="ma-form-bar"></span>
                                    <label for="reply<?php echo $forum_post['ForumPost']['id']; ?>">Seu comentário</label>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary btn-sm" type="submit">Comentar</button>
                                </div>
                              <?php echo $this->Form->end();?>
                            </div>

                            <div class="text-right" data-content="btnComment">
                              <a class="link" title="Comentar resposta" data-id="<?php echo $forum_post['ForumPost']['id']; ?>" data-toggle="comment">Comentar<i class="fa fa-fw fa-angle-right"></i></a>
                            </div>
                          </div>
                          <?php endif; ?>

                      </div>
                  </div>
              </div>
              <?php foreach($forum_post['ForumPostComment'] as $forum_post_comment): ?>
              <!-- Comment -->
                <div class="forum-thread-reply">
                    <div class="media s-container">
                        <div class="media-left">
                            <div class="width-70 text-center">
                                <p><?php echo $this->Utility->avatarUser($forum_post_comment['User']['id'], $forum_post_comment['User']['avatar'], 'width-50');?></p>
                                <?php echo $forum_post_comment['User']['group_id']!=4?'<b class="text-black">'.$forum_post_comment['User']['Group']['name'].'</b>':''; ?>
                                <?php if($forum_post_comment['User']['group_id']==4): ?>
                                <p class="text-caption text-light"><?php echo $forum_post_comment['User']['forum_post_count']; ?> <?php echo $forum_post_comment['User']['forum_post_count']>1?'posts':'post' ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="media-body">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="text-subhead-2"><?php echo $forum_post_comment['User']['name'] ?> <span class="text-caption text-light">- há <?php echo $this->Utility->clockTimeDiff($forum_post_comment['diff']); ?></span></div>
                                    <?php echo $forum_post_comment['text']; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <?php endforeach;?>
            <?php endforeach;?>

            <div class="text-right">
            <?php echo $this->Element('site/lms/pagination'); ?>
            </div>

            <div class="page-section padding-top-none">
                <div class="panel panel-default paper-shadow" data-z="0.5">
                    <div class="panel-heading">
                        <h4 class="text-headline">Responder o Tópico</h4>
                    </div>
                    <div class="panel-body">
                        <?php echo $this->Form->create('ForumPost', array('url' => array('controller' => 'virtual_room_forums', 'action' => 'forum_post',$this->params['pass'][0], $this->params['pass'][1])));?>
                            <div class="form-group form-control-material">
                                <textarea id="reply" name="data[ForumPost][text]" class="form-control" placeholder="Escreva sobre o tópico principal..."></textarea><span class="ma-form-highlight"></span><span class="ma-form-bar"></span>
                                <label for="reply">Sua resposta</label>
                            </div>
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit">Enviar resposta <i class="fa fa-fw fa-plus"></i></button>
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
  $('a[data-toggle="comment"]').click(function(){
    var id = $(this).attr('data-id');
    $(this).hide();
    $('div[data-id="form-'+id+'"]').show();
    $('#reply'+id).focus();
  });
</script>
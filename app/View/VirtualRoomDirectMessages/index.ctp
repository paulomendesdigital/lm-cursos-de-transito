<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * DirectMessage View
 *
*/ ?>
<div class="container">
   <div class="page-section">
      <div class="row">
         <div class="col-md-9">

          <p class="text-light text-caption">
            <i class="fa fa-fw icon-dial-pad"></i> <?php echo $this->Html->link('Meus cursos', ['controller' => 'meus-cursos', 'action' => 'index']); ?>
            <i class="fa fa-fw  fa-angle-right"></i><?php echo $this->Html->link($course['Course']['name'], ['controller' => 'meus-cursos', 'action' => 'course', $this->params['pass'][0]]); ?>
            <i class="fa fa-fw  fa-angle-right"></i>Fale com Tutores
          </p>

          <div class="page-section padding-top-none">
                <div class="media v-middle">
                    <div class="media-body">
                        <h1 class="text-display-1 margin-none"> Fale com Tutores</h1>
                        <p class="text-subhead text-light"><?php echo $course['Course']['name'];?> - <?php echo $course['Course']['firstname'];?></p>
                    </div>
                </div>
            </div>

            <div class="media messages-container media-clearfix-xs-min media-grid">
                <div class="media-left">
                    <h5 class="text-subhead-2 text-light">Selecione o Tutor</h5>
                    <div class="messages-list">
                        <div class="panel panel-default paper-shadow" data-z="0.5" data-scrollable-h="" style="overflow: hidden; outline: none;" tabindex="0">
                            <ul class="list-group">
                            <?php foreach ($course['CourseInstructor'] as $course_instructor):?>
                                <li class="list-group-item">
                                    <?php
                                    //URL do chat
                                    $url = Router::url('/', true).'fale-com-instrutores/view/'.$this->params['pass'][0].'/'.$course_instructor['token'];
                                    ?>
                                    <a href="<?php echo $url;?>">
                                        <div class="media v-middle">
                                            <div class="media-left">
                                                <?php echo $this->Utility->avatarUser($course_instructor['Instructor']['User']['id'], $course_instructor['Instructor']['User']['avatar'], 'width-50 media-object');?>
                                            </div>
                                            <div class="media-body">
                                                <span class="date"><?php echo isset($course_instructor['Instructor']['DirectMessage'][0])?$this->Utility->clockTimeDiff($course_instructor['Instructor']['DirectMessage'][0]['diff']):'';?></span>
                                                <span class="user"><?php echo $course_instructor['Instructor']['name'];?></span>
                                                <div class="text-light">
                                                <?php
                                                  if(isset($course_instructor['Instructor']['DirectMessage'][0])):
                                                    if($course_instructor['Instructor']['DirectMessage'][0]['view']==false):
                                                      echo '<strong class="text-info">'.$course_instructor['Instructor']['DirectMessage'][0]['text'].'</strong>';
                                                    else:
                                                      echo $course_instructor['Instructor']['DirectMessage'][0]['text'];
                                                    endif;
                                                  endif;
                                                ?>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                              <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="media-body">
                    <p>Selecione o instrutor para abrir a conversa.</p>
                </div>
            </div>
            
          </div>
         
         <?php echo $this->Element('site/lms/course-col-right');?>
      </div>
   </div>
</div>
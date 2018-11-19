<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva - www.lmcursosdetransito.com.br
 * Element View
 *
*/ ?>
<div class="media-left">
    <div class="messages-list">
        <div class="panel panel-default paper-shadow" data-z="0.5" data-scrollable-h="" style="overflow: hidden; outline: none;" tabindex="0">
            <ul class="list-group">
            <?php foreach ($course['CourseInstructor'] as $course_instructor):?>
                <li class="list-group-item <?php echo $instructor_id==$course_instructor['instructor_id']?'active':'';?>">
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
                                <span class="user"><?php echo $course_instructor['Instructor']['name'];?></span>
                                <div class="text-light">
                                <?php
                                  if(isset($course_instructor['Instructor']['DirectMessage'][0])):
                                    if($course_instructor['Instructor']['DirectMessage'][0]['view_user']==false):
                                      echo '<strong class="text-info">'. $this->Text->truncate( strip_tags($course_instructor['Instructor']['DirectMessage'][0]['text']),25) .'</strong>';
                                    else:
                                      echo $this->Text->truncate( strip_tags($course_instructor['Instructor']['DirectMessage'][0]['text']),25);
                                    endif;
                                  endif;
                                ?>
                                </div>
                                <span class="date"><?php echo isset($course_instructor['Instructor']['DirectMessage'][0])?$this->Utility->clockTimeDiff($course_instructor['Instructor']['DirectMessage'][0]['diff']):'';?></span>
                            </div>
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>
<div id='home' class='page'>
    <div class='container'>
        <div style="margin-top: 15px">
        <?php echo $this->Utility->breadcumbs([
            'Início'=>['controller'=>'pages','action'=>'index','prefixes'=>false],
            'Cursos' => ['controller'=>'courses','action'=>'index','prefixes'=>false]
        ]);
        ?>
        </div>
        <section class="courses">
            <div class='row'>
                <div class='col-md-12'>
                    <div id='courses'>
                        <h4 class='section-title'>Cursos em Destaque</h4>
                        <hr/>
                        <?php if(!empty($courses)){ ?>
                            <ul class='courses-list row'>
                                <?php foreach($courses as $course){ ?>
                                    <li class='course col-md-4 col-sm-6'>
                                        <div class='box-course thumbnail'>
                                            <figure>
                                                <?php
                                                $img = $this->Html->image('/files/course/image/'.$course['Course']['id'].'/xvga_'.$course['Course']['image'],['alt'=>$course['Course']['name'],'title'=>$course['Course']['name']]);
                                                if ($course['Course']['active_order']) {
                                                    echo $this->Html->link($img, ['controller' => 'courses', 'action' => 'view', 'id' => $course['Course']['id'], 'slug' => $this->Utility->__Normalize($course['Course']['name'])], ['escape' => false]);
                                                } else {
                                                    echo $img;
                                                }
                                                ?>
                                            </figure>
                                            <hr/>
                                            <?php
                                            if( $course['Course']['active_order'] ):
                                                echo $this->Html->link("COMPRAR",['controller'=>'courses','action'=>'view', 'id' => $course['Course']['id'], 'slug' => $this->Utility->__Normalize($course['Course']['name'])],['class'=>'button btn-primary']);
                                            else:
                                                echo $this->Html->link("EM BREVE!",'javascript:void(0);',['class'=>'button btn-primary']);
                                            endif;
                                            ?>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php }else{ ?>
                            <h3 class='orange-text text-center'>Não há cursos disponíveis!</h3>
                        <?php } ?>
                    </div>
                </div>
        </section>
    </div>
</div>

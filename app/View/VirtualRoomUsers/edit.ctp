<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Meu Perfil
 *
*/?>
<div class="container">
   <div class="page-section">
      <div class="row">
         <div class="col-md-9">
            <!-- Tabbable Widget -->
            <div class="tabbable paper-shadow relative" data-z="0.5">
                <!-- Tabs -->
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#account" data-toggle="tab"><i class="fa fa-fw fa-lock"></i> <span class="hidden-sm hidden-xs">Dados de cadastro</span></a></li>
                    <li><a href="#address" data-toggle="tab"><i class="fa fa-fw fa-home"></i> <span class="hidden-sm hidden-xs">Endereço</span></a></li>
                </ul>
                <!-- // END Tabs -->
                <?php echo $this->Form->create('User', ['url' => ['controller' => 'virtual_room_users', 'action' => 'edit'], 'class' => 'form-horizontal', 'type' => 'file']);?>
                    <!-- Panes -->
                    <div class="tab-content">
                        <div id="account" class="tab-pane active">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Avatar</label>
                                <div class="col-md-6">
                                    <div class="media v-middle">
                                        <div class="media-left">
                                          <?php echo $this->Utility->avatarUser($this->request->data['User']['id'], $this->request->data['User']['avatar'], 'width-100', 'avatarEdit');?>
                                        </div>
                                        <div class="media-body">
                                            <input type="file" name="data[User][avatar]" class="hide">
                                            <a class="btn btn-white btn-sm paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated  data-toggle="upload-avatar">enviar <i class="fa fa-fw fa-upload"></i></a>
                                            <p><small class="text-light" data-toggle="helpavatar">* Sua foto será atualizada no próximo acesso.</small></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Nome</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php if( isset($urlReturn) ){
                                              echo $this->Form->hidden('urlReturn', ['value' => $urlReturn]);  
                                            }?>
                                            <?php echo $this->Form->text('name', ['type' => 'text', 'placeholder' => 'Nome Completo', 'class' => 'form-control']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="UserCpf" class="col-md-2 control-label">CPF</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->text('cpf', ['disabled'=>true,'type' => 'text', 'placeholder' => 'nº do CPF', 'class' => 'form-control']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="UserEmail" class="col-md-2 control-label">Email</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                            <?php echo $this->Form->text('email', ['type' => 'email', 'placeholder' => 'Endereço de email', 'class' => 'form-control']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="UserPassword" class="col-md-2 control-label">Senha</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <?php echo $this->Form->text('password', ['type' => 'password', 'placeholder' => 'Senha de acesso', 'class' => 'form-control']);?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="address" class="tab-pane">
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">CEP</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->hidden('Student.0.id'); ?>
                                            <?php echo $this->Form->input('Student.0.zipcode',['class'=>'form-control','label'=>false,'data-mask'=>'zipcode','required'=>true]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Endereço</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->input('Student.0.address',['class'=>'form-control','label'=>false,'required'=>true, 'data-toggle'=>'returnAddress']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Número</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->input('Student.0.number',['class'=>'form-control','label'=>false,'required'=>true, 'data-toggle'=>'returnNumber']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Complemento</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->input('Student.0.complement',['class'=>'form-control','label'=>false,'required'=>true]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Bairro</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->input('Student.0.neighborhood',['class'=>'form-control','label'=>false,'required'=>true, 'data-toggle'=>'returnNeighborhood']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Estado</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->input('Student.0.state_id',['class'=>'form-control','label'=>false,'required'=>true, 'data-toggle'=>'returnState']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="UserName" class="col-md-2 control-label">Cidade</label>
                                <div class="col-md-6">
                                    <div class="form-control-material">
                                        <div class="input-group">
                                            <?php echo $this->Form->input('Student.0.city_id',['class'=>'form-control','label'=>false,'required'=>true, 'data-toggle'=>'returnCity']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-6">
                            <div class="checkbox checkbox-success">
                                <input id="UserNewsletter" type="checkbox" checked>
                                <label for="UserNewsletter">Deseja receber nossos informativos?</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group margin-none">
                        <div class="col-md-offset-2 col-md-10">
                            <button type="submit" class="btn btn-primary paper-shadow relative" data-z="0.5" data-hover-z="1" data-animated>Salvar dados</button>
                        </div>
                    </div>
                    </div>
                </form>
                <!-- // END Panes -->
            </div>
            <!-- // END Tabbable Widget -->
            <br/>
            <br/>
        </div>
 
      </div>
   </div>
</div>

<script type="text/javascript">
  $('a[data-toggle="upload-avatar"]').click(function(){
    $('input[type="file"]').click();
  });

  $('input[type="file"]').change(function(){
         readURL(this);
         $('small[data-toggle="helpavatar"]').append('<br/> <span class="text-info"><i class="fa fa-fw fa-info"></i> Você precisa salvar para gravar seu avatar.</span>');
 })

  function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatarEdit').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

</script>
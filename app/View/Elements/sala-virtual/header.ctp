<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Header AVA
 *
*/?>
<div class="navbar navbar-default navbar-fixed-top navbar-size-large navbar-size-xlarge paper-shadow" data-z="0" data-animated="" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand navbar-brand-logo" style="max-width: 300px;">
            	<?php echo $this->Utility->__getLogo(); ?>
            </div>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="main-nav">
            <ul class="nav navbar-nav navbar-nav-margin-left">
                <li><?php echo $this->Html->link('Meus Cursos', ['controller' => 'meus-cursos', 'action' => 'index', 'school'=>false]);?></li>
                <li><?php echo $this->Html->link('Meu Perfil',  ['controller' => 'meu-perfil',  'action' => 'edit', 'school'=>false]);?></li>
                <li><?php echo $this->Utility->__getLinkAtendimento(); ?></li>
            </ul>
            <div class="navbar-right">
                <ul class="nav navbar-nav navbar-nav-bordered navbar-nav-margin-right">
                    <!-- user -->
                    <li class="dropdown user">
                        <div id='acessibility-header'>
                            <a style="color: black;" href='javascript:void(0)' data-toggle='accesibility-contrast-control'><i class='fa fa-adjust'></i></a>
                            <a style="color: black;" href='javascript:void(0)' data-toggle="accessibility-font-size-control" data-accessibility-control='plus'>A+</a>
                            <a style="color: black;" href='javascript:void(0)' data-toggle="accessibility-font-size-control" data-accessibility-control='minus'>A-</a>
                        </div>
                    </li>
                    <li class="dropdown user active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                            <?php echo $this->Utility->avatarUser($Auth['id'], $Auth['avatar'], 'img-circle');?>
                            <?php echo $this->Utility->getFirstName($Auth['name']);?>
                             <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li <?php echo strpos($_SERVER["REQUEST_URI"], 'meus-cursos')?'class="active"':'';?>>
                                <?php echo $this->Html->link('<i class="fa fa-fw fa-mortar-board"></i> Meus Cursos', ['controller' => 'meus-cursos', 'action' => 'index', 'school'=>false], ['escape' => false]);?>
                            </li>
                            <li <?php echo strpos($_SERVER["REQUEST_URI"], 'meu-perfil')?'class="active"':'';?>>
                                <?php echo $this->Html->link('<i class="fa fa-fw fa-user"></i> Meu Perfil', ['controller' => 'meu-perfil', 'action' => 'edit', 'school'=>false], ['escape' => false]);?>
                            </li>
                            <li>
                                <?php echo $this->Html->link('<i class="fa fa-fw fa-sign-out"></i> Sair', ['controller' => 'users', 'action' => 'logout'], ['escape' => false]);?>
                            </li>
                        </ul>
                    </li>
                    <!-- // END user -->
                </ul>
                <?php echo $this->Html->link('Sair <i class="fa fa-fw fa-sign-out"></i>', ['controller' => 'users', 'action' => 'logout'], ['escape' => false, 'class' => 'navbar-btn btn btn-primary']);?>
            </div>
        </div>
        <!-- /.navbar-collapse -->
    </div>
</div>

<?php if(!strpos($_SERVER["REQUEST_URI"], 'simulate')): ?>
<div class="parallax overflow-hidden bg-blue-400 page-section third">
    <div class="container parallax-layer" data-opacity="true" style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
        <div class="media v-middle">
            <div class="media-left text-center">
                <?php echo $this->Utility->avatarUser($Auth['id'], $Auth['avatar'], 'img-circle width-80');?>
            </div>
            <div class="media-body">
                <h1 class="text-white text-display-1 margin-v-0">
                    <?php echo $Auth['first_name'];?>
                    <span class="hidden-xs"> <?php echo $Auth['last_name'];?></span>
                </h1>
                <p class="text-subhead text-white"><?php echo $Auth['cpf'];?></p>
            </div>
            <div class="media-right hidden-xs">
                <span class="label bg-blue-500"><?php echo $Auth['Group']['name'];?></span>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
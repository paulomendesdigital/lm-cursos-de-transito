<header id='header'>
    <div class="navbar" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-nav">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="navbar-brand">
                    <?php echo $this->Html->link($this->Html->image('site/logo-header.png'),['controller'=>'pages','action'=>'index','prefixes'=>false],['escape'=>false]); ?>
                </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="main-nav">
                <ul class="nav navbar-nav navbar-right">
                    <li><?php echo $this->Html->link('Início',['controller'=>'pages','action'=>'index','prefixes'=>false],['class'=>'active']); ?></li>
                    <li><?php echo $this->Html->link('Quem Somos','javascript:void(0)'); ?></li>
                    <li><?php echo $this->Html->link('Nossa Equipe','javascript:void(0)'); ?></li>
                    <li><?php echo $this->Html->link('Termo de Serviço','javascript:void(0)'); ?></li>
                    <!--
                    <li><?php echo $this->Html->link('Meus Cursos', ['controller' => 'meus-cursos', 'action' => 'index']);?></li>
                    <li><?php echo $this->Html->link('Meu Perfil', ['controller' => 'meu-perfil', 'action' => 'edit']);?></li>
                    -->
                </ul>
                <!--
                <div class="navbar-right">
                    <ul class="nav navbar-nav navbar-nav-bordered navbar-nav-margin-right">                        
                        <li class="dropdown user active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <?php echo $this->Utility->avatarUser($Auth['id'], $Auth['avatar'], 'img-circle');?>
                                <?php echo $Auth['name'];?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li <?php echo strpos($_SERVER["REQUEST_URI"], 'meus-cursos')?'class="active"':'';?>>
                                	<?php echo $this->Html->link('<i class="fa fa-fw fa-mortar-board"></i> Meus Cursos', ['controller' => 'meus-cursos', 'action' => 'index'], ['escape' => false]);?>
                            	</li>
                            	<li <?php echo strpos($_SERVER["REQUEST_URI"], 'meu-perfil')?'class="active"':'';?>>
                                	<?php echo $this->Html->link('<i class="fa fa-fw fa-user"></i> Meu Perfil', ['controller' => 'meu-perfil', 'action' => 'edit'], ['escape' => false]);?>
                            	</li>
                            	<li>
                                	<?php echo $this->Html->link('<i class="fa fa-fw fa-sign-out"></i> Sair', ['controller' => 'users', 'action' => 'logout'], ['escape' => false]);?>
                            	</li>
                            </ul>
                        </li>                        
                    </ul>
                    <?php echo $this->Html->link('Sair <i class="fa fa-fw fa-sign-out"></i>', ['controller' => 'users', 'action' => 'logout'], ['escape' => false, 'class' => 'navbar-btn btn btn-primary']);?>
                </div>
                -->
            </div>
            <!-- /.navbar-collapse -->
        </div>
    </div>
    <!--
    <?php if(!strpos($_SERVER["REQUEST_URI"], 'simulate')): ?>
    <div class="parallax overflow-hidden bg-blue-400 page-section third">
        <div class="container parallax-layer" data-opacity="true" style="transform: translate3d(0px, 0px, 0px); opacity: 1;">
            <div class="media v-middle">
                <div class="media-left text-center">
                    <?php echo $this->Utility->avatarUser($Auth['id'], $Auth['avatar'], 'img-circle width-80');?>
                </div>
                <div class="media-body">
                    <h1 class="text-white text-display-1 margin-v-0"><?php echo $Auth['name'];?></h1>
                    <p class="text-subhead text-white"><?php echo $Auth['cpf'];?></p>
                </div>
                <div class="media-right">
                    <span class="label bg-blue-500"><?php echo $Auth['Group']['name'];?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    -->
</header>
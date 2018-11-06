<div class="navbar navbar-inverse" role="navigation">
		<div class="navbar-header">
			<?php echo $this->html->link($Sistems['Title'], array('controller' => 'pages', 'action' => 'index'), array('class' => 'navbar-brand'));?>
			<a class="sidebar-toggle"><i class="icon-paragraph-justify2"></i></a>
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-icons">
				<span class="sr-only">Toggle navbar</span>
				<i class="icon-grid3"></i>
			</button>
			<button type="button" class="navbar-toggle offcanvas">
				<span class="sr-only">Toggle navigation</span>
				<i class="icon-paragraph-justify2"></i>
			</button>
		</div>

		<ul class="nav navbar-nav navbar-right collapse" id="navbar-icons">
			<li class="user dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown">
					<span><?php echo $Auth['username'];?></span>
					<i class="caret"></i>
				</a>
				<ul class="dropdown-menu dropdown-menu-right icons-right">
					<li><?php echo $this->Html->link('<i class="icon-exit"></i> Sair', array('controller' => 'users', 'action' => 'logout'), array('escape' => false));?></li>
				</ul>
			</li>
		</ul>
	</div>
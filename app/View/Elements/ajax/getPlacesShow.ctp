<?php foreach($places as $place):?>
				<div class='route'>
					<div class='row'>
						<div class='col-md-7 col-left'>
							<div class='route-header'>
								<div class='route-header-title'>
									<div class='title'><?php echo $place['Place']['name'];?></div>
									<div class='subtitle'><?php echo $place['Place']['city'];?> <?php echo $place['Place']['state'];?></div>
								</div>
								<div class='distance'>
									<div class='icon'></div>
									<div class='text'><div class='big'><?php echo $place['Place']['distancia'];?></div><div class='small'>de distancia</div></div>
								</div>
							</div>
							<div class='route-address'>
								<div class='icon'></div>
								<div class='text'>
									<?php echo $place['Place']['address'];?> <?php echo $place['Place']['number'];?><br/>
									<?php echo $place['Place']['neighborhood'];?> <br/>
									<?php echo $place['Place']['city'];?> - <?php echo $place['Place']['state'];?><br/>
									CEP.: <?php echo $place['Place']['zipcode'];?>
								</div>
							</div>
							<div class='route-link'>
								<div class='icon'></div>
								<div class='text'><a href='<?php echo $place['Place']['website'];?>' target="_blank"><?php echo $place['Place']['website'];?></a></div>
							</div>
							<div class='route-phone'>
								<div class='icon'></div>
								<div class='text'><?php echo $place['Place']['phone'];?><br/><?php echo $place['Place']['cellphone'];?></div>
							</div>
						</div>
						<div class='col-md-5 col-right'>
							<div class='map'><figure><object id="map" type="text/html" data="http://maps.google.com/maps?f=q&source=s_q&hl=en&geocode=&q=<?php echo $place['Place']['address'];?>,<?php echo $place['Place']['number'];?> <?php echo $place['Place']['city'];?> - <?php echo $place['Place']['state'];?>&output=embed" style="width:388px;height:230px;"></object></figure></div>
							<div class='route-options'>
								<div class='option print'><div class='icon'></div><div class='text'>Imprimir <br> mapa</div></div>
								<div class='divider'></div>
								<div class='option zoom'><div class='icon'></div><div class='text'>Ampliar <br> mapa</div></div>
								<div class='divider'></div>
								<div class='option show-route'><div class='icon'></div><div class='text'>Mostrar <br> rota</div></div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach;?>
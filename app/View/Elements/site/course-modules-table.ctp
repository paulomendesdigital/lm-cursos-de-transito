<?php if(!empty($course['ModuleCourse'])){ ?>
	<div class='modules-table-container table-lms-container'>
		<h3 class='table-title'>Módulos</h3>
		<div class='modules-table table-lms'>
			<div class='table-header'>
				<div class='table-row'>
					<div class='table-cell'>
						<span>Módulos</span>
					</div>
					<div class='table-cell'>
						<span>Horas/Aula</span>
					</div>
				</div>
			</div>
			<div class='table-body'>
				<?php foreach($course['ModuleCourse'] as $module){ ?>
					<?php if( $module['Module']['is_introduction'] ) continue;?>
					<div class='table-row'>
						<div class='table-cell'>
							<span class='cell-label'>Módulo</span>
							<span class='cell-value'><?php echo $module['Module']['name']; ?></span>
						</div>
						<div class='table-cell'>
							<span class='cell-label'>Horas/Aula</span>
							<span class='cell-value'><?php echo $module['Module']['value_time']; ?>h</span>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

        <?php if(!empty($promotional_price)){ ?>
            <script>
                var promotional_price = '<?php echo $promotional_price; ?>';
                var installment_price = '<?php echo $installment_price; ?>';
            </script>
        <?php } ?>
        <?php if(isset($order_in_school)){ ?>
            <script>
                var order_in_school = <?php echo $order_in_school; ?>;
            </script>
        <?php } ?>
	</div>
    <?php if (!isset($view)) {
        echo $this->Element('site/course-cart-additional-form');
    }?>
<?php } ?>

<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Layout Default
 *
*/
?>
<!DOCTYPE html>
<html class="transition-navbar-scroll top-navbar-xlarge bottom-footer" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $Developer['Title'];?></title>
    <!-- Compressed Vendor BUNDLE
    Includes vendor (3rd party) styling such as the customized Bootstrap and other 3rd party libraries used for the current theme/module -->
    <?php echo $this->Html->css('../themes/css/vendor.min');?>
    <!-- Compressed Theme BUNDLE
Note: The bundle includes all the custom styling required for the current theme, however
it was tweaked for the current theme/module and does NOT include ALL of the standalone modules;
The bundle was generated using modern frontend development tools that are provided with the package
To learn more about the development process, please refer to the documentation. -->
    <!-- Compressed Theme CORE
This variant is to be used when loading the separate styling modules -->
    <?php echo $this->Html->css('../themes/css/theme-core.min');?>
    <!-- Standalone Modules
    As a convenience, we provide the entire UI framework broke down in separate modules
    Some of the standalone modules may have not been used with the current theme/module
    but ALL modules are 100% compatible -->
    <?php echo $this->Html->css('../themes/css/module-essentials.min');?>
    <?php echo $this->Html->css('../themes/css/module-material.min');?>
    <?php echo $this->Html->css('../themes/css/module-layout.min');?>
    <?php echo $this->Html->css('../themes/css/module-sidebar.min');?>
    <?php echo $this->Html->css('../themes/css/module-sidebar-skins.min');?>
    <?php echo $this->Html->css('../themes/css/module-navbar.min');?>
    <?php echo $this->Html->css('../themes/css/module-messages.min');?>
    <?php echo $this->Html->css('../themes/css/module-carousel-slick.min');?>
    <?php echo $this->Html->css('../themes/css/module-charts.min');?>
    <?php echo $this->Html->css('../themes/css/module-maps.min');?>
    <?php echo $this->Html->css('../themes/css/module-colors-alerts.min');?>
    <?php echo $this->Html->css('../themes/css/module-colors-background.min');?>
    <?php echo $this->Html->css('../themes/css/module-colors-buttons.min');?>
    <?php echo $this->Html->css('../themes/css/module-colors-text.min');?>

    <?php echo $this->Html->css('sala-virtual/style');?>
    
    <?php echo $this->Html->script('jquery.min');?>
    <?php echo $this->Html->script('jpeg_camera/jpeg_camera_with_dependencies.min');?>

    <?php 
    echo $this->Html->script('site/jquery.animateNumber');
    ?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min');?>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min');?>
<![endif]-->
</head>

<?php if( $this->params['controller'] == 'users' ): ?>
    <body class="login">
<?php else: ?>
    <body>
<?php endif; ?>

<!-- CAKEPHP -->
    <?php if($this->Session->read('Auth.User')):?>
        <?php echo $this->Element("sala-virtual/header"); ?>
    <?php endif;?>

    
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Session->flash(); ?>
    <?php echo $this->fetch('content'); ?>
    
    <?php echo $this->element("sala-virtual/footer"); ?>
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min');?>-->
    

    <!-- ---------- GOOGLE ANALYTICS -------------- -->
    <?php if( Configure::read('Sistems.Analytics') ):?>
        <script type="text/javascript">
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php echo $Sistems['Analytics'];?>', '<?php echo Router::url('/', true); ?>');
        ga('send', 'pageview');
        </script>
    <?php endif;?>
    <!-- ---------- END GOOGLE ANALYTICS -------------- -->


<!-- Inline Script for colors and config objects; used by various external scripts; -->
    <script>
        var colors = {
            "danger-color": "#e74c3c",
            "success-color": "#81b53e",
            "warning-color": "#f0ad4e",
            "inverse-color": "#2c3e50",
            "info-color": "#2d7cb5",
            "default-color": "#6e7882",
            "default-light-color": "#cfd9db",
            "purple-color": "#9D8AC7",
            "mustard-color": "#d4d171",
            "lightred-color": "#e15258",
            "body-bg": "#f6f6f6"
        };
        var config = {
            theme: "html",
            skins: {
                "default": {
                    "primary-color": "#42a5f5"
                }
            }
        };
    </script>
    <?php //echo $this->Html->script('jquery.min'); ?>

    <!-- Separate Vendor Script Bundles -->
    <?php echo $this->Html->script('../themes/js/vendor-core.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-countdown.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-tables.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-forms.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-carousel-slick.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-player.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-charts-flot.min');?>
    <?php echo $this->Html->script('../themes/js/vendor-nestable.min');?>
    <!-- <?php echo $this->Html->script('../themes/js/vendor-angular.min');?> -->
    <!-- Compressed Vendor Scripts Bundle
    Includes all of the 3rd party JavaScript libraries above.
    The bundle was generated using modern frontend development tools that are provided with the package
    To learn more about the development process, please refer to the documentation.
    Do not use it simultaneously with the separate bundles above. -->
    <!-- <?php echo $this->Html->script('../themes/js/vendor-bundle-all.min');?> -->
    <!-- Compressed App Scripts Bundle
    Includes Custom Application JavaScript used for the current theme/module;
    Do not use it simultaneously with the standalone modules below. -->
    <!-- <?php echo $this->Html->script('../themes/js/module-bundle-main.min');?> -->
    <!-- Standalone Modules
    As a convenience, we provide the entire UI framework broke down in separate modules
    Some of the standalone modules may have not been used with the current theme/module
    but ALL the modules are 100% compatible -->
    <?php echo $this->Html->script('../themes/js/module-essentials.min');?>
    <?php echo $this->Html->script('../themes/js/module-material.min');?>
    <?php echo $this->Html->script('../themes/js/module-layout.min');?>
    <?php echo $this->Html->script('../themes/js/module-sidebar.min');?>
    <?php echo $this->Html->script('../themes/js/module-carousel-slick.min');?>
    <?php echo $this->Html->script('../themes/js/module-player.min');?>
    <?php echo $this->Html->script('../themes/js/module-messages.min');?>
    <?php //echo $this->Html->script('../themes/js/module-maps-google.min');?>
    <?php echo $this->Html->script('../themes/js/module-charts-flot.min');?>
    <!-- [html] Core Theme Script:
        Includes the custom JavaScript for this theme/module;
        The file has to be loaded in addition to the UI modules above;
        module-bundle-main.js already includes theme-core.js so this should be loaded
        ONLY when using the standalone modules; -->
    <?php echo $this->Html->script('../themes/js/theme-core');?>

    <?php
    echo $this->Html->script('jquery.maskmoney');
    echo $this->Html->script('jquery.mask');
    echo $this->Html->script('global');
    echo $this->Html->script('sala-virtual');
    echo $this->Html->script('manager/ckeditor/ckeditor');
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <script>
        var options = {
          shutter_ogg_url: "jpeg_camera/shutter.ogg",
          shutter_mp3_url: "jpeg_camera/shutter.mp3",
          swf_url: "jpeg_camera/jpeg_camera.swf",
        };
        var camera = new JpegCamera("#camera", options);
      
        $('#take_snapshots').click(function(){
            var snapshot = camera.capture();
            snapshot.show();
            
            snapshot.upload({api_url: "/virtual_rooms/send_biometria_facial"}).done(function(response) {
                window.location = response;
                //$('#imagelist').prepend("<tr><td><img src='/"+response+"' class='img-responsive'></td><td>"+response+"</td></tr>");
            }).fail(function(response) {
                alert("Upload failed with status " + response);
            });
        });

        $('#take_snapshot_avatar').click(function(){
            $('#camera_info').html('');
            var type = 'avatar';

            if( $('#img-avatar').is(':visible') ){
                type = 'unknown';
            }

            if( $('#img-avatar').is(':visible') && $('#img-unknown').is(':visible') ){
                type = 'avatar';
                $('#imagelist').html('');
            }


            var snapshot = camera.capture();
            snapshot.show();
            
            snapshot.upload({
                api_url: "/virtual_rooms/send_biometria_facial_temp/"+type
            }).done(function(response) {
                if( type == 'avatar' ){
                    var imagem = "<img src='/"+response+"?var=<?php echo time();?>' class='img-responsive' />";
                    $('#imagelist').prepend("<div id='img-avatar' class='col-md-6'><h4 class='text-center'>Foto Referência</h4>"+imagem+"</div>");
                    $('#camera_info').html("<h4 class='text-center'>Fotografe novamente para a comparação...</h4>");
                }else{
                    var imagem = "<img src='/"+response+"?var=<?php echo time();?>' class='img-responsive' />";
                    $('#imagelist').append("<div id='img-unknown' class='col-md-6'><h4 class='text-center'>Foto Comparação</h4>"+imagem+"</div>");
                    $('#camera_info').html("<h4 class='text-center'>Aguarde...</h4>");
                    compare();
                }
            }).fail(function(response) {
                alert("Upload failed with status " + response);
            });
        });

        function done(){
            $('#snapshots').html("uploaded");
        }
    </script>
    <script>
        $(document).ready(function(){
            $('[data-toggle=tooltip]').tooltip();
        });
        function compare(){
            $('#camera_info').html("<h4 class='text-center'><i class='fa fa-spinner' aria-hidden='true'></i> Comparando...</h4>");
            var url = 'http://127.0.0.1:5000';//com a vpn ligada
            var url = 'http://192.168.2.1:5000/';//com a vpn ligada
            var url = '/virtual_rooms/compare';//com a vpn ligada
            //var url = 'http://201.33.25.156:5000';//sem a vpn ligada
            
            /*$.ajax({
                url: url,
                headers: {'X-Requested-With': 'XMLHttpRequest'}
            }, function( result ) {
                console.log( "JSON Data: " + result );
            });
*/
            //$.getJSON( url, function( result ) {
            //    console.log( "JSON Data: " + result );
            //});

            $.get(url,function(data){
                if( data == 'true' ){
                    $('#camera_info').html("<h2 class='text-center text-success'><i class='fa fa-smile-o' aria-hidden='true'></i> Foto compatível!</h2>");
                }else{
                    $('#camera_info').html("<h2 class='text-center text-danger'><i class='fa fa-frown-o' aria-hidden='true'></i> Foto não compatível!</h2>");
                }
            });
        }
    </script>
</body>
</html>

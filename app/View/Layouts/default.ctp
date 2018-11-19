<?php /**
 * @copyright Copyright 2018
 * @author Dayvison Silva
 * Layout Default
 *
*/?>
<!DOCTYPE html>
<html class="transition-navbar-scroll top-navbar-xlarge bottom-footer" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-N6PL3FJ');</script>
    <!-- End Google Tag Manager -->
    
    <link rel="manifest" href="/manifest.json" />
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      var OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "df149b25-c7d5-4f27-ad73-61f69969d66d",
        });
      });
    </script>

    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo $this->Utility->__getMetaTitle();?></title>
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

    <?php //echo $this->Html->css('sala-virtual/style');?>
    <link rel="stylesheet" href="/css/sala-virtual/style.css?<?php echo time();?>"> 
    
    <?php echo $this->Html->script('jquery.min');?>
    <?php echo $this->Html->script('jpeg_camera/jpeg_camera_with_dependencies.min');?>

    <?php 
    echo $this->Html->script('site/jquery.animateNumber');
    ?>

    <?php echo $this->Element("site/chat", ['show'=>$this->Utility->__isAllowedChat()]); ?>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries
WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!-- If you don't need support for Internet Explorer <= 8 you can safely remove these -->
    <!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min');?>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min');?>
<![endif]-->
</head>

<?php //if( $this->params['controller'] == 'virtual_rooms' and $this->params['action'] == 'index' ): ?>
    <?php //if ($this->Utility->__isAmbientSchool()): ?>
        <?php //echo $this->Element("site/popup-comunicado",['imagem'=>'site/comunicado-detran-auto-escola.png']); ?>
    <?php //else:?>
        <?php //echo $this->Element("site/popup-comunicado",['imagem'=>'site/comunicado-detran.png']); ?>
    <?php //endif; ?>
<?php //endif; ?>

<?php if( $this->params['controller'] == 'users' ): ?>
    <body class="login">
<?php else: ?>
    <body>
<?php endif; ?>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N6PL3FJ" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

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
    <?php echo $this->Html->script('jquery.min'); ?>

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
    //echo $this->Html->script('global');
    ?><script src="/js/global.js?<?php echo time();?>"></script><?php
    echo $this->Html->script('sala-virtual');
    echo $this->Html->script('manager/ckeditor/ckeditor');
    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <div class="modal fade" id="formNotepadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <?php echo $this->Form->create('Notepad', array('class'=>'form-horizontal','role'=>'form','url'=>['controller'=>'notepads','action'=>'save'])); ?>
                    <div class="modal-header">
                        <h5 class="modal-title text-center">MEU BLOCO DE ANOTAÇÕES</h5>
                    </div>
                    <div class="modal-body">
                        <?php 
                        $value = !empty($this->Session->read('Auth.User.Notepad.id')) ? $this->Session->read('Auth.User.Notepad.description') : false;
                        echo $this->Form->input('description', array('class'=>'form-control ckeditor', 'id'=>'ckfinder', 'label'=>false, 'value'=>$value));
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <input type="submit" class="btn btn-success" value="Enviar" />
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>

        $(document).ready(function(){
            $('[data-toggle=tooltip]').tooltip();
        });

        var editor =
        CKEDITOR.replace( 'ckfinder', {
            toolbar: 'Page',
            width: '700',
            height: '280',
            filebrowserBrowseUrl : '/js/manager/ckfinder/ckfinder.html',
            filebrowserImageBrowseUrl : '/js/manager/ckfinder/ckfinder.html?type=Images',
            filebrowserFlashBrowseUrl : '/js/manager/ckfinder/ckfinder.html?type=Flash',
            filebrowserUploadUrl : '/js/manager/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            filebrowserImageUploadUrl : '/js/manager/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
            filebrowserFlashUploadUrl : '/js/manager/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
        });
    </script>
</body>
</html>

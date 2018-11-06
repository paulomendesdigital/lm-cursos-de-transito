<?php
/*
 * Config Bootstrap
 */
$Sistems = Configure::read('Sistems');
$Developer = Configure::read('Developer');
?>

<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1, maximum-scale=1">
        <title><?php echo $Developer['Title'];?></title>

        <script type="text/javascript">
            var Domain = '<?php echo Router::url('/', true);?>';
        </script>

        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('manager/bootstrap.min');
        echo $this->Html->css('manager/londinium-theme');
        echo $this->Html->css('manager/highcharts');

        echo $this->Html->script('jquery.min');

        echo $this->Html->script('manager/jquery-ui.min');

        echo $this->Html->script('manager/plugins/charts/sparkline.min');

        echo $this->Html->script('manager/plugins/forms/uniform.min');
        echo $this->Html->script('manager/plugins/forms/select2.min');
        // echo $this->Html->script('manager/plugins/forms/inputmask');
        echo $this->Html->script('manager/plugins/forms/autosize');
        echo $this->Html->script('manager/plugins/forms/inputlimit.min');
        echo $this->Html->script('manager/plugins/forms/listbox');
        echo $this->Html->script('manager/plugins/forms/multiselect');
        echo $this->Html->script('manager/plugins/forms/validate.min');
        echo $this->Html->script('manager/plugins/forms/tags.min');
        echo $this->Html->script('manager/plugins/forms/switch.min');

        echo $this->Html->script('manager/plugins/forms/uploader/plupload.full.min');
        echo $this->Html->script('manager/plugins/forms/uploader/plupload.queue.min');

        echo $this->Html->script('manager/plugins/forms/wysihtml5/wysihtml5.min');
        echo $this->Html->script('manager/plugins/forms/wysihtml5/toolbar');

        echo $this->Html->script('manager/globalize/globalize');
        echo $this->Html->script('manager/globalize/globalize.culture.de-DE');
        echo $this->Html->script('manager/globalize/globalize.culture.ja-JP');

        echo $this->Html->script('manager/plugins/interface/daterangepicker');
        echo $this->Html->script('manager/plugins/interface/fancybox.min');
        echo $this->Html->script('manager/plugins/interface/moment');
        echo $this->Html->script('manager/plugins/interface/mousewheel');
        echo $this->Html->script('manager/plugins/interface/jgrowl.min');
        echo $this->Html->script('manager/plugins/interface/datatables.min');
        echo $this->Html->script('manager/plugins/interface/colorpicker');
        echo $this->Html->script('manager/plugins/interface/fullcalendar.min');
        echo $this->Html->script('manager/plugins/interface/timepicker.min');

        //echo $this->Html->script('jquery.maskmoney');
        //echo $this->Html->script('jquery.maskedinput');
        echo $this->Html->script('jquery.mask');
        
        //echo $this->Html->script('manager/api');
        echo $this->Html->script('manager/bootstrap.min');
        echo $this->Html->script('manager/application');
        
        //echo $this->Html->script('manager/function');
        ?>
        <script src="/js/manager/api.js?<?php echo time();?>"></script>
        <script src="/js/manager/function.js?<?php echo time();?>"></script>
        <?php
        echo $this->Html->script('manager/highcharts');

        echo $this->Html->script('manager/ckeditor/ckeditor');

        echo $this->Html->css('manager/styles');
        echo $this->Html->css('manager/icons');
        echo $this->Html->css('manager/custom');

        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->fetch('script');
        ?>

        <!-- <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=latin,cyrillic-ext" rel="stylesheet" type="text/css"> -->

    </head>

    <body>
        <?php if($this->Session->read('Auth.User')):?>

            <!-- Navbar -->
            <?php echo $this->Element('manager/navbar'); ?>
            <!-- /navbar -->

            <!-- Page container -->
            <div class="page-container">

                <!-- Sidebar -->
                <?php echo $this->Element('manager/sidebar'); ?>
                <!-- /sidebar -->


                <!-- Page content -->
                <div class="page-content">

                    <?php echo $this->Session->flash(); ?>
                    <?php echo $this->Session->flash('auth'); ?>
                    <?php echo $this->fetch('content'); ?>

                    <!-- Footer -->
                    <?php echo $this->Element('manager/footer'); ?>
                    <!-- /footer -->
                </div>
                <!-- /page content -->

            </div>
            <!-- /container -->
        <?php else:?>
            <?php echo $this->fetch('content'); ?>
        <?php endif;?>
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
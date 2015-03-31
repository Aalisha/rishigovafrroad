<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
        <title>
            <?php echo $title_for_layout; ?>
        </title>


        <?php
        echo $this->Html->css('style');

        echo $this->Html->meta('icon');

        echo $this->Html->script('jquery-1.10.2.min');

        echo $this->Html->script('jquery-ui');

       // echo $this->Html->css('http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css');
	   echo $this->Html->css('jquery-ui');

        echo $this->Html->script('jquery.validate');

        echo $this->Html->script('additional-methods');

        echo $this->Html->script('fileuploader');
        ?>
        <!-- <script type="text/javascript" src="https://getfirebug.com/firebug-lite-debug.js"></script> -->
		<script type='text/javascript' >

            var GLOBLA_PATH = '<?php echo WWW_HOST; ?>';

            var USER_ACCESS = '<?php echo $this->Session->check('Auth.Member') == true ? "yes" : "no"; ?>';

        </script>
    </head>

    <body>
        <?php
        echo $this->Session->flash();

        echo $this->element('cbc/header');
        ?>

        <!-- Start wrapper here-->
        <div class="wrapper">

            <?php echo $content_for_layout; ?> 

        </div>
        <!-- end wrapper here-->

        <?php echo $this->element('footer'); ?>

        <?php echo $this->element('sql_dump'); ?>

        <?php echo $this->Html->script('cbc/commonlib'); ?>

    </body>

</html>
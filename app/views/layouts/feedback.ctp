<?php
/**
 *
 * Registration Layout
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php echo $this->Html->charset(); ?>
        <title> 
            <?php echo $title_for_layout; ?>
        </title>

        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('style');

        echo $this->Html->script('jquery-1.10.2.min');

        echo $this->Html->script('jquery-ui');

        echo $this->Html->script('jquery.validate');
        echo $this->Html->script('additional-methods');
        ?>
        <script type='text/javascript' >
            var GLOBLA_PATH = '<?php echo WWW_HOST; ?>';
        </script>
    </head>
    <body>
        <?php echo $this->Session->flash(); ?>

        <?php echo $this->element('feedback'); ?>

        <!-- Start wrapper here-->
        <div class="wrapper">
            <div class="mainbody">
                <?php echo $content_for_layout; ?> 
            </div>  
        </div>
        <!-- end wrapper here-->
        <?php echo $this->element('user-footer'); ?>
        <?php echo $this->Html->script('commonlib'); ?>
        <?php echo $this->element('sql_dump'); ?>
    </body>

</html>
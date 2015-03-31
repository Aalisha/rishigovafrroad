<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?php echo $this->Html->charset(); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
        <title>
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');

        echo $this->Html->css('home-style');

        echo $this->Html->script('jquery-1.10.2.min');

        echo $this->Html->script('jquery.validate');
        echo $this->Html->script('additional-methods');
        ?>
        <script type='text/javascript' >

            var GLOBLA_PATH = '<?php echo WWW_HOST; ?>';

            var USER_ACCESS = '<?php echo $this->Session->check('Auth.Member') == true ? "yes" : "no"; ?>';

        </script>

    </head>

    <body>

        <?php echo $this->Session->flash(); ?>

        <!-- Start wrapper here-->
        <div class="wrapper">

            <div class="wrapper-main">

                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td bgcolor="#006600" width="154px" valign="top" >

                            <?php echo $this->element('home-left'); ?>

                        </td>
                        <td valign="top" >

                            <?php echo $this->element('home-center'); ?>

                        </td>
                        <td width="155px" valign="top" > 

                            <?php echo $this->element('home-right'); ?>

                        </td>
                    </tr>

                </table>

            </div>

        </div>

        <!-- end wrapper here-->

        <?php echo $this->element('footer'); ?>

        <?php echo $this->element('sql_dump'); ?>

        <?php echo $this->Html->script('home'); ?>

    </body>

</html>
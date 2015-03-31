<!-- Start header here-->

<div class="header">

    <div class="header-main">

        <!-- Start logo here-->
        <div class="logo">

            <?php
            $image = $this->Html->image(
                    'logo.jpg', array(
                'alt' => 'Home',
            ));
            ?>
 
                <?php
                echo $this->Html->link(
                        $image, array('controller' => 'homes', 'action' => 'index'), array(
                    'escape' => false
                ));
                ?>

        </div>
        <!-- end logo here-->

        <!-- Start header-right here-->
        <div class="header-right">
            <div class="callus">
                <?php echo $this->Html->image('callus.png', array('alt' => 'Call Us')); ?>
            </div>
        </div>
        <!-- end header-right here-->
    </div> 
</div>

<!-- end header here-->
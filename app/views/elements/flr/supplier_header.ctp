<!-- Start header here-->
<div class="header">
    <div class="header-main">
        <!-- Start logo here-->
        <div class="logo">
            <?php
            if ($loggedIn):
                $url = $this->Html->url(array('controller' => 'suppliers', 'action' => 'index','flr'=>true));
            else :
                $url = $this->Html->url(array('controller' => 'members', 'action' => 'login'));
            endif;
            ?>
            <a href="<?php echo $url; ?>"><?php echo $this->Html->image('logo.jpg'); ?></a>

        </div>
        <!-- end logo here-->  
        
        <!-- Start nevigation here-->    

        <div class="nevigation">
            <ul class="dropdown">
                  <?php foreach ($flrHeaderNavigation as $key => $values) : 
				  
				 // pr($this->Common);?>
                    <li class="<?php if ($this->Common->in_array_recursive(trim($this->params['controller']), $values) && $this->Common->in_array_recursive(trim($this->action), $values)): ?>select  hover xxxx <?php
                        echo $this->action;
                    endif;
                    ?>">
                        <a><?php echo $key; ?></a>
                        <?php if (count($values) > 0) : ?>
                            <ul class="sub_menu">
                            <?php endif; ?>
                            <?php foreach ($values as $innerKey => $innerValues) : ?>
                                <li> 
                                    <?php echo $this->Html->link($innerKey, array('controller' => $innerValues['controller'], 'action' => $innerValues['action']), array('alt' => $innerValues['alt'])); ?> 	
                                </li>
                            <?php endforeach; ?>
                            <?php if (count($values) > 0) : ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>

            </ul>
        </div>
        <!-- end nevigation here-->
        <!-- Start header-right here-->
        <div class="header-right">
            <div class="callus">
                <?php echo $this->Html->image('callus.png', array('alt' => 'Call Us')); ?>
            </div>
            <div class="logout">  Hello 
			
			<?php
			echo $this->Suppliername->showHeadername($this->Session->read('Auth.Member.vc_user_firstname'),$this->Session->read('Auth.Member.vc_user_lastname'));
		 ?>  | <?php
			echo $this->Html->link('Logout', array('controller' => 'members', 'action' => 'logout', 'flr' => false)); ?>
            </div>      
        </div>
        <!-- end header-right here-->

    </div> 
</div>
<!-- end header here-->   
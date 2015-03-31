<!-- Start header here-->
<div class="header">

    <div class="header-main">

        <!-- Start logo here-->
        <div class="logo">
            <?php
            if ($loggedIn):
                $url = $this->Html->url(array('controller' => 'inspectors', 'action' => 'index'));
            else :
                $url = $this->Html->url(array('controller' => 'inspectors', 'action' => 'login'));
            endif;
            ?>
            <a href="<?php echo $url; ?>"><?php echo $this->Html->image('logo.jpg'); ?></a>


        </div>
        <!-- end logo here-->  


        <!-- Start nevigation here-->    

        <div class="nevigation">

            <ul class="dropdown">
				
				<?php
			
				foreach ($inspectorHeaderNavigation as $key=>$value) : ?>
				
					<li class="<?php if (  $this->Common->in_array_recursive(trim($this->params['controller']), $value)  && $this->Common->in_array_recursive(trim($this->action), $value)): ?> select  hover xxxx <?php echo $this->action;  endif; ?>">
					
						<a ><?php echo $key; ?></a>
					
						<ul class="sub_menu">
							
						<?php foreach ( $value as $innerkey => $innervalue   ) : ?>	
						
							<?php if(  array_key_exists('controller',$innervalue)  ) : ?>
							
							<li>
								<?php echo $this->Html->link($innerkey, array('controller' => $innervalue['controller'], 'action' => $innervalue['action']), array('alt' => $innervalue['alt'])); ?>
							</li>	
							
							<?php else : ?>
							
							<li>
								<a ><?php echo $innerkey  ?></a>
										
								<ul>
											
									<?php foreach ($innervalue as $inkey =>$invalue) : ?>

									<li>
										<?php echo $this->Html->link($inkey, array('controller' => $invalue['controller'], 'action' => $invalue['action']), array('alt' => $invalue['alt'])); ?>
									</li>								
													
									<?php endforeach;?>
											
								</ul>
							
							</li>	
							
							<?php endif;?>	

						<?php endforeach; ?>			
						
						</ul>
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
            <div class="logout">  Hello <?php echo ucfirst($this->Session->read('Auth.Member.vc_user_firstname'));  ?> | <?php echo $this->Html->link('Logout', array('controller' => 'inspectors', 'action' => 'logout')); ?>
            </div>      
        </div>
        <!-- end header-right here-->
     
    </div> 
</div>
<!-- end header here-->   
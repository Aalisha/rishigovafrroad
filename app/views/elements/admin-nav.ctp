<!-- Start header here -->
<div class="header">

    <div class="header-main">

        <!-- Start logo here-->
        <div class="logo">
            
			<?php
                $url = $this->Html->url(array('controller' => 'homes', 'action' => 'index'));
            ?>
            
			<a href="<?php echo $url; ?>"><?php echo $this->Html->image('logo.jpg'); ?></a>


        </div>
        <!-- end logo here-->  

        <!-- Start nevigation here-->    
        <div class="nevigation">

            <ul class="dropdown">

				<li class"" >
			<?php echo $this->Html->link('Import MDC Data', array('controller' => 'erpimports', 'action' => 'getMdcDataImport' ), array('alt' => 'Import MDC Data')); ?> 	
				</li>
				<li>
		 <?php echo $this->Html->link('Import CBC Data', array('controller' => 'erpimports', 'action' => 'getCbcDataImport' ), array('alt' => ' Import CBC Data ')); ?> 	
				</li>
				<li>
		 <?php echo $this->Html->link('Import FLR Data', array('controller' => 'erpimports', 'action' => 'getFlrDataImport'), array('alt' => 'Import FLR Data' )); ?> 	
		
				</li>
				
					<li>
		 <?php echo $this->Html->link('Generate Password', array('controller' => 'erpimports', 'action' => 'generatetemporarypassword'), array('alt' => 'Generate Password' )); ?> 	
		
				</li>
				
               


            </ul>

        </div>

        <!-- end nevigation here-->

        <!-- Start header-right here-->
        <div class="header-right">
            <div class="callus">
                <?php echo $this->Html->image('callus.png', array('alt' => 'Call Us')); ?>
            </div>
            <div class="logout">  Hello Admin | <?php echo $this->Html->link('Logout', array('controller' => 'erpimports', 'action' => 'logout')); ?>
            </div>      
        </div>
        <!-- end header-right here-->
    </div> 
</div>
<!-- end header here-->   
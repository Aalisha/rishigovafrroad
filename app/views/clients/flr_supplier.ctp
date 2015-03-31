<!-- Start wrapper here-->
<?php //pr($this->Session->read('Auth.Member')); die;?>
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'clients', 'action' => 'supplier', 'flr' => true), array('title' => 'Home', 'class' => 'vtip'))
                ?>

            </li>
            <li class="last">My Profile</li>               
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1>Welcome to RFA FLR</h1>
        <h3>Wholesaler / Supplier Details</h3>
        <!-- Start innerbody here-->
        <div class="innerbody">
            <?php echo $this->Form->create(array('url' => array('controller' => 'clients', 'action' => 'supplier', 'flr' => true), 'type' => 'file')); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="40%" valign="middle" align="right"><label class="lab-inner">Upload Document :</label></td>
                    <td width="60%" align="left" valign="top"><?php
                        echo $this->Form->input('Supplier.saledetails', array('label' => false,
                            'div' => false,
                            'type' => 'file',
                            'id'=>'supplierdoc',
                            'class' => 'upload-supplierdoc'));
                        ?>
                    </td>
                </tr>
            </table>
            <br/>
            <table  width="100%" border="0" cellpadding="3" >
                <tr>
                    <td   width='50%' colspan='3' align="right" valign="top">
                        <?php echo $this->Form->submit('Submit', array('div' => false, 'label' => false, 'type' => 'submit', 'class' => 'submit', 'value' => 'submit')); ?>
                    </td>
                    <td width='50%'  colspan ='3' align="left" valign="top">
                        &nbsp;
                    </td>
                </tr>
            </table>
            <?php echo $this->Form->end(null); ?>	
        </div>
        <!-- end innerbody here-->
    </div>
    <!-- end mainbody here-->    
</div>
<?php echo $this->Html->script('flr/supplier_upload_file');
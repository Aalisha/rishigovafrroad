<!-- Start wrapper here-->
<div class="wrapper">
    <!-- Start breadcrumb here-->
    <div class="breadcrumb">
        <ul>
            <li class="first">
                <?php echo $this->Html->link('Home', array('controller' => 'profiles', 'action' => 'index'), array('title' => 'Home', 'class' => 'vtip')) ?>
            </li>
            <li class="last">Customer Vehicle Report</li>        
        </ul>
    </div>
    <!-- end breadcrumb here-->
    <!-- Start mainbody here-->
    <div class="mainbody">
        <h1><?php echo $mdclocal;?></h1>
        <h3>Customer Vehicle Report</h3>

        <?php echo $this->Session->flash(); ?>
        <!-- Start innerbody here-->


        <div class="innerbody">
            <?php echo $this->Form->create(array('url' => array('controller' => 'inspectors', 'action' => 'vehiclereport'))); ?>
            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="13%"><label class="valuetext" >Customer Name :</label></td>
                    <td width="20%">
                        <?php
                        echo $this->Form->input('vc_cutomer_name', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'onclick' => "$('#popDiv3').css('display', 'block')",
                            'required' => 'required',
                            'class' => 'round2'));
                        ?>
                    </td>
                    <td width="13%"><label class="valuetext" >Vehicle LIC. No.</label></td>
                    <td width="15%"><?php
                        echo $this->Form->input('vc_vehicle_lic_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'onclick' => "$('#popDiv3').css('display', 'block')",
                            'required' => 'required',
                            'class' => 'round2'));
                        ?></td>
                    <td width="17%"><span class="valuetext" >Vehicle Reg. No.</span></td>
                    <td width="18%">
                        <?php
                        echo $this->Form->input('vc_vehicle_reg_no', array('label' => false,
                            'div' => false,
                            'type' => 'text',
                            'onclick' => "$('#popDiv3').css('display', 'block')",
                            'required' => 'required',
                            'class' => 'round2'));
                        ?>

                    </td>
                    <td width="15%" align="center">

                        <?php echo $this->Form->submit('submit', array('class' => 'submit')); ?>

                    </td>

                </tr>      
            </table>
            <?php echo $this->Form->end(null); ?>
        </div>


        <div id='ajaxdata' class="innerbody">

            <table width="100%" border="0" cellpadding="3">
                <tr>
                    <td width="13%"><label class="lab-inner">Customer Name :</label></td>
                    <td width="20%"><span class="valuetext"></span></td>
                    <td width="13%"><label class="lab-inner">Veh. LIC. No. : </label></td>
                    <td width="24%"><span class="valuetext"></span></td>
                    <td width="13%"><label class="lab-inner">Veh. Reg. No. :</td>
                    <td width="17%"><span class="valuetext"></span></td>
                </tr>
            </table>
            <br>

            <table width="100%" cellspacing="1" cellpadding="5" border="0" >
                <tr class="listhead1">
                    <td width="6%" align="center">S. No.</td>
                    <td width="17%">Vehicle LIC. No.</td>
                    <td width="17%">Vehicle Reg. No.</td>
                    <td width="15%">Vehicle Type</td>
                    <td width="15%">V Rating</td>
                    <td width="15%">D/T Rating</td>
                    <td width="15%">Rate</td>
                </tr>
                <tr class="cont1">
                    <td align="center" colspan='7'>No Record Found</td>

                </tr>
            </table>

        </div>

    </div>
    <!-- end wrapper here-->

    <div id="popDiv3" class="ontop">
        <div id="popup" class="popup3">
            <a href="javascript:void(0);" class="close" onClick="$('#popDiv3').css('display', 'none');">Close</a>            
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="left" class="content-area"><div class="listhead-popup">Insert Customer Name /  Vehicle Lic. No. / Reg. No.</div></td>
                </tr>
                <tr>
                    <td width="100%" align="center" class="content-area">
                        <div class="content-area-outer">
                            <table width="100%" border="0">
                                <tr>
                                    <td> <input type="text" class="tftextinput" name="q" size="21" maxlength="120"><input type="submit" value="search" class="tfbutton"></td>
                                </tr>
                                <tr>
                                    <td><table width="100%" cellspacing="1" cellpadding="5" border="0" >
                                            <tr class="listhead1">
                                                <td width="50%" align="left">Customer Name</td>
                                                <td width="25%">LIC. No.</td>
                                                <td width="25%">Reg. No.</td>
                                            </tr>
                                            <tr class="cont1">
                                                <td width="50%" align="left">Customer Name</td>
                                                <td width="25%">LIC. No.</td>
                                                <td width="25%">Reg. No.</td>
                                            </tr>
                                            <tr class="cont">
                                                <td width="50%" align="left">Customer Name</td>
                                                <td width="25%">LIC. No.</td>
                                                <td width="25%">Reg. No.</td>
                                            </tr>
                                            <tr class="cont1">
                                                <td width="50%" align="left">Customer Name</td>
                                                <td width="25%">LIC. No.</td>
                                                <td width="25%">Reg. No.</td>
                                            </tr>
                                        </table></td>
                                </tr>
                            </table>
                        </div>

                    </td>
                </tr>
            </table>
        </div>
    </div>

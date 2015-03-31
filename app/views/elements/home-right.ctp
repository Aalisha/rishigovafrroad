 <!-- Start right here-->
    <div class="right">
        <div class="right-logo">
           <?php echo $this->Html->image("rfalogo.jpg", array(
                    "alt" => "Brownies",
                    "width"=>81,
                    "height"=>81, 
                    "border"=>0, 
                    'url' => array('controller' => 'homes', 'action' => 'index')
                    ));
        ?>
    	</div>
		
		<?php if(!@$isInspector) : ?>
        <!-- Start right form here-->
        <div class="rightform">
        
        <?php echo $this->Form->create('Inspector',array('url' => array('controller' => 'inspectors', 'action' => 'login'))); ?>

         <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">

            <tr>
              <td class="textblue" bgcolor="#006600">&nbsp;</td>
              <td height="19" colspan="2"  bgcolor="#006600" class="textblue"><div align="left" class="rightheading">MDC-Inspector Zone </div></td>
            </tr>
           
             <tr>
                <td height="1" colspan="3" bgcolor="#c2c2c2"></td>
             </tr>

              <tr bgcolor="#F8F8F8">
                <td width="14" bgcolor="#F8F8F8">&nbsp;</td>
              <td colspan="2">&nbsp;</td>
            </tr>
              <tr bgcolor="#F8F8F8">
                <td class="text"><div align="left"></div></td>
              <td colspan="2" class="text">Inspector Login</td>
            </tr>
              <tr bgcolor="#F8F8F8">
                <td class="text"><div align="left"> </div></td>
              <td colspan="2" class="text">
<?php echo $this->Form->input( 'vc_username', array( 'label' =>false,'maxlength'=>'30', 'required'=>'required', 'div'=>false, 'type' => 'text', 'id'=>'vc_username' ,'class'=>'field')); ?>
</td>
            </tr>
              <tr bgcolor="#F8F8F8">
                <td height="19" colspan="3" class="text">&nbsp;</td>
            </tr>
              <tr bgcolor="#F8F8F8">
                <td class="text">&nbsp;</td>
              <td colspan="2" class="text"><div align="left">Password</div></td>
            </tr>
              <tr valign="middle" bgcolor="#F8F8F8">
                <td class="text">&nbsp;</td>
              <td colspan="2" class="text"><div align="left">
                <?php echo $this->Form->input('vc_password', array( 'label' =>false,'maxlength'=>30, 'required'=>'required', 'div'=>false, 'type' => 'password', 'id'=>'vc_password' , 'class'=>'field')); ?>
				<input type=image src="<?php echo $this->webroot;?>/img/SUBMIT1.gif"   width="14" height="14" border="0" align="absmiddle"></div></td>
            </tr>
              </form>

				<tr bgcolor="#F8F8F8">
					<td class="text">&nbsp;</td>
					<td colspan="2" >&nbsp;</td>
				</tr>
				
				<tr bgcolor="#F8F8F8">
					<td class="text">&nbsp;</td>
					<td colspan="2" class="text"><?php echo $this->Html->link(' Forgot Password ', array('controller'=>'inspectors','action'=>'forgotpassword',$mdc));?></td>
				</tr>
				
				<tr bgcolor="#F8F8F8">
					<td class="text">&nbsp;</td>
					<td colspan="2" class="text"><?php echo $this->Html->link(' Inspector Registration ', array('controller'=>'inspectors','action'=>'registration',$mdc));?></td>
				</tr>
				
				<tr bgcolor="#F8F8F8">
					<td class="text">&nbsp;</td>
					<td colspan="2" >&nbsp;</td>
				</tr>

          </table>
          
            <?php echo $this->Form->end(null); ?>

    	</div>
		
		<?php endif; ?>
        <!-- end right form here-->
    </div>
    <!-- end right here-->
   
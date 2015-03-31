<?php 
if(isset($this->params['pass'][0]) && $this->params['pass'][0]!='')
$browseid= $this->params['pass'][0];
echo $this->Form->input('InvoiceClaimDoc.'.$browseid, array('label' => false,
                                'div' => false,
                                'type'=>'file',
                                'id' => 'updoc'.$browseid,
                                'tabindex' => '10',
                                'class' => 'uploadfile'));
								?>
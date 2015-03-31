<?php echo $this->Html->link('Portal Home',array('controller'=>'homes','action'=>'index')); ?> |
<?php echo $this->Html->link('Register Now', 
                                        array('controller'=>'members','action'=>'registration')); ?> |
<?php echo $this->Html->link('MDC Local Customer',array('controller'=>'members','action'=>'login',$mdc)); ?> |
<?php echo $this->Html->link('CBC / MDC Foreign Customer', 
                                         array('controller'=>'members','action'=>'login',$cbc)); ?> |
<?php echo $this->Html->link('FLR Clients', 
                                        array('controller'=>'members','action'=>'login',$flr)); ?> |

<?php // echo $this->Html->link('Inspector Registration', array('controller'=>'inspectors','action'=>'registration')); ?> 
<!--| -->											   
								
<?php  echo $this->Html->link('Feedback Form', array('controller'=>'feedbacks','action'=>'userfeedback')); ?>
| 
<?php echo $this->Html->link('Contact Us',''); ?>
										
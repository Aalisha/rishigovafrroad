<!-- Start left here-->
    <div class="lefttop">
      
    <?php echo $this->Html->image(
                            'home.gif',
                            array('width'=> '13', 'height'=> '13', 'align'=> 'absmiddle'));?>

<?php echo $this->Html->link(
                            'Home',
                             array(
                                'controller'=>'homes',
                                'action'=>'index'),
                             array('class'=>'text')); ?>

<?php echo $this->Html->image(
                         'sitemap.gif',
                         array('width'=> '15', 'height'=> '12', 'align'=> 'absmiddle'));?>

<?php echo $this->Html->link(
                            'FAQ',
                             array(
                                'controller'=>'homes',
                                'action'=>'index'),
                             array('class'=>'text')); ?>
    

     
    </div>
    <div class="leftheading">
    News @RFA
    </div>
    <div class="leftnews">
    <ul>
    <li><a href="#" class="textyellow" target="_blank">RFA Annual Stakeholders Consultation on its Business Plan 2008/2009 - 2012/2013</a></li>
    <li><a href="#" class="textyellow" target="_blank">Road Fund Administration re-implements mass distance charges</a></li>
    <li><a href="#" class="textyellow" target="_blank">Public notice on the recent high court judgment on the mass distance charges</a></li>
    <li><a href="#" class="textyellow" target="_blank">RFA Board of Directors appointed</a></li>
    </ul>
    </div>
    <!-- end left here-->
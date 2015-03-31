<table width="100%" border="0">
    <tr>
        <td align="center">

            <?php echo $this->Paginator->numbers(); ?>

            &nbsp;&nbsp;&nbsp;&nbsp;

            <!-- Shows the next and previous links -->
            <?php echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled')); ?>

            &nbsp;&nbsp;&nbsp;&nbsp;

            <?php echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled')); ?>

            &nbsp;&nbsp;&nbsp;&nbsp;

            <!-- prints X of Y, where X is current page and Y is number of pages -->
            <?php echo $this->Paginator->counter(); ?>			


        </td>

    </tr>
</table>

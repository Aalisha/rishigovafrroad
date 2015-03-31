<div id="logpopup" class="ontop">

    <div id="popup" class="popup" style='overflow:scroll; height:400px;'>
      
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
           
            <tr>
                <td height="40" align="center" valign="middle">
                    <div id='showlogdata' class="content-area"></div>
                </td>
            </tr>
			
            <tr>
              <td height="40" align="center" valign="top">  <a href="javascript:void(0);"  onClick="getvaluefromscreen();"><button class="popup-close" id="addrow" type="button">Close</button></a></td>
            </tr>
        </table>
    </div>

</div>

<script>
function getvaluefromscreen(){
//alert();
  hide('logpopup');	
    //$(parentObj).parent().parent().find('input[name ="[vc_end_om]"]').val($('#lastvalueodometerid').val());

  //alert($(this).attr('id'));
}
</script>
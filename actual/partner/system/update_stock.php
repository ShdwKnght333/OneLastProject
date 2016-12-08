<?php

include "../../conf/config.php";
$rs=getSqlRow("SELECT * FROM products WHERE id='".$_REQUEST['id']."' and resid=".$_SESSION['restaid']."");

if( $_REQUEST['id'] == $rs['id'] )
{

?>



<div id="overlay" class="web_dialog_overlay"></div>
        <div id="dialog" class="web_dialog">

        <table style="width: 100%; border: 0px;" cellpadding="3" cellspacing="0">
            <tr>
                <td class="web_dialog_title">&nbsp; <?=$rs['name']?></td>
                <td class="web_dialog_title align_right">
                <a href="javascript:void(0)" title="Close" onclick="HideDialog();">X</a> &nbsp;
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 15px;">
                    <b>Current Stock : <?=$rs['stock_qty']?> Qty.</b>
                </td>
            </tr>

            <tr>
                <td colspan="2" style="padding-left: 15px;">
                    <div id="brands"><br/>

        <form id="myform" name="myform" method="post" action="javascript:void(null);">
        <input type="hidden" name="id" id="id" value="<?=$rs['id']?>" />
        <input type="hidden" name="cmd" id="cmd" value="update_product_stock" />

<input id="Add" name="uptype" type="radio" value="1" checked="1"/> Add
<input id="Remove" name="uptype" type="radio" value="2"/> Remove<br/><br/>
<input type="text" name="st_data" id="st_data" placeholder="Enter Qty." style="width:120px;" class="input-text"/> &nbsp; 
<input id="ssbt" type="submit" class="b22" value="UPDATE STOCK" onclick='this.disabled=true; post_admin("myform"); return false;'/>
</form>

                    </div><br/>
                </td>
            </tr>
        </table>

    </div>

<script type="text/javascript">
$(document).ready(function(){
                ShowDialog(true);
                e.preventDefault();
});

</script>

<?php } else { echo "Access Denied!"; } 

?>

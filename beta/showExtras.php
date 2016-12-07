<?php 
include "conf/config.php";
if(isset($_REQUEST['egid']) && $_REQUEST['egid']) {
echo "<table>";
			$extra_total=0;
			$session_id=session_id();
			$product_id= mysql_query("SELECT * FROM cart where session_id='".$session_id."' and id=".$_REQUEST['egid']." order by added_date asc");
			$proid = mysql_fetch_array($product_id);
			$extras_array=explode(",",$proid['extras']);
			$Extras = mysql_query("SELECT * FROM optional_group where proid=".$proid['prod_id'] ." order by id asc");
			while ($extras_id= @mysql_fetch_array($Extras)) 
			{					
						$extras_info = mysql_query("SELECT * FROM extra_group where id=".$extras_id['egid']." order by id asc");
							while ($roc2 = @mysql_fetch_array($extras_info)) 
							{ 
										if ($roc2['items']) // Check if it has some extra items 
										{ 
													echo "<tr><td colspan='4' style='font-size:12px;padding-top:8px;'>
													<font style='font-size:13px;color:#DB1921;'><b>".$roc2['name']."</b></font><br/>";
													$getRoc3 = mysql_query("SELECT * FROM optionals where id IN (".$roc2['items'].") order by id asc");
													while ($roc3 = mysql_fetch_array($getRoc3)) { ?>
													<?php $send_data =$roc3['id'].",".$_REQUEST['egid'].",".$roc3['price'].",".$proid['qty']; ?>
														<input type="checkbox" style="padding-top:2px;" name="extra_<?=$roc3['id']?>" id="<?=$roc3['id']?>" value="<?=$roc3['id']?>" class="extras_cb cb_<?php echo $_REQUEST['egid']; ?>" onclick="updateExtras(<?php echo $send_data; ?>);" <?php if (in_array($roc3['id'],$extras_array)) echo "checked='true'"; ?>  /> <?php echo $roc3['optional']; ?> [<?=setPrice($roc3['price']);?>]<br/>
													<?php }	/* End of Inner While Loop			*/							
											echo "</td></tr>"; 
										} /* End Of IF condition */ 
							 } /* End of outer While Loop */
			  }/* End of Last Outer While Looop */
echo "</table>";
} ?>


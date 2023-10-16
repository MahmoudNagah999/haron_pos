<?php /*
<div style="position: relative; overflow: hidden;" id="scroller_container">
							<div class="jscroller2_right jscroller2_speed-50  jscroller2_mousemove jscroller2_dynamic" style="white-space: nowrap; margin: 0px; position: absolute; top: 0px; left: -946px;">
<?php $totalxpenses_invee=""; ?>
                                             <span><a href="#" onclick="window.open(this.href, 'AnimeArchive'); return false"> </font> <?php // echo"".$get_db_Currency.""; ?>  </a></span>
                                            
<?php
function alert($id  , $subqty){
    $openQ = get_sum_product_store_data($id)[Quantity] ;
    $all_qty0 = ($openQ + GetQuantity($id,null ));
    $NumberBreakdown = NumberBreakdown($all_qty0, $returnUnsigned = false);
//    var_dump($subqty);
//    die('----------');
    $all_qty = (abs($NumberBreakdown[0]) * $subqty);
####################
return $all_qty ;
	}
$result_new = mysqli_query($con, "SELECT * FROM items where alert_shortcomings!=0");
                            $alr_num=@mysqli_num_rows($result_new);
                            if ($alr_num>=1) {
                                $xxx=1;
while ($row_new = mysqli_fetch_array($result_new)) {
 $alr=alert($row_new['id'] , $row_new['subqty']);
	if($row_new['alert_shortcomings']>=$alr){
        if($xxx=='1'){echo' <span style="color:#ffffff;"></span>';}
	  echo'<font color="#FF0000" dir="ltr">';
echo'<span style="color:#FFF;" dir="ltr"> '.$row_new['item'].' : </span><span style="color:#F59696;" dir="ltr"> '.$alr.'</span>';
echo"</font>";
}
$xxx++;

											}
										}
					?>
                            <?php  //} ?>
           
							
							
                            

							</div>

							</div>
							*/
							?>
                            <div style="   position : absolute;    
    width:200px;
    z-index:1000000000000000;
    height:200px;
    left:50%;
    top:50%;
    margin-left:-100px;
    margin-top:-100px; display:none; background-color:#CCC;" id="tId">
<form  method="get" action="statement_of_account_client.php" target="_blank">
<input type="hidden" name="from" value="<?php echo"".date("Y-m-01").""; ?>" />
<input type="hidden" name="to" value="<?php echo"".date("Y-m-d").""; ?>" />
<input type="number" value="" name="id" />
<input type="submit" value="<?php echo"$client_statement_lang"; ?>" name="submit" />
</form>
</div>
<div style="   position : absolute;    
    width:200px;
    z-index:1000000000000000;
    height:200px;
    left:50%;
    top:50%;
    margin-left:-100px;
    margin-top:-100px; display:none; background-color:#CCC;" id="sId">
<form  method="get" action="statement_of_account_suppliers.php" target="_blank">
<input type="hidden" name="from" value="<?php echo"".date("Y-m-01").""; ?>" />
<input type="hidden" name="to" value="<?php echo"".date("Y-m-d").""; ?>" />
<input type="number" value="" name="id" />
<input type="submit" value="<?php echo"$supplier_statement_lang"; ?>" name="submit" />
</form>
</div>

<div style="   position : absolute;    
    width:200px;
    z-index:1000000000000000;
    height:200px;
    left:50%;
    top:50%;
    margin-left:-100px;
    margin-top:-100px; display:none; background-color:#CCC;" id="INV">
<form  method="get" action="invoice.php" target="_blank">
<input type="number" value="" name="id" /><select name="type">
<option value="sales"><?php echo"$sales_lang"; ?></option>
<option value="receivings"><?php echo"$Purchases_lang"; ?></option>
<option value="sales_returns"><?php echo"$Sales_returns_lang"; ?></option>
<option value="receivings_returns"><?php echo"$Returns_Purchases_lang"; ?></option>
</select>
<input type="submit" value="<?php echo"$Search_bill_lang"; ?>" name="submit" />

</form>
</div>
<?php include"includes/footer.php"; ?>
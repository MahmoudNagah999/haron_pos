<?php
$from=str_replace("/", "-", $_GET['from']);
$to=str_replace("/", "-", $_GET['to']);
$from=stripslashes(date('Y-m-d',strtotime($from)));
$to=stripslashes(date('Y-m-d',strtotime($to)));
?>
                                                <?php
			if($user_profit!=="1" and $user_IsAdmin!=1){
				echo '<div class="alert alert-warning text-right" style="margin-top:150px;">                   '.$not_have_permission_lang.'                             </div>';
				}else{ ?>
                <?php
				if(isset($_GET['from']) and isset($_GET['to'])){ ?>
<table width="50%" border="1" style="border-collapse:collapse; text-align:center; margin:0 auto; margin-top:100px; direction:rtl;">
 <thead style="background-color:#CCC;">
  <tr>
  
    <td>&nbsp;</td>
      <td><?php echo"$the_amount_lang"; ?></td>
  </tr>
  </thead>
  <tr>
    
    <td width="278"><?php echo"$Total_profit_loss_lang"; ?></td>
    <td width="55">
                            <?php
							
$result_total_profitqq= mysqli_query($con,"SELECT * FROM ".$prefix."_sales where   left(date,10) BETWEEN '".$from."' AND '".$to."'");
if(mysqli_num_rows($result_total_profitqq)>0){
while($row_total_profitqq=mysqli_fetch_array($result_total_profitqq))
  {
$pget_total_sales+=($row_total_profitqq['Total']-($row_total_profitqq['Quantity']*$row_total_profitqq['BuyPrice']));
  }
}
///////////////////////////
echo round($pget_total_sales);
							?>
    </td>
  </tr>

    
    <td>- <?php echo"$Expenses_lang"; ?></td>
    <td>-<?php
$presult_total_expenses = mysqli_query($con,"SELECT Amount FROM ".$prefix."_expenses where left(date,10) BETWEEN '".$from."' AND '".$to."'");
if(@mysqli_num_rows($presult_total_expenses)>0){
while($prow_total_expenses=mysqli_fetch_array($presult_total_expenses))
  {
$pget_total_Amount+=$prow_total_expenses['Amount'];
  }
} echo round($pget_total_Amount); ?>
    
    </td>
  </tr>
  <tr>
   <thead style="background-color:#CCC;">
    <td><?php echo"$Net_profit_lang"; ?></td> 
     <td><?php echo round($pget_total_sales-$pget_total_Amount); ?></td>
  </tr>
 
</thead>


  <tr>
</table>
<?php } ?>
<?php } ?>

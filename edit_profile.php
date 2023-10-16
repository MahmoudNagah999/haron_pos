<?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo"".$get_db_CompanyName.""; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php include"includes/css.php"; ?>
    <?php include"includes/js.php"; ?>
</head>
<body  class="cmenu1 example-target">

<div>
    <div>
        <?php
        if ($get_db_isLogo == 1) {
            if ($get_db_Logo=="") {
                echo '<img src="images/yourLogoHere.png" style="float:left; border:0px;"/>';
            } else {
                echo '<img src="uploads/'.$get_db_Logo.'" style="float:left; border:0px;"/>';
            }
        } else {
            //echo"<div class='logodiv'>$get_db_CompanyName</div>";
        }
        ?>
    </div>
    <?php
    include"includes/buttons.php";
    ?>			</div>

<div id='main'>
    <article style="margin-bottom:70px;">

            <div class="text-center">
                <?php include"includes/config_menu.php"; ?>
            </div>
            <fieldset style=" margin:0 auto;">


                <?php
                if( isset($_POST['modification'])){
                    $name=Trim(stripslashes($_POST['name']));
                    $username=Trim(stripslashes($_POST['username']));
                    $password=Trim(stripslashes($_POST['password']));
                    $sale=Trim(stripslashes($_POST['sale']));
                    $buy=Trim(stripslashes($_POST['buy']));
                    $SoldReturns=Trim(stripslashes($_POST['SoldReturns']));
                    $purchasesReturns=Trim(stripslashes($_POST['purchasesReturns']));
                    $EditPrice=Trim(stripslashes($_POST['EditPrice']));
                    $DeleteBllsOfSale=Trim(stripslashes($_POST['DeleteBllsOfSale']));
                    $DeletePurchaseInvoices=Trim(stripslashes($_POST['DeletePurchaseInvoices']));
                    $ModifyBillsOfSale=Trim(stripslashes($_POST['ModifyBillsOfSale']));
                    $ModifyBillsBuy=Trim(stripslashes($_POST['ModifyBillsBuy']));
                    $Revenue=Trim(stripslashes($_POST['Revenue']));
                    $Expenses=Trim(stripslashes($_POST['Expenses']));
                    $Customers=Trim(stripslashes($_POST['Customers']));
                    $GeneralSettings=Trim(stripslashes($_POST['GeneralSettings']));
                    $Groups=Trim(stripslashes($_POST['Groups']));
                    $Items=Trim(stripslashes($_POST['Items']));
                    $UsersAndPermissions=Trim(stripslashes($_POST['UsersAndPermissions']));
                    $ReportsPurchases=Trim(stripslashes($_POST['ReportsPurchases']));
                    $SalesReports=Trim(stripslashes($_POST['SalesReports']));
                    $ReportsSuppliers=Trim(stripslashes($_POST['ReportsSuppliers']));
                    $CustomerReports=Trim(stripslashes($_POST['CustomerReports']));
                    $InventoryReports=Trim(stripslashes($_POST['InventoryReports']));
                    $ReportsRevenues=Trim(stripslashes($_POST['ReportsRevenues']));
                    $ExpenseReports=Trim(stripslashes($_POST['ExpenseReports']));
                    $ReportsOfPayments=Trim(stripslashes($_POST['ReportsOfPayments']));
                    $user_treasury=Trim(stripslashes($_POST['user_treasury']));
                    $user_offers=Trim(stripslashes($_POST['user_offers']));
                    $user_order_supply_report=Trim(stripslashes($_POST['user_order_supply_report']));
                    $user_edit_order_supply=Trim(stripslashes($_POST['user_edit_order_supply']));
                    $user_pdf_order_supply=Trim(stripslashes($_POST['user_pdf_order_supply']));
                    $user_excel_order_supply=Trim(stripslashes($_POST['user_excel_order_supply']));
                    $user_delete_order_supply=Trim(stripslashes($_POST['user_delete_order_supply']));
                    $user_order_supply=Trim(stripslashes($_POST['user_order_supply']));
                    $user_stores_change=Trim(stripslashes($_POST['user_stores_change']));
                    $Suppliers=Trim(stripslashes($_POST['Suppliers']));
                }
                ?>
                <legend align="right"><?php echo"$users_lang"; ?>:</legend>
                <!--  <span id="result"></span>-->
                <?php
                if(isset($_POST['modification'])){
                    if($demo==1){
                        echo '<div class="alert alert-warning text-right">
                  '.$demo_alert.'
                            </div>';
                    }else{
                        $sql="UPDATE ".$prefix."_users SET name='".$name."', username='".$username."',  password='".$password."', sale='".$sale."', buy='".$buy."', SoldReturns='".$SoldReturns."', purchasesReturns='".$purchasesReturns."', DeleteBllsOfSale='".$DeleteBllsOfSale."', DeletePurchaseInvoices='".$DeletePurchaseInvoices."', ModifyBillsOfSale='".$ModifyBillsOfSale."', ModifyBillsBuy='".$ModifyBillsBuy."', Revenue='".$Revenue."', Expenses='".$Expenses."', Customers='".$Customers."', Suppliers='".$Suppliers."', GeneralSettings='".$GeneralSettings."', Groups='".$Groups."', Items='".$Items."', UsersAndPermissions='".$UsersAndPermissions."', ReportsPurchases='".$ReportsPurchases."', SalesReports='".$SalesReports."', ReportsSuppliers='".$ReportsSuppliers."', CustomerReports='".$CustomerReports."', InventoryReports='".$InventoryReports."', ReportsRevenues='".$ReportsRevenues."', ExpenseReports='".$ExpenseReports."', ReportsOfPayments='".$ReportsOfPayments."',user_stores_change='".$user_stores_change."', user_treasury='".$user_treasury."', user_order_supply='".$user_order_supply."', user_delete_order_supply='".$user_delete_order_supply."', user_excel_order_supply='".$user_excel_order_supply."', user_pdf_order_supply='".$user_pdf_order_supply."', user_edit_order_supply='".$user_edit_order_supply."', user_order_supply_report='".$user_order_supply_report."', user_offers='".$user_offers."', EditPrice='".$EditPrice."' where id=".$_POST['id']."";

                        if (!mysqli_query($con,$sql))
                        {
                            echo'<div class="alert alert-danger  text-right">
             '.$not_saved_try_lang.'
                            </div>';
                        }else{
                            echo'<div class="alert alert-success text-right">
                          '.$Data_is_saved_lang.'
                            </div>';
                            header("refresh:1;url=index.php");
                        }
                    }
                }
                if(isset($user_id)){
                    $isedit=1;
                    $result_users = mysqli_query($con,"SELECT * FROM  ".$prefix."_users where id='".$user_id."'");
                    if(mysqli_num_rows($result_users)>0){
                        while($row_users = mysqli_fetch_array($result_users))
                        {
                            $row_id=$row_users['id'];
                            $row_name=$row_users['name'];
                            $row_username=$row_users['username'];
                            $row_password=$row_users['password'];
                            $row_sale=$row_users['sale'];
                            $row_buy=$row_users['buy'];
                            $row_SoldReturns=$row_users['SoldReturns'];
                            $row_purchasesReturns=$row_users['purchasesReturns'];
                            $row_DeleteBllsOfSale=$row_users['DeleteBllsOfSale'];
                            $row_DeletePurchaseInvoices=$row_users['DeletePurchaseInvoices'];
                            $row_ModifyBillsOfSale=$row_users['ModifyBillsOfSale'];
                            $row_ModifyBillsBuy=$row_users['ModifyBillsBuy'];
                            $row_Revenue=$row_users['Revenue'];
                            $row_Expenses=$row_users['Expenses'];
                            $row_Customers=$row_users['Customers'];
                            $row_Suppliers=$row_users['Suppliers'];
                            $row_GeneralSettings=$row_users['GeneralSettings'];
                            $row_Groups=$row_users['Groups'];
                            $row_Items=$row_users['Items'];
                            $row_UsersAndPermissions=$row_users['UsersAndPermissions'];
                            $row_ReportsPurchases=$row_users['ReportsPurchases'];
                            $row_SalesReports=$row_users['SalesReports'];
                            $row_ReportsSuppliers=$row_users['ReportsSuppliers'];
                            $row_CustomerReports=$row_users['CustomerReports'];
                            $row_InventoryReports=$row_users['InventoryReports'];
                            $row_ReportsRevenues=$row_users['ReportsRevenues'];
                            $row_ExpenseReports=$row_users['ExpenseReports'];
                            $row_ReportsOfPayments=$row_users['ReportsOfPayments'];
                            $row_EditPrice=$row_users['EditPrice'];
                            $row_user_treasury=$row_users['user_treasury'];
                            $row_user_edit_order_supply=$row_users['user_edit_order_supply'];
                            $row_user_excel_order_supply=$row_users['user_excel_order_supply'];
                            $row_user_pdf_order_supply=$row_users['user_pdf_order_supply'];
                            $row_user_delete_order_supply=$row_users['user_delete_order_supply'];
                            $row_user_order_supply=$row_users['user_order_supply'];
                            $row_user_order_supply_report=$row_users['user_order_supply_report'];
                            $row_user_offers=$row_users['user_offers'];
                            $row_user_stores_change=$row_users['user_stores_change'];
                        }
                    }
                }else{

                }
                ?>
                <form id="myForm"  method="post"  name="myForm" enctype="multipart/form-data">
                    <table  border="0" dir="rtl" style="padding-top:30px; text-align:right; color:#009; font-weight:bold; font-size:14px; text-align:center; width:100%;">
                        <tr>
                            <th colspan="5" class="text-right"><?php echo"$the_name_lang"; ?>
                                <input type="text" name="name"   class="form-control" value="<?php echo"$row_name"; ?>" /></th>
                            <th class="text-right"><?php echo"$user_name_lang"; ?>
                                <input type="text" name="username"   class="form-control" value="<?php echo"$row_username"; ?>" /></th>
                            <td colspan="2" class="text-right"><span style="vertical-align:middle;"><?php echo"$password_lang"; ?></span>
                                <input type="text" name="password"   class="form-control" value="<?php echo"$row_password"; ?>" /></td>

                        </tr>

                        <tr>
                            <th  class="text-center">&nbsp;</th>
                            <th  class="text-center">&nbsp;</th>
                            <th  class="text-center">&nbsp;</th>
                            <th  class="text-center">&nbsp;</th>
                            <th  class="text-center">&nbsp;</th>
                            <th colspan="2"  class="text-center">&nbsp;</th>
                            <th  class="text-center">&nbsp;</th>
                            <th  class="text-center">&nbsp;</th>
                        </tr>
                        <tr>
                            <th colspan="9"  class="text-center"><?php
                                if($isedit==1){
                                    echo'<input type="submit" name="modification" id="modification" value="'.$Modify_lang.'" class="button"  />';
                                    echo'<input type="hidden"  name="id" value="'.$row_id.'"/>';
                                }else{
                                    echo'<input type="submit" name="add" id="add" value="'.$save_lang.'" class="button"  />';
                                }
                                ?>
                                <input type="button" class="button"  value="<?php echo"$Cancel_lang"; ?>" onclick="javascript:location.href='index.php'"  />
                            </th>
                        </tr>
                        <tr  class="text-right">
                            <th colspan="4"></th>
                            <td width="9%"></td>
                            <td width="22%" style="text-align:right; vertical-align:middle;"><!--<span style="text-align:right; direction:rtl;">التاريخ/المدة</span>--></td>
                            <td colspan="2" style="text-align:right; direction:rtl;"></td>
                        </tr>
                    </table>
                </form>
            </fieldset>
            <?php if($demo==1){
                echo '<div class="alert alert-warning text-right">
                 '.$demo_lang.'
                            </div>';
            }else{ ?>


            <?php } ?>
    </article>
</div>

<div id="toolbar">
    <footer>

        <?php include"includes/scroller_container.php"; ?>
    </footer>
</div>
</body>

</html>
<?php include 'includes/footer.php'; ?>

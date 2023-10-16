<?php
include "includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
        <?php include"includes/css.php"; ?>
        <?php include"includes/js.php"; ?>
    </head>

    <body   >

        <div>
            <div>
                <?php
                if ($get_db_isLogo == 1) {
                    if ($get_db_Logo == "") {
                        echo '<img src="images/yourLogoHere.png" style="float:left; border:0px;"/>';
                    } else {
                        echo '<img src="uploads/' . $get_db_Logo . '" style="float:left; border:0px;"/>';
                    }
                } else {
                    //echo"<div class='logodiv'>$get_db_CompanyName</div>";
                }
                ?>
            </div>
            <?php
            include"includes/buttons.php";
            ?>

        </div>

        <div id='main'>

            <!--   <p class="text-right pull-righ"><?php echo"$date_today_lang"; ?><span> <?php echo"" . $dateonly . ""; ?></span></p> -->

          <!--  <img src="images/logo.jpg" class="img-responsive" /> -->
<br />
<div class="container">
    <div class="row">
        <b  style="dir:rtl;"><?php echo"$welcome_lang"; ?> <?php echo"$user_name"; ?></b>

        <br/>
        <a class="link" href="edit_profile.php"> <?php echo"$profile_lang"; ?> </a></b>

    </div>
    <div class="row" >
        <?php          if ($user_order_supply_report !== "1" and $user_IsAdmin != 1) {}else{?>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 fa-6" style="  ; text-align: center ; border-radius: 20px">
            <a href="reports.php?reports=order_supply" >
                <h1 style="color:#ffc413 " class="text-white"><i  class="fa fa-file"></i></h1>

                <h5 class="card-title"  style="  border: inherit; font-size: large ; border: 1px">
                                        <span style=" color: #ffc413">

                    <?php echo  $order_supply_report_lang; ?>
                                        </span>
                </h5>
            </a>
        </div>
        <?php } ?>
        <?php          if ($user_offers !== "1" and $user_IsAdmin != 1) {}else{?>

            <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 fa-6" style="  ; text-align: center ; border-radius: 20px">
            <a href="offers.php" >
                <h1 style="color: #ff912d" class="text-white"><i  class="fa fa-gift"></i></h1>

                <h5 class="card-title"  style="  border: inherit; font-size: large ; border: 1px">

                                        <span style=" color: #ff912d">

                    <?php echo  $offers_lang; ?>
                                        </span>
                </h5>
            </a>
        </div>
        <?php } ?>
        <?php          if ($user_ReportsPurchases !== "1" and $user_IsAdmin != 1) {}else{?>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 fa-6" style="  ; text-align: center ; border-radius: 20px">
            <a href="reports.php?reports=item_receivings" >
                <h1 style="color: #ff5277" class="text-white"><i  class="fa fa-cart-plus" aria-hidden="true"></i>
                </h1>

                <h5 class="card-title"  style="  border: inherit; font-size: large ; border: 1px">
                    <span style=" color: #ff5277"
>
                    <?php echo  $Purchases_lang; ?></h5>

                    </span>
            </a>
        </div>

      <?php } ?>
        <?php          if ($user_SalesReports !== "1" and $user_IsAdmin != 1) {}else{?>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 fa-6" style="  ; text-align: center ;border-radius: 20px">
            <a href="reports.php?reports=sales" >
                <h1 style="color: #5375ff" class="text-white"><i  class="fa fa-shopping-cart"></i></h1>

                <h5 class="card-title"  style=" border: inherit; font-size: large ; border: 1px">
                    <span style=" color: #5375ff">
                    <?php echo  $sales_lang; ?></h5>

                </span>


            </a>
        </div>
        <?php } ?>
                <?php          if ( $user_IsAdmin != 1) {}else{?>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6 fa-6" style="text-align: center ;border-radius: 20px;">
            <a href="order_supply_status.php" >
                <h1 style="color: #5375ff" class="text-white"><i  class="fa fa-cog"></i></h1>

                <h5 class="card-title"  style=" border: inherit; font-size: large ; border: 1px">
                    <span style=" color: #5375ff">
                    <?php echo  "حالات امر التوريد"; ?></h5>

                </span>


            </a>
        </div>
        <?php } ?>
        
        
        
        
    </div>
</div>

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


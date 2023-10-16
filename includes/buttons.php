<nav class="navbar  navbar-custom" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>

    <div class="navbar-collapse collapse">
        <?php
        $query = $_SERVER['PHP_SELF'];
        $path = pathinfo($query);
        $what_you_want = $path['basename'];
        if ($what_you_want == "") {

        ?>
            <style>
                @media print {
                    .noprint {
                        display: none;
                    }
                }

                tr {
                    page-break-inside: avoid;
                }
            </style>
            <button class="noprint btn btn-info" id="printAll">Print</button>
        <?php } ?>
        <!--      <li>-->
        <!--              <button class="noprint btn btn-info" id="printbyn"  >Print</button>-->
        <!--      </li>-->
        <!--  <ul class="nav navbar-nav navbar-left">
        <li><a href="#">Left</a></li>
        <li><a href="#about">Left</a></li>
    </ul> -->
        <ul class="nav navbar-nav navbar-right text-center">
            <li><a href="logout.php">خروج</a></li>

            <?php if ($user_user_treasury !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "treasury.php") {
                        echo 'class="active"';
                    } ?>><a href="treasury.php"><?php echo "$Treasury_lang"; ?></a></li>
            <?php } ?>
            <?php if ($user_Items !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "items_and_inventory.php") {
                        echo 'class="active"';
                    } ?>><a href="items_and_inventory.php"><?php echo "$Items_and_inventory_lang"; ?></a></li>
            <?php } ?>
            <?php if ($user_Expenses !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "expenses.php") {
                        echo 'class="active"';
                    } ?>><a href="expenses.php"><?php echo "$Expenses_lang"; ?></a></li>
            <?php } ?>

            <?php if($user_AllReports == 1 || $user_IsAdmin == 1){ ?>
                <li <?php if (basename($_SERVER['PHP_SELF']) == "reports.php") { echo 'class="active"'; } ?>>
                    <a href="reports.php">
                        <?php echo "$Reports_lang"; ?>
                    </a>
                </li>
            <?php } ?>


            <?php if ($user_Suppliers !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "suppliers.php") {
                        echo 'class="active"';
                    } ?>><a href="suppliers.php"><?php echo "$Suppliers_lang"; ?></a></li>
            <?php } ?>
            <?php if ($user_Customers !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "clients.php") {
                        echo 'class="active"';
                    } ?>><a href="clients.php"><?php echo "$Clients_lang"; ?></a></li>

            <?php } ?>
            <?php if ($user_GeneralSettings !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "config.php") {
                        echo 'class="active"';
                    } ?>><a href="config.php"><?php echo "$Settings_lang"; ?></a></li>
            <?php } ?>

            <?php if ($user_buy !== "1" and $user_IsAdmin != 1) {
            } else { ?>
                <li <?php if (basename($_SERVER['PHP_SELF']) == "receivings.php") {
                        echo 'class="active"';
                    } ?>><a href="receivings.php"><?php echo "$Purchases_lang"; ?></a></li>

            <?php } ?>

            <?php if ($user_sale !== "1" and $user_IsAdmin != 1) {
            } else { ?>
                <li <?php if (basename($_SERVER['PHP_SELF']) == "sales.php") {
                        echo 'class="active"';
                    } ?>><a href="sales.php"><?php echo "$sales_lang"; ?></a></li>
            <?php } ?>
            <?php if ($user_order_supply !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "order_supply.php") {
                        echo 'class="active"';
                    } ?>><a href="order_supply.php"><?php echo "$order_supply_lang"; ?></a></li>
            <?php } ?>
            <?php if ($user_offer !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "reports.php?reports=order_supply") {
                        echo 'class="active"';
                    } ?>><a href="reports.php?reports=order_supply"><?php echo "الرحلات"; ?></a></li>
            <?php } ?>
            <?php if ($user_stores_change !== "1" and $user_IsAdmin != 1) {
            } else { ?>

                <li <?php if (basename($_SERVER['PHP_SELF']) == "stores_change.php") {
                        echo 'class="active"';
                    } ?>><a href="stores_change.php"><?php echo "$stores_change_lang"; ?></a></li>
            <?php } ?>
            <li <?php if (basename($_SERVER['PHP_SELF']) == "index.php") {
                    echo 'class="active"';
                } ?>><a href="index.php"><?php echo "$Home_lang"; ?></a></li>
        </ul>
    </div>
</nav>
<script type='text/javascript'>
    $(document).on('click', '#printAll', function() {
        var divContents = $('.container').html(); //div which have to print
        var printWindow = window.open('', '', 'height=700,width=900');

        printWindow.document.write('<html><head><title></title>');
        // printWindow.document.write('</head><body onload=\"window.print()\">');
        printWindow.document.write('<link href="../css/forms.css" rel="stylesheet" type="text/css" />');
        printWindow.document.write('<style type="text/css">.test { color:red; } </style></head><body onload=\"window.print()\">');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        printWindow.document.close();

        printWindow.onload = function() {
            printWindow.print();
        }
    });
</script>
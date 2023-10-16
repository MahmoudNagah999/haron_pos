<?php
include "includes/inc.php";
?>
<?php include "includes/css.php"; ?>
<?php include "includes/js.php"; ?>
<!DOCTYPE html>
<html lang="en">

<?php if($user_AllReports == "1" || $user_IsAdmin == '1'){ ?>

<head>
    <style type="text/css">
        /* printer specific CSS */
        @media print {
            #contentnoprint {
                display: none;
            }

            #contentnoprint2 {
                display: none;
            }

            #contentnoprint3 {
                display: none;
            }
        }
    </style>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo "" . $get_db_CompanyName . ""; ?></title>
    <script>
        function showResults(str) {
            if (str.length == 0) {
                document.getElementById("livesearchcl").innerHTML = "";
                document.getElementById("livesearchcl").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearchcl").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearchcl").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "suppliers_search_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function showResultspaym(str) {
            if (str.length == 0) {
                document.getElementById("livesearchcl").innerHTML = "";
                document.getElementById("livesearchcl").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearchcl").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearchcl").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "suppliers_search_paym_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function showResultsOfItems(str) {
            if (str.length == 0) {
                document.getElementById("livesearch").innerHTML = "";
                document.getElementById("livesearch").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearch").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearch").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "items_search_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>

    <script>
        function showResultsOfItemssalei(str) {
            if (str.length == 0) {
                document.getElementById("livesearch30").innerHTML = "";
                document.getElementById("livesearch30").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearch30").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearch30").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "items_search_sale_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function showResultsOfCli(str) {
            if (str.length == 0) {
                document.getElementById("livesearchcli").innerHTML = "";
                document.getElementById("livesearchcli").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearchcli").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearchcli").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "clients_search_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function showResultsOfClipaym(str) {
            if (str.length == 0) {
                document.getElementById("livesearchcli").innerHTML = "";
                document.getElementById("livesearchcli").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearchcli").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearchcli").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "clients_search_paym_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function showResultsOfItemssr(str) {
            if (str.length == 0) {
                document.getElementById("livesearchit40").innerHTML = "";
                document.getElementById("livesearchit40").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearchit40").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearchit40").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "items_search_resale_r.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <script>
        function showResultsOfItemsrew(str) {
            if (str.length == 0) {
                document.getElementById("livesearch22").innerHTML = "";
                document.getElementById("livesearch22").style.border = "0px";
                return;
            }
            if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else { // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("livesearch22").innerHTML = xmlhttp.responseText;
                    document.getElementById("livesearch22").style.border = "0px solid #A5ACB2";
                }
            }
            xmlhttp.open("GET", "showResultsOfItemsrew.php?q=" + str, true);
            xmlhttp.send();
        }
    </script>
    <link href="menu_source/styles.css" rel="stylesheet" type="text/css">
    <script type='text/javascript' src='menu_source/menu_jquery.js'></script>
    <script type="text/javascript" src="js/chart.js"></script>
</head>

<body class="cmenu1 example-target">

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
        include "includes/buttons.php";
        ?>
    </div>

    <div id='main'>
        <article style="margin-bottom:70px;">
            <style>
                .wrap {
                    width: 100%;
                    overflow: auto;
                }

                .fleft {
                    float: left;
                    width: 80%;
                    text-align: center;
                    min-height: 400px;
                }

                .fright {
                    float: right;
                    min-height: 400px;
                    width: 20%;
                    text-align: center;
                }
            </style>


            <div class="wrap">

                <?php
                if (isset($_GET['reports']) and (($_GET['reports'] == "detailed_order_supply") or ($_GET['reports'] == "order_supply"))) {
                ?>
                    <div style="width: 100%" class="fleft">
                    <?php } else {
                    ?>
                        <div class="fleft">

                        <?php
                    }
                        ?>
                        <?php if ($_GET['reports'] == "items_and_inventory" or $_GET['reports'] == null) {
                        } else { ?>
                            <form method="get" id="contentnoprint">

                                <div style="width:100%; margin:0 auto;">
                                    <?php
                                    if ($_GET['reports'] == "client_returns" or $_GET['reports'] == "customer_payments") {
                                        $result_search_clientid = mysqli_query($con, "SELECT name FROM " . $prefix . "_clients WHERE id='" . $_GET['clientID'] . "'");
                                        if (@mysqli_num_rows($result_search_clientid) > 0) {
                                            while ($row_search_clientid = mysqli_fetch_array($result_search_clientid)) {
                                                $clientname = $row_search_clientid['name'];
                                            }
                                        }
                                    ?>
                                        <div style="width:20%; float:right;"><label style="float:right; "><?php echo "$The_client_lang"; ?></label><input type="text" name="client" id="client" dir="rtl" value="<?php if (isset($_GET['clientID'])) {
                                                                                                                                                                                                                        echo "" . $clientname . "";
                                                                                                                                                                                                                    } ?>" class="w100 form-control" <?php if ($_GET['reports'] == "customer_payments") { ?> onkeyup="showResultsOfClipaym(this.value);" <?php } else { ?> onkeyup="showResultsOfCli(this.value);" <?php } ?> autocomplete="off" />
                                            <div id="livesearchcli" style="z-index:1000000000; width:20%; padding-right:50px;  text-align:right; margin-top:5px;  float:right; position:fixed; border:0px; "></div>
                                            <input type="hidden" name="clientID" value="<?php echo "" . $_GET['clientID'] . ""; ?>" />
                                        </div>
                                    <?php } ?>

                                    <?php
                                    if ($_GET['reports'] == "suppliers_receivings" or $_GET['reports'] == "payments_suppliers") {
                                        $result_search_suppliersid = mysqli_query($con, "SELECT name FROM " . $prefix . "_suppliers WHERE id='" . $_GET['SupplierID'] . "'");
                                        if (@mysqli_num_rows($result_search_suppliersid) > 0) {
                                            while ($row_search_suppliersid = mysqli_fetch_array($result_search_suppliersid)) {
                                                $suppliername = $row_search_suppliersid['name'];
                                            }
                                        }
                                    ?>
                                        <div style="width:20%; float:right;"><label style="float:right; "><?php echo "$The_Supplier_lang"; ?></label><input type="text" name="supplier" id="supplier" dir="rtl" value="<?php if (isset($_GET['SupplierID'])) {
                                                                                                                                                                                                                            echo "" . $suppliername . "";
                                                                                                                                                                                                                        } ?>" class="w100 form-control" <?php if ($_GET['reports'] == "payments_suppliers") { ?>onkeyup="showResultspaym(this.value)" <?php } else { ?>onkeyup="showResults(this.value)" <?php } ?> autocomplete="off" />
                                            <div id="livesearchcl" style="z-index:1000000000; width:20%; padding-right:50px;  text-align:right; margin-top:5px;  float:right; position:fixed; border:0px; "></div>
                                            <input type="hidden" name="SupplierID" value="<?php echo "" . $_GET['SupplierID'] . ""; ?>" />
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($_GET['reports'] == "item_order_supply" or $_GET['reports'] == "item_sale") {
                                        $result_search_itemsid = mysqli_query($con, "SELECT item FROM items WHERE id='" . $_GET['q'] . "'");
                                        if (@mysqli_num_rows($result_search_itemsid) > 0) {
                                            while ($row_search_itemsid = mysqli_fetch_array($result_search_itemsid)) {
                                                $itemsname = $row_search_itemsid['item'];
                                            }
                                        }
                                    ?>
                                        <div style="width:20%; float:right;"><label style="float:right; "><?php echo "$the_Item_lang"; ?></label><input type="text" name="item" id="item" value="<?php if (isset($_GET['q'])) {
                                                                                                                                                                                                        echo "" . $itemsname . "";
                                                                                                                                                                                                    } ?>" onkeyup="showResultsOfItemssalei(this.value)" autocomplete="off" class="w100 form-control" />
                                            <div id="livesearch30" style="z-index:1000000000; width:20%; padding-right:50px;  text-align:right; margin-top:5px;  float:right; position:fixed; border:0px; "></div>
                                            <input type="hidden" name="q" value="<?php echo "" . $_GET['q'] . ""; ?>" />
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($_GET['reports'] == "item_receivings") {
                                        $result_search_itemsid = mysqli_query($con, "SELECT item FROM items WHERE id='" . $_GET['q'] . "'");
                                        if (@mysqli_num_rows($result_search_itemsid) > 0) {
                                            while ($row_search_itemsid = mysqli_fetch_array($result_search_itemsid)) {
                                                $itemsname = $row_search_itemsid['item'];
                                            }
                                        }
                                    ?>
                                        <div style="width:20%; float:right;"><label style="float:right; "><?php echo "$the_Item_lang"; ?></label><input type="text" name="item" id="item" value="<?php if (isset($_GET['q'])) {
                                                                                                                                                                                                        echo "" . $itemsname . "";
                                                                                                                                                                                                    } ?>" onkeyup="showResultsOfItemsrew(this.value)" autocomplete="off" class="w100 form-control" />
                                            <div id="livesearch22" style="z-index:1000000000; width:20%; padding-right:50px;  text-align:right; margin-top:5px;  float:right; position:fixed; border:0px; "></div>
                                            <input type="hidden" name="q" value="<?php echo "" . $_GET['q'] . ""; ?>" />
                                        </div>
                                    <?php } ?>
                                    <?php
                                    if ($_GET['reports'] == "items_returns") {
                                        $result_search_itemsid = mysqli_query($con, "SELECT item FROM items WHERE id='" . $_GET['q'] . "'");
                                        if (@mysqli_num_rows($result_search_itemsid) > 0) {
                                            while ($row_search_itemsid = mysqli_fetch_array($result_search_itemsid)) {
                                                $itemsname = $row_search_itemsid['item'];
                                            }
                                        }
                                    ?>
                                        <div style="width:20%; float:right;"><label style="float:right; "><?php echo "$the_Item_lang"; ?></label><input type="text" name="item" id="item" value="<?php if (isset($_GET['q'])) {
                                                                                                                                                                                                        echo "" . $itemsname . "";
                                                                                                                                                                                                    } ?>" onkeyup="showResultsOfItemssr(this.value)" autocomplete="off" class="w100 form-control" />
                                            <div id="livesearchit40" style="z-index:1000000000; width:20%; padding-right:50px;  text-align:right; margin-top:5px;  float:right; position:fixed; border:0px; "></div>
                                            <input type="hidden" name="q" value="<?php echo "" . $_GET['q'] . ""; ?>" />
                                        </div>
                                    <?php } ?>

                                    <div style="width:15%; float:right;">
                                        <?php if ($_GET['reports'] == "order_log") { ?>
                                            <label style="float:right;margin-right: 15px "> <?php echo "رقم امر التوريد"; ?></label>
                                            <input type="text" name="inv_idid" id="inv_idid" class="w100 form-control" value="<?php if (isset($_GET['inv_idid'])) {
                                                                                                                                    echo "" . $_GET['inv_idid'] . "";
                                                                                                                                } else {
                                                                                                                                } ?>" />
                                        <?php } ?>
                                    </div>


                                    <div style="width:15%; float:right;"><label style="float:right; "><?php echo "$from_lang"; ?></label><input type="text" name="from" id="from" value="<?php if (isset($_GET['from'])) {
                                                                                                                                                                                                echo "" . $_GET['from'] . "";
                                                                                                                                                                                            } else {
                                                                                                                                                                                                echo date("d/m/2019");
                                                                                                                                                                                            } ?>" class="w100 form-control" />
                                        <script type="text/javascript">
                                            $('#from').dateEntry({
                                                dateFormat: 'dmy/',
                                                spinnerImage: ''
                                            });
                                        </script>
                                    </div>


                                    <div style="width:15%; float:right;">
                                        <label style="float:right; "> <?php echo "$to_lang"; ?></label>
                                        <input type="text" name="to" id="to" class="w100 form-control" value="<?php if (isset($_GET['to'])) {
                                                                                                                    echo "" . $_GET['to'] . "";
                                                                                                                } else {
                                                                                                                    echo date("d/m/Y");
                                                                                                                } ?>" />


                                        <?php if ($_GET['reports'] == "expenses") { ?>
                                            <div style="width:20%; float:right;">
                                                <label style="float:right; "><?php echo "type"; ?></label>
                                            </div>
                                            <select name="exp_type">
                                                <option value=""></option>
                                                <?php
                                                $expensesName_list = mysqli_query($con, "SELECT * FROM " . $prefix . "_expenses_set");
                                                $num_expensesName_list = mysqli_num_rows($expensesName_list);
                                                if ($num_expensesName_list > 0) {
                                                    while ($row_expensesName_list = mysqli_fetch_array($expensesName_list)) {
                                                        if ($row_expensesName_list['id'] == $_GET['type']) {
                                                            $selected = 'selected="selected"';
                                                        } else {
                                                            $selected = null;
                                                        }
                                                        echo '<option value="' . $row_expensesName_list['id'] . '" ' . $selected . '>' . $row_expensesName_list['expensestype'] . '</option>';
                                                    }
                                                }

                                                ?>
                                            </select>
                                        <?php } ?>
                                        <script type="text/javascript">
                                            $('#to').dateEntry({
                                                dateFormat: 'dmy/',
                                                spinnerImage: ''
                                            });
                                        </script>
                                    </div>
                                </div>

                                <?php if ($_GET['reports'] == "sales") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $The_client_lang; ?></label>

                                        <select id="client_id" name="client_id" size="1" class="w100 placeholder-single w25 js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_clients order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['client_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "receivings") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $The_Supplier_lang; ?></label>

                                        <select id="supplier_id" name="supplier_id" size="1" class="w100 placeholder-single w25 js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_suppliers order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['supplier_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "treasury_statement") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $Safe_name; ?></label>

                                        <select id="safe_id" name="safe_id" size="1" class="w100 placeholder-single w25 js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_safe order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['safe_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "stores_change") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; ">
                                            <?php echo $store_from; ?></label>


                                        <select id="store_from_id" name="store_from_id" size="1" class="w100 placeholder-single  js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_store order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['store_from_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; ">
                                            <?php echo $store_to; ?></label>
                                        <select id="store_to_id" name="store_to_id" size="1" class="w100 placeholder-single  js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_store order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['store_to_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "sales" or $_GET['reports'] == "stores_change" or $_GET['reports'] == "treasury_statement") { ?>

                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo "التفاصيل"; ?></label>

                                        <textarea class="form-control" name="notes"><?php echo $_GET['notes']; ?></textarea>


                                    </div>
                                <?php } ?>



                                <?php if ($_GET['reports'] == "receivings" or $_GET['reports'] == "sales") { ?>
                                    <!--                                    <div style="width:10%; float:right;"><label style="float:right; ">--><?php //echo"INV#"; 
                                                                                                                                                    ?><!--</label>-->
                                    <!--                                        <input type="text" name="inv" id="inv" dir="rtl" value="--><?php //if (isset($_GET['inv'])) {
                                                                                                                                            //                                            echo"" . $_GET['inv'] . "";
                                                                                                                                            //                                        } 
                                                                                                                                            ?><!--" class="w100 form-control"   autocomplete="off" />-->
                                    <!---->
                                    <!--                                    </div>-->
                                <?php } ?>
                                <?php if ($_GET['reports'] == "order_supply" or $_GET['reports'] == "receivings" or $_GET['reports'] == "sales") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo "ORDER#"; ?></label>
                                        <input type="text" name="inv" id="inv" dir="rtl" value="<?php if (isset($_GET['inv'])) {
                                                                                                    echo "" . $_GET['inv'] . "";
                                                                                                } ?>" class="w100 form-control" autocomplete="off" />

                                    </div>

                                <?php } ?>
                                <?php if ($_GET['reports'] == "sales") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; "><?php echo "DOC#"; ?></label><input type="text" name="doc" id="doc" dir="rtl" value="<?php if (isset($_GET['doc'])) {
                                                                                                                                                                                                echo "" . $_GET['doc'] . "";
                                                                                                                                                                                            } ?>" class="w100 form-control" autocomplete="off" />

                                    </div>
                                <?php } ?>

                                <?php if ($_GET['reports'] == "total_item_sale" or $_GET['reports'] == "detailed_sales" or $_GET['reports'] == "sales") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; ">
                                            <?php echo $Store_name; ?></label>


                                        <select id="store_id" name="store_id" size="1" class="w100 placeholder-single  js-states  form-control">
                                            <?php
                                            echo '<option value=""></option>';
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_store order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['store_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                        <!--                                        <input type="text" name="UerID" id="UerID" dir="rtl" value="-->
                                        <?php //if (isset($_GET['UerID'])) {
                                        //                                            echo"" . $_GET['UerID'] . "";
                                        //                                        } 
                                        ?><!--" class="w100 form-control"   autocomplete="off" />-->

                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "total_item_sale") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; ">
                                            <?php echo "العميل"; ?></label>


                                        <select id="client_id" name="client_id" size="1" class="w100 placeholder-single  js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_clients order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['client_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                        <!--                                        <input type="text" name="UerID" id="UerID" dir="rtl" value="-->
                                        <?php //if (isset($_GET['UerID'])) {
                                        //                                            echo"" . $_GET['UerID'] . "";
                                        //                                        } 
                                        ?><!--" class="w100 form-control"   autocomplete="off" />-->

                                    </div>
                                <?php } ?>


                                <?php if ($_GET['reports'] == "total_item_sale" or $_GET['reports'] == "order_supply" or $_GET['reports'] == "sales") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; ">
                                            <?php echo "UerID"; ?></label>


                                        <select id="UerID" name="UerID" size="1" class="w100 placeholder-single  js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_users order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['UerID']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                        <!--                                        <input type="text" name="UerID" id="UerID" dir="rtl" value="-->
                                        <?php //if (isset($_GET['UerID'])) {
                                        //                                            echo"" . $_GET['UerID'] . "";
                                        //                                        } 
                                        ?><!--" class="w100 form-control"   autocomplete="off" />-->

                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "order_supply") { ?>
                                    <!-- 
                                <div style="width:10%; float:right;display: none">
                                    <label style="float:right; "><?php //echo $region_lang; 
                                                                    ?></label>
                                    <select id="region_id" multiple="multiple" name="region_id[]" size="1" class="w100 placeholder-single_order_status  js-states  form-control">
                                        <?php
                                        // echo '<option value=""></option>';
                                        // $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_region order by name ASC");
                                        // $num_item = mysqli_num_rows($ProductsName);
                                        // if ($num_item > 0) {
                                        //     while ($row_item = mysqli_fetch_array($ProductsName)) {
                                        //         if (in_array($row_item['id'], $_GET['region_id'])) {
                                        //             echo '<option data-attrchangeid="' . $row_item['id'] . '" value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                        //         } else {
                                        //             echo '<option data-attrchangeid="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                        //         }
                                        //     }
                                        // }
                                        ?>
                                    </select>
                                </div> -->
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $region_lang; ?></label>

                                        <select id="region_id" multiple="multiple" name="region_id[]" size="1" class="w100 placeholder-single_order_status  js-states  form-control">

                                            <?php
                                            echo '<option value=""></option>';
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_region order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {

                                                    if (in_array($row_item['id'], $_GET['region_id'])) {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>

                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo "المجموعة"; ?></label>
                                        <select name="products[]" multiple="multiple" size="1" class="w100 placeholder-single_order_status  js-states  form-control">
                                            <option value="">المجموعة</option>
                                            <?php
                                            $result_search_products = mysqli_query($con, "SELECT id,product_name FROM products order by product_name ASC");
                                            if (@mysqli_num_rows($result_search_products) > 0) {
                                                while ($row_search_products = mysqli_fetch_array($result_search_products)) {
                                                    if (in_array($row_search_products['id'], $_GET['products'])) {
                                                        echo ' <option value="' . $row_search_products['id'] . '"  selected>' . $row_search_products['product_name'] . '</option>';
                                                    } else {
                                                        echo ' <option value="' . $row_search_products['id'] . '">' . $row_search_products['product_name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>

                                        </select>

                                    </div>
                                <?php } ?>


                                <?php if ($_GET['reports'] == "order_supply") { ?>


                                    <!-- <div style="width:10%; float:right;display: none">
                                    <label style="float:right; "><?php //echo "المركز"; 
                                                                    ?></label>

                                    <select id="centers_id" multiple="multiple" name="centers_id[]" size="1"
                                            class="w100 placeholder-single_order_status  js-states  form-control">

                                        <?php
                                        // echo '<option value=""></option>';
                                        // $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_centers order by name ASC");
                                        // $num_item = mysqli_num_rows($ProductsName);
                                        // if ($num_item > 0) {
                                        //     while ($row_item = mysqli_fetch_array($ProductsName)) {

                                        //         if (in_array($row_item['id'], $_GET['centers'])) {
                                        //             echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                        //         } else {
                                        //             echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                        //         }
                                        //     }
                                        // }
                                        ?>
                                    </select>

                                </div> -->


                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo "المركز"; ?></label>

                                        <select id="centers_id" multiple="multiple" name="centers_id[]" size="1" class="w100 placeholder-single_order_status  js-states  form-control">

                                            <?php
                                            echo '<option value=""></option>';
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_centers order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {

                                                    if (in_array($row_item['id'], $_GET['centers_id'])) {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>


                                <?php } ?>


                                <?php if ($_GET['reports'] == "order_supply") {
                                    $alphapatic = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
                                ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo "Alpha"; ?></label>

                                        <select id="Alpha" multiple="multiple" name="Alpha[]" size="1" class="w100 placeholder-single_order_status  js-states  form-control">
                                            <?php
                                            echo '<option value=""></option>';
                                            foreach ($alphapatic as $value) {
                                                if (in_array($value, $_GET['Alpha'])) {
                                                    echo '<option data-attrchangeid ="' . $value . '" value="' . $value . '"   selected="selected">' . $value . '</option>';
                                                } else {
                                                    echo '<option data-attrchangeid ="' . $value . '" value="' . $value . '">' . $value . '</option>';
                                                }
                                            }
                                            /*  $AlphaName = mysqli_query($con, "SELECT * FROM alpha order by name ASC");
                                          $num_Alpha = mysqli_num_rows($AlphaName);
                                          if ($num_Alpha > 0) {
                                              while ($row_Alpha = mysqli_fetch_array($AlphaName)) {

                                                  if ( in_array($row_Alpha['id'],$_GET['alpha'])) {
                                                      echo'<option data-attrchangeid ="'.$row_Alpha['id'].'" value="' . $row_Alpha['id'] . '"   selected="selected">' . $row_Alpha['name'] . '</option>';
                                                  } else {
                                                      echo'<option data-attrchangeid ="'.$row_Alpha['id'].'" value="' . $row_Alpha['id'] . '">' . $row_Alpha['name'] . '</option>';
                                                  }
                                              }
                                          }*/
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>


                                <?php if ($_GET['reports'] == "total_item_sale" or $_GET['reports'] == "sales" or $_GET['reports'] == "detailed_sales") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $the_branch_name_lang; ?></label>

                                        <select id="branch_id" name="branch_id" size="1" class="w100 placeholder-single w25 js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_branch order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['branch_id']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "order_supply" and ($user_branch_id == 0 or $user_branch_id == '' or $user_branch_id == null)) { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $the_branch_name_lang; ?></label>

                                        <select id="branch_id" multiple="multiple" name="branch_id[]" size="1" class="w100 placeholder-single w25 js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_branch order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if (in_array($row_item['id'], $_GET['branch_id'])) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "total_item_sale" or $_GET['reports'] == "detailed_sales") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo "الصنف"; ?></label>

                                        <select id="item" name="item" size="1" class="w100 placeholder-single w25 js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM items order by item ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {
                                                    if ($row_item['id'] == $_GET['item']) {
                                                        echo '<option value="' . $row_item['id'] . '"   selected="selected">' . $row_item['item'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['item'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>

                                <?php if ($_GET['reports'] == "order_supply") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; ">
                                            <?php echo "mobile1"; ?></label>
                                        <input type="text" name="mobile1" id="mobile1" dir="rtl" value="<?php if (isset($_GET['mobile1'])) {
                                                                                                            echo "" . $_GET['mobile1'] . "";
                                                                                                        } ?>" class="w100 form-control" autocomplete="off" />


                                    </div>
                                    <div style="width:10%; float:right;display: none"><label style="float:right; ">
                                            <?php echo "mobile2"; ?></label>
                                        <input type="text" name="mobile2" id="mobile2" dir="rtl" value="<?php if (isset($_GET['mobile2'])) {
                                                                                                            echo "" . $_GET['mobile2'] . "";
                                                                                                        } ?>" class="w100 form-control" autocomplete="off" />


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "order_supply") { ?>
                                    <div style="width:10%; float:right;">
                                        <label style="float:right; "><?php echo $status_name; ?></label>

                                        <select id="status" multiple="multiple" name="status[]" size="1" class="w100 placeholder-single_order_status  js-states  form-control">
                                            echo'
                                            <option value=""></option>
                                            ';
                                            <?php
                                            $ProductsName = mysqli_query($con, "SELECT * FROM " . $prefix . "_order_supply_status order by name ASC");
                                            $num_item = mysqli_num_rows($ProductsName);
                                            if ($num_item > 0) {
                                                while ($row_item = mysqli_fetch_array($ProductsName)) {

                                                    if (in_array($row_item['id'], $_GET['status'])) {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '"   selected="selected">' . $row_item['name'] . '</option>';
                                                    } else {
                                                        echo '<option data-attrchangeid ="' . $row_item['id'] . '" value="' . $row_item['id'] . '">' . $row_item['name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>


                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "detailed_order_supply" or $_GET['reports'] == "detailed_sales") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; "><?php echo "المجموعة"; ?></label>
                                        <select name="groupid[]" multiple="multiple" class="w100 placeholder-single form-control">
                                            <option value=""></option>
                                            <?php
                                            $Groups_list = mysqli_query($con, "SELECT * FROM products where id>0  order by product_name ASC");
                                            $num_Groups_list = mysqli_num_rows($Groups_list);
                                            if ($num_Groups_list > 0) {
                                                while ($row_Groups_list = mysqli_fetch_array($Groups_list)) {
                                                    if (in_array($row_Groups_list['id'], $_GET['groupid'])) {
                                                        echo '<option value="' . $row_Groups_list['id'] . '"   selected="selected">' . $row_Groups_list['product_name'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row_Groups_list['id'] . '">' . $row_Groups_list['product_name'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                <?php } ?>
                                <?php if ($_GET['reports'] == "detailed_order_supply" or $_GET['reports'] == "detailed_sales") { ?>
                                    <div style="width:10%; float:right;"><label style="float:right; "><?php echo "الشركة"; ?></label>
                                        <select name="companies" class="w100 placeholder-single form-control">
                                            <option value=""></option>
                                            <?php
                                            $companies = mysqli_query($con, "SELECT * FROM " . $prefix . "_companies  order by id ASC");
                                            $num_companies = mysqli_num_rows($companies);
                                            if ($num_companies > 0) {
                                                while ($row_companies = mysqli_fetch_array($companies)) {
                                                    if ($row_companies['id'] == $_GET['companies']) {
                                                        echo '<option value="' . $row_companies['id'] . '"   selected="selected">' . $row_companies['CompaniesName'] . '</option>';
                                                    } else {
                                                        echo '<option value="' . $row_companies['id'] . '">' . $row_companies['CompaniesName'] . '</option>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>
                                <?php } ?>
                                <div style="float:right; padding-top:20px; text-align:center;">
                                    <input type="submit" value="<?php echo "$View_report_lang"; ?>" class="btn btn-info" />

                                </div>
                                <?php if ($_GET['reports'] == "order_supply") { ?>
                                    <?php if ($user_excel_order_supply !== "1" and $user_IsAdmin != 1) {
                                    } else { ?>
                                        <div style=" float:right; padding-top:20px; text-align:center;">
                                            <a href="#" id="excel" class="btn btn-danger"> <i class="fa fa-file-excel-o"> <?php echo "$export_report_lang"; ?></i></a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($user_pdf_order_supply !== "1" and $user_IsAdmin != 1) {
                                    } else { ?>
                                        <div style=" float:right; padding-top:20px; text-align:center;">
                                            <a href="#" id="allmultiPrint" class="btn btn-primary"><i class="fa fa-print"></i><?php echo $print_all_lang; ?></a>
                                        </div>
                                    <?php } ?>

                                <?php } ?>
                                <?php if ($_GET['reports'] == "receivings") {


                                ?>
                                    <div style=" float:right; padding-top:20px; text-align:center;">
                                        <?php if ($user_excel_order_supply !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <a href="#" id="excelreceivings">
                                                <i class="fa fa-file-excel-o"> <?php echo "$export_report_lang"; ?></i>

                                            <?php } ?>
                                    </div>
                                    <div style=" float:right; padding-top:20px; text-align:center;">
                                        <?php if ($user_pdf_order_supply !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <a href="#" id="allmultiPrintreceivings"><i class="fa fa-print"></i><?php echo $print_all_lang; ?></a>

                                        <?php } ?>
                                    </div>

                                <?php } ?>
                                <?php if ($_GET['reports'] == "stores_change") { ?>

                                    <div style=" float:right; padding-top:20px; text-align:center;">
                                        <?php if ($user_stores_change !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <a href="#" id="allmultiPrint2"><i class="fa fa-print"></i><?php echo $print_all_lang; ?></a>

                                        <?php } ?>
                                    </div>

                                <?php } ?>
                                <?php if ($_GET['reports'] == "treasury_statement") { ?>

                                    <div style=" float:right; padding-top:20px; text-align:center;">
                                        <?php if ($user_user_treasury !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <a href="#" id="allmultiPrintTreauryStatement"><i class="fa fa-print"></i><?php echo $print_lang; ?></a>

                                        <?php } ?>
                                    </div>

                                <?php } ?>
                                <input type="hidden" name="reports" value="<?php echo "" . $_GET['reports'] . ""; ?>" />
                            </form>
                        <?php } ?>
                        <?php
                        if ($_GET['reports'] == "receivings") {
                            include "includes/reports/receivings_r.php";
                        } else if ($_GET['reports'] == "sales") {
                            include "includes/reports/sales_r.php";
                        } else if ($_GET['reports'] == "order_supply") {
                            include "includes/reports/order_supply_r.php";
                        } else if ($_GET['reports'] == "offers") {
                            include "includes/reports/offers_r.php";
                        } else if ($_GET['reports'] == "stores_change") {
                            include "includes/reports/stores_change_r.php";
                        } else if ($_GET['reports'] == "receivings_returns") {
                            include "includes/reports/receivings_returns_r.php";
                        } else if ($_GET['reports'] == "expenses") {
                            include "includes/reports/expenses_r.php";
                        } else if ($_GET['reports'] == "suppliers_receivings") {
                            include "includes/reports/suppliers_receivings_r.php";
                        } else if ($_GET['reports'] == "item_receivings") {
                            include "includes/reports/item_receivings_r.php";
                        } else if ($_GET['reports'] == "sales_returns") {
                            include "includes/reports/sales_returns_r.php";
                        } else if ($_GET['reports'] == "client_returns") {
                            include "includes/reports/client_returns_r.php";
                        } else if ($_GET['reports'] == "items_returns") {
                            include "includes/reports/items_returns_r.php";
                        } else if ($_GET['reports'] == "profit") {
                            include "includes/reports/profit.php";
                        } else if ($_GET['reports'] == "order_log") {
                            include "includes/reports/order_log.php";
                        } else if ($_GET['reports'] == "items_and_inventory") {
                            include "includes/reports/items_and_inventory.php";
                        } else if ($_GET['reports'] == "customer_payments") {
                            include "includes/reports/customer_payments_r.php";
                        } else if ($_GET['reports'] == "payments_suppliers") {
                            include "includes/reports/payments_suppliers_r.php";
                        } else if ($_GET['reports'] == "item_sale") {
                            include "includes/reports/item_sale_r.php";
                        } else if ($_GET['reports'] == "total_item_sale") {
                            include "includes/reports/total_item_sale_r.php";
                        } else if ($_GET['reports'] == "item_order_supply") {
                            include "includes/reports/item_order_supply_r.php";
                        } else if ($_GET['reports'] == "treasury") {
                            include "includes/reports/treasury_r.php";
                        } else if ($_GET['reports'] == "treasury_statement") {
                            include "includes/reports/treasury_statement_r.php";
                        } else if ($_GET['reports'] == "detailed_sales") {
                            include "includes/reports/detailed_sales_report.php";
                        } else if ($_GET['reports'] == "detailed_order_supply") {
                            include "includes/reports/detailed_order_supply_report.php";
                        } else if ($_GET['reports'] == "detailed_offers") {
                            include "includes/reports/detailed_offers_report.php";
                        } else if ($_GET['reports'] == "orders_rate") {
                            include "includes/reports/orders_rate_r.php";
                        } else if ($_GET['reports'] == "orders_rate_regions") {
                            include "includes/reports/regions_orders_rate_r.php";
                        } else if ($_GET['reports'] == "detailed_stores_change") {
                            include "includes/reports/detailed_stores_change_report.php";
                        } else {
                            if ($user_IsAdmin == 1) {
                                $this_year = date("Y");
                                if ($Discount_type == 2) {
                                    $add_sql_disc = "Total-(Total*discount/100)";
                                } else {
                                    $add_sql_disc = "Total-discount";
                                }
                                if ($_GET['chart'] == "daily") {
                                    echo "<h3>" . $Daily_sales_lang . "</h3>";
                                    $sql_chart = "SELECT DATE_FORMAT(date, '%d') as monthe,sum($add_sql_disc) as total FROM " . $prefix . "_sales_inv where type in('1','2') and date_format(date, '%Y-%m')=date_format(now(), '%Y-%m') and YEAR(date)='$this_year' group by DAY(date)  order by DAY(date) ASC";
                                } else if ($_GET['cahrt'] == "monthly") {
                                    echo "<h3>" . $Monthly_sales_lang . "</h3>";
                                    $sql_chart = "SELECT DATE_FORMAT(date, '%m-%Y') as monthe,sum($add_sql_disc) as total FROM " . $prefix . "_sales_inv where type in('1','2') and YEAR(date)='$this_year' group by MONTH(date)  order by MONTH(date) ASC";
                                } else {
                                    $sql_chart = "SELECT DATE_FORMAT(date, '%m-%Y') as monthe,sum($add_sql_disc) as total FROM " . $prefix . "_sales_inv where type in('1','2')  and YEAR(date)='$this_year' group by MONTH(date)  order by MONTH(date) ASC";
                                }
                                echo "<ul class='list-inline'>
        <li><a href='?chart=monthly'>" . $Monthly_sales_lang . "</a></li>
       <li><a href='?chart=daily'>" . $Daily_sales_lang . "</a></li>
                        </ul>";
                                $result_chart = @mysqli_query($con, $sql_chart);
                                $chart_num = @mysqli_num_rows($result_chart);
                                $chart_i = 1;
                                while ($row_chart = @mysqli_fetch_array($result_chart)) {
                                    if ($chart_i == $chart_num) {
                                        $chart_months .= "'" . $row_chart['monthe'] . "'";
                                    } else {
                                        $chart_months .= "'" . $row_chart['monthe'] . "',";
                                    }
                                    if ($chart_i == $chart_num) {
                                        $chart_total .= "'" . $row_chart['total'] . "'";
                                    } else {
                                        $chart_total .= "'" . $row_chart['total'] . "',";
                                    }
                                    $chart_i++;
                                }
                        ?>
                                <canvas id="canvas" height="300" width="580"></canvas>


                                <script>
                                    var barChartData = {
                                        labels: [<?php echo "$chart_months"; ?>],
                                        datasets: [{
                                            label: "المبيعات الشهرية",
                                            fillColor: "rgba(245, 124, 21, 0.75)",
                                            strokeColor: "#901B1B",
                                            highlightFill: "#0026F8",
                                            highlightStroke: "#901B1B",
                                            data: [<?php echo "$chart_total"; ?>]
                                        }]
                                    };

                                    // window.onload = function(){
                                    //     var ctx = document.getElementById("canvas").getContext("2d");
                                    //     window.myBar = new Chart(ctx).Line(barChartData, {
                                    //         responsive : true
                                    //     });
                                    // }
                                </script>
                                <table class="table table-bordered" border="1" style="width:50%; text-align:center; margin:0 auto; border-collapse:collapse;">
                                    <tr>
                                        <td>

                                            <?php
                                            $result_gettreasury = mysqli_query($con, "SELECT SUM(Amount) as Amount FROM " . $prefix . "_treasury");
                                            $row_gettreasury = mysqli_fetch_assoc($result_gettreasury);
                                            print $totaltreasury = round($row_gettreasury['Amount'], 2);
                                            ?>
                                        </td>
                                        <td><?php echo "$Total_cash_treasury_lang"; ?></td>
                                    </tr>

                                    <tr>
                                        <td><?php
                                            ##################
                                            $result_price = mysqli_query($con, "SELECT price,Quantity,id FROM items");
                                            if (@mysqli_num_rows($result_price) > 0) {
                                                while ($row_price = mysqli_fetch_array($result_price)) {
                                                    $totalgetprice += $row_price['price'] * ($row_price['Quantity'] + GetQuantity($row_price['id']));
                                                }
                                            }
                                            ######################################################
                                            print round($totalgetprice, 2);
                                            ?></td>
                                        <td><?php echo "$stock_Purchase_price_lang"; ?></td>
                                    </tr>


                                    <tr>
                                        <td><?php
                                            ##################
                                            $result_Retail_price = mysqli_query($con, "SELECT Retail_price,Quantity,id FROM items");
                                            if (@mysqli_num_rows($result_Retail_price) > 0) {
                                                while ($row_Retail_price = mysqli_fetch_array($result_Retail_price)) {
                                                    $totalgetRetail_price += $row_Retail_price['Retail_price'] * ($row_Retail_price['Quantity'] + GetQuantity($row_Retail_price['id']));
                                                }
                                            }
                                            print round($totalgetRetail_price, 2);
                                            ######################################################
                                            ?></td>
                                        <td><?php echo "$stock_Selling_price_lang"; ?></td>
                                    </tr>


                                </table>

                        <?php
                            }
                        }
                        ?>
                        </div>
                        <?php
                        if (($_GET['reports'] != "detailed_order_supply") and ($_GET['reports'] != "order_supply")) {
                        ?>

                            <div class="fright" id="contentnoprint3">

                                <div id='cssmenu'>

                                    <ul>

                                        <li class='<?php if ($_GET['reports'] == "") {
                                                        echo "active";
                                                    } ?>'><a href='reports.php'><span><?php echo "$Reports_lang"; ?></span></a></li>
                                        <li><a target="_BLANK" href="orders_rate_r.php"><span>اﻻوردرات المجمعه</span></a></li>
                                        <li><a target="_BLANK" href="regions_orders_rate_r.php"><span>اﻻوردرات المجمعه - الفروع</span></a></li>
                                        <li><a target="_BLANK" href="orders_rate_emps_r.php"><span>اوردرات الموظفين المجمع</span></a></li>
                                        <li><a target="_BLANK" href="branches_rate_emps_r.php"><span>اوردرات الموظفين المجمع - الفروع</span></a>
                                        </li>

                                        <?php if ($user_ReportsPurchases !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "receivings" or $_GET['reports'] == "receivings_returns" or $_GET['reports'] == "suppliers_receivings" or $_GET['reports'] == "item_receivings") {
                                                            echo "active";
                                                        } ?>'><a href='#'><span><?php echo "$Purchases_lang"; ?></span></a>
                                                <ul>
                                                    <li>
                                                        <a href='?reports=receivings'><span><?php echo "$Purchases_lang"; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href='?reports=receivings_returns'><span><?php echo "$Returns_Purchases_lang"; ?></span></a>
                                                    </li>
                                                    <li class='last'><a href='?reports=suppliers_receivings'><span><?php echo "$Purchases_supplier_lang"; ?></span></a>
                                                    </li>
                                                    <li class='last'><a href='?reports=item_receivings'><span><?php echo "$Purchases_items_lang"; ?></span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                        <?php if ($user_SalesReports !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "sales" or $_GET['reports'] == "sales_returns" or $_GET['reports'] == "client_returns" or $_GET['reports'] == "items_returns") {
                                                            echo "active";
                                                        } ?>'><a href='#'><span><?php echo "$sales_lang"; ?></span></a>
                                                <ul>
                                                    <li>
                                                        <a href='?reports=detailed_sales'><span><?php echo "تقرير المبيعات التفصيلى"; ?></span></a>
                                                    </li>
                                                    <li><a href='?reports=sales'><span><?php echo "$sales_lang"; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href='?reports=item_sale'><span><?php echo "$Sales_items_lang"; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href='?reports=total_item_sale'><span><?php echo "$Total_Sales_items_lang"; ?></span></a>
                                                    </li>

                                                    <li>
                                                        <a href='?reports=sales_returns'><span><?php echo "$Sales_returns_lang"; ?></span></a>
                                                    </li>
                                                    <li class='last'><a href='?reports=client_returns'><span><?php echo "$Returns_client_lang"; ?></span></a>
                                                    </li>
                                                    <li class='last'><a href='?reports=items_returns'><span><?php echo "$Return_items_lang"; ?></span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                        <?php if ($user_order_supply_report !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "order_supply" or $_GET['reports'] == "client_returns" or $_GET['reports'] == "items_returns") {
                                                            echo "active";
                                                        } ?>'><a href='#'><span><?php echo "$order_supply_lang"; ?></span></a>
                                                <ul>

                                                    <li>
                                                        <a href='?reports=detailed_order_supply'><span><?php echo "تقرير اوامر التوريد التفصيلى"; ?></span></a>
                                                    </li>

                                                    <li>
                                                        <a href='?reports=order_supply'><span><?php echo "$order_supply_report_lang"; ?></span></a>
                                                    </li>

                                                </ul>
                                            </li>

                                        <?php } ?>
                                        <?php if ($user_offers !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "offers" or $_GET['reports'] == "client_returns" or $_GET['reports'] == "items_returns") {
                                                            echo "active";
                                                        } ?>'><a href='#'><span><?php echo "$offers_lang"; ?></span></a>
                                                <ul>
                                                    <li>
                                                        <a href='?reports=detailed_offers'><span><?php echo "تقرير العروض التفصيلى"; ?></span></a>
                                                    </li>
                                                    <li><a href='?reports=offers'><span><?php echo "$offers_lang"; ?></span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                        <?php if ($user_stores_change !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "stores_change" or $_GET['reports'] == "client_returns" or $_GET['reports'] == "items_returns") {
                                                            echo "active";
                                                        } ?>'><a href='#'><span><?php echo "$stores_change_lang"; ?></span></a>
                                                <ul>
                                                    <li>
                                                        <a href='?reports=detailed_stores_change'><span><?php echo "تقرير تحويل المخازن التفصيلى"; ?></span></a>
                                                    </li>
                                                    <li>
                                                        <a href='?reports=stores_change'><span><?php echo "$stores_change_lang"; ?></span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } ?>

                                        <?php if ($user_Expenses !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "expenses") {
                                                            echo "active";
                                                        } ?>'><a href='?reports=expenses'><span><?php echo "$Expenses_lang"; ?></span></a>
                                            </li>

                                        <?php } ?>


                                        <?php if ($user_ReportsSuppliers !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "payments_suppliers") {
                                                            echo "active";
                                                        } ?>'>
                                                <a href='?reports=payments_suppliers'><span><?php echo "$Suppliers_payments_lang"; ?></span></a>
                                            </li>

                                        <?php } ?>

                                        <?php if ($user_CustomerReports !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "customer_payments") {
                                                            echo "active";
                                                        } ?>'>
                                                <a href='?reports=customer_payments'><span><?php echo "$Customers_payments_lang"; ?></span></a>
                                            </li>

                                        <?php } ?>

                                        <?php if ($user_Items !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "items_and_inventory") {
                                                            echo "active";
                                                        } ?>'>
                                                <a href='?reports=items_and_inventory'><span><?php echo "$Items_and_inventory_lang"; ?></span></a>
                                            </li>

                                        <?php } ?>


                                        <?php if ($user_Revenue !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>
                                            <li class='<?php if ($_GET['reports'] == "profit") {
                                                            echo "active";
                                                        } ?>'><a href='?reports=profit'><span><?php echo "$profits_lang"; ?></span></a></li>
                                        <?php } ?>

                                        <?php if ($user_Revenue !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>
                                            <li class='<?php if ($_GET['reports'] == "order_log") {
                                                            echo "active";
                                                        } ?>'>
                                                <a href='?reports=order_log'><span><?php echo "تقرير تعديلات امر توريد"; ?></span></a>
                                            </li>
                                        <?php } ?>


                                        <?php if ($user_user_treasury !== "1" and $user_IsAdmin != 1) {
                                        } else { ?>

                                            <li class='<?php if ($_GET['reports'] == "treasury" or $_GET['reports'] == "treasury_statement") {
                                                            echo "active";
                                                        } ?>'><a href='#'><span><?php echo "الخزينة"; ?></span></a>
                                                <ul>
                                                    <li class='<?php if ($_GET['reports'] == "treasury") {
                                                                    echo "active";
                                                                } ?>'><a href='?reports=treasury'><span><?php echo "الخزينة"; ?></span></a>
                                                    </li>
                                                    <li class='<?php if ($_GET['reports'] == "treasury_statement") {
                                                                    echo "active";
                                                                } ?>'>
                                                        <a href='?reports=treasury_statement'><span><?php echo "تفصيل الخزينة"; ?></span></a>
                                                    </li>
                                                </ul>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
        </article>
    </div>
    <!--
        <div id="toolbar">
            <footer>
<?php // include"includes/scroller_container.php";
?>
            </footer>
        </div>
        -->
</body>

</html>
<?php include 'includes/footer.php'; ?>
<?php }else{ ?>
    <div class="alert alert-warning"> <?= $not_have_permission_lang; ?> </div>
<?php } ?>
<script>
    $(".js-example-placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    });
    $(".placeholder-single_order_status").select2({
        placeholder: "اختر",
        allowClear: true,
        multiple: true
    });
    $(".placeholder-single").select2({
        placeholder: "اختر",
        allowClear: true
    });
    $('#excel').click(function(e) {
        var url = 'xls/export/order_supply_excel.php' + '<?php echo $targetpage ?>';
        window.open(url, '_blank');
    });
    $('#excelreceivings').click(function(e) {
        var url = 'xls/export/receivings_excel.php' + '<?php echo $targetpage ?>';
        window.open(url, '_blank');
    });
    $('#allmultiPrint').click(function(e) {
        // alert('multi here print')
        var ids = [];


        var url = 'pdf/export/order_supply_print_all.php' + '<?php echo $targetpage ?>';
        window.open(url, '_blank');
    });
    $('#allmultiPrintreceivings').click(function(e) {
        // alert('multi here print')
        var ids = [];


        var url = 'pdf/export/receivings_print_all.php' + '<?php echo $targetpage ?>';
        window.open(url, '_blank');
    });
    $('#allmultiPrintTreauryStatement').click(function(e) {
        // alert('multi here print')
        var ids = [];
        var url = 'pdf/export/treasury_statement_print_all.php' + '<?php echo $targetpage ?>';
        window.open(url, '_blank');
    });
    $('#allmultiPrint2').click(function(e) {
        // alert('multi here print')
        var ids = [];


        var url = 'pdf/export/stores_change_print_all.php<?php echo $targetpage; ?>&ids=' + ids;
        window.open(url, '_blank');
    });
</script>
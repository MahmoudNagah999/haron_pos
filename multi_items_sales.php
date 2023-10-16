<?php
include"includes/inc.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <title><?php echo"" . $get_db_CompanyName . ""; ?></title>
  <?php include"includes/css.php"; ?>
    </head>
    <body>
        <div id="content">
 
            <form method="post" name="form" id="form">


                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo"$items_lang"; ?>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center"><?php echo"$product_lang"; ?></th>
                                            <th class="text-center"><?php echo"$model_lang"; ?></th>
                                            <th class="text-center"><?php echo"$color_lang"; ?></th>
                                            <?php
                                            if($use_sizes==1){
                                            $result_sizes = @mysqli_query($con, "SELECT * FROM sizes limit 15");
                                            $num_sizes = @mysqli_num_rows($result_sizes);
                                            if ($num_sizes > 0) {

                                                while ($row_sizes = mysqli_fetch_array($result_sizes)) {
                                                    echo $row_sizes = "<th class='text-center'>" . $row_sizes['size'] . "</th>";
                                                }
                                            }
                                            }else{
                                               echo "<th class='text-center'>الكمية</th>"; 
                                            }
                                            ?>
                                        </tr>
                                    </thead>

                                    <tbody>


                                        <tr>
                                            <th class="text-center">
                                                <select class="validate[required] form-control"  style="min-width: 120px" name="products" id="products">
                                                    <option value=""></option>
<?php products_option(); ?>
                                                </select>
                                            </th>
                                            <th class="text-right">
                                                <select class="validate[required] form-control"  style="min-width: 120px" name="code" id="code">

                                                </select>
                                            </th>
                                            <th class="text-right">
                                                <select class="validate[required] form-control" style="min-width: 120px" name="color[]" multiple="">
                                                    <option value="">

                                                    </option>
<?php colors_option($_POST['color']); ?>
                                                </select>
                                            </th>
<?php
if($use_sizes==1){
for ($index1 = 1; $index1 < $num_sizes + 1; $index1++) {
    echo'<th class="text-right"><input class="form-control" name="size' . $index1 . '" value="" type="text"></th>';
}
}else{
    echo'<th class="text-right"><input class="form-control" name="qty' . $index1 . '" value="" type="text"></th>';    
}
?>



                                        </tr>

                                        <tr><th> <input name="submit2" value="إضافة" class="btn btn-default" type="submit">

                                        </tr></tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </form>


  






        </div>

        <!--END PAGE CONTENT -->





        <!--    <nav>nav</nav>-->
        <!-- <aside>aside</aside>-->
    </div>

    <div id="toolbar">

    </div>
</body>
</html>

<script>
    $(function() {
        (function($){
        function processForm( e ){
            $.ajax({
                url: 'storein_sales.php',
                dataType: 'text',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function( data, textStatus, jQxhr ){
                    $('#response').html( data );
                          var $container = $("#data");
        $container.load('multi_items_sales.php');
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });

            e.preventDefault();
        }

        $('#form').submit( processForm );
    })(jQuery);
    
        function changeitems(e) {
            $.ajax({
                url: 'storeout_changeitems.php',
                dataType: 'json',
                type: 'post',
                contentType: 'application/x-www-form-urlencoded',
                data: $(this).serialize(),
                success: function(data) {
                    var options, index, select, option;

                    // Get the raw DOM object for the select box
                    select = document.getElementById('code');

                    // Clear the old options
                    select.options.length = 0;

                    // Load the new options
                    options = data.options; // Or whatever source information you're working with
                    for (index = 0; index < options.length; ++index) {
                        option = options[index];
                        select.options.add(new Option(option.text, option.value));
                    }
                },
                error: function(jqXhr, textStatus, errorThrown) {
                    console.log(errorThrown);
                }
            });

            e.preventDefault();
        }
        $('#products').change(changeitems);
    });
</script>
<?php include 'includes/footer.php'; ?>
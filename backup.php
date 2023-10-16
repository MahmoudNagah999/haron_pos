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
        
        <link rel="stylesheet" href="css/sweetalert.css">
        <script type="text/javascript" src="js/sweetalert.min.js"></script>
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
            include"includes/buttons.php";
            ?>			</div>

        <div id='main'>
            <article style="margin-bottom:70px;">
                <?php
                if ($user_GeneralSettings !== "1" and $user_IsAdmin != 1) {


                    echo'<div class="alert alert-warning text-right">
                            ' . $not_have_permission_lang . '
                            </div>';
                } else {
                    ?>
                    <div class="text-center">
    <?php include"includes/config_menu.php"; ?>
                    </div>
                    <fieldset class="clearfix">
                        <legend  align="right"><?php echo"النسخ الاحتياطى"; ?></legend> 
                        <form id="myForm"  method="post" action="backup/index.php"  name="myForm">
                            <input type="submit" name="save" value="نسخ احتياطى" />
                            <script type="text/javascript">
    var frm = $('#myForm');
    frm.submit(function (ev) {
        $.ajax({
            type: frm.attr('method'),
            url: frm.attr('action'),
            data: frm.serialize(),
                  success: function(response) { // on success..
            $('#table_response').html(response); // update the DIV
            swal("تهانينا", "تم حفظ النسخة الاحتياطية من قاعدة البيانات", "success")
        }
        });

        ev.preventDefault();
    });
</script>
<div class="table-responsive" id="table_response">
    <table class="table-bordered text-center" style="width: 100%;">
        <tr style="background-color: #A7A7A7;">
            <th style="text-align: center;">الوقت</th>
                                    <th style="text-align: center;">التاريخ</th>
                                    <th style="text-align: center;">الملف</th>
                                </tr>
                             <?php
$files1 = scandir("backup",1);
$i=0;
foreach ($files1 as $value) {
    if (strpos($value, '.sql') !== false) {
       $split=explode(".sql", $value);
     echo" <tr>
      <td><a href='backup/".$value."' target='_BLANK'>".date('H:i:s', $split[0])."</a></td>
      <td><a href='backup/".$value."' target='_BLANK'>".date('m/d/Y', $split[0])."</a></td>
          <td><a href='backup/".$value."' target='_BLANK'>".$value."</a></td>
       </tr>";
  if($i==31){   break; }
     $i++;
}
   
    
}
?>
                               
                            </table></div>
                        </form>
                    </fieldset>            
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
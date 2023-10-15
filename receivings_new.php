<?php 
include "includes/inc.php"; 
include "receivings/functions.php";
?>
<html lang="en">
	<head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <script type="text/javascript" src="js/jquery.min.js"></script>
            <title><?php echo"".$get_db_CompanyName.""; ?></title>
             <link href="bootstrap-3.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="font-awesome-4.3.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="assets/css/combo.select.css">
     
      <script type="text/javascript" src="stacktable/stacktable.js"></script>
      <link rel="stylesheet" href="stacktable/stacktable.css">
        </head>
        <body>
      <?php include"includes/buttons.php"; ?>   
            <div class="row">
            <div class="col-xs-5">
                       <div class="row">
                           <div class="col-xs-1"><i class="fa fa-plus-square"></i></div>
             
                    <div class="col-xs-4"><input type="text" name="" value="" class="form-control" /></i></div>
                    <div class="col-xs-4"><input type="text" name="" value="" class="form-control" /></div>
                    <div class="col-xs-1"><a href="suppliers.php"><i class="fa fa-list"></i></a></div>
                    
                </div>
              <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
              <p><a class="btn btn-default" href="#" role="button">View details »</a></p>
            </div>
        <div class="col-xs-7">
                <div class="row">
                    <div class="col-xs-1"><i class="fa fa-backward fa-3"></i></div>
                      <div class="col-xs-1"><i class="fa fa-pause"></i></div>
                    <div class="col-xs-1"><i class="fa fa-backward fa-3"></i></div>
                    <div class="col-xs-1"><i class="fa fa-times fa-3"></i></div>
                    <div class="col-xs-7"><select  class="js-select  form-control" id="suppliers">
                        <?php Get_suppliers_options(); ?>
                        </select></div>
                    <div class="col-xs-1"><a href="suppliers.php"><i class="fa fa-user-plus fa-3"></i></a></div>
                    
                </div>
            <table id="card-table" class="table" dir="rtl">
  <thead>
  <tr>
      <th class="text-center">م</th>
     <th class="text-center">الصنف</th>
     <th class="text-center">الكمية</th>
     <th class="text-center">المقاس</th>
     <th class="text-center">اللون</th>
     <th class="text-center">السعر</th>
     <th class="text-center">الخصم</th>
     <th class="text-center">الاجمالى</th>
     <th class="text-center">حذف</th>
  </tr>
 </thead> 
 <tbody dir="ltr">
  <tr>
    <td>
      Test
    </td>
    <td>
      555-555-5555
    </td>
    <td>
      I am a test
    </td>
    <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
  </tr>
  <tr>
    <td>
      Greg
    </td>
    <td>
      555-555-5555
    </td>
    <td>
      This is an example
    </td>
    <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
  </tr>
  <tr>
    <td>
      John
    </td>
    <td>
      444-444-4444
    </td>
    <td>
      Tables are cool
    </td>
    <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
        <td>
      <a href="#">Edit</a>
    </td>
  </tr>
 </tbody>
 <tfoot>
  <tr>
  <td colspan="4">
    <a href="#">View all</a>
  </td>
  </tr>
 </tfoot>

</table> 
            </div>
          </div>
        </body>
        <script src="assets/js/jquery.combo.select.js"></script>  
        <script>
		$(function(){

			var s = $('#suppliers')
			.comboSelect();

      /**
       * on Change
       */
      
      $('.js-select').change(function(e, v){
          $('.idx').text(e.target.selectedIndex);
          $('.val').text(e.target.value);
      });

      /**
       * Open select
       */
      
      $('.js-select-open').click(function(e){
        $('.js-select').focus()
        e.preventDefault();
      })

      /**
       * Open select
       */
      
      $('.js-select-close').click(function(e){
        $('.js-select').trigger('comboselect:close');
        e.preventDefault();
      });
      
		});
	</script>
        <script>
  $(document).on('click', '#run', function(e) {
    e.preventDefault();
    $('#simple-example-table').stacktable({hideOriginal:true});
    $(this).replaceWith('<span>ran</span>');
  });
  $('#responsive-example-table').stacktable({myClass:'stacktable small-only'});
  $('#card-table').cardtable({myClass:'stacktable small-only' });
  $('#agenda-example').stackcolumns({myClass:'stacktable small-only' });
</script>
            <script src="bootstrap-3.3.5/dist/js/bootstrap.min.js"></script>
</html>

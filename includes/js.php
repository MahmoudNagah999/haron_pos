<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jscroller2-1.61.js"></script>
<!-- <script type="text/javascript" src="js/jquery.contextmenu.js"></script> -->
<script type="text/javascript" src="js/select2.min.js"></script>
<script src="jquery.dateentry.package-2.0.0/jquery.dateentry.min.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery.dateentry.package-2.0.0/jquery.plugin.js"></script>
<script type="text/javascript" src="jquery.dateentry.package-2.0.0/jquery.dateentry.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery.colorPicker.js"/></script>		
    <script type="text/javascript" src="js/jquery.number.js"></script>


     <script language="javascript" type="text/javascript">
function addEvent(obj, evType, fn){ 
	if (obj.addEventListener){ 
   		obj.addEventListener(evType, fn, false); 
   		return true; 
 	} else if (obj.attachEvent){ 
   		var r = obj.attachEvent("on"+evType, fn); 
   		return r; 
 	} else { 
   		return false; 
 	} 
}
 
addEvent(window, 'load', initCheckboxes);
 
function initCheckboxes() {
	addEvent(document.getElementById('all'), 'click', setCheckboxes);
}
 
function setCheckboxes() {
	var cb = document.getElementById('container').getElementsByTagName('input');
 
	for (var i = 0; i < cb.length; i++) {
		cb[i].checked = document.getElementById('all').checked;
	}
}
</script>
  <script>
  function confirmSubmit() {
  if (confirm("<?php echo"$sure_delete_lang"; ?>")) {
    document.getElementById("mainform").submit();
  }
  return false;
}
  </script>
  
  <script type="text/javascript">
  //Run the code when document ready
  $(function() {    

   $('#color2').colorPicker();

   $('#color3').colorPicker({pickerDefault: "ffffff", colors: ["ffffff", "000000", "111FFF", "C0C0C0", "FFF000"], transparency: true}); 

    $('#color4').colorPicker();

    $('#color5').colorPicker({showHexField: true});
   
   //fires an event when the color is changed
   //$('#color1').change(function(){
    //alert("color changed");
   //});

   $("#button1").click(function(){
    $("#color1").val("#ffffff");   
    $("#color1").change();
   });

   $("#button2").click(function(){
    $("#color2").val("#000000");   
    $("#color2").change();
   });

  });
</script>
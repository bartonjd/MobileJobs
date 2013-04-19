<?php
   set_include_path ('/home/jbarton/public_html/');
   include('includes/common.inc.php');
   $page = new Page();
   
    $linkedIn = $page->getLinkedIn();
    $userAccount = $linkedIn->getUserData();
    $selected = array('t'=>'','f'=>'');
    $notifyValue = $userAccount['notify'];
    $selected[$notifyValue] = 'selected';
  //  print_r($userAccount);
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <?php $page->commonIncludes(); ?>
      <style>
      </style>
      <script>

         var docURL = window.location; 
         
         $(document).on('pagecreate',function() {
         	$("form").change(function(e){
	         	e.preventDefault();
 
	        var dataString = "data=" + $.encodeJSON($.serializeForm($("form")));

	        $.ajax({
		        type: "POST",
		        url: 'includes/client-ajax/user.php?action=notify',
		        data: dataString,
		        dataType: "json",
		        success: function(data) {
			        
		        }
		     });
		   });
	    });
         
         
         
      </script>
   </head>
   <body>
      <div  data-role="page" data-theme="c">
         <?php $page->commonHeader(); ?>
         <div>
            <img style="width: 288px; height: 100px" src="http://huntsman.usu.edu/mis/images/uploads/site/topbars/MIS1.jpg" />
         </div>
         <h2>
            Notifications
         </h2>

      <div data-role="content">
         <div id="checkboxes1" data-role="fieldcontain">
            <form data-role="none" method="POST">
               <div data-role="fieldcontain">
                  <label for="notify">Email me about new opportunities</label>
                  <select name="notify" id="notify" data-role="slider" data-theme="d">
                     <option value="f" <?php echo $selected['f'];?>>Off</option>
                     <option value="t" <?php echo $selected['t'];?>>On</option>
                  </select>
               </div>
            </form>
         </div>
      </div>
      <?php $page->commonFooter(); ?>
      </div>
   </body>
</html>
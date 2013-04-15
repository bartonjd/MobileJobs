<?php
   set_include_path ('/home/jbarton/public_html/');
   include('includes/common.inc.php');
   $page = new Page();
   
    $linkedIn = $page->getLinkedIn();
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8" />
      <?php $page->commonIncludes(); ?>
      <style>
      </style>
      <script>
         <?php echo $page->URL;
         	   echo $linkedIn->getLoginConfig(); 
         ?>    
         
         $(function() {
         
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
            <form action="includes/client-ajax/user.php">
               <div data-role="fieldcontain">
                  <label for="emailme">Email me about new opportunities</label>
                  <select name="emailme" id="emailme" data-role="slider" data-theme="d">
                     <option value="false">Off</option>
                     <option value="true">On</option>
                  </select>
               </div>
            </form>
         </div>
      </div>
      <?php $page->commonFooter(); ?>
      </div>
   </body>
</html>
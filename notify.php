<?php

    $linkedIn = $page->getLinkedIn();
    $userAccount = $linkedIn->getUserData();
    $selected = array('t'=>'','f'=>'');
    $notifyValue = $userAccount['notify'];
    $selected[$notifyValue] = 'selected';
  //  print_r($userAccount);
   ?>
      <div data-theme="c" data-role="header" class="header">
         <?php $page->commonHeader(); ?>

         <h2>
            Notifications
         </h2>
      </div>
      <div data-role="content">
            <form data-role="none" method="POST" id="notify-user-form" name="notify-user-form">
               <div data-role="fieldcontain">
                  <label for="notify">Email me about new opportunities</label>
                  <select name="notify" id="notify" data-role="slider" data-theme="d">
                     <option value="f" <?php echo $selected['f'];?>>Off</option>
                     <option value="t" <?php echo $selected['t'];?>>On</option>
                  </select>
               </div>
            </form>

      </div>
      <?php $page->commonFooter(); ?>
      </div>

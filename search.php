<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>
        </title>
        <link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet" href="my.css" />
        <script src="http://code.jquery.com/jquery-1.7.2.min.js">
        </script>
        <script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js">
        </script>
        <script src="my.js">
        </script>
        <!-- User-generated css -->
        <style>
        </style>
        <!-- User-generated js -->
        <script>
            try {

    $(function() {

    });

  } catch (error) {
    console.error("Your javascript has an error: " + error);
  }
        </script>
    </head>
    <body>
        <!-- Home -->
        <div data-role="page" id="page1">
            <div data-theme="c" data-role="header" class="header">
                <h1>
                    Utah State University
                </h1>
				<div>
                        <img style="width: 288px; height: 100px" src="http://huntsman.usu.edu/mis/images/uploads/site/topbars/MIS1.jpg" />
                </div>
				<h2>
                    Opportunity Search
                </h2>
				            
                    
                
                
            </div>
            <div data-role="content">
               
           
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <label for="textinput2">
                            City
                        </label>
                         <select name="city">
                        <option value="Logan">
                            Logan
                        </option>
                    </select>
                    </fieldset>
                </div>
                <div data-role="fieldcontain">
                    <label for="selectmenu1">
                        State
                    </label>
                    <select name="state">
                        <option value="AK">
                            AK
                        </option>
                    </select>
                </div>
                
                <div data-role="fieldcontain">
                    <label for="selectmenu2">
                        Pay Type
                    </label>
                    <select name="pay_type">
                        <option value="Paid">
                            Paid
                        </option>
                        <option value="Unpaid">
                            Unpaid
                        </option>
                    </select>
                </div>
                <div data-role="fieldcontain">
                    <label for="selectmenu3">
                        Schedule Type
                    </label>
                    <select name="schedule_type">
                        <option value="Full-Time">
                            Full-Time
                        </option>
                        <option value="Part-Time">
                            Part-Time
                        </option>
                        <option value="Contract">
                            Contract
                        </option>
                    </select>
                </div>
                <div id="checkboxes1" data-role="fieldcontain">
                    <fieldset data-role="controlgroup" data-type="vertical">
                        <legend>
                            Internship
                        </legend>
                        <input id="checkbox1" name="yes" type="checkbox" />
                        <label for="checkbox1">
                            Yes
                        </label>
                    </fieldset>
                </div>
                <input type="submit" data-icon="check" data-iconpos="left" value="Submit" />
            </div>
      
        
            <div data-theme="c" data-role="footer" data-position="fixed" class="footer">
                <h3>
                    <img style="width: 288px; height: 100px" src="logo.png" />
                </h3>
            </div>
        </div>
    </body>
</html>

<?php
set_include_path ('/home/jbarton/public_html/');
include('savedresults.php');
include('resources/common.inc.php');
include('resources/client-ajax/autocomplete.php');

?>
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
                    Opportunities
                </h2>
				            
                  
                
                
            </div>
            <div data-role="content">
                <div data-role="fieldcontain">
                    <fieldset data-role="controlgroup">
                        <table>
						<tr>
						<td>
						<label>
                            Opportunity Name:
                        </label>
						</td>
						<td>
                       <label>
                            Opportunity Description:
                        </label>
						</td>
						<td>
						 <label>
                            City:
                        </label>
						</td>
						<td>
						<label>
                            State:
                        </label>
						</td>
						<td>
						<label>
                            Organization/Company:
                        </label>
						</td>
						<td>
						<label>
                            Pay Type:
                        </label>
						</td>
						<td>
						<label>
                            Schedule Type:
                        </label>
						</td>
						<td>
						<label>
                            Internship:
                        </label>
						</td>
						</tr>
						<tr>
						<td>
						<label>
							placeholder for name
						</label>
						</td>
						<td>
						 <label>
							placeholder for description
						</label>
						</td>
						<td>
						<label>
							placeholder for city
						</label>
						</td>
						<td>
						<label>
							placeholder for state
						</label>
						</td>
						<td>
						<label>
							placeholder for organization/company
						</label>
						</td>
						<td>
						<label>
							placeholder for pay type
						</label>
						</td>
						<td>
						<label>
							placeholder for schedule type
						</label>
						</td>
						<td>
						 <div id="checkboxes1" data-role="fieldcontain" >
						<input id="checkbox1" name="Yes" type="checkbox" />
                        <label for="checkbox1" >
                            Yes
                        </label>
                    </fieldset>
            </div>
						</td>
						</tr>
						
						</table>
						
                    </fieldset>
                </div>
                
						
                        
                </div>
               
            <div data-theme="c" data-role="footer" data-position="fixed" class="footer">
                <h3>
                    <img style="width: 288px; height: 100px" src="logo.png" />
                </h3>
            </div>
        </div>
  

        
           <?php $page->commonFooter(); ?>
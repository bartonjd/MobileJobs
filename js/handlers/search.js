         $(document).delegate('#search-page', 'pageshow', function () {
             var docURL = window.location;
             if (window.ranOnce != 1) {
                 $('#state').mobiscroll().select({
                     theme: 'ios',
                     display: 'top',
                     preset: 'select',
                     mode: 'scroller',
                     width: 200
                 });
                 $('#schedule_type').mobiscroll().select({
                     theme: 'ios',
                     display: 'top',
                     preset: 'select',
                     mode: 'scroller',
                     width: 200
                 });
                 $('#pay_type').mobiscroll().select({
                     theme: 'ios',
                     display: 'top',
                     preset: 'select',
                     mode: 'scroller',
                     width: 200
                 });
                 $('#internship').mobiscroll().select({
                     theme: 'ios',
                     display: 'top',
                     preset: 'select',
                     mode: 'scroller',
                     width: 200
                 });
                 $('#tags').tagsInput({
                 });
                 window.ranOnce = 1;
             }
             var valid = $('form#search-form').validate();
             $('form input[type=button]').on('click', function (e) {

                 var valid = $('form#search-form').validate();
                 if (valid.errorList.length > 0) {

                     return false;
                 }
                 var data = $.serializeForm($('form#search-form'));
                 //set to data get variable, url encode json string
                 var dataString = 'data=' + encodeURIComponent($.encodeJSON(data));
                 $.ajax({
                     type: "POST",
                     url: 'resources/client-ajax/opportunity.php?action=search_jobs',
                     data: dataString,
                     dataType: "json",
                     success: function (data, status) {
                         if (data.success == true) {
                             //clear any previous search settings
                             store.clear();
                             //store the search options
                             data.options.firstLoad = 0;
                             store.set('searchParams', {
                                 options: data.options,
                                 search: data.search
                             });

                             $('#search-results-page').load('searchResults.php', {
                                 options: $.encodeJSON(data.options),
                                 search: $.encodeJSON(data.search)
                             }, function () {
                                 try {
                                     $.mobile.changePage('#search-results-page');
                                     $(this).trigger('create');
                                 } catch (ex) {

                                 }
                             });
                         } else {
                             if (data.errors != '' && data.errors != undefined) {
                                 $('body').append(
                                     '<div id="error_msg" data-close-btn="right" data-overlay-theme="a"  data-corners="true" data-role="dialog">' +
                                     '<div data-role="header" ><div style="font-size:22px;padding:5px;color:#DDD;">Notice</div></div>' +
                                     '<div data-role="content" class="err_cnt">' + data.errors + '</div>' +
                                     '<div data-role="footer" >&nbsp;</div>' +
                                     '</div>');
                                 $('#err_msg').append($('.err_cnt'));

                                 $.mobile.changePage('#error_msg', {
                                     transition: "pop",
                                     role: "dialog"
                                 });
                             }
                         }
                     }
                 });
             }).keydown(function (event) {
                 if (event.keyCode == 13) {
                     event.preventDefault();
                     return false;
                 }
             });
         });
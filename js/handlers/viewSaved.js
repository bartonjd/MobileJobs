            $(document).delegate('#saved-results-page', 'pagecreate', function () {

                $('li.sres').bind('tap click', function () {
                    var id = $(this).attr('opp_id');
                    $('#job-detail-page').load('result.php?opp_id=' + id, function () {
                        try {
                            //$(this).trigger('create');
                            $.mobile.changePage('#job-detail-page');
                            $(this).trigger('pagecreate');
                        } catch (ex) {
                            //There seems to be a problem with jquerymobile and the pagecreate event so we are catching it
                        }
                    });
                });
                $('.paging-sres').bind('tap click', function () {
                    //get search options out of local storage
                    var data = store.get('searchParams');
                    if ($(this).attr('mode') == 'prev') {
                        if (data.options.page !== 1) {
                            data.options.page--;
                        }
                    }
                    if ($(this).attr('mode') == 'next') {
                        if (data.options.page !== data.options.pages) {
                            data.options.page++;
                        }
                    }

                    data.options.start = (data.options.page - 1) * data.options.limit;
                    store.set('searchParams', data);
                    $('#saved-results-page').load('savedResults.php', {
                        options: $.encodeJSON(data.options),
                        search: $.encodeJSON(data.search)
                    }, function () {
                        $(this).trigger('create');
                        $.mobile.changePage('#saved-results-page');
                    });
                });
            });
            $(document).delegate('#saved-results-page', 'pagebeforecreate', function () {
                //get search options out of local storage
                var data = store.get('searchParams');
                if ($('#saved-results-page').children().length == 0) {
                    data.options.firstLoad = 1;
                    store.set('searchParams', data);
                    $('#saved-results-page').load('savedResults.php', {
                        options: $.encodeJSON(data.options),
                        search: $.encodeJSON(data.search)
                    }, function () {
                        $(this).trigger('pagecreate');
                        $.mobile.changePage('#saved-results-page');

                    });
                }
            });
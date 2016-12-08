    $(document).ready(function(){

$('#results').html('<p style="padding:5px;"><br/> Loading... </p><br/>');

        $('#searchData').ready(function() {

            var searchVal = $(this).val();

$.get('system/products/search-data.php?' + 'scat=' + encodeURIComponent($("#searchCat").val()) + '&searchData='+searchVal, function(returnData) {

                    if (!returnData) {
                        $('#results').html('<p style="padding:5px;"><br/>No Products found.</p>');
                    } else {
                        $('#results').html(returnData);
                    }
                });

        });


        $('#searchCat').change(function() {

            var searchVal = $(this).val();

$.get('system/products/search-data.php?' + 'searchData=' + encodeURIComponent($("#searchData").val()) + '&scat='+searchVal, function(returnData) {

                    if (!returnData) {
                        $('#results').html('<p style="padding:5px;"><br/>No Products found.</p>');
                    } else {
                        $('#results').html(returnData);
                    }
                });

        });

        $('#searchData').keyup(function() {

            var searchVal = $(this).val();

$.get('system/products/search-data.php?' + 'scat=' + encodeURIComponent($("#searchCat").val()) + '&searchData='+searchVal, function(returnData) {

                    if (!returnData) {
                        $('#results').html('<p style="padding:5px;"><br/>No Products found.</p>');
                    } else {
                        $('#results').html(returnData);
                    }
                });

        });

    });
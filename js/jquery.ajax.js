$(function() {
    $('#delivery_to').on('change', function() {

        var code            = $(this).find(":selected").text();
        var requestData     = { items: [] };

        requestData.code   = code;

        $.ajax({
            method: 'GET',
            dataType:"json",
            data: requestData,
            success: function(response) {
                $.each(response, function(key, value) {
                    $('#'+key).text(value);
                });

                if (response.deliveredFrom) {
                    $.each(response.deliveredFrom, function(item, code) {
                        $('div[item-id='+item+']').find('.delivered-from').text(code);
                    });
                }
                console.log(response);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR.responseText);
            }
        });

    });
});

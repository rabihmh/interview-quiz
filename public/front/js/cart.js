(function ($) {

    $('#item-quantity').on('change', function (e) {

        $.ajax({
            url: "/cart/" + $(this).data('id'),
            method: 'put',
            data: {
                quantity: $(this).val(),
                _token: csrf_token
            },
            success: function (response) {
                alert('Cart item updated successfully.');
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Error updating cart item.';
                alert(errorMessage);
            }
        });
    });
    $('.remove-item').on('click', function (e) {
        let id = $(this).data('id');
        $.ajax({
            url: "/cart/" + id, //data-id
            method: 'delete',
            data: {
                _token: csrf_token
            },
            success: response => {
                $(`#${id}`).remove()
                alert('Item Removed Successfully')

            }
        });
    });


})(jQuery);


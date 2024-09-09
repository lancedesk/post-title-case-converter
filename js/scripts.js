jQuery(document).ready(function($)
{
    /* Capture form submission or button click */
    $('.update-post-title').click(function(e) {
        e.preventDefault(); /*  Prevent the default form submission */

        /*  Get values from the form */
        var button = $(this);
        var postId = button.data('post-id');
        var convertedTitle = button.data('converted-title');

        /*  AJAX request */
        $.ajax({
            url: ajax_data.ajaxurl,
            type: 'POST',
            data: {
                action: 'update_post_title',
                nonce: ajax_data.nonce, /*  Nonce from localized data */
                post_id: postId,
                converted_title: convertedTitle
            },
            success: function(response) {
                /* Check if the response was successful */
                if (response.data.status === 'success')
                {
                    /* Alert the message from the server */
                    alert(response.data.message);

                    button.attr('disabled', 'disabled');
                    button.text('Updated');
                    button.removeClass('update-post-title').addClass('updated-post-title');
                }
                else
                {
                    /* Handle error and show message */
                    alert('Error: ' + response.data.message);
                }
            }
        });
    });
});

jQuery(document).ready(function($) {
    $('.update-post-title').click(function(e) {
        e.preventDefault();

        var button = $(this);
        var postId = button.data('post-id');
        var convertedTitle = button.data('converted-title');

        $.ajax({
            url: postCaseConverter.ajaxUrl,
            type: 'POST',
            data: {
                action: 'update_post_title',
                post_id: postId,
                converted_title: convertedTitle
            },
            success: function(response) {
                if (response === 'success') {
                    button.attr('disabled', 'disabled');
                    button.text('Updated');
                    button.removeClass('update-post-title').addClass('updated-post-title');
                }
            }
        });
    });
});
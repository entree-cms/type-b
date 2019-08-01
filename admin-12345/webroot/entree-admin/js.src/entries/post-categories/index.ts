import "../../config/bootstrap.ts";

declare var DEL_CFM_MSG: string;

/**
 * Delete post
 */
$(document).on('click', '[data-class="btn-del"]', (event) => {
  const categoryId = $(event.target).data('id');
  const name = $(`#name-${ categoryId }`).text();
  const msg = DEL_CFM_MSG.replace('%NAME%', name);
    if (confirm(msg)) {
    $('<form>')
      .attr('method', 'post')
      .append(
        $('<input>').attr({
          type: 'hidden',
          name: 'post_category_id[]',
          value: categoryId,
        }),
        $('<input>').attr({
          type: 'hidden',
          name: 'action',
          value: 'delete'
        }),
        $('<input>').attr({
          type: 'hidden',
          name: '_csrfToken',
          value: CSRF_TOKEN
        })
      )
      .appendTo('body')
      .submit();
  }
});

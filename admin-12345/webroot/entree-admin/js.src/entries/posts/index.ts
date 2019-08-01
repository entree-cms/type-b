import "../../config/bootstrap.ts";

declare var DEL_CFM_MSG: string;

/**
 * On click delete button
 */
$(document).on("click", '[data-class="btn-del"]', (event): void => {
  const postId: string = $(event.target).data("id");
  const title = $(`#title-${postId}`).text();
  const msg = DEL_CFM_MSG.replace('%NAME%', title);
  if (confirm(msg)) {
    $('<form>')
      .attr('method', 'post')
      .append(
        $('<input>').attr({
          type: 'hidden',
          name: 'post_id[]',
          value: postId
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

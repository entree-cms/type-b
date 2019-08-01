import "../../config/bootstrap.ts";

declare var DEL_CFM_MSG: string;

/**
 * Delete contact
 */
$(document).on('click', '[data-class="btn-del"]', (event) => {
  const contactId = $(event.target).data('id');
  const $tr = $(`#contact-${contactId}`);
  const date = $tr.find('.date').text();
  const time = $tr.find('.time').text();
  const name = $tr.find('.td-name').text().trim();
  const msg = DEL_CFM_MSG
    .replace('%DATE%', date)
    .replace('%TIME%', time)
    .replace('%NAME%', name);
  if (confirm(msg)) {
    $('<form>')
      .attr('method', 'post')
      .append(
        $('<input>').attr({
          type: 'hidden',
          name: 'contact_id',
          value: contactId
        }),
        $('<input>').attr({
          type: 'hidden',
          name: 'action',
          value: 'delete',
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

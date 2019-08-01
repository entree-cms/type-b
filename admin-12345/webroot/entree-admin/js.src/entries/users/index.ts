import "../../config/bootstrap.ts";

declare var DEL_CFM_MSG: string;

/**
 * On click delete button
 */
$(document).on("click", '[data-class="btn-del"]', (event): void => {
  const userId: string = $(event.target).data("id");
  const name: string = $(`#name-${userId}`).text();
  const msg: string = DEL_CFM_MSG.replace("%NAME%", name);
  if (confirm(msg)) {
    $("<form>")
      .attr("method", "post")
      .append(
        $("<input>").attr({
          type: "hidden",
          name: "user_id[]",
          value: userId
        }),
        $("<input>").attr({
          type: "hidden",
          name: "action",
          value: "delete"
        }),
        $("<input>").attr({
          type: "hidden",
          name: "_csrfToken",
          value: CSRF_TOKEN
        })
      )
      .appendTo("body")
      .submit();
  }
});

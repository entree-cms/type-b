import "../../config/bootstrap";

import * as Datepicker from "../../modules/datepicker";
import * as Images from "../../modules/images";
import * as TinyMCE from "../../modules/tinymce";

declare var tinymce: any;
let imgMode: string|null = null;

/**
 * Initialize
 */
window.addEventListener("load", () => {
  // Datepicker
  Datepicker.setDefaults();
  $("#input-date").datepicker();

  // TinyMCE
  TinyMCE.init({
    selector: "#textarea-body"
  });
});

// *********************************************************
// * Event listeners
// *********************************************************
/**
 * On change "Now" checkbox.
 */
$(document).on("change", "#checkbox-date-now", (event) => {
  const isDisabled:boolean = $(event.target).is(":checked");
  $("#input-date").prop("disabled", isDisabled);
  $("#input-time").prop("disabled", isDisabled);
});

/**
 * On click "Choose file" buttons (Eyecatch, Thumbnail)
 */
$(document).on("click", '[data-class="btn-img-choose"]', (event) => {
  imgMode = $(event.target).data("mode");
  Images.openImageList();
});

/**
 * On click "Remove" buttons (Eyecatch, Thumbnail)
 */
$(document).on("click", '[data-class="btn-img-remove"]', (event) => {
  imgMode = $(event.target).data("mode");
  $(`#${ imgMode }`).hide();
  $(`#btn-remove-${ imgMode }`).hide();
  $(`#img-${ imgMode }`).attr("src", "");
  $(`#input-${ imgMode }-alt`).val("");
  $(`#input-${ imgMode }-id`).val("");
  $(`#alert-no-${ imgMode }`).show();
});

// *********************************************************
// * Event triggerd from other window
// *********************************************************
/**
 * On choose image from image list subwindow.
 */
window.addEventListener("message", (event) => {
  try {
    const data = JSON.parse(event.data);
    const imgId = data.imgId;
    const src = data.src;
    switch(imgMode) {
      // Eyecatch, Thumbnaill
      case 'eyecatch':
      case 'thumb':
        $(`#alert-no-${ imgMode }`).hide();
        $(`#img-${ imgMode }`).attr('src', src);
        $(`#input-${ imgMode }-id`).val(imgId);
        $(`#${ imgMode }`).show();
        $(`#btn-remove-${ imgMode }`).show();
        Images.subwin.close();
        break;

      // Insert into post body
      default:
        const img = `<img src="${src}" width="100%">`;
        tinymce.activeEditor.insertContent(img);
        break;
    }
    imgMode = null;
  } catch (e) {

  }
});

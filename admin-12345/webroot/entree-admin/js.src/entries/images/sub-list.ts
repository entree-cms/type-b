import "../../config/bootstrap.ts";

declare var DEL_CFM_MSG: string;
declare var DEL_ERR_MSG: string;
declare var IMG_TPL: string;
declare var LAST_PAGE: number;
declare var UP_ERR_MSG: string;

var page = 1;

/**
 * Initialize
 */
window.addEventListener("load", (event) => {
  // Initialize file drag & drop.
  initFileDnD();
});

// *********************************************************
// * Event Listeners
// *********************************************************
/**
 * On change file
 */
$(document).on("change", "#input-file", (e) => {
  const inputFile = <HTMLInputElement>event.target;
  const file: File = inputFile.files[0];
  submitFile(file);
  $(inputFile).val("");
});

/**
 * On select image
 */
$(document).on("click", '[data-class="image"]', (event) => {
  const img: HTMLImageElement = event.target;
  const data = JSON.stringify({
    imgId: $(img).data('id'),
    src: $(img).prop('src')
  });
  const origin = `${ location.protocol }//${ location.hostname }`;
  window.opener.postMessage(data, origin);
});

/**
 * On click delete buttons
 */
$(document).on("click", '[data-class="btn-del"]', (event) => {
  const imgId = $(event.currentTarget).data('id');
  console.log(imgId);
  if (confirm(DEL_CFM_MSG)) {
    $.ajax ({
      url: `${SITE_ROOT}images/ajax-delete`,
      type: "POST",
      data: {
        image_id: imgId,
        _csrfToken: CSRF_TOKEN
      },
      dataType: 'json'
    })
    .done((data) => {
      if (data.result) {
        $(`#image-${ imgId }`).remove();
      } else {
        alert(DEL_ERR_MSG);
      }
    })
    .fail((data) => {
      alert(DEL_ERR_MSG);
    });
  }
});

// *********************************************************
// * Private functions
// *********************************************************
/**
 * Add image to list
 */
const addImage = (imgId: string, src: string, mode: string) => {
  const imageItem = IMG_TPL
    .replace(/%IMAGE_ID%/g, imgId)
    .replace(/%SRC%/g, src);

  const $images = $('#images');
  if (mode === 'prepend') {
    $images.prepend(imageItem);
  } else {
    $images.append(imageItem);
  }
}

/**
 * Initialize file Drag And Drop.
 */
const initFileDnD = () => {
  const $body = $("body");
  const animSpd = 200;

  // Mask box
  const $mask = $("<div>").css({
    display: "none",
    width: "100%",
    height: "100%",
    position: "fixed",
    top: 0,
    left: 0,
    opacity: 0.3,
    "z-index": 9999
  });
  $body.append($mask);

  // Overlay box
  const $overlay = $("#overlay");
  $body.append($overlay);

  // Event on drag over
  $body.on("dragover", (event) => {
    event.stopPropagation();
    event.preventDefault();
    $mask.show();
    $overlay.fadeIn(animSpd).css("display", "flex");
  });

  // Event on drop
  $mask.on("drop", (event) => {
    event.stopPropagation();
    event.preventDefault();
    $mask.hide();
    $overlay.hide();
    const files = (<DragEvent>event.originalEvent).dataTransfer.files;
    $.each(files, (key, file) => {
      submitFile(file);
    });
  });

  // Event on drag leave
  $mask.on("dragleave", (event) => {
    event.stopPropagation();
    event.preventDefault();
    $mask.hide();
    $overlay.fadeOut(animSpd);
  });
}

/**
 * Submit image file
 */
const submitFile = (file: File) => {
  const formData = new FormData();
  formData.append("_csrfToken", CSRF_TOKEN);
  formData.append("upfile", file);
  $.ajax({
      url: `${SITE_ROOT}images/ajax-upload`,
      type: "POST",
      contentType: false,
      processData: false,
      cache: false,
      data: formData,
      dataType: "json",
      success: function(data) {
        if (data.result === true) {
          addImage(data.image.id, data.image.src, "prepend")
        } else {
          let msg = UP_ERR_MSG;
          if (data.error) {
            msg += `\n\n${data.error}`;
          }
          alert(msg);
        }
      }
  });
};

/**
 * ON click Load images
 */
$(document).on('click', '#btn-load', (event) =>  {
  page++;
  if (page <= Number(LAST_PAGE)) {
    $.ajax({
      url: SITE_ROOT + `/images/ajax-get-images/${page}`,
      dataType: 'json'
    })
    .done((data) => {
      if (data.result !== true) {
        return;
      }
      $.each(data.images, function(i, image) {
        addImage(image.id, image.src, 'append');
      });
    });
    // Hide load img button
    if (page >= LAST_PAGE) {
      $('#load-img').hide();
    }
  }
});

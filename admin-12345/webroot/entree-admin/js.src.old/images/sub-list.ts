var page = 1;

/**
 * Initialize
 */
$(function() {
  // Initialize file drag & drop.
  initFileDnD();
});

// *********************************************************
// * Functions called from HTML
// *********************************************************
/**
 * On change file
 */
function onChangeFile(inputFile) {
  const $file = $(inputFile);
  const file = $(inputFile).get(0).files[0];
  submitFile(file);
  $file.val();
}

/**
 * On click Delete button
 */
function onClickDel(imageId) {
  if (confirm(DEL_CFM_MSG)) {
    $.ajax ({
      url: `${SITE_ROOT}images/ajax-delete`,
      type: "POST",
      data: {
        image_id: imageId,
        _csrfToken: CSRF_TOKEN
      },
      dataType: 'json'
    })
    .done((data) => {
      if (data.result) {
        $(`#image-${imageId}`).remove();
      } else {
        alert(DEL_ERR_MSG);
      }
    })
    .fail((data) => {
      alert(DEL_ERR_MSG);
    });
  }
}

/**
 * On click image
 */
function onClickImg(img) {
  const $img = $(img);
  const id   = $img.attr('data-id');
  const src  = $img.attr('src');
  window.opener.subOnClickImg(id, src);
}

/**
 * ON click Load images
 */
function onClickLoadImg() {
  page++;
  if (page <= LAST_PAGE) {
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
}

// *********************************************************
// * Private functions
// *********************************************************
/**
 * Add image to list
 */
function addImage(imageId, src, mode)
{
  const imageItem = IMG_TPL
    .replace(/%IMAGE_ID%/g, imageId)
    .replace(/%SRC%/g, src);

  if (mode === 'prepend') {
    $('#images').prepend(imageItem);
  } else {
    $('#images').append(imageItem);
  }
}

/**
 * Initialize file Drag And Drop.
 */
function initFileDnD() {
  const $body = $('body');
  const animSpd = 200;

  // Mask box
  const $mask = $('<div>').css({
    display: 'none',
    width: '100%',
    height: '100%',
    position: 'fixed',
    top: 0,
    left: 0,
    opacity: 0.3,
    'z-index': 9999
  });
  $body.append($mask);

  // Overlay box
  const $overlay = $('#overlay');
  $body.append($overlay);

  // Event on drag over
  $body.on('dragover', function (e){
    e.stopPropagation();
    e.preventDefault();
    $mask.show();
    $overlay.fadeIn(animSpd).css('display', 'flex');
  });

  // Event on drop
  $mask.on('drop', function(e) {
    e.stopPropagation();
    e.preventDefault();
    $mask.hide();
    $overlay.hide();
    const files = e.originalEvent.dataTransfer.files;
    $.each(files, function(key, file) {
      submitFile(file);
    });
  });

  // Event on drag leave
  $mask.on('dragleave', function (e) {
    e.stopPropagation();
    e.preventDefault();
    $mask.hide();
    $overlay.fadeOut(animSpd);
  });
}

/**
 * Submit image file
 */
function submitFile(file) {
  const formData = new FormData();
  formData.append('_csrfToken', CSRF_TOKEN);
  formData.append('upfile', file);
  $.ajax({
      url: `${SITE_ROOT}images/ajax-upload`,
      type: "POST",
      contentType: false,
      processData: false,
      cache: false,
      data: formData,
      dataType: 'json',
      success: function(data) {
        if (data.result === true) {
          addImage(data.image.id, data.image.src, 'prepend')
        } else {
          let msg = UP_ERR_MSG;
          if (data.error) {
            msg += `\n\n${data.error}`;
          }
          alert(msg);
        }
      }
  });
}

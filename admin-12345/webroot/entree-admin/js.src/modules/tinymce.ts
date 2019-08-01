declare var tinymce: any;

/**
 * Initialize TinyMCE
 */
export const init = (addOptions) => {
  const options = {
    height: 460,
    convert_urls: false,
    element_format: "html",
    relative_urls: false,
    remove_script_host: false,
    // Menubar, Toolbar
    plugins: 'code imagetools link lists table',
    menubar: false,
    toolbar: "undo redo"
      + " | formatselect"
      + " | bold link"
      + " | alignleft aligncenter alignright alignjustify"
      + " | bullist numlist table"
      + " | image"
      + " | code ",
    // Image toolbar
    imagetools_toolbar: null,
    // Context menu
    contextmenu: null,
    setup: (editor) => {
      // Images button
      editor.ui.registry.addButton('image', {
        icon: 'image',
        tooltip: 'Insert Image',
        onAction: () => {
          const options = 'width=550,height=720,scrollbars=yes';
          subwin = window.open(`${SITE_ROOT}images/sub-list`, 'sub-img', options);
          subwin.focus();
        }
      });
    },
  };
  $.each(addOptions, function(key, value) {
    options[key] = value;
  });
  tinymce.init(options);
}

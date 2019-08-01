export let subwin;

export const openImageList = () => {
  const options = 'width=550,height=720,scrollbars=yes';
  subwin = window.open(`${ SITE_ROOT }images/sub-list`, 'sub-img', options);
  subwin.focus();
};

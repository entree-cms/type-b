require("dotenv").config();
const fs = require("fs-extra");

const themes = [
  { name: "admin", dir: `${ process.env.ADMIN_DIR }/webroot/${ process.env.ADMIN_THEME }` },
];

// Copy javascript libraries
themes.filter(theme => {
  // Make "lib" dir
  fs.mkdirsSync(`${ theme.dir }/js/lib`);

  // jQuery
  const jqueryDir = `${ theme.dir }/js/lib/jquery`;
  fs.removeSync(jqueryDir);
  fs.copy("./node_modules/jquery/dist/jquery.min.js", `${ jqueryDir}/jquery.min.js`);

  // jQuery UI
  const jqueryUiDir = `${ theme.dir }/js/lib/jquery-ui`;
  fs.removeSync(jqueryUiDir);
  fs.copy("./node_modules/jquery-ui-dist/jquery-ui.min.js", `${ jqueryUiDir }/jquery-ui.min.js`);

  // TinyMCE
  const tinyMceDir = `${ theme.dir }/js/lib/tinymce`;
  fs.removeSync(tinyMceDir);
  const filenameFilter = path => {
    return (fs.statSync(path).isDirectory() || path.match(/(min\.js|min\.css|\.woff)$/));
  };
  fs.copy("./node_modules/tinymce/tinymce.min.js", `${ tinyMceDir }/tinymce.min.js`);
  fs.copy("./node_modules/tinymce/plugins", `${ tinyMceDir }/plugins`, {filter: filenameFilter});
  fs.copy("./node_modules/tinymce/skins", `${ tinyMceDir }/skins`, {filter: filenameFilter});
  fs.copy("./node_modules/tinymce/themes", `${ tinyMceDir }/themes`, {filter: filenameFilter});
});
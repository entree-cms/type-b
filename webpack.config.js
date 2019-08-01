// Modules
const glob = require("glob");

// Themes
require("dotenv").config();
const themes = [
  { name: "admin", dir: `${ process.env.ADMIN_DIR }/webroot/${ process.env.ADMIN_THEME }` },
  { name: "site", dir: `${ process.env.SITE_DIR }/webroot/${ process.env.SITE_THEME }` }
];

// Get entry points
const entries = {};
const reportFiles = [];
themes.filter(theme => {
  const srcFiles = `./${theme.dir}/js.src/entries/**/*.ts`;
  reportFiles.push(srcFiles);
  glob.sync(srcFiles).map(function (file) {
    const key = file.replace("js.src/entries/", "js/").replace(/ts$/, 'js');
    entries[key] = file;
  });
});

module.exports = {
  mode: "production",
  entry: entries,
  output: {
    filename: "[name]"
  },
  module: {
    rules: [
      {
        test: /\.ts$/,
        loader: "ts-loader",
        options: {
          reportFiles: reportFiles
        }
      }
    ]
  },
  resolve: {
    extensions: [".ts"]
  }
}

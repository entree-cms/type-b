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
  const srcFiles = `./${theme.dir}/js.src/entries/**/*.*`;
  reportFiles.push(srcFiles);
  glob.sync(srcFiles).map(function (file) {
    const ext = file.substr(-3);
    let key = file.replace("js.src/entries/", "js/");
    if (ext === ".ts") {
      key = key.replace(/ts$/, "js")
    } else if (ext !== ".js") {
      return true;
    }
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

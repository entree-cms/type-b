// Config
const webpackConfig = require("./webpack.config.js");

// Modules
const gulp = require("gulp");
const gulpPlumber = require("gulp-plumber");
const gulpSass = require("gulp-sass");
const webpack = require("webpack");
const webpackStream = require("webpack-stream");

// Themes
require('dotenv').config();
const themes = [
  { name: "admin", dir: `${ process.env.ADMIN_DIR }/webroot/${ process.env.ADMIN_THEME }` },
  { name: "site", dir: `${ process.env.SITE_DIR }/webroot/${ process.env.SITE_THEME }` }
];

// Task of compiling js
gulp.task('compile-js', () => {
  return gulp.src('/*/webroot/**/*.ts') 
    .pipe(gulpPlumber())
    .pipe(webpackStream(webpackConfig, webpack))
    .pipe(gulp.dest(__dirname));
});

// Task of compiling SCSS
themes.filter(theme => {
  gulp.task(`compile-sass-${theme.name}`, () => {
    return gulp.src(`./${theme.dir}/css.src/**/*.scss`)
      .pipe(
        gulpSass({outputStyle: 'compressed'})
          .on('error', gulpSass.logError)
      )
      .pipe(
        gulp.dest(`./${theme.dir}/css`)
      );
  });
});

// Run initial tasks
gulp.task('default', () => {
  themes.filter(theme => {
    gulp.watch(`./${theme.dir}/js.src/**/*.ts`, gulp.task('compile-js'));
    gulp.watch(`./${theme.dir}/css.src/**/*.scss`, gulp.task(`compile-sass-${theme.name}`));
  });
});

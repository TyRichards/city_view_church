var gulp = require('gulp');
var rename = require('gulp-rename');
var watch = require('gulp-watch');
var sass = require('gulp-sass');
var recess = require('gulp-recess');

gulp.task('sass', function () {
  gulp.src('./scss/*.scss')
    .pipe(sass())
    .pipe(gulp.dest('./'));
});

gulp.task('watch', function () {
  gulp.src('./scss/*.scss')
    .pipe(watch('./scss/*.scss', function(files) {
      return files.pipe(sass())
      .pipe(gulp.dest('./'));
    }))
});

gulp.task('recess', function () {
  return gulp.src('style.css')
    .pipe(recess())
    .pipe(recess.reporter())
    .pipe(gulp.dest('/'));
});

gulp.task('default', ['sass'], function () {} );
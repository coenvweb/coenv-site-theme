// TODO: dev, ./
var gulp = require('gulp');
var rename = require('gulp-rename');
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var sass = require('gulp-sass');
var copy = require('gulp-copy');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var cssmin = require('gulp-minify-css');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "https://college-of-the-environment-staging.local"
    });
});

gulp.task('main_js', function () {
  return gulp
    .src([  './bower_components/jquery/dist/jquery.min.js',
            './bower_components/jquery/dist/jquery-migrate.min.js',
            './bower_components/jquery-fast-click/jQuery.fastClick.js',
            './bower_components/jquery-throttle-debounce/jquery.ba-throttle-debounce.js',
            './assets/scripts/src/plugins/modernizr.custom.92408.js',
            './bower_components/fitvids/jquery.fitvids.js',
            './bower_components/jquery-placeholder/jquery.placeholder.js',
            './bower_components/jquery-hoverIntent/jquery.hoverIntent.js',
            './bower_components/picturefill/picturefill.js',
            './bower_components/matchmedia/matchMedia.js',
            './bower_components/enquire/dist/enquire.js',
            './bower_components/masonry/dist/masonry.pkgd.min.js',
            './bower_components/imagesloaded/imagesloaded.pkgd.min.js',
            './bower_components/nivo-lightbox/nivo-lightbox.js',
            './assets/scripts/src/plugins/royalslider/jquery.royalslider.min.js',
            './assets/scripts/src/jquery.stickyNavbar.js',
            './assets/scripts/src/menu.js',
            './assets/scripts/src/features.js',
            './assets/scripts/src/blog.js',
            './assets/scripts/src/share.js',
            './assets/scripts/src/slider.js',
            './assets/scripts/src/acf-gmaps.js',
            './assets/scripts/src/navigator.js',
            './assets/scripts/src/main.js',])
    //.pipe(jshint('./.jshintrc')) Too many hinting errors
    //.pipe(jshint.reporter('jshint-stylish'))
    .pipe(sourcemaps.init())
    .pipe(concat('main.js'))
    .pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(rename('main2.min.js'))
    .pipe(gulp.dest('./assets/scripts/build/'))
    .pipe(browserSync.stream());
  ;
});

gulp.task('faculty_js', function () {
  return gulp
    .src([  './bower_components/get-style-property/get-style-property.js',
            './bower_components/get-size/get-size.js',
            './bower_components/jquery-smartresize/jquery.debouncedresize.js',
            './bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js',
            './bower_components/jquery.scrollTo/jquery.scrollTo.js',
            './assets/scripts/src/plugins/isotope2.js',
            './assets/scripts/src/faculty.js'])
    //.pipe(jshint('./.jshintrc')) Too many hinting errors
    //.pipe(jshint.reporter('jshint-stylish'))
    //.pipe(sourcemaps.init())
    .pipe(concat('faculty.js'))
    //.pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(rename('faculty.min.js'))
    .pipe(gulp.dest('./assets/scripts/build/'))
    .pipe(browserSync.stream());
  ;
});

gulp.task('fallback_js', function () {
  return gulp
    .src([  './assets/scripts/src/jquery-fallback.js'])
    //.pipe(jshint('./.jshintrc')) Too many hinting errors
    //.pipe(jshint.reporter('jshint-stylish'))
    //.pipe(sourcemaps.init())
    .pipe(concat('jquery-fallback.js'))
    //.pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(rename('jquery-fallback.min.js'))
    .pipe(gulp.dest('./assets/scripts/build/'))
    .pipe(browserSync.stream());
  ;
});

gulp.task('admin_js', function () {
  return gulp
    .src([  '.assets/scripts/build/admin.min.js'])
    //.pipe(jshint('./.jshintrc')) Too many hinting errors
    //.pipe(jshint.reporter('jshint-stylish')) 
    //.pipe(sourcemaps.init())
    .pipe(concat('customNavSubheadCheckboxes.js'))
    //.pipe(sourcemaps.write())
    .pipe(uglify())
    .pipe(rename('customNavSubheadCheckboxes.js'))
    .pipe(gulp.dest('./assets/scripts/build/'))
    .pipe(browserSync.stream());
  ;
});


gulp.task('sass', function () {
  return gulp
    .src('assets/styles/src/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(autoprefixer({
        browsers: ['last 4 versions'],
        cascade: false
    }))
    .pipe(cssmin())
    .pipe(sourcemaps.write('./maps'))
    .pipe(gulp.dest('assets/styles/build'))
    .pipe(browserSync.stream());
  ;
});

gulp.task('watch', function () {
    browserSync.init({
        proxy: "https://college-of-the-environment-staging.local"
    });
    gulp.watch('**/*.{html,php}', browserSync.reload);
    gulp.watch('assets/styles/**/*.scss', ['sass']);
    gulp.watch(['./assets/scripts/**/*.js', '!./assets/scripts/build/*.js'], ['js']);
;
});

gulp.task('dev', ["default","watch"]);

gulp.task('js', ["main_js","faculty_js","fallback_js","admin_js"]);

gulp.task('default', ["js","sass", "watch"]);


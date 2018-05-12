/**
 * Gulpfile
 */


var styleSRC            = '../assets/sass/frontend.scss'; // Path to main .scss file
var styleDestination    = '../assets/css/'; // Path to place the compiled CSS file

var jsCustomSRC         = '../assets/js/src/*.js'; // Path to JS custom scripts folder
var jsCustomDestination = '../assets/js/'; // Path to place the compiled JS custom scripts file
var jsCustomFile        = 'frontend'; // Compiled JS custom file name
// Default set to custom i.e. custom.js

var styleWatchFiles     = '../assets/sass/**/*.scss'; // Path to all *.scss files inside css folder and inside them
var customJSWatchFiles  = '../assets/js/src/*.js'; // Path to all custom JS files


// Load gulp and plugin
var gulp = require('gulp');

// css related plugins
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');
var minifycss    = require('gulp-uglifycss');
var filter       = require('gulp-filter');
var mmq          = require('gulp-merge-media-queries');

// JS related plugins.
var concat       = require('gulp-concat');
var uglify       = require('gulp-uglify');

// Utility related plugins.
var rename       = require('gulp-rename');
var sourcemaps   = require('gulp-sourcemaps');
var notify       = require('gulp-notify');


/**
 * Task: styles
 *
 * Compiles Sass, Autoprefixes it and Minifies CSS.
 *
 * This task does the following:
 *      1. Gets the source scss file
 *      2. Compiles Sass to CSS
 *      3. Writes Sourcemaps for it
 *      4. Autoprefixes it and generates style.css
 *      5. Renames the CSS file with suffix .min.css
 *      6. Minifies the CSS file and generates style.min.css
 */
gulp.task('styles', function () {
    gulp.src( styleSRC )
        .pipe( sourcemaps.init() )
        .pipe( sass( {
            errLogToConsole: true,
            //outputStyle: 'compact',
            //outputStyle: 'compressed',
            // outputStyle: 'nested',
            outputStyle: 'expanded',
            precision: 10
        } ) )

        .pipe( sourcemaps.write( { includeContent: false } ) )
        .pipe( sourcemaps.init( { loadMaps: true } ) )
        .pipe( autoprefixer({
            browsers: ['last 2 version'] }) )

        .pipe( sourcemaps.write ( styleDestination ) )
        .pipe( mmq( { log: true } ) )
        .pipe( gulp.dest( styleDestination ) )
        //.pipe( filter( '**/*.css' ) )
        //.pipe( mmq( { log: true } ) )
        //.pipe( gulp.dest( styleDestination ) )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( minifycss( {
            maxLineLen: 0
        }))
        .pipe( gulp.dest( styleDestination ) )
        .pipe( notify( { message: 'TASK: "styles" Completed!', onLast: true } ) );
});


/**
 * Task: vendorJS
 *
 * Concatenate and uglify vendor JS scripts.
 *
 * This task does the following:
 *      1. Gets the source folder for JS vendor files
 *      2. Concatenates all the files and generates vendors.js
 *      3. Renames the JS file with suffix .min.js
 *      4. Uglifes/Minifies the JS file and generates vendors.min.js
 */
//gulp.task( 'vendorsJs', function() {
//    gulp.src( jsVendorSRC )
//        .pipe( concat( jsVendorFile + '.js' ) )
//        .pipe( gulp.dest( jsVendorDestination ) )
//        .pipe( rename( {
//            basename: jsVendorFile,
//            suffix: '.min'
//        }))
//        .pipe( uglify() )
//        .pipe( gulp.dest( jsVendorDestination ) )
//        .pipe( notify( { message: 'TASK: "vendorsJs" Completed!', onLast: true } ) );
//});


/**
 * Task: customJS
 *
 * Concatenate and uglify custom JS scripts.
 *
 * This task does the following:
 *      1. Gets the source folder for JS custom files
 *      2. Concatenates all the files and generates custom.js
 *      3. Renames the JS file with suffix .min.js
 *      4. Uglifes/Minifies the JS file and generates custom.min.js
 */
gulp.task( 'customJS', function() {
    gulp.src( jsCustomSRC )
        .pipe( concat( jsCustomFile + '.js' ) )
        .pipe( gulp.dest( jsCustomDestination ) )
        .pipe( rename( {
            basename: jsCustomFile,
            suffix: '.min'
        }))
        .pipe( uglify() )
        .pipe( gulp.dest( jsCustomDestination ) )
        .pipe( notify( { message: 'TASK: "customJs" Completed!', onLast: true } ) );
});

 /**
  * Watch Tasks.
  *
  * Watches for file changes and runs specific tasks.
  */

 gulp.task( 'default', [ 'styles', 'customJS' ], function () {
    gulp.watch( styleWatchFiles, [ 'styles' ] );
    gulp.watch( customJSWatchFiles, [ 'customJS' ] );
    
 });
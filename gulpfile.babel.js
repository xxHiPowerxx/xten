/* eslint-env es6 */
'use strict';

/**
 * To start theme building process, define the theme name below,
 * then run "gulp" in command line.
 */

import gulp from 'gulp';
import autoprefixer from 'autoprefixer';
import browserSync from 'browser-sync';
import cssnano from 'cssnano';
import babel from 'gulp-babel';
import del from 'del';
import eslint from 'gulp-eslint';
import log from 'fancy-log';
import gulpif from 'gulp-if';
import image from 'gulp-image';
import newer from 'gulp-newer';
import partialImport from 'postcss-partial-import';
import postcssPresetEnv from 'postcss-preset-env';
import postcss from 'gulp-postcss';
import print from 'gulp-print';
import replace from 'gulp-string-replace';
import requireUncached from 'require-uncached';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import sort from 'gulp-sort';
import tabify from 'gulp-tabify';
import uglify from 'gulp-uglify';
import zip from 'gulp-zip';

// Import theme-specific configurations.
var config = require('./dev/config/themeConfig.js');
var themeConfig = config.theme;
themeConfig.isFirstRun = true;

// Project paths
const paths = {
	config: {
		cssVars: './dev/config/cssVariables.json',
		themeConfig: './dev/config/themeConfig.js'
	},
	php: {
		src: ['dev/**/*.php', '!dev/optional/**/*.*'],
		dest: './'
	},
	styles: {
		src: ['dev/**/*.css', '!dev/optional/**/*.*'],
		dest: './css/',
		sass: './dev/css/**/*.scss',
	},
	scripts: {
		src: ['dev/**/*.js', '!dev/**/*.min.js', '!dev/js/libs/**/*.js', '!dev/optional/**/*.*', '!dev/config/**/*', '!node_modules/**/*'],
		min: 'dev/**/*.min.js',
		dest: './',
		libs: 'dev/js/libs/**/*.js',
		libsDest: './js/libs/',
		verboseLibsDest: './verbose/js/libs/'
	},
	images: {
		src: ['dev/**/*.{jpg,JPG,png,svg}', '!dev/optional/**/*.*'],
		dest: './'
	},
	languages: {
		src: ['./**/*.php', '!dev/**/*.php', '!verbose/**/*.php'],
		dest: './languages/' + config.theme.slug + '.pot'
	},
	verbose: './verbose/',
	export: {
		src: ['**/*', '!save-acf-fields.php', '!' + config.theme.slug, '!' + config.theme.slug + '/**/*', '!dev/**/*', '!node_modules', '!node_modules/**/*', '!vendor', '!vendor/**/*', '!.*', '!composer.*', '!gulpfile.*', '!package*.*', '!phpcs.*', '!*.zip'],
		dest: './dist'
	}
};

/**
 * Conditionally set up BrowserSync.
 * Only run BrowserSync if config.browserSync.live = true.
 */

// Create a BrowserSync instance:
const server = browserSync.create();

// Initialize the BrowserSync server conditionally:
function serve(done) {
	if (config.dev.browserSync.live) {
		server.init({
			proxy: config.dev.browserSync.proxyURL,
			port: config.dev.browserSync.bypassPort,
			liveReload: true
		});
	}
	done();
}

// Reload the live site:
function reload(done) {
	config = requireUncached('./dev/config/themeConfig.js');
	if (config.dev.browserSync.live) {
		if (server.paused) {
			server.resume();
		}
		server.reload();
	} else {
		server.pause();
	}
	done();
}


/**
 * PHP via PHP Code Sniffer.
 */
export function php() {
	config = requireUncached('./dev/config/themeConfig.js');
	// Check if theme slug has been updated.
	let isRebuild = themeConfig.isFirstRun ||
		( themeConfig.slug !== config.theme.slug ) ||
		( themeConfig.name !== config.theme.name );
	if ( isRebuild ) {
		themeConfig.slug = config.theme.slug;
		themeConfig.name = config.theme.name;
	}

	// Reset first run.
	if ( themeConfig.isFirstRun ) {
		themeConfig.isFirstRun = false;
	}

	return gulp.src(paths.php.src)
	// If not a rebuild, then run tasks on changed files only.
	.pipe(gulpif(!isRebuild, newer(paths.php.dest)))
	.pipe(gulp.dest(paths.php.dest));

}

/**
 * Sass, if that's being used.
 */
export function sassStyles() {
	return gulp.src(paths.styles.sass)
	.pipe(sass().on('error', sass.logError))
	.pipe(sass({ outputStyle: "expanded" }))
	.pipe(
		postcss([
			autoprefixer(),
			cssnano()
		])
	)
	.pipe(gulp.dest(paths.styles.dest));
}

/**
 * CSS via PostCSS + CSSNext (includes Autoprefixer by default).
 */
export function styles() {
	config = requireUncached('./dev/config/themeConfig.js');

	return gulp.src(paths.styles.src)
	.pipe(print())
	.pipe(gulp.dest(paths.verbose))
	.pipe(gulpif(!config.dev.debug.styles, cssnano({autoprefixer: false})))
	.pipe(gulp.dest(paths.styles.dest));
}


/**
 * JavaScript via Babel, ESlint, and uglify.
 */
export function scripts() {
	config = requireUncached('./dev/config/themeConfig.js');
	return gulp	.src(paths.scripts.src)
	.pipe(newer(paths.scripts.dest))
	.pipe(eslint())
	.pipe(eslint.format())
	.pipe(babel())
	.pipe(gulp.dest(paths.verbose))
	.pipe(gulpif(!config.dev.debug.scripts, uglify()))
	.pipe(gulp.dest(paths.scripts.dest));
}


/**
 * Copy JS libraries without touching them.
 */
export function jsLibs() {
	return gulp.src(paths.scripts.libs)
	.pipe(newer(paths.scripts.verboseLibsDest))
	.pipe(gulp.dest(paths.scripts.verboseLibsDest))
	.pipe(gulp.dest(paths.scripts.libsDest));
}


/**
 * Copy minified JS files without touching them.
 */
export function jsMin() {
	return gulp.src(paths.scripts.min)
	.pipe(newer(paths.scripts.dest))
	.pipe(gulp.dest(paths.verbose))
	.pipe(gulp.dest(paths.scripts.dest));
}

/**
 * Optimize images.
 */
export function images() {
	return gulp.src(paths.images.src)
	.pipe(newer(paths.images.dest))
	.pipe(image())
	.pipe(gulp.dest(paths.images.dest));
}


/**
 * Watch everything
 */
export function watch() {
	gulp.watch(paths.php.src, gulp.series(php));
	gulp.watch(paths.config.themeConfig, gulp.series(php));
	gulp.watch(paths.styles.sass, gulp.series(sassStyles));
	gulp.watch(paths.scripts.src, gulp.series(scripts));
	gulp.watch(paths.scripts.min, gulp.series(jsMin));
	gulp.watch(paths.scripts.libs, gulp.series(jsLibs));
	gulp.watch(paths.images.src, gulp.series(images));
}
export function watchBS() {
	gulp.watch(paths.php.src, gulp.series(php, reload));
	gulp.watch(paths.config.themeConfig, gulp.series(php, reload));
	gulp.watch(paths.styles.sass, gulp.series(sassStyles, reload));
	gulp.watch(paths.scripts.src, gulp.series(scripts, reload));
	gulp.watch(paths.scripts.min, gulp.series(jsMin, reload));
	gulp.watch(paths.scripts.libs, gulp.series(jsLibs, reload));
	gulp.watch(paths.images.src, gulp.series(images, reload));
}


/**
 * Map out the sequence of events on first load:
 */
const firstRun = gulp.series(php, gulp.parallel(scripts, jsMin, jsLibs), sassStyles, images, watch);
const firstRunBS = gulp.series(php, gulp.parallel(scripts, jsMin, jsLibs), sassStyles, images, serve, watchBS);


/**
 * Run the whole thing.
 */
export default firstRun;
export {firstRunBS};

/**
 * Clean Dist
 */
function clean() {
  return del([paths.export.dest]);
}

/**
 * Create zip archive from generated theme files.
 */
export function bundle() {
	return gulp.src(paths.export.src)
	.pipe(print())
	.pipe(gulpif(config.export.compress, gulp.dest(paths.export.dest)));
}




/**
 * Test the theme.
 */
const testTheme = gulp.series(php);


/**
 * Export theme for distribution.
 */
const bundleTheme = gulp.series(clean, php, gulp.parallel(scripts, jsMin, jsLibs), sassStyles, images, bundle);

export { bundleTheme };

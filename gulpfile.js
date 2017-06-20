var gulp = require('gulp');
var util = require('gulp-util');
var concat = require("gulp-concat");
var cleanCSS = require('gulp-clean-css');
var less = require('gulp-less');
var autoprefixer = require('gulp-autoprefixer');

var production = util.env.production;

gulp.task('style', function() {
	return gulp.src(["resources/assets/less/style.less"])
		.pipe(less())
		.pipe(autoprefixer({
			browsers : [
				'Android 2.3',
				'Android >= 4',
				'Chrome >= 20',
				'Firefox >= 24', // Firefox 24 is the latest ESR
				'Explorer >= 8',
				'iOS >= 6',
				'Opera >= 12',
				'Safari >= 6'
			],
			cascade: false
		}))
		.pipe(concat("style.css"))
		.pipe(production ? cleanCSS() : util.noop())
		.pipe(gulp.dest("public/css"));
	
	
});

gulp.task('admin', function() {
	return gulp.src(["resources/assets/less/admin.less"])
		.pipe(less())
		.pipe(autoprefixer({
			browsers : [
				'Android 2.3',
				'Android >= 4',
				'Chrome >= 20',
				'Firefox >= 24', // Firefox 24 is the latest ESR
				'Explorer >= 8',
				'iOS >= 6',
				'Opera >= 12',
				'Safari >= 6'
			],
			cascade: false
		}))
		.pipe(concat("admin.css"))
		.pipe(production ? cleanCSS() : util.noop())
		.pipe(gulp.dest("public/css"));
	
	
});


gulp.task('default', [
    'style'
]);
var gulp = require('gulp');
var concat = require('gulp-concat');

gulp.task('scripts', function () {
    return gulp.src('./src/js/*.js')
    .pipe(concat('main.js'))
    .pipe(gulp.dest('./build/js/'))
});

gulp.task('copy', function () {
    gulp.src('./src/gfx/*')
        .pipe(gulp.dest('./build/gfx'));
    gulp.src('./src/fonts/*')
        .pipe(gulp.dest('./build/fonts'));
    gulp.src('./src/html/*')
        .pipe(gulp.dest('./build/html'));
    gulp.src('./src/php/*')
        .pipe(gulp.dest('./build/php'));
    gulp.src('./src/php/*')
        .pipe(gulp.dest('./build/php'));
    gulp.src('./src/css/*')
        .pipe(gulp.dest('./build/css'));
});

gulp.task('build', ['scripts', 'copy']);
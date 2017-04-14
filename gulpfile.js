var gulp = require('gulp');
var concat = require('gulp-concat');

gulp.task('js', function () {
    
    return gulp.src([
        './src/js/lib/jquery.js',
        './src/js/lib/bootstrap.min.js',
        './src/js/**/*.js'
    ])
        .pipe(concat('main.js'))
        .pipe(gulp.dest('./build/js/'));
});

gulp.task('css', function () {
    
    return gulp.src([
        './src/css/lib/bootstrap.min.css',
        './src/css/**/*.css'
    ])
        .pipe(concat('main.css'))
        .pipe(gulp.dest('./build/css/'));
});

gulp.task('copy', function () {
    // gulp.src('./src/gfx/**/*')
    //     .pipe(gulp.dest('./build/gfx'));
    // gulp.src('./src/fonts/*')
    //     .pipe(gulp.dest('./build/fonts'));
    // gulp.src('./src/html/*')
    //     .pipe(gulp.dest('./build/html'));
    // gulp.src('./src/php/**/*')
    //     .pipe(gulp.dest('./build/php'));
    // gulp.src('./src/Classes/**/*')
    //     .pipe(gulp.dest('./build/Classes'));
    // gulp.src('./src/Examples/**/*')
    //     .pipe(gulp.dest('./build/Examples'));
    gulp.src([
        './src/**/*',
        '!./src/Examples/**',
        '!./src/Examples/',
        '!./src/js/**',
        '!./src/css/**'
    ])
        .pipe(gulp.dest('./build/'));
});

gulp.task('watch',function(){
	gulp.watch(['./src/html/**/*', './src/scss/**/*'],['copy']);
    gulp.watch(['./src/js/**/*'], ['js']);
    gulp.watch(['./src/css/**/*'],['css']);
});

gulp.task('build', ['js', 'css', 'copy', 'watch']);

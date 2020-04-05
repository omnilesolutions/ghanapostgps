let gulp = require('gulp');
let phpunit = require('gulp-phpunit');

gulp.task('test', function() {

    return gulp.src('tests/**/*.php')
        .pipe(phpunit('', { notify: true, clear: true }), function(err, _){
            if(err){
                console.log('Error: ' + err);
            }
        });
});

gulp.task('watch', function() {
    gulp.series('test');
    gulp.watch(['tests/**/*.php', 'src/**/*.php'], gulp.series('test'));
});
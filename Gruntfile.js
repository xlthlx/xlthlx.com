// Load Grunt
module.exports = function (grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // Tasks
    watch: { // Compile everything into one task with Watch Plugin
      css: {
        files: 'scss/**/*.scss',
        tasks: ['sass']
      }
    },
    sass: { // Begin Sass Plugin
      dist: {
        options: {
          style: 'compressed',
          trace: true
        },
        files: [{
          'css/main.min.css': 'scss/main.scss',
        }]
      }
    }

  });
  // Load Grunt plugins
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-watch');

  // Register Grunt tasks
  grunt.registerTask('default', ['browserSync', 'watch']);
};

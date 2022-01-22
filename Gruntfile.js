module.exports = function (grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    jshint: {
      options: {
        reporter: require('jshint-stylish'),
        esversion: 6
      },
      build: ['Gruntfile.js', 'src/js/*.js']
    },

    uglify: {
      options: {
        banner: '/* <%= grunt.template.today("dd/mm/yyyy HH:MM:ss") %> */'
      },
      build: {
        files: {
          'assets/js/main.min.js': ['assets/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js','src/js/sw.js', 'src/js/badge.js', 'src/js/single.js','../../../wp-includes/js/wp-embed.js'],
          'assets/js/admin/admin.min.js': ['src/js/admin/admin.js'],
          'assets/js/admin/login.min.js': ['src/js/admin/login.js', 'assets/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js']
        }
      }
    },

    cssmin: {
      target: {
        files: {
          'assets/css/main.min.css': ['assets/vendor/twbs/bootstrap/dist/css/bootstrap.css', 'src/css/main.css', 'src/css/highlight.css', '../../plugins/wp-inci/public/css/wp-inci.min.css','../../../wp-includes//css/dist/block-library/style.min.css'],
          'assets/css/admin/admin.min.css': ['src/css/admin/admin.css'],
          'assets/css/admin/login.min.css': ['assets/vendor/twbs/bootstrap/dist/css/bootstrap.css','src/css/admin/login.css'],
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-contrib-cssmin');
  grunt.loadNpmTasks('grunt-contrib-watch');

  grunt.registerTask('default', ['jshint', 'uglify', 'cssmin']);
};

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
					'assets/js/main.min.js': ['src/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js', 'src/js/sw.js', 'src/js/badge.js', 'src/js/single.js', 'src/js/dark-mode.js', '../../../wp-includes/js/wp-embed.min.js', '../../../wp-includes/js/comment-reply.js'],
					'assets/js/admin/admin.min.js': ['src/js/admin/admin.js'],
					'assets/js/admin/editor.min.js': ['src/js/admin/editor.js'],
					'assets/js/admin/login.min.js': ['src/js/admin/login.js', 'src/vendor/twbs/bootstrap/dist/js/bootstrap.bundle.js']
				}
			}
		},

		cssmin: {
			target: {
				files: {
					'assets/css/main.min.css': ['src/vendor/twbs/bootstrap/dist/css/bootstrap.css', 'src/css/main.css', 'src/css/highlight.css', '../../../wp-includes/css/dist/block-library/style.min.css'],
					'assets/css/admin/admin.min.css': ['src/css/admin/admin.css'],
					'assets/css/admin/color-scheme.min.css': ['src/css/admin/color-scheme.css'],
					'assets/css/admin/login.min.css': ['src/vendor/twbs/bootstrap/dist/css/bootstrap.css', 'src/css/main.css', 'src/css/admin/login.css'],
				}
			}
		},

		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					cwd: 'src/',
					src: ['**/*.{png,jpg,gif}', '!vendor/**'],
					dest: 'assets/'
				}]
			}
		},

		watch: {
			styles: {
				files: ['src/css/**/*'],
				tasks: ['cssmin']
			},
			scripts: {
				files: ['src/js/**/*'],
				tasks: ['jshint', 'uglify',],
			},
		}

	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-imagemin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('default', ['jshint', 'uglify', 'cssmin', 'imagemin']);
};

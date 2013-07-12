'use strict';
var path = require('path');
var lrSnippet = require('grunt-contrib-livereload/lib/utils').livereloadSnippet;
var folderMount = function folderMount(connect, point) {
	return connect.static(path.resolve(point));
};

module.exports = function(grunt) {

	grunt.initConfig({
		paths: {
			dev: '.',
			test: 'test'
		},
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= paths.dev %>/assets/scripts/src/{,*/}*.js',
				'!<%= paths.dev %>/assets/scripts/src/jquery-fallback.js',
				'!<%= paths.dev %>/assets/scripts/src/plugins/{,*/}*.js'
			]
		},
		uglify: {
			dist: {
				files: {
					'<%= paths.dev %>/assets/scripts/build/main.min.js': [
						'<%= paths.dev %>/components/jquery-fast-click/jQuery.fastClick.js',
						'<%= paths.dev %>/components/jquery-throttle-debounce/jquery.ba-throttle-debounce.js',
						'<%= paths.dev %>/components/jquery.lazyload/jquery.lazyload.js',
						'<%= paths.dev %>/components/chosen/chosen/chosen.jquery.js',
						'<%= paths.dev %>/components/jquery.fitvids/jquery.fitvids.js',
						'<%= paths.dev %>/components/jquery-hoverIntent/jquery.hoverIntent.js',
						'<%= paths.dev %>/assets/scripts/src/plugins/jquery.royalslider.js',
						'<%= paths.dev %>/assets/scripts/src/plugins/royalslider-modules/jquery.rs.auto-height.js',
						'<%= paths.dev %>/assets/scripts/src/plugins/royalslider-modules/jquery.rs.autoplay.js',
						'<%= paths.dev %>/assets/scripts/src/main.js',
						'<%= paths.dev %>/assets/scripts/src/menu.js',
						'<%= paths.dev %>/assets/scripts/src/features.js',
						'<%= paths.dev %>/assets/scripts/src/blog.js'
					],
					'<%= paths.dev %>/assets/scripts/build/faculty.min.js': [
						'<%= paths.dev %>/components/get-style-property/get-style-property.js',
						'<%= paths.dev %>/components/get-size/get-size.js',
						'<%= paths.dev %>/components/isotope/jquery.isotope.js',
						//'<%= paths.dev %>/components/isotope-perfectmasonry/jquery.isotope.perfectmasonry.js',
						'<%= paths.dev %>/components/procession/jquery.procession.js',
						'<%= paths.dev %>/assets/scripts/src/faculty.js'
					],
					'<%= paths.dev %>/assets/scripts/build/jquery-fallback.min.js': [
						'<%= paths.dev %>/assets/scripts/src/jquery-fallback.js'
					],
					'<%= paths.dev %>/assets/scripts/build/admin.min.js': [
						'<%= paths.dev %>/assets/scripts/src/customNavSubheadCheckboxes.js'
					]
				}
			}
		},
		compass: {
			dist: {
				options: {
					sassDir: '<%= paths.dev %>/assets/styles/src',
					cssDir: '<%= paths.dev %>/assets/styles/build',
					imagesDir: '<%= paths.dev %>/assets/img',
					javascriptsDir: '<%= paths.dev %>/assets/scripts/build',
					fontsDir: '<%= paths.dev %>/assets/fonts',
					importPath: 'components',
					outputStyle: 'compressed',
					relativeAssets: true
				}
			}
		},
		watch: {
			compass: {
				files: ['<%= paths.dev %>/assets/styles/src/**/*.scss'],
				tasks: ['compass']
			},
			srcjs: {
				files: ['<%= paths.dev %>/assets/scripts/src/**/*.js'],
				tasks: ['jshint', 'uglify']
			},
			livereload: {
				files: [
					'<%= paths.dev %>/assets/scripts/build/**/*.js',
					'<%= paths.dev %>/assets/styles/build/*.css',
					'<%= paths.dev %>/**/*.{html,php}',
				],
				tasks: ['livereload']
			}
		},
		livereload: {
			port: 35729 // Default livereload listening port.
			// Must have livereload browser extension installed and working
		},
		connect: {
			livereload: {
				options: {
					port: 9001,
					middleware: function(connect, options) {
						return [lrSnippet, folderMount(connect, options.base)];
					}
				}
			}
		},
		rsync: {
			dev: {
				src: './',
				dest: '~/webapps/coenvdev/wordpress/wp-content/themes/coenv',
				host: 'darinreid@darinreid.webfactional.com',
				recursive: true,
				syncDest: true
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-connect');
	grunt.loadNpmTasks('grunt-contrib-livereload');
	grunt.loadNpmTasks('grunt-regarde');
	grunt.loadNpmTasks('grunt-rsync');

	grunt.renameTask('regarde', 'watch');

	grunt.registerTask('server', [
		'default',
		'livereload-start',
		'connect:livereload',
		'watch'
	]);

	grunt.registerTask('deploy', [
		'default',
		'rsync:dev'
	]);

	grunt.registerTask('default', [
		'jshint',
		'compass',
		'uglify'
	]);

};
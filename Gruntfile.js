'use strict';

module.exports = function(grunt) {

	grunt.initConfig({

		paths: {
			dev: './'
		},

		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: [
				'Gruntfile.js',
				'<%= paths.dev %>assets/scripts/src/{,*/}*.js',
				'!<%= paths.dev %>assets/scripts/src/jquery-fallback.js',
				'!<%= paths.dev %>assets/scripts/src/plugins/{,*/}*.js'
			]
		},

		/**
		 * Concat and minify all scripts and plugins
		 */
		uglify: {
			dist: {
				options: {
					sourceMap: true
				},
				files: {
					// The main script file
					'<%= paths.dev %>assets/scripts/build/main.min.js': [
						'<%= paths.dev %>bower_components/jquery/jquery-migrate.min.js',
						'<%= paths.dev %>bower_components/jquery-fast-click/jQuery.fastClick.js',
						'<%= paths.dev %>bower_components/jquery-throttle-debounce/jquery.ba-throttle-debounce.js',
						'<%= paths.dev %>bower_components/chosen/chosen/chosen.jquery.js',
						'<%= paths.dev %>bower_components/fitvids/jquery.fitvids.js',
						'<%= paths.dev %>bower_components/jquery-placeholder/jquery.placeholder.js',
						'<%= paths.dev %>bower_components/jquery-hoverIntent/jquery.hoverIntent.js',
						'<%= paths.dev %>bower_components/picturefill/picturefill.js',
						'<%= paths.dev %>bower_components/matchmedia/matchMedia.js',
						'<%= paths.dev %>bower_components/enquire/dist/enquire.js',
						'<%= paths.dev %>assets/scripts/src/plugins/jquery.royalslider.js',
						'<%= paths.dev %>assets/scripts/src/plugins/royalslider-modules/jquery.rs.auto-height.js',
						'<%= paths.dev %>assets/scripts/src/plugins/royalslider-modules/jquery.rs.autoplay.js',
						'<%= paths.dev %>assets/scripts/src/menu.js',
						'<%= paths.dev %>assets/scripts/src/features.js',
						'<%= paths.dev %>assets/scripts/src/blog.js',
						'<%= paths.dev %>assets/scripts/src/share.js',
						'<%= paths.dev %>assets/scripts/src/main.js'
					],
					// Faculty specific scripts–we'll probably only load this for
					// faculty directory pages.
					'<%= paths.dev %>assets/scripts/build/faculty.min.js': [
						'<%= paths.dev %>bower_components/get-style-property/get-style-property.js',
						'<%= paths.dev %>bower_components/get-size/get-size.js',
						'<%= paths.dev %>bower_components/jquery-smartresize/jquery.debouncedresize.js',
						//'<%= paths.dev %>bower_components/odometer/odometer.js',
						'<%= paths.dev %>bower_components/jquery.scrollTo/jquery.scrollTo.js',
						'<%= paths.dev %>assets/scripts/src/plugins/isotope2.js',
						'<%= paths.dev %>assets/scripts/src/faculty.js'
					],

					// jQuery fallback. Load this if CDN version is not available (user is offline)
					'<%= paths.dev %>assets/scripts/build/jquery-fallback.min.js': [
						'<%= paths.dev %>assets/scripts/src/jquery-fallback.js'
					],

					// Admin specific-scripts
					'<%= paths.dev %>assets/scripts/build/admin.min.js': [
						'<%= paths.dev %>assets/scripts/src/customNavSubheadCheckboxes.js'
					]
				}
			}
		},

		/**
		 * Process SASS into temp directory
		 */
		sass: {
			dist: {
				options: {
					sourcemap: true
				},
				files: [
					{
						expand: true,
						flatten: true,
						src: ['<%= paths.dev %>assets/styles/src/*.scss'],
						dest:  '<%= paths.dev %>.tmp/styles/build',
						ext: '.css'
					}
				]
			}
		},

		/**
		 * Auto-prefix temporary CSS file
		 */
		autoprefixer: {
			dist: {
				options: {
					browsers: ['last 2 versions'],
					map: true
				},
				files: [
					{
						expand: true,
						flatten: true,
						src: ['<%= paths.dev %>.tmp/styles/build/*.css'],
						dest: '<%= paths.dev %>.tmp/styles/build'
					}
				]
			}
		},

		/**
		 * Minify css after auto-prefixing and output to build
		 */
		cssmin: {
			dist: {
				files: [
					{
						expand: true,
						flatten: true,
						src: ['<%= paths.dev %>.tmp/styles/build/*.css'],
						dest: '<%= paths.dev %>assets/styles/build'
					}
				]
			}
		},

		/**
		 * Copying files
		 */
		copy: {
			css: {
				files: [
					// copy css source maps
					{
						expand: true,
						flatten: true,
						src: ['<%= paths.dev %>.tmp/styles/build/*.map'],
						dest: '<%= paths.dev %>assets/styles/build/'
					}
				]
			}
		},

		/**
		 * Concatenating files
		 */
		concat: {
			css: {
				options: {
					process: function (src, filepath) {
						var filename = filepath.replace(/^.*[\\\/]/, '');
						return src + '\n\n' + '/*# sourceMappingURL=' + filename + '.map */';
					}
				},
				files: [
					{
						expand: true,
						flatten: true,
						src: ['<%= paths.dev %>assets/styles/build/*.css'],
						dest: '<%= paths.dev %>assets/styles/build'
					}
				]
			}
		},

		/**
		 * Watching files for changes
		 * https://github.com/gruntjs/grunt-contrib-watch
		 *
		 * To enable live reloading, you'll need:
		 * LiveReload: http://livereload.com/
		 * LiveReload browser extension: http://feedback.livereload.com/knowledgebase/articles/86242-how-do-i-install-and-use-the-browser-extensions-
		 */
		watch: {
			sass: {
				files: ['<%= paths.dev %>assets/styles/src/**/*.scss'],
				tasks: [ 'sass', 'autoprefixer' ]
			},
			css: {
				files: ['<%= paths.dev %>.tmp/styles/build/**/*.css'],
				tasks: [ 'cssmin', 'copy:css' ],
				options: {
					livereload: true
				}
			},
			scripts: {
				files: ['<%= paths.dev %>assets/scripts/src/**/*.js'],
				tasks: [ 'jshint', 'uglify' ],
				options: {
					livereload: true
				}
			},
			files: {
				files: [
					'<%= paths.dev %>**/*.{html,php}'
				],
				options: {
					livereload: true
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-autoprefixer');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-watch');

	grunt.registerTask('dev', [
		'default',
		'watch'
	]);

	grunt.registerTask('default', [
		'jshint',
		'uglify',
		'sass',
		'autoprefixer',
		'cssmin',
		'copy:css',
		'concat:css'
	]);

};
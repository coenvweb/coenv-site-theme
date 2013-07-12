'use strict';
var path = require('path');
var lrSnippet = require('grunt-contrib-livereload/lib/utils').livereloadSnippet;
var folderMount = function folderMount(connect, point) {
	return connect.static(path.resolve(point));
};

module.exports = function (grunt) {

	grunt.initConfig({
		paths: {
			dev: '.',
			test: 'test'
		},
		jshint: {
			options: {
				jshintrc: '.jshintrc'
			},
			all: ['Gruntfile.js', 'scripts/*.js']
		},
		compass: {
			dist: {
				options: {
					sassDir: '<%= paths.test %>/assets',
					specify: 'test/assets/screen.scss',
					cssDir: '<%= paths.test %>/assets',
					outputStyle: 'expanded',
					importPath: '<%= paths.dev %>/styles',
					relativeAssets: true
				}
			}
		},
		watch: {
			compass: {
				files: [
					'<%= paths.dev %>/styles/*.scss',
					'<%= paths.test %>/assets/*.scss'
				],
				tasks: ['compass']
			},
			srcjs: {
				files: ['<%= paths.dev %>/scripts/*.js'],
				tasks: ['jshint', 'uglify']
			},
			livereload: {
				files: [
					'<%= paths.test %>/assets/*.css',
					'<%= paths.test %>/asssts/*.js',
					'<%= paths.test %>/*.html'
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
		}
	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-connect');
	grunt.loadNpmTasks('grunt-contrib-livereload');
	grunt.loadNpmTasks('grunt-regarde');

	grunt.renameTask('regarde', 'watch');

	grunt.registerTask('server', [
		'default',
		'livereload-start',
		'connect:livereload',
		'watch'
	]);

	grunt.registerTask('default', [
		'jshint',
		'compass'
	]);
};
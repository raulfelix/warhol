module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {                             
      dist: {                           
        options: {                 
          style: 'compressed'
        },
        files: {
          'static/style.css': 'static/scss/master.scss'
        }
      }
    },

    watch: {
      js: {
        files: 'static/scripts/*.js',
        tasks: ['jshint', 'concat'],
      },
      src: {
        files: ['static/scss/*.scss'],
        tasks: ['sass'],
        options: {
          interrupt: true,
          reload: true
        }
      }
    },

    jshint: {
      options: {
        jshintrc: '.jshintrc',
      },
      files: [
        'static/scripts/*.js',
        '!static/scripts/jquery-2.0.3.min.js'
      ]
    },

    concat: {
      dist: {
        files: {
          'static/dist/build.js' : [
            'static/scripts/*.js'
          ]
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-sass');

  grunt.registerTask('default', ['sass', 'concat']);
};
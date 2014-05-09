module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {                             
      dist: {                           
        options: {                 
          style: 'compressed'
        },
        files: {
          'static/style.css': 'static/scss/master.scss',
          'style.css': 'static/scss/master.scss'
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
        'static/scripts/*.js'
      ]
    },

    concat: {
      dist: {
        files: {
          'static/dist/home-build.js' : [
            'static/scripts/precompiled/article-template.js',
            'static/scripts/post-loader.js',
            'static/scripts/home.js'
          ],
          'static/dist/global-build.js' : [
            'static/vendor/jquery-2.0.3.min.js',
            'static/vendor/*.js',
            'static/scripts/global.js',
            'static/scripts/nav.js',
            'static/scripts/modal.js',
            'static/scripts/back-up.js',
            'static/scripts/precompiled/search-template.js',
            'static/scripts/search.js'
          ]
        }
      }
    },

    handlebars: {
      compile: {
        options: {
          namespace: 'Handlebars',
          min: true,
          processName: function(filePath) {
            return filePath.match(/[^\/]+$/)[0].split('.')[0];
          }
        },

        files: {
          "static/scripts/precompiled/article-template.js": ["js_partial/article_thumb.hbs.html"],
          "static/scripts/precompiled/search-template.js": ["js_partial/search_thumb.hbs.html", "js_partial/search_next_link.hbs.html"]
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-handlebars');

  grunt.registerTask('default', ['sass', 'concat']);
};
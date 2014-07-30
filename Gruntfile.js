module.exports = function(grunt) {

  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    sass: {                             
      dist: {                           
        options: {                 
          style: 'compressed'
        },
        files: {
          'static/scss/style.css': 'static/scss/master.scss'
        }
      }
    },

    watch: {
      js: {
        files: ['static/scripts/*.js', 'js_partial/*.hbs.html'],
        tasks: ['jshint', 'handlebars', 'concat', 'uglify'],
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
            'static/vendor/sly.min.js',
            'static/vendor/jquery.slider.min.js',
            'static/scripts/precompiled/article-template.js',
            'static/scripts/precompiled/instabinge-template.js',
            'static/scripts/post-loader.js',
            'static/scripts/home.js',
            'static/scripts/instabinge.js'
          ],
          'static/dist/global-build.js' : [
            'static/vendor/jquery-2.0.3.min.js',
            'static/vendor/*.js',
            '!static/vendor/sly.min.js',
            '!static/vendor/jquery.slider.min.js',
            'static/scripts/global.js',
            'static/scripts/nav.js',
            'static/scripts/modal.js',
            'static/scripts/back-up.js',
            'static/scripts/precompiled/search-template.js',
            'static/scripts/button-loader.js',
            'static/scripts/search.js',
            'static/scripts/load.js',
            'static/scripts/spinner.js'
          ],
          'static/dist/gallery-build.js' : [
            'static/vendor/sly.min.js',
            'static/vendor/jquery.slider.min.js',
            'static/scripts/precompiled/gallery-template.js',
            'static/scripts/gallery.js'
          ],
          'static/dist/single-build.js' : [
            'static/scripts/share.js',
            'static/scripts/single.js'
          ],
          'static/dist/category-build.js' : [
            'static/scripts/dropdown.js',
            'static/scripts/category.js'
          ]
        }
      }
    },

    uglify: {
      options: {
        sourceMap: true,
        compress: {
          drop_console: true
        },
        mangle: {
          except: ['jQuery', 'Handlebars']
        }
      },
      my_target: {
        files: {
          'static/dist/prod/global.min.js': ['static/dist/global-build.js'],
          'static/dist/prod/home.min.js': ['static/dist/home-build.js'],
          'static/dist/prod/single.min.js': ['static/dist/single-build.js'],
          'static/dist/prod/gallery.min.js': ['static/dist/gallery-build.js'],
          'static/dist/prod/category.min.js': ['static/dist/category-build.js'],
          'static/dist/prod/dropdown.min.js': ['static/scripts/dropdown.js']
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
          "static/scripts/precompiled/search-template.js": ["js_partial/search_thumb.hbs.html", "js_partial/search_next_link.hbs.html"],
          "static/scripts/precompiled/instabinge-template.js": ["js_partial/instabinge_thumb.hbs.html", "js_partial/instabinge_thumb_modal.hbs.html", "js_partial/instabinge_single_thumb_modal.hbs.html"],
          "static/scripts/precompiled/gallery-template.js": ["js_partial/gallery_inline.hbs.html"]
        }
      }
    },

    asset_cachekiller: {
      options: {
        file: 'functions.php',
        length: 12
      },
      bust: {
        files: {
          'static/dist/js': ['static/dist/prod/*.js'],
          'static/dist/css': ['static/scss/style.css']
        }
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-handlebars');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-asset-cachekiller');

  grunt.registerTask('default', ['sass', 'concat']);
};
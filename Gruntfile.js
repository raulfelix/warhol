var UglifyJsPlugin = require("webpack/lib/optimize/UglifyJsPlugin");

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
        tasks: [
          'jshint',
          'handlebars',
          'concat',
          'uglify',
          'asset_cachekiller',
          'copy',
          'clean'
        ],
      },
      src: {
        files: ['static/scss/*.scss'],
        tasks: ['sass', 'asset_cachekiller'],
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
          'static/dist/js/global-build.js' : [
            'static/vendor/jquery-2.0.3.min.js',
            'static/vendor/*.js',
            'static/scripts/global.js',
            'static/scripts/modal.js',
            'static/scripts/load.js',
            'static/scripts/spinner.js'
          ],
          'static/dist/js/gallery-build.js' : [
            'static/scripts/precompiled/gallery-template.js',
            'static/scripts/lazyload.js',
            'static/scripts/gallery.js'
          ]
        }
      }
    },

    uglify: {
      options: {
        sourceMap: true,
        compress: {
          drop_console: false
        },
        mangle: {
          except: ['jQuery', 'Handlebars']
        }
      },
      my_target: {
        files: {
          'static/dist/build/global.min.js': ['static/dist/js/global-build.js'],
          'static/dist/build/gallery.min.js': ['static/dist/js/gallery-build.js']
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
          "static/scripts/precompiled/gallery-template.js": [
            "js_partial/gallery_inline.hbs.html",
            "js_partial/gallery_modal.hbs.html",
            "js_partial/gallery_thumb.hbs.html"
          ]
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
          'static/dist/js': ['static/dist/build/*.js'],
          'static/dist/css': ['static/scss/style.css'],
          'build/dist/js': [
            'build/dist/js/everywhere.entry.js',
            'build/dist/js/index.entry.js',
            'build/dist/js/category.entry.js',
            'build/dist/js/single.entry.js'
          ]
        }
      }
    },

    copy: {
      dist: {
        files: [
          {
            expand: true,
            cwd: 'static/dist/build',
            src: ['*.map'],
            dest: 'static/dist/js'
          }
        ]
      }
    },

    clean: {
      dist: [
        'build/dist/js/everywhere.entry.js',
        'build/dist/js/index.entry.js',
        'build/dist/js/category.entry.js',
        'build/dist/js/single.entry.js'
      ]
    },
    
    webpack: {
      
      options: {
        entry: {
          index: './static/js/main',
          everywhere: './static/js/global',
          category: './static/js/category',
          single: './static/js/single'
        },
        devtool: 'source-map',
        output: {
          path: './build/dist/js/',
          filename: '[name].entry.js'
        },
        module: {
          loaders: [
            {
              test: /\.js?$/,
              exclude: /(node_modules|bower_components)/,
              loader: 'babel',
              query: {
                presets: ['react', 'es2015']
              }
            },
            {
              include: /\.json$/, 
              loaders: ["json-loader"]
            }
          ]
        }
      },
      
      prod: {
        plugins: [ 
          // minify
          new UglifyJsPlugin({minimize: true})
        ]
      },
      
      dev: {
        plugins: [ 
      
        ]
      }
    }

  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-jshint');
  grunt.loadNpmTasks('grunt-contrib-concat');
  grunt.loadNpmTasks('grunt-contrib-copy');
  grunt.loadNpmTasks('grunt-contrib-clean');
  grunt.loadNpmTasks('grunt-contrib-sass');
  grunt.loadNpmTasks('grunt-contrib-handlebars');
  grunt.loadNpmTasks('grunt-contrib-uglify');
  grunt.loadNpmTasks('grunt-asset-cachekiller');
  grunt.loadNpmTasks('grunt-webpack');

  grunt.registerTask('dev', ['handlebars', 'webpack:dev', 'asset_cachekiller', 'copy', 'clean']);
  grunt.registerTask('prod', ['handlebars', 'webpack:prod', 'asset_cachekiller', 'copy', 'clean']);
  grunt.registerTask('build', ['jshint', 'handlebars', 'concat', 'uglify', 'asset_cachekiller', 'copy', 'clean']);
};

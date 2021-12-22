module.exports = function (grunt) {
  grunt.initConfig({
    clean: ["assets/js/*", "assets/css/*", "assets/dist"],
    browserify: {
      admin: {
        src: "./src/backend/js/main.ts",
        dest: "./assets/js/backend.js",
      },
      frontend: {
        src: "./src/frontend/js/main.ts",
        dest: "./assets/js/frontend.js",
      },
      options: {
        browserifyOptions: {
          debug: true,
        },
        configure: function (bundler) {
          bundler.plugin(require("tsify"));
          bundler.transform(require("babelify"), {
            presets: ["@babel/preset-env"],
            extensions: [".ts"],
          });
        },
      },
    },
    sass: {                             
      dist: {                   
        options: {                      
          style: "compressed"
        },
        files: {                         
          "assets/css/frontend.css": "src/frontend/sass/main.scss",       
          "assets/css/backend.css": "src/backend/sass/main.scss",   
        }
      }
    }
  });
  grunt.loadNpmTasks("grunt-contrib-clean");
  grunt.loadNpmTasks("grunt-browserify");
  grunt.loadNpmTasks("grunt-contrib-sass");
  grunt.registerTask("default", ["clean", "browserify", "sass"]);
};
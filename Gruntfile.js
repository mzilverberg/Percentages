module.exports = function(grunt) {
    grunt.initConfig({

        // Package.json
        pkg: grunt.file.readJSON("package.json"),

        // CoffeeScript
        // https://github.com/gruntjs/grunt-contrib-coffee
        coffee: {
            compile: {
                files: {
                    "dist/js/Percentages.js": "source/coffee/Percentages.coffee"
                }
            },
            options: {
                bare: true
            }
        },

        // Uglify
        uglify: {
            target: {
                files: {
                    "dist/js/Percentages.min.js": ["dist/js/Percentages.js"]
                }
            },
            options: {
                preserveComments: "all"
            }
        },

        // Tests
        jasmine: {
            src: "dist/js/Percentages.min.js",
            options: {
                specs: "tests/js/*.js",
                display: "full"
            }
        },

        // Compile on save
        // https://github.com/gruntjs/grunt-contrib-watch
        watch: {
            styles: {
                files: ["source/coffee/**/*.coffee"],
                tasks: ["coffee"]
            }
        }
    });

    // Load and register tasks
    grunt.loadNpmTasks("grunt-contrib-coffee");
    grunt.loadNpmTasks("grunt-contrib-uglify");
    grunt.loadNpmTasks("grunt-contrib-watch");
    grunt.loadNpmTasks("grunt-contrib-jasmine");

    grunt.registerTask("default", ["coffee", "uglify", "watch"]);
    grunt.registerTask("test", ["coffee", "uglify", "jasmine"]);
};

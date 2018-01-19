var _ = require('lodash');
var argv = require('yargs').argv;
var gulp = require('gulp');
var gulpSequence = require('gulp-sequence');
var clean = require('gulp-clean');
var colors = require('ansi-colors');
var file = require('gulp-file');
var backstopjs = require('backstopjs');
var fs = require('fs');
var path = require('path');
var Promise = require('es6-promise').Promise;

var utils = require('./gulp/utils');
var test = require('./gulp/test');

// BackstopJS tasks
(function () {
  var backstopDir = 'backstop_data/';
  var files = { config: 'site-config.json', tpl: 'backstop.tpl.json' };
  var configTpl = {
    'url': 'http://%{site-host}',
    'credentials': { 'name': '%{user-name}', 'pass': '%{user-password}' }
  };

  gulp.task('backstopjs:reference', function (done) {
    runBackstopJS('reference').then(function () {
      done();
    });
  });

  gulp.task('backstopjs:test', function (done) {
    runBackstopJS('test').then(function () {
      done();
    });
  });

  gulp.task('backstopjs:report', function (done) {
    runBackstopJS('openReport').then(function () {
      done();
    });
  });

  gulp.task('backstopjs:approve', function (done) {
    runBackstopJS('approve').then(function () {
      done();
    });
  });

  /**
   * Checks if the site config file is in the backstopjs folder
   * If not, it creates a template for it
   *
   * @return {Boolean} [description]
   */
  function isConfigFilePresent () {
    var check = true;

    try {
      fs.readFileSync(backstopDir + files.config);
    } catch (err) {
      fs.writeFileSync(backstopDir + files.config, JSON.stringify(configTpl, null, 2));
      check = false;
    }

    return check;
  }

  /**
   * Runs backstopJS with the given command.
   *
   * It fills the template file with the list of scenarios, create a temp
   * file passed to backstopJS, then when the command is completed it removes the temp file
   *
   * @param  {string} command
   * @return {Promise}
   */
  function runBackstopJS (command) {
    var destFile = 'backstop.temp.json';

    if (!isConfigFilePresent()) {
      console.log(colors.red(
        'No site-config.json file detected!\n' +
        'One has been created for you under ' + backstopDir + '\n' +
        'Please insert the real value for each placholder and try again'
      ));

      return Promise.reject(new Error());
    }

    return new Promise(function (resolve) {
      gulp.src(backstopDir + files.tpl)
        .pipe(file(destFile, tempFileContent()))
        .pipe(gulp.dest(backstopDir))
        .on('end', function () {
          var promise = backstopjs(command, {
            configPath: backstopDir + destFile,
            filter: argv.filter
          })
            .catch(_.noop).then(function () { // equivalent to .finally()
              gulp.src(backstopDir + destFile, { read: false }).pipe(clean());
            });

          resolve(promise);
        });
    });
  }

  /**
   * Creates the content of the config temporary file that will be fed to BackstopJS
   * The content is the mix of the config template and the list of scenarios
   * under the scenarios/ folder
   *
   * @return {string}
   */
  function tempFileContent () {
    var config = JSON.parse(fs.readFileSync(backstopDir + files.config));
    var content = JSON.parse(fs.readFileSync(backstopDir + files.tpl));

    content.scenarios = scenariosList().map(function (scenario) {
      scenario.url = config.url + '/' + scenario.url;

      return scenario;
    });

    return JSON.stringify(content);
  }

  /**
   * Concatenates all the scenarios, or returns only the scenario passed as
   * an argument to the gulp task
   *
   * The first scenario of the list gets the login script to run
   *
   * @return {Array}
   */
  function scenariosList () {
    var scenariosPath = backstopDir + 'scenarios/';

    return _(fs.readdirSync(scenariosPath))
      .filter(function (scenario) {
        return argv.configFile ? scenario === argv.configFile : true;
      })
      .map(function (scenarioFile) {
        return JSON.parse(fs.readFileSync(scenariosPath + scenarioFile)).scenarios;
      })
      .flatten()
      .map(function (scenario) {
        return _.assign(scenario, { delay: scenario.delay || 6000 });
      })
      .tap(function (scenarios) {
        scenarios[0].onBeforeScript = 'login';

        return scenarios;
      })
      .value();
  }
})();

// Sass
(function () {
  var tasks = require('./gulp/tasks/sass');

  tasks.forEach(function (task) {
    gulp.task(task.name, task.fn);
  });
}());

// RequireJS
(function () {
  var tasks = require('./gulp/tasks/requirejs');

  tasks.forEach(function (task) {
    gulp.task(task.name, task.fn);
  });
}());

// Test
(function () {
  gulp.task('test', function (cb) {
    var sequence = utils.addExtensionCustomTasksToSequence([
      utils.spawnTaskForExtension('test:main', mainTask, utils.getCurrentExtension())
    ], 'test');

    gulpSequence.apply(null, sequence)(cb);
  });

  gulp.task('test:watch', function () {
    var extPath = utils.getExtensionPath();
    var watchPatterns = utils.addExtensionCustomWatchPatternsToDefaultList([
      path.join(extPath, '**', 'test/**/*.spec.js'),
      '!' + path.join(extPath, '**', 'test/mocks/**/*.js'),
      '!' + path.join(extPath, '**', 'test/test-main.js')
    ], 'test');

    gulp.watch(watchPatterns).on('change', function (file) {
      test.single(file.path);
    });
  });

  /**
   * Runs all the JS unit tests of the extension
   */
  function mainTask () {
    test.all();
  }
}());

// Watch
(function () {
  gulp.task('watch', ['sass:watch', 'requirejs:watch', 'test:watch']);
}());

// Build
(function () {
  gulp.task('build', function (cb) {
    gulpSequence('sass', 'requirejs', 'test')(cb);
  });
}());

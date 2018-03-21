'use strict';

var page = require('../../../page-objects/ssp-leave-absences-my-leave-report');

// precondition: need to have at least one pending leave request
module.exports = function (engine) {
  page.init(engine).openSection('pending');
};

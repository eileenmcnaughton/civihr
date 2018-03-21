'use strict';

var page = require('../../../page-objects/ssp-leave-absences-manager-leave-requests');

// precondition: need to have the login of manager and have at least one leave request
module.exports = function (engine) {
  page.init(engine).expandFilter();
};

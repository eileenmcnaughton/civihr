'use strict';

var page = require('../../../page-objects/ssp-leave-absences-manager-leave-calendar');

module.exports = function (engine) {
  page.init(engine).toggleContactsWithLeaves();
};

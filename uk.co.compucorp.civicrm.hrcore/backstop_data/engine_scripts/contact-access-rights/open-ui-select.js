'use strict';

var page = require('../../page-objects/contact-summary');

module.exports = function (engine) {
  page.init(engine).openManageRightsModal()
    .then(function (modal) {
      modal.openDropdown('locations');
    });
};

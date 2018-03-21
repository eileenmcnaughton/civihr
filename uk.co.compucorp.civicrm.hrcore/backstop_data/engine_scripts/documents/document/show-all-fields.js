'use strict';

var page = require('../../../page-objects/documents');

module.exports = function (engine) {
  page.init(engine).addDocument().then(function (modal) {
    modal.showTab('Assignments').showField('Assignee').showField('Assignment');
  });
};

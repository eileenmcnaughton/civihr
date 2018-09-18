/* eslint-env amd */

define([
  'common/lodash'
], function (_) {
  LeaveTypeWizardFormController.$inject = ['$log', 'shared-settings'];

  return {
    __name: 'leaveTypeWizardForm',
    controller: LeaveTypeWizardFormController,
    controllerAs: 'form',
    templateUrl: ['shared-settings', function (sharedSettings) {
      return sharedSettings.sourcePath + 'leave-type-wizard/form/components/leave-type-wizard-form.html';
    }]
  };

  function LeaveTypeWizardFormController ($log, sharedSettings) {
    $log.debug('Controller: LeaveTypeWizardFormController');

    var vm = this;

    vm.sections = [
      {
        name: 'basic',
        title: 'Leave Category'
      },
      {
        name: 'settings',
        title: 'Leave Category Settings'
      }
    ];
    vm.sectionsTemplatesPath =
      sharedSettings.sourcePath + 'leave-type-wizard/form/components/form-sections';

    vm.$onInit = $onInit;
    vm.openSection = openSection;

    function $onInit () {
      initSections();
    }

    /**
     * Finds a sections by its name
     *
     * @param  {String} sectionName
     * @return {Object}
     */
    function findSection (sectionName) {
      return _.find(vm.sections, { name: sectionName });
    }

    /**
     * Initiates sections.
     * Expands the Basic section and leaves the Settings section collapsed.
     */
    function initSections () {
      openSection('basic');
    }

    /**
     * Opens a section by its name and collapses all other sections
     *
     * @param {String} sectionName
     */
    function openSection (sectionName) {
      vm.sections.forEach(function (section) {
        section.expanded = false;
      });

      findSection(sectionName).expanded = true;
    }
  }
});

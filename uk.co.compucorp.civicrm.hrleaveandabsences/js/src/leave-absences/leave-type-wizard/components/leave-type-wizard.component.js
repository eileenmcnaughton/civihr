/* eslint-env amd */

define([
  'common/angular',
  'common/lodash'
], function (angular, _) {
  LeaveTypeWizardController.$inject = ['$log', '$q', '$scope', '$window',
    'AbsenceType', 'Contact', 'custom-tab-names-by-category',
    'fields-hidden-by-category', 'form-sections', 'leave-type-categories-icons',
    'tabs-hidden-by-category', 'notificationService', 'OptionGroup',
    'defaults-by-category', 'shared-settings'];

  return {
    leaveTypeWizard: {
      controller: LeaveTypeWizardController,
      controllerAs: 'form',
      templateUrl: ['shared-settings', function (sharedSettings) {
        return sharedSettings.sourcePath + 'leave-type-wizard/components/leave-type-wizard.html';
      }]
    }
  };

  function LeaveTypeWizardController ($log, $q, $scope, $window, AbsenceType,
    Contact, customTabNamesByCategory, fieldsHiddenByCategory, formSections,
    leaveTypeCategoriesIcons, hiddenTabsByCategory, notificationService,
    OptionGroup, defaultsByCategory, sharedSettings) {
    $log.debug('Controller: LeaveTypeWizardController');

    var promises = {
      titlesInUse: null
    };
    var state = {
      sectionIndex: null,
      tabIndex: null
    };
    var tabsIndexed = {};
    var vm = this;

    vm.availableColours = null;
    vm.componentsPath =
      sharedSettings.sourcePath + 'leave-type-wizard/components';
    vm.contacts = null;
    vm.fieldsIndexed = {};
    vm.leaveTypeCategories = [];
    vm.loading = true;
    vm.sections = _.cloneDeep(formSections);

    vm.$onInit = $onInit;
    vm.checkIfAccordionHeaderClicked = checkIfAccordionHeaderClicked;
    vm.goBack = goBack;
    vm.goNext = goNext;
    vm.openActiveSectionTab = openActiveSectionTab;
    vm.openSection = openSection;

    function $onInit () {
      vm.loading = true;

      loadLeaveTypeCategories()
        // @NOTE this is a temporary option group suppressor to match user stories
        // @TODO the suppressor should be amended to gradually support other leave categories
        // @TODO the suppressor must be completely removed once all leave categories are supported
        .then(temporarilySuppressNotYetUsedLeaveCategories)
        .then(initDefaultView)
        .then(function () {
          tabsIndexed = indexPropertyByName(vm.sections, 'tabs');
          vm.fieldsIndexed = indexPropertyByName(tabsIndexed, 'fields');
          promises.titlesInUse = fetchAbsenceTypesTitlesInUse();
        })
        .then(markFirstAndLastTabsInSections)
        .then(initDefaultValues)
        .then(initFieldsWatchers)
        .then(initValidators)
        .then(initCustomValidators)
        .then(function () {
          vm.loading = false;
        })
        .then(function () {
          return $q.all([
            loadContacts(),
            loadAvailableColours()
          ]);
        });
    }

    /**
     * Check if the header of the accordion was clicked and not other area
     *
     * @param  {Event} $event
     * @return {Boolean}
     */
    function checkIfAccordionHeaderClicked ($event) {
      var className = 'panel-heading';
      var $sourceElement = angular.element($event.originalEvent.path);
      var isHeaderOrElementInsideHeader = $sourceElement.hasClass(className) ||
        !!$sourceElement.closest('.' + className).length;

      return isHeaderOrElementInsideHeader;
    }

    /**
     * Checks if title provided is unique.
     * If existing titles are not yet loaded, the validation will not be executed,
     * instead, it will show that the field is "loading".
     *
     * @return {Promise}
     */
    function checkIfTitleIsUnique () {
      var titleField = vm.fieldsIndexed.title;

      if (_.isEmpty(titleField.value) || titleField.validating) {
        return $q.resolve();
      }

      titleField.validating = true;

      return promises.titlesInUse
        .then(function (titlesInUse) {
          if (_.includes(titlesInUse, titleField.value.toLowerCase())) {
            titleField.error = 'This leave type title is already in use';
          }
        })
        .then(function () {
          titleField.validating = false;
        });
    }

    /**
     * Searches for a tab with errors and,
     * if finds, returnes indexes of the section and the tab.
     *
     * @return {Object} { sectionIndex, tabIndex }
     */
    function findIndexesOfFirstSectionAndTabWithErrors () {
      var indexes;

      _.each(vm.sections, function (section, sectionIndex) {
        _.each(section.tabs, function (tab, tabIndex) {
          if (!tab.valid) {
            indexes = {
              sectionIndex: sectionIndex,
              tabIndex: tabIndex
            };

            return false;
          }
        });

        if (indexes) {
          return false;
        }
      });

      return indexes;
    }

    /**
     * Fetches absence types titles in use.
     * It also lowers the case of the titles.
     *
     * @return {Promise} resolves with an {Array}
     */
    function fetchAbsenceTypesTitlesInUse () {
      return AbsenceType.all({}, { return: ['title'] })
        .then(function (absenceTypes) {
          return absenceTypes.map(function (absenceType) {
            return absenceType.title.toLowerCase();
          });
        });
    }

    /**
     * Flushes an error for a given field
     *
     * @param {Object} field
     */
    function flushErrorForField (field) {
      delete field.error;
    }

    /**
     * Returns the active tab
     *
     * @return {Object}
     */
    function getActiveTab () {
      return vm.sections[state.sectionIndex].tabs[state.tabIndex];
    }

    /**
     * Returns either next or previous tab index.
     * Returns -1 if there is no such tab found.
     *
     * @param  {String} direction "next" or "previous"
     * @return {Number}
     */
    function getSiblingTabIndex (direction) {
      var indexSearchFunction = direction === 'next' ? _.findIndex : _.findLastIndex;

      return indexSearchFunction(vm.sections[state.sectionIndex].tabs,
        function (tab, tabIndex) {
          var directionCondition = direction === 'next'
            ? tabIndex > state.tabIndex
            : tabIndex < state.tabIndex;

          return directionCondition && !tab.hidden;
        });
    }

    /**
     * Navigates to the previous step:
     * - if there is a previous tab in the same section, navigates to the previous tab
     * - if there is no previous tab in the current section - opens previous section
     */
    function goBack () {
      var previousTabIndex = getSiblingTabIndex('previous');

      if (previousTabIndex === -1) {
        openPreviousSection();
      } else {
        openActiveSectionTab(previousTabIndex);
      }
    }

    /**
     * Navigates to the next step:
     * - if there is a next tab in the same section, navigates to the next tab
     * - if there is no next tab in the current section - opens next section
     */
    function goNext () {
      var activeTab = getActiveTab();
      var nextTabIndex = getSiblingTabIndex('next');

      validateTab(activeTab);

      if (nextTabIndex === -1) {
        openNextSection();
      } else {
        openActiveSectionTab(nextTabIndex);
      }
    }

    /**
     * Indexes collection by a property name
     *
     * @param  {Array} collection
     * @param  {String} propertyName
     * @return {Object}
     */
    function indexPropertyByName (collection, propertyName) {
      return _.chain(collection)
        .flatMap(propertyName)
        .keyBy('name')
        .value();
    }

    /**
     * Initiates custom validators
     */
    function initCustomValidators () {
      watchTitleField();
    }

    /**
     * Initiates default values for all fields.
     * Skips the field if the current value is defined or the default value is not defined.
     */
    function initDefaultValues () {
      _.each(vm.fieldsIndexed, function (field) {
        if (field.value !== undefined || field.defaultValue === undefined) {
          return;
        }

        field.value = field.defaultValue;
      });
    }

    /**
     * Initiates the default view:
     * - expands the General section and leaves the Settings section collapsed;
     * - selects Basic Details settings tab.
     */
    function initDefaultView () {
      openSection(0);
    }

    /**
     * Initiates all fields watchers
     */
    function initFieldsWatchers () {
      watchAllowCarryForwardField();
      watchCarryForwardExpirySwitch();
      watchAccrualExpirationSwitch();
      watchLeaveCategorySelector();
    }

    /**
     * Initiates validators of a given field
     *
     * @param {Object} field
     */
    function initValidatorsForField (field) {
      $scope.$watch(function () {
        return field.value;
      }, function (newValue, oldValue) {
        var activeTab = getActiveTab();
        var wasActiveTabValidatedBefore = activeTab.valid !== undefined;

        if (newValue === oldValue) {
          return;
        }

        wasActiveTabValidatedBefore
          ? validateTab(activeTab)
          : validateField(field, oldValue);
      });
    }

    /**
     * Initiates validators for all fields
     */
    function initValidators () {
      _.each(vm.fieldsIndexed, function (field) {
        initValidatorsForField(field);
      });
    }

    /**
     * Marks first and last tabs in sections with according flags
     */
    function markFirstAndLastTabsInSections () {
      vm.sections.forEach(function (section) {
        var visibleTabs = section.tabs.filter(function (tab) {
          return !tab.hidden;
        });

        _.each(section.tabs, function (tab) {
          tab.first = tab.last = false;
        });

        _.first(visibleTabs).first = true;
        _.last(visibleTabs).last = true;
      });
    }

    /**
     * Fetches available colours and sets them to the component
     *
     * @return {Promise}
     */
    function loadAvailableColours () {
      return AbsenceType.getAvailableColours()
        .then(function (availableColours) {
          vm.availableColours = availableColours;
        });
    }

    /**
     * Fetches contact and sets them to the component
     *
     * @return {Promise}
     */
    function loadContacts () {
      return Contact.all()
        .then(function (contacts) {
          vm.contacts = contacts.list;
        });
    }

    /**
     * Fetches leave type categories and sets them to the component.
     * It only stores names, labels and icons mapped from the respected constant.
     *
     * @return {Promise}
     */
    function loadLeaveTypeCategories () {
      return OptionGroup.valuesOf('hrleaveandabsences_absence_type_category')
        .then(function (categories) {
          vm.leaveTypeCategories = categories.map(function (category) {
            return _.assign(_.pick(category, ['name', 'label']),
              { icon: leaveTypeCategoriesIcons[category.name] });
          });
        });
    }

    /**
     * Redirects to the leave types list page
     */
    function navigateToLeaveTypesList () {
      $window.location.href = CRM.url('civicrm/admin/leaveandabsences/types', {
        action: 'browse',
        reset: 1
      });
    }

    /**
     * Opens next section. If there are no more sections, then submits the form.
     */
    function openNextSection () {
      var isOnLastSection = state.sectionIndex === vm.sections.length - 1;

      if (isOnLastSection) {
        submit();

        return;
      }

      openSection(state.sectionIndex + 1);
    }

    /**
     * Opens previous section. If there are no sections behind, cancels form filling.
     */
    function openPreviousSection () {
      var isOnFirstSection = state.sectionIndex === 0;

      if (isOnFirstSection) {
        vm.loading = true;

        navigateToLeaveTypesList();

        return;
      }

      openSection(state.sectionIndex - 1);
    }

    /**
     * Opens a section by its index, collapses all other sections and,
     * if there are any tabs, opens the first tab.
     *
     * @param {Number} sectionIndex
     */
    function openSection (sectionIndex) {
      var sectionToOpen = vm.sections[sectionIndex];

      if (!sectionToOpen) {
        submit();

        return;
      }

      vm.sections.forEach(function (section) {
        section.active = false;
      });

      state.sectionIndex = sectionIndex;
      sectionToOpen.active = true;

      openActiveSectionTab(0);
    }

    /**
     * Opens a section tab by its index and collapses all other section tabs
     *
     * @param {Number} tabIndex
     */
    function openActiveSectionTab (tabIndex) {
      var activeSection = vm.sections[state.sectionIndex];

      activeSection.tabs.forEach(function (tab) {
        tab.active = false;
      });

      state.tabIndex = tabIndex;
      activeSection.tabs[tabIndex].active = true;
    }

    /**
     * Prepares some parameters for sending them to the backend.
     * - sets default entitlement to 0 if not provided
     * - flushes dependent fields' values
     * - deletes fields held for UX only
     *
     * @param {Object} params
     */
    function prepareParamsForSaving (params) {
      if (params.default_entitlement === '') {
        params.default_entitlement = '0';
      }

      if (!params.allow_carry_forward) {
        params.max_number_of_days_to_carry_forward = '';
      }

      if (!params.allow_carry_forward || !params.carry_forward_expiration_duration_switch) {
        params.carry_forward_expiration_duration = '';
        params.carry_forward_expiration_unit = '';
      }

      if (params.accrual_never_expire) {
        params.accrual_expiration_duration = '';
        params.accrual_expiration_unit = '';
      }

      delete params.carry_forward_expiration_duration_switch;
    }

    /**
     * Pre-processes parameters depending on the selected leave category.
     */
    function preProcessParamsDependingOnLeaveCategory (params) {
      _.each(defaultsByCategory[params.category], function (value, fieldName) {
        params[fieldName] = value;
      });
    }

    /**
     * Saves leave type by sending an API call to the backend
     * with all appropriate parameters.
     */
    function save () {
      var params = _.chain(vm.fieldsIndexed)
        .keyBy('name')
        .mapValues('value')
        .value();

      vm.loading = true;

      preProcessParamsDependingOnLeaveCategory(params);
      prepareParamsForSaving(params);
      AbsenceType.save(params)
        .then(navigateToLeaveTypesList)
        .catch(function (error) {
          notificationService.error('', error);
          openSection(0);

          vm.loading = false;
        });
    }

    /**
     * Sets the availability of the sections that follow the active section.
     * Also sets the availability of the "Next section" button for the active section.
     *
     * @param {Boolean} isDisabled
     */
    function setAvailabilityOfFollowingSections (isDisabled) {
      vm.sections[state.sectionIndex].disableNextSectionButton = isDisabled;

      vm.sections.slice(state.sectionIndex + 1).forEach(function (section) {
        section.disabled = isDisabled;
      });
    }

    /**
     * Sets custom tabs labels depending on the set category
     *
     * @param {String} category "leave", "sickness" etc
     */
    function setCustomTabNamesByCategory (category) {
      _.each(customTabNamesByCategory, function (categories, tabName) {
        tabsIndexed[tabName].label = categories[category];
      });
    }

    /**
     * Submits the whole wizard.
     * Validates all fields and, if all valid, saves the form.
     * If errors are found, navigates to the first found tab with errors.
     */
    function submit () {
      var sectionAndTabWithErrorsIndexes;

      validateAllSections();

      sectionAndTabWithErrorsIndexes = findIndexesOfFirstSectionAndTabWithErrors();

      if (sectionAndTabWithErrorsIndexes) {
        notificationService.error('', 'There are errors on the form. Please fix them before continuing.');
        openSection(sectionAndTabWithErrorsIndexes.sectionIndex);
        openActiveSectionTab(sectionAndTabWithErrorsIndexes.tabIndex);

        return;
      }

      save();
    }

    /**
     * Suppresses the not yet used leave categories by removing them from
     * the list that was made by loading option groups
     *
     * @TODO the suppressor must be completely removed once all leave categories are supported
     */
    function temporarilySuppressNotYetUsedLeaveCategories () {
      vm.leaveTypeCategories = _.filter(vm.leaveTypeCategories, function (category) {
        return !_.includes(['custom'], category.name);
      });
    }

    /**
     * Toggles fields depending on the leave category
     *
     * @param {String} category "leave", "sickness" etc
     */
    function toggleFieldsDependingOnLeaveCategory (category) {
      _.each(fieldsHiddenByCategory, function (categories, fieldName) {
        vm.fieldsIndexed[fieldName].hidden = categories[category];
      });
    }

    /**
     * Toggles the Settings section depending on the title field value
     */
    function toggleSettingsSectionAvailability () {
      var titleField = vm.fieldsIndexed.title;
      var disallowedToMoveToSettingsSection =
        !!(titleField.error || titleField.value === '' || titleField.validating);

      setAvailabilityOfFollowingSections(disallowedToMoveToSettingsSection);
    }

    /**
     * Toggles tabs depending on the leave category
     *
     * @param {String} category "leave", "sickness" etc
     */
    function toggleTabsDependingOnLeaveCategory (category) {
      _.each(tabsIndexed, function (tab) {
        tab.hidden = _.includes(hiddenTabsByCategory[category], tab.name);
      });
    }

    /**
     * Validates all sections (the whole wizard)
     */
    function validateAllSections () {
      vm.sections.forEach(function (section) {
        section.tabs.forEach(function (tab) {
          validateTab(tab);
        });
      });
    }

    /**
     * Validates a field
     *
     * @param {Object} field
     * @param {String} [oldValue]
     */
    function validateField (field, oldValue) {
      var fieldIsEmpty = field.value === '' || field.value === null;

      flushErrorForField(field);

      if (field.required && fieldIsEmpty && oldValue !== '') {
        field.error = 'This field is required';
      } else if (!fieldIsEmpty && field.validations) {
        field.validations.forEach(function (validation) {
          if (!validation.rule.test(field.value)) {
            field.error = validation.message;
          }
        });
      }
    }

    /**
     * Validates the title field:
     * - checks if the title is unique
     * - toggles the Settings section depending on the title
     */
    function validateTitleField () {
      checkIfTitleIsUnique()
        .then(toggleSettingsSectionAvailability);
    }

    /**
     * Validates all fields for a tab
     * and checks if the whole tab is filled in correctly
     *
     * @param {Object} tab
     */
    function validateTab (tab) {
      tab.fields.forEach(function (field) {
        validateField(field);
      });

      tab.valid = !_.find(tab.fields, function (field) {
        return !field.hidden && field.error;
      });
    }

    /**
     * Initiates a watcher over the "Expiry" field.
     * Toggles dependent fields on value change.
     */
    function watchAccrualExpirationSwitch () {
      $scope.$watch(function () {
        return vm.fieldsIndexed.accrual_never_expire.value;
      }, function (neverExpires) {
        vm.fieldsIndexed.accrual_expiration_duration.hidden = neverExpires;
      });
    }

    /**
     * Initiates a watcher over the "Allow carry forward" field.
     * Toggles dependent fields on value change.
     */
    function watchAllowCarryForwardField () {
      $scope.$watch(function () {
        return vm.fieldsIndexed.allow_carry_forward.value;
      }, function (allowCarryForward) {
        vm.fieldsIndexed.carry_forward_expiration_duration_switch.hidden = !allowCarryForward;
        vm.fieldsIndexed.max_number_of_days_to_carry_forward.hidden = !allowCarryForward;
      });
    }

    /**
     * Initiates a watcher over the "Carry forward expiry" field.
     * Toggles dependent fields on value change or if gets toggled.
     */
    function watchCarryForwardExpirySwitch () {
      $scope.$watch(function () {
        return vm.fieldsIndexed.carry_forward_expiration_duration_switch;
      }, function (expirySwitch) {
        vm.fieldsIndexed.carry_forward_expiration_duration.hidden =
          !expirySwitch.value || expirySwitch.hidden;
      }, true);
    }

    /**
     * Watches the leave category selector field:
     * - it toggles tabs
     */
    function watchLeaveCategorySelector () {
      $scope.$watch(function () {
        return vm.fieldsIndexed.category.value;
      }, function (category) {
        toggleTabsDependingOnLeaveCategory(category);
        toggleFieldsDependingOnLeaveCategory(category);
        setCustomTabNamesByCategory(category);
        markFirstAndLastTabsInSections();
      });
    }

    /**
     * Initiates a watches over "Title" field.
     * Watches for already used leave types titles.
     */
    function watchTitleField () {
      $scope.$watch(function () {
        return vm.fieldsIndexed.title.value;
      }, function () {
        validateTitleField();
      });
    }
  }
});

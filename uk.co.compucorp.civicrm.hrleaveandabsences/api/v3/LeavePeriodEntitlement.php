<?php

/**
 * LeavePeriodEntitlement.create API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_leave_period_entitlement_create_spec(&$spec) {
  // $spec['some_parameter']['api.required'] = 1;
}

/**
 * LeavePeriodEntitlement.create API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_leave_period_entitlement_create($params) {
  return _civicrm_api3_basic_create(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * LeavePeriodEntitlement.delete API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_leave_period_entitlement_delete($params) {
  return _civicrm_api3_basic_delete(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * LeavePeriodEntitlement.get API
 *
 * @param array $params
 * @return array API result descriptor
 * @throws API_Exception
 */
function civicrm_api3_leave_period_entitlement_get($params) {
  return _civicrm_api3_basic_get(_civicrm_api3_get_BAO(__FUNCTION__), $params);
}

/**
 * LeavePeriodEntitlement.getremainder API
 *
 * @param array $params
 *
 * @return array API result descriptor
 *
 * @throws CiviCRM_API3_Exception
 */
function civicrm_api3_leave_period_entitlement_getremainder($params) {
  $hasEntitlementID = !empty($params['entitlement_id']);
  $hasContactAndPeriodID = !empty($params['contact_id']) && !empty($params['period_id']);
  $hasContactOrPeriodID = !empty($params['contact_id']) || !empty($params['period_id']);
  if(($hasEntitlementID && $hasContactAndPeriodID) || (!$hasEntitlementID && !$hasContactAndPeriodID) || ($hasEntitlementID && $hasContactOrPeriodID)) {
    throw new InvalidArgumentException("You must include either the id of a specific entitlement, or both the contact and period id");
  }
  $results = CRM_HRLeaveAndAbsences_BAO_LeavePeriodEntitlement::getRemainder($params);
  return civicrm_api3_create_success($results);
}

/**
 * LeavePeriodEntitlement.getremainder API specification
 *
 * @param array $params
 *
 * @return void
 */
function _civicrm_api3_leave_period_entitlement_getremainder_spec(&$params) {
  $params['entitlement_id']['api.required'] = 0;
  $params['contact_id']['api.required'] = 0;
  $params['period_id']['api.required'] = 0;
  $params['include_future']['api.required'] = 0;
}

/**
 * LeavePeriodEntitlement.getbreakdown API
 *
 * @param array $params
 *
 * @return array API result descriptor
 *
 * @throws CiviCRM_API3_Exception
 */
function civicrm_api3_leave_period_entitlement_getbreakdown($params) {
  $hasEntitlementID = !empty($params['entitlement_id']);
  $hasContactAndPeriodID = !empty($params['contact_id']) && !empty($params['period_id']);
  $hasContactOrPeriodID = !empty($params['contact_id']) || !empty($params['period_id']);
  if(($hasEntitlementID && $hasContactOrPeriodID) || (!$hasEntitlementID && !$hasContactAndPeriodID)) {
    throw new InvalidArgumentException("You must include either the id of a specific entitlement, or both the contact and period id");
  }
  $results = CRM_HRLeaveAndAbsences_BAO_LeavePeriodEntitlement::getBreakdown($params);
  return civicrm_api3_create_success($results);
}

/**
 * LeavePeriodEntitlement.getbreakdown specification
 *
 * @param array $params
 *
 * @return void
 */
function _civicrm_api3_leave_period_entitlement_getbreakdown_spec(&$spec) {
  $spec['entitlement_id'] = [
    'name' => 'entitlement_id',
    'title' => 'Leave Period Entitlement ID',
    'type' => CRM_Utils_Type::T_INT,
    'api.required' => 0
  ];

  $spec['contact_id'] = [
    'name' => 'contact_id',
    'title' => 'Contact ID',
    'type' => CRM_Utils_Type::T_INT,
    'api.required' => 0
  ];

  $spec['period_id'] = [
    'name' => 'period_id',
    'title' => 'Absence Period ID',
    'type' => CRM_Utils_Type::T_INT,
    'api.required' => 0
  ];

  $spec['expired'] = [
    'name' => 'expired',
    'title' => 'Return expired only',
    'type' => CRM_Utils_Type::T_BOOLEAN,
    'api.required' => 0
  ];
}


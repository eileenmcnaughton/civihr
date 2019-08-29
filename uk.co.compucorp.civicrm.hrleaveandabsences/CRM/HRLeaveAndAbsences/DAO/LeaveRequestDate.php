<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /vagrant/hr-bugs-4002/sites/all/modules/civicrm/tools/extensions/civihr/uk.co.compucorp.civicrm.hrleaveandabsences/xml/schema/CRM/HRLeaveAndAbsences/LeaveRequestDate.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:087efe2a43739871f3c83526f9bf94a5)
 */

/**
 * Database access object for the LeaveRequestDate entity.
 */
class CRM_HRLeaveAndAbsences_DAO_LeaveRequestDate extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_hrleaveandabsences_leave_request_date';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Unique LeaveRequestDate ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * A date part of the Leave Request.
   *
   * @var date
   */
  public $date;

  /**
   * FK to LeaveRequest
   *
   * @var int unsigned
   */
  public $leave_request_id;

  /**
   * The type of this day, according to the values on the Leave Request Day Types Option Group
   *
   * @var string
   */
  public $type;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_hrleaveandabsences_leave_request_date';
    parent::__construct();
  }

  /**
   * Returns foreign keys and entity references.
   *
   * @return array
   *   [CRM_Core_Reference_Interface]
   */
  public static function getReferenceColumns() {
    if (!isset(Civi::$statics[__CLASS__]['links'])) {
      Civi::$statics[__CLASS__]['links'] = static ::createReferenceColumns(__CLASS__);
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'leave_request_id', 'civicrm_hrleaveandabsences_leave_request', 'id');
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'links_callback', Civi::$statics[__CLASS__]['links']);
    }
    return Civi::$statics[__CLASS__]['links'];
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'Unique LeaveRequestDate ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_request_date',
          'entity' => 'LeaveRequestDate',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveRequestDate',
          'localizable' => 0,
        ],
        'date' => [
          'name' => 'date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Date'),
          'description' => 'A date part of the Leave Request.',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_request_date',
          'entity' => 'LeaveRequestDate',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveRequestDate',
          'localizable' => 0,
        ],
        'leave_request_id' => [
          'name' => 'leave_request_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to LeaveRequest',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_request_date',
          'entity' => 'LeaveRequestDate',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveRequestDate',
          'localizable' => 0,
        ],
        'type' => [
          'name' => 'type',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Type'),
          'description' => 'The type of this day, according to the values on the Leave Request Day Types Option Group',
          'maxlength' => 512,
          'size' => CRM_Utils_Type::HUGE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_request_date',
          'entity' => 'LeaveRequestDate',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveRequestDate',
          'localizable' => 0,
          'pseudoconstant' => [
            'optionGroupName' => 'hrleaveandabsences_leave_request_day_type',
            'optionEditPath' => 'civicrm/admin/options/hrleaveandabsences_leave_request_day_type',
          ]
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'hrleaveandabsences_leave_request_date', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'hrleaveandabsences_leave_request_date', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [
      'unique_leave_request_date' => [
        'name' => 'unique_leave_request_date',
        'field' => [
          0 => 'date',
          1 => 'leave_request_id',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_hrleaveandabsences_leave_request_date::1::date::leave_request_id',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}

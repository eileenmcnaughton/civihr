<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /vagrant/hr-bugs-4002/sites/all/modules/civicrm/tools/extensions/civihr/uk.co.compucorp.civicrm.hrleaveandabsences/xml/schema/CRM/HRLeaveAndAbsences/LeaveBalanceChangeExpiryLog.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:c59182b74c4c98d54284ba16630e2b85)
 */

/**
 * Database access object for the LeaveBalanceChangeExpiryLog entity.
 */
class CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Unique LeaveBalanceChangeExpiryLog ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * The expired balance change ID
   *
   * @var int unsigned
   */
  public $balance_change_id;

  /**
   * The expired balance amount
   *
   * @var float
   */
  public $amount;

  /**
   * Expired Balance change source ID
   *
   * @var int unsigned
   */
  public $source_id;

  /**
   * Expired Balance change source type
   *
   * @var string
   */
  public $source_type;

  /**
   * The balance change expiry date
   *
   * @var date
   */
  public $expiry_date;

  /**
   * One of the values of the Leave Balance Type option group
   *
   * @var int unsigned
   */
  public $balance_type_id;

  /**
   * The Leave date of the expired balance change (i.e If it is a leave request balance change)
   *
   * @var date
   */
  public $leave_date;

  /**
   * The Leave Request ID linked to the expired balance change (i.e If it is a leave request balance change)
   *
   * @var int unsigned
   */
  public $leave_request_id;

  /**
   * The date and time this log was created
   *
   * @var datetime
   */
  public $created_date;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log';
    parent::__construct();
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
          'description' => 'Unique LeaveBalanceChangeExpiryLog ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'balance_change_id' => [
          'name' => 'balance_change_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'The expired balance change ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'amount' => [
          'name' => 'amount',
          'type' => CRM_Utils_Type::T_MONEY,
          'title' => ts('Amount'),
          'description' => 'The expired balance amount',
          'required' => TRUE,
          'precision' => [
            20,
            2
          ],
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'source_id' => [
          'name' => 'source_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'Expired Balance change source ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'source_type' => [
          'name' => 'source_type',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Source Type'),
          'description' => 'Expired Balance change source type',
          'required' => TRUE,
          'maxlength' => 20,
          'size' => CRM_Utils_Type::MEDIUM,
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'expiry_date' => [
          'name' => 'expiry_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Expiry Date'),
          'description' => 'The balance change expiry date',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'balance_type_id' => [
          'name' => 'balance_type_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'One of the values of the Leave Balance Type option group',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
          'pseudoconstant' => [
            'optionGroupName' => 'hrleaveandabsences_leave_balance_change_type',
            'optionEditPath' => 'civicrm/admin/options/hrleaveandabsences_leave_balance_change_type',
          ]
        ],
        'leave_date' => [
          'name' => 'leave_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Leave Date'),
          'description' => 'The Leave date of the expired balance change (i.e If it is a leave request balance change)',
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'leave_request_id' => [
          'name' => 'leave_request_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'The Leave Request ID linked to the expired balance change (i.e If it is a leave request balance change)',
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
        ],
        'created_date' => [
          'name' => 'created_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Created Date'),
          'description' => 'The date and time this log was created',
          'table_name' => 'civicrm_hrleaveandabsences_leave_balance_change_expiry_log',
          'entity' => 'LeaveBalanceChangeExpiryLog',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeaveBalanceChangeExpiryLog',
          'localizable' => 0,
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'hrleaveandabsences_leave_balance_change_expiry_log', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'hrleaveandabsences_leave_balance_change_expiry_log', $prefix, []);
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
    $indices = [];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}

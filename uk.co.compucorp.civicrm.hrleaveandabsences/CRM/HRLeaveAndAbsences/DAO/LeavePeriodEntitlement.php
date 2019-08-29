<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /vagrant/hr-bugs-4002/sites/all/modules/civicrm/tools/extensions/civihr/uk.co.compucorp.civicrm.hrleaveandabsences/xml/schema/CRM/HRLeaveAndAbsences/LeavePeriodEntitlement.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:53c6f5ef64a6b998c56f7ee3a45e8783)
 */

/**
 * Database access object for the LeavePeriodEntitlement entity.
 */
class CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_hrleaveandabsences_leave_period_entitlement';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Unique Leave Period Entitlement ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * FK to AbsencePeriod
   *
   * @var int unsigned
   */
  public $period_id;

  /**
   * FK to AbsenceType
   *
   * @var int unsigned
   */
  public $type_id;

  /**
   * FK to Contact (civicrm_contact)
   *
   * @var int unsigned
   */
  public $contact_id;

  /**
   * Indicates if the entitlement was overridden
   *
   * @var boolean
   */
  public $overridden;

  /**
   * The comment added by the user about the calculation for this entitlement
   *
   * @var text
   */
  public $comment;

  /**
   * FK to Contact. The contact that represents the user who made changes to this entitlement
   *
   * @var int unsigned
   */
  public $editor_id;

  /**
   * The date and time this entitlement was added/updated
   *
   * @var datetime
   */
  public $created_date;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_hrleaveandabsences_leave_period_entitlement';
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'period_id', 'civicrm_hrleaveandabsences_absence_period', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'type_id', 'civicrm_hrleaveandabsences_absence_type', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'contact_id', 'civicrm_contact', 'id');
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'editor_id', 'civicrm_contact', 'id');
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
          'description' => 'Unique Leave Period Entitlement ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'period_id' => [
          'name' => 'period_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to AbsencePeriod',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'type_id' => [
          'name' => 'type_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to AbsenceType',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'contact_id' => [
          'name' => 'contact_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to Contact (civicrm_contact)',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'overridden' => [
          'name' => 'overridden',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Overridden'),
          'description' => 'Indicates if the entitlement was overridden',
          'default' => 'false',
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'comment' => [
          'name' => 'comment',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => ts('Comment'),
          'description' => 'The comment added by the user about the calculation for this entitlement',
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'editor_id' => [
          'name' => 'editor_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'FK to Contact. The contact that represents the user who made changes to this entitlement',
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
          'localizable' => 0,
        ],
        'created_date' => [
          'name' => 'created_date',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Created Date'),
          'description' => 'The date and time this entitlement was added/updated',
          'table_name' => 'civicrm_hrleaveandabsences_leave_period_entitlement',
          'entity' => 'LeavePeriodEntitlement',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_LeavePeriodEntitlement',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'hrleaveandabsences_leave_period_entitlement', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'hrleaveandabsences_leave_period_entitlement', $prefix, []);
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
      'unique_entitlement' => [
        'name' => 'unique_entitlement',
        'field' => [
          0 => 'period_id',
          1 => 'contact_id',
          2 => 'type_id',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_hrleaveandabsences_leave_period_entitlement::1::period_id::contact_id::type_id',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}

<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /vagrant/hr-bugs-4002/sites/all/modules/civicrm/tools/extensions/civihr/uk.co.compucorp.civicrm.hrleaveandabsences/xml/schema/CRM/HRLeaveAndAbsences/WorkWeek.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:0a5704cf56bcf873fad2401e7c4652fb)
 */

/**
 * Database access object for the WorkWeek entity.
 */
class CRM_HRLeaveAndAbsences_DAO_WorkWeek extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_hrleaveandabsences_work_week';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Unique WorkWeek ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * Each Week of a Pattern has a unique and sequential number
   *
   * @var int unsigned
   */
  public $number;

  /**
   * The Work Pattern this Week belongs to
   *
   * @var int unsigned
   */
  public $pattern_id;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_hrleaveandabsences_work_week';
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
      Civi::$statics[__CLASS__]['links'][] = new CRM_Core_Reference_Basic(self::getTableName(), 'pattern_id', 'civicrm_hrleaveandabsences_work_pattern', 'id');
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
          'description' => 'Unique WorkWeek ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_work_week',
          'entity' => 'WorkWeek',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_WorkWeek',
          'localizable' => 0,
        ],
        'number' => [
          'name' => 'number',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Number'),
          'description' => 'Each Week of a Pattern has a unique and sequential number',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_work_week',
          'entity' => 'WorkWeek',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_WorkWeek',
          'localizable' => 0,
        ],
        'pattern_id' => [
          'name' => 'pattern_id',
          'type' => CRM_Utils_Type::T_INT,
          'description' => 'The Work Pattern this Week belongs to',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_work_week',
          'entity' => 'WorkWeek',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_WorkWeek',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'hrleaveandabsences_work_week', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'hrleaveandabsences_work_week', $prefix, []);
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

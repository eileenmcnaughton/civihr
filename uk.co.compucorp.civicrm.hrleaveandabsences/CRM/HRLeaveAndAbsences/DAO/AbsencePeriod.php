<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2018
 *
 * Generated from /vagrant/hr-bugs-4002/sites/all/modules/civicrm/tools/extensions/civihr/uk.co.compucorp.civicrm.hrleaveandabsences/xml/schema/CRM/HRLeaveAndAbsences/AbsencePeriod.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:f0082c6262472d69b89ca379217bae9b)
 */

/**
 * Database access object for the AbsencePeriod entity.
 */
class CRM_HRLeaveAndAbsences_DAO_AbsencePeriod extends CRM_Core_DAO {

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  static $_tableName = 'civicrm_hrleaveandabsences_absence_period';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  static $_log = TRUE;

  /**
   * Unique AbsencePeriod ID
   *
   * @var int unsigned
   */
  public $id;

  /**
   * The AbsencePeriod title. There cannot be more than one entity with the same title
   *
   * @var string
   */
  public $title;

  /**
   * The date this Absence Period starts
   *
   * @var date
   */
  public $start_date;

  /**
   * The date this Absence Period ends
   *
   * @var date
   */
  public $end_date;

  /**
   * The weight value is used to order the types on a list
   *
   * @var int unsigned
   */
  public $weight;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_hrleaveandabsences_absence_period';
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
          'description' => 'Unique AbsencePeriod ID',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_absence_period',
          'entity' => 'AbsencePeriod',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_AbsencePeriod',
          'localizable' => 0,
        ],
        'title' => [
          'name' => 'title',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => ts('Title'),
          'description' => 'The AbsencePeriod title. There cannot be more than one entity with the same title',
          'required' => TRUE,
          'maxlength' => 127,
          'size' => CRM_Utils_Type::HUGE,
          'table_name' => 'civicrm_hrleaveandabsences_absence_period',
          'entity' => 'AbsencePeriod',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_AbsencePeriod',
          'localizable' => 0,
        ],
        'start_date' => [
          'name' => 'start_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('Start Date'),
          'description' => 'The date this Absence Period starts',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_absence_period',
          'entity' => 'AbsencePeriod',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_AbsencePeriod',
          'localizable' => 0,
        ],
        'end_date' => [
          'name' => 'end_date',
          'type' => CRM_Utils_Type::T_DATE,
          'title' => ts('End Date'),
          'description' => 'The date this Absence Period ends',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_absence_period',
          'entity' => 'AbsencePeriod',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_AbsencePeriod',
          'localizable' => 0,
        ],
        'weight' => [
          'name' => 'weight',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Weight'),
          'description' => 'The weight value is used to order the types on a list',
          'required' => TRUE,
          'table_name' => 'civicrm_hrleaveandabsences_absence_period',
          'entity' => 'AbsencePeriod',
          'bao' => 'CRM_HRLeaveAndAbsences_DAO_AbsencePeriod',
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
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'hrleaveandabsences_absence_period', $prefix, []);
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
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'hrleaveandabsences_absence_period', $prefix, []);
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
      'unique_absence_period' => [
        'name' => 'unique_absence_period',
        'field' => [
          0 => 'title',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_hrleaveandabsences_absence_period::1::title',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}

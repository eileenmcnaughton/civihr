<?php

use CRM_HRLeaveAndAbsences_BAO_PublicHoliday as PublicHoliday;
use CRM_HRLeaveAndAbsences_Test_Fabricator_PublicHoliday as PublicHolidayFabricator;
use CRM_HRLeaveAndAbsences_Test_Fabricator_AbsencePeriod as AbsencePeriodFabricator;
use CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException as InvalidPublicHolidayException;

/**
 * Class CRM_HRLeaveAndAbsences_BAO_PublicHolidayTest
 *
 * @group headless
 */
class CRM_HRLeaveAndAbsences_BAO_PublicHolidayTest extends BaseHeadlessTest {

  /**
   * @expectedException CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException
   * @expectedExceptionMessage Date value is required
   */
  public function testPublicHolidayDateShouldNotBeEmpty() {
    PublicHoliday::create([
      'title' => 'Public holiday 1',
    ]);
  }

  /**
   * @expectedException CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException
   * @expectedExceptionMessage Date value should be valid
   */
  public function testPublicHolidayDateShouldBeValid() {
    PublicHoliday::create([
      'title' => 'Public holiday 1',
      'date' => '2016-06-01',
    ]);
  }

  /**
   * @expectedException CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException
   * @expectedExceptionMessage Another Public Holiday with the same date already exists
   */
  public function testPublicHolidayDateShouldBeUnique() {
    // We're not allowed to create Public Holidays outside
    // an Absence Period dates, so we need to have one on the database
    AbsencePeriodFabricator::fabricate([
      'start_date' => CRM_Utils_Date::processDate('now'),
      'end_date' => CRM_Utils_Date::processDate('+1 day'),
    ]);

    PublicHoliday::create([
      'title' => 'Public holiday 1',
      'date' => CRM_Utils_Date::processDate('now'),
    ]);
    PublicHoliday::create([
      'title' => 'Public holiday 2',
      'date' => CRM_Utils_Date::processDate('now'),
    ]);
  }

  /**
   * @expectedException CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException
   * @expectedExceptionMessage Title value is required
   */
  public function testPublicHolidayTitleShouldNotBeEmpty() {
    PublicHoliday::create([
      'date' => CRM_Utils_Date::processDate('2016-07-01'),
    ]);
  }

  /**
   * @expectedException CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException
   * @expectedException The date cannot be in the past
   */
  public function testCannotBeCreatedWithADateInThePast() {
    PublicHolidayFabricator::fabricate([
      'date' => CRM_Utils_Date::processDate('2016-01-02')
    ]);
  }

  public function testCannotChangeDateToOneInThePast() {
    $publicHoliday = PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('+1 day')
    ]);

    try {
      PublicHolidayFabricator::fabricate([
        'id' => $publicHoliday->id,
        'date' => CRM_Utils_Date::processDate('-1 day')
      ]);
    } catch(Exception $e) {
      $this->assertInstanceOf(InvalidPublicHolidayException::class, $e);
      $this->assertEquals('The date cannot be in the past', $e->getMessage());
      return;
    }

    $this->fail('Expected an exception, but the public holiday was updated with to a date in the past');
  }

  public function testCannotChangeTheDateOfAPastPublicHoliday() {
    $publicHoliday = PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-01-02')
    ]);

    try {
      PublicHoliday::create([
        'id' => $publicHoliday->id,
        'date' => CRM_Utils_Date::processDate('+1 day')
      ]);
    } catch(Exception $e) {
      $this->assertInstanceOf(InvalidPublicHolidayException::class, $e);
      $this->assertEquals('You cannot change the date of a past public holiday', $e->getMessage());
      return;
    }

    $this->fail('Expected an exception, but the public holiday was updated with to a date in the past');
  }

  public function testCanChangeTheTitleOfAPastPublicHoliday() {
    AbsencePeriodFabricator::fabricate([
      'start_date' => CRM_Utils_Date::processDate('2016-01-01'),
      'end_date' => CRM_Utils_Date::processDate('2016-01-02'),
    ]);

    $publicHoliday = PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday',
      'date' => CRM_Utils_Date::processDate('2016-01-02')
    ]);

    PublicHoliday::create([
      'id' => $publicHoliday->id,
      'title' => 'Updated'
    ]);
  }

  public function testCannotDisableAnEnabledPastPublicHoliday() {
    $publicHoliday = PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday',
      'date' => CRM_Utils_Date::processDate('2016-01-02')
    ]);

    try {
      PublicHoliday::create([
        'id' => $publicHoliday->id,
        'is_active' => false
      ]);
    } catch(Exception $e) {
      $this->assertInstanceOf(InvalidPublicHolidayException::class, $e);
      $this->assertEquals('You cannot disable/enable a past public holiday', $e->getMessage());
      return;
    }

    $this->fail('Expected an exception, but the public holiday was disabled');
  }

  public function testCannotEnableADisabledPastPublicHoliday() {
    $publicHoliday = PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday',
      'date' => CRM_Utils_Date::processDate('2016-01-02'),
      'is_active' => false,
    ]);

    try {
      PublicHoliday::create([
        'id' => $publicHoliday->id,
        'is_active' => true
      ]);
    } catch(Exception $e) {
      $this->assertInstanceOf(InvalidPublicHolidayException::class, $e);
      $this->assertEquals('You cannot disable/enable a past public holiday', $e->getMessage());
      return;
    }

    $this->fail('Expected an exception, but the public holiday was disabled');
  }

  /**
   * @expectedException CRM_HRLeaveAndAbsences_Exception_InvalidPublicHolidayException
   * @expectedExceptionMessage The date cannot be outside the existing absence periods
   */
  public function testCannotCreateAPublicHolidayForADateNotOverlappingAnyAbsencePeriod() {
    PublicHoliday::create([
      'title' => 'Holiday',
      'date' => CRM_Utils_Date::processDate('+1 day')
    ]);
  }

  public function testGetNumberOfPublicHolidaysForPeriod() {
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-01-01')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-03-25')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-05-02')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-05-30')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-08-29')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-12-25')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-12-26')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-12-27')
    ]);

    $this->assertEquals(
      8,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-01-01', '2016-12-31')
    );

    $this->assertEquals(
      1,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-01-01', '2016-01-31')
    );

    $this->assertEquals(
      0,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-02-01', '2016-02-29')
    );

    $this->assertEquals(
      1,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-02-02', '2016-03-31')
    );

    $this->assertEquals(
      3,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-04-01', '2016-08-30')
    );

    $this->assertEquals(
      3,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-08-30', '2016-12-28')
    );
  }

  public function testGetNumberOfPublicHolidaysDoesntCountNonActiveHolidays()
  {
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-02-01')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date'      => CRM_Utils_Date::processDate('2016-07-25'),
      'is_active' => FALSE
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-04-02')
    ]);

    $this->assertEquals(
      2,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-02-01', '2016-12-31')
    );
  }

  public function testGetNumberOfPublicHolidaysCanExcludeWeekendsFromCount()
  {
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-02-01')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-06-04') // Saturday
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-04-13')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2016-05-15') // Sunday
    ]);

    $this->assertEquals(
      2,
      PublicHoliday::getNumberOfPublicHolidaysForPeriod('2016-02-01', '2016-12-31', true)
    );
  }

  public function testGetNumberOfPublicHolidaysForCurrentPeriod()
  {
    AbsencePeriodFabricator::fabricate([
      'start_date' => CRM_Utils_Date::processDate('first day of January'),
      'end_date' => CRM_Utils_Date::processDate('last day of December'),
    ]);

    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('2015-01-01')
    ]);

    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('first monday of January')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('first tuesday of February')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('last thursday of May')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('last monday of May')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('last friday of December')
    ]);

    $this->assertEquals(
      5,
      PublicHoliday::getNumberOfPublicHolidaysForCurrentPeriod()
    );
  }

  public function testGetNumberOfPublicHolidaysForCurrentPeriodCanExcludeWeekendsFromCount()
  {
    AbsencePeriodFabricator::fabricate([
      'start_date' => CRM_Utils_Date::processDate('first day of January'),
      'end_date' => CRM_Utils_Date::processDate('last day of December'),
    ]);

    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('first monday of January')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'date' => CRM_Utils_Date::processDate('first sunday of February')
    ]);

    $excludeWeekends = true;
    $this->assertEquals(
      1,
      PublicHoliday::getNumberOfPublicHolidaysForCurrentPeriod($excludeWeekends)
    );
  }

  public function testGetPublicHolidaysForPeriod() {
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 1',
      'date' => CRM_Utils_Date::processDate('2016-01-01')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 2',
      'date' => CRM_Utils_Date::processDate('2016-03-25')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 3',
      'date' => CRM_Utils_Date::processDate('2016-12-26')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 4',
      'date' => CRM_Utils_Date::processDate('2016-12-27')
    ]);

    $publicHolidays = PublicHoliday::getPublicHolidaysForPeriod('2016-01-01', '2016-12-31');
    $this->assertCount(4, $publicHolidays);
    $this->assertEquals('Holiday 1', $publicHolidays[0]->title);
    $this->assertEquals('Holiday 2', $publicHolidays[1]->title);
    $this->assertEquals('Holiday 3', $publicHolidays[2]->title);
    $this->assertEquals('Holiday 4', $publicHolidays[3]->title);


    $publicHolidays = PublicHoliday::getPublicHolidaysForPeriod('2016-01-01', '2016-01-31');
    $this->assertCount(1, $publicHolidays);
    $this->assertEquals('Holiday 1', $publicHolidays[0]->title);

    $publicHolidays = PublicHoliday::getPublicHolidaysForPeriod('2016-02-01', '2016-02-29');
    $this->assertCount(0, $publicHolidays);

    $publicHolidays = PublicHoliday::getPublicHolidaysForPeriod('2016-12-01', '2016-12-29');
    $this->assertCount(2, $publicHolidays);
    $this->assertEquals('Holiday 3', $publicHolidays[0]->title);
    $this->assertEquals('Holiday 4', $publicHolidays[1]->title);
  }

  public function testGetPublicHolidaysForPeriodShouldOnlyReturnActivePublicHolidays() {
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 1',
      'date' => CRM_Utils_Date::processDate('2016-01-01'),
      'is_active' => false,
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 2',
      'date' => CRM_Utils_Date::processDate('2016-01-02')
    ]);
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 3',
      'date' => CRM_Utils_Date::processDate('2016-01-03')
    ]);

    $publicHolidays = PublicHoliday::getPublicHolidaysForPeriod('2016-01-01', '2016-01-31');
    $this->assertCount(2, $publicHolidays);
    $this->assertEquals('Holiday 2', $publicHolidays[0]->title);
    $this->assertEquals('Holiday 3', $publicHolidays[1]->title);
  }

  public function testGetPublicHolidaysForPeriodCanExcludeWeekends() {
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 1',
      'date' => CRM_Utils_Date::processDate('2016-01-01'),
    ]);
    // 2016-01-02 is a Saturday
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 2',
      'date' => CRM_Utils_Date::processDate('2016-01-02')
    ]);
    // 2016-01-02 is a Sunday
    PublicHolidayFabricator::fabricateWithoutValidation([
      'title' => 'Holiday 3',
      'date' => CRM_Utils_Date::processDate('2016-01-03')
    ]);

    $excludeWeekends = true;
    $publicHolidays = PublicHoliday::getPublicHolidaysForPeriod('2016-01-01', '2016-01-31', $excludeWeekends);
    $this->assertCount(1, $publicHolidays);
    $this->assertEquals('Holiday 1', $publicHolidays[0]->title);
  }

}

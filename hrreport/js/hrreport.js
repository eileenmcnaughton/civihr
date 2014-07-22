// Copyright CiviCRM LLC 2013. See http://civicrm.org/licensing
(function ($, _) {
  $(document).on('crmLoad', function() {
    //change heading consisting 'Case' replacing with 'Assignment' 
    $('.crm-report-instanceList-form-block .crm-accordion_Case-accordion .crm-accordion-header').html('Assignment Reports');
    $('.crm-report-templateList-form-block .crm-accordion_Case-accordion .crm-accordion-header').html('Assignment Report Templates');
    //change templates name consisting 'Case' replacing with 'Assignment'
    $('#Case #row_1 .crm-report-templateList-title a strong, #Case #row_10 .crm-report-templateList-title a strong').html('Assignment Summary Report');
    $('#Case #row_2 .crm-report-templateList-title a strong, #Case #row_11 .crm-report-templateList-title a strong').html('Assignment Time Spent Report');
    $('#Case #row_4 .crm-report-templateList-title a strong, #Case #row_13 .crm-report-templateList-title a strong').html('Assignment Detail Report');
    //change text on anchor link
    $('.icon').parent('span:contains("New Case Report")').html('<div class="icon add-icon"></div>New Assignment Report');
    //change information text
    $("span:contains('New Assignment Report')").closest('div.action-link').next('.crm-content-block').children('.messages').html('<div class="icon inform-icon"></div>' + 'No Assignment reports have been created. You can create reports by selecting from the ' + '<a href="/webtask/civicrm/report/template/list?reset=1&compid=7">list of report templates here.</a>'); 
  });
}(CRM.$, CRM._));

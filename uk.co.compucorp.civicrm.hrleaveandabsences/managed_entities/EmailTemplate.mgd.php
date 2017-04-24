<?php

return [
  [
    'name' => 'Email Template: Leave Request',
    'entity' => 'MessageTemplate',
    'params' => [
      'version' => 3,
      'msg_title' => 'CiviHR Leave Request Notification',
      'msg_subject' => 'Leave Request',
      'msg_text' => 'CiviHR Leave Request Leave Request Type{ts}Status:{/ts}{$leaveStatus}{ts}Staff Member:{/ts}{contact.display_name}{if $leaveRequest->from_date eq $leaveRequest->to_date}{ts}Date:{/ts}{$fromDate}{$fromDateType}{else}{ts}From Date:{/ts}{$fromDate}{$fromDateType}{ts}To Date:{/ts}{$toDate}{$toDateType}{/if}View This Request{if $leaveComments}Request Comments{foreach from=$leaveComments item=value key=label}{$value.commenter}:{$value.created_at}{$value.text}{/foreach}{/if}{if $leaveFiles}Other files recorded on this request{foreach from=$leaveFiles item=value key=label}{$value.name}: Added on{$value.upload_date}{/foreach}{/if}',
      'msg_html' => '<html><head><title></title></head><body><h3>CiviHR Leave Request</h3><p><strong>Leave Request Type</strong></p><table><tbody><tr><td>{ts}Status:{/ts}</td><td>{$leaveStatus}</td></tr><tr><td>{ts}Staff Member:{/ts}</td><td>{contact.display_name}</td></tr>{if $leaveRequest->from_date eq $leaveRequest->to_date}<tr><td>{ts}Date:{/ts}</td><td>{$fromDate}{$fromDateType}</td></tr>{else}<tr><td>{ts}From Date:{/ts}</td><td>{$fromDate}{$fromDateType}</td></tr><tr><td>{ts}To Date:{/ts}</td><td>{$toDate}{$toDateType}</td></tr>{/if}</tbody></table><p><a href="{$leaveRequestLink}">View This Request</a></p>{if $leaveComments}<p><strong>Request Comments</strong></p><table border="0" cellpadding="1" cellspacing="1" style="width: 700px;"><tbody>{foreach from=$leaveComments item=value key=label}<tr><td>{$value.commenter}:{$value.created_at}</td></tr><tr><td>{$value.text}</td></tr>{/foreach}</tbody></table>{/if}<p></p>{if $leaveFiles}<p><b>Other files recorded on this request</b></p><table border="0" cellpadding="1" cellspacing="1" style="width: 700px";><tbody>{foreach from=$leaveFiles item=value key=label}<tr><td>{$value.name}: Added on{$value.upload_date}</td></tr>{/foreach}</tbody></table>{/if}</body></html>',
      'is_reserved' => 1
    ],
  ],
  [
    'name' => 'Email Template: TOIL Request',
    'entity' => 'MessageTemplate',
    'params' => [
      'version' => 3,
      'msg_title' => 'CiviHR TOIL Request Notification',
      'msg_subject' => 'TOIL Request',
      'msg_text' =>   'CiviHR TOIL Request Leave Request Type{ts}Status:{/ts}{$leaveStatus}{ts}Staff Member:{/ts}{contact.display_name}{if $leaveRequest->from_date eq $leaveRequest->to_date}{ts}Date:{/ts}{$fromDate}{else}{ts}From Date:{/ts}{$fromDate}{ts}To Date:{/ts}{$toDate}{/if}{ts}No. TOIL Days Requested{/ts}{$leaveRequest->toil_to_accrue}{if $leaveRequest->toil_to_accrue > 1}days{else}day{/if}View This Request{if $leaveComments}Request Comments{foreach from=$leaveComments item=value key=label}{$value.commenter}:{$value.created_at}{$value.text}{/foreach}{/if}{if $leaveFiles}Other files recorded on this request{foreach from=$leaveFiles item=value key=label}{$value.name}: Added on{$value.upload_date}{/foreach}{/if}',
      'msg_html' => '<html><head><title></title></head><body><h3>CiviHR TOIL Request</h3><p><strong>Leave Request Type</strong></p><table><tbody><tr><td>{ts}Status:{/ts}</td><td>{$leaveStatus}</td></tr><tr><td>{ts}Staff Member:{/ts}</td><td>{contact.display_name}</td></tr>{if $leaveRequest->from_date eq $leaveRequest->to_date}<tr><td>{ts}Date:{/ts}</td><td>{$fromDate}</td></tr>{else}<tr><td>{ts}From Date:{/ts}</td><td>{$fromDate}</td></tr><tr><td>{ts}To Date:{/ts}</td><td>{$toDate}</td></tr>{/if}<tr><td>{ts}No. TOIL Days Requested{/ts}</td><td>{$leaveRequest->toil_to_accrue}{if $leaveRequest->toil_to_accrue > 1}days{else}day{/if}</td></tr></tbody></table><p><a href="{$leaveRequestLink}">View This Request</a></p>{if $leaveComments}<p><strong>Request Comments</strong></p><table border="0" cellpadding="1" cellspacing="1" style="width: 700px;"><tbody>{foreach from=$leaveComments item=value key=label}<tr><td>{$value.commenter}:{$value.created_at}</td></tr><tr><td>{$value.text}</td></tr>{/foreach}</tbody></table>{/if}<p></p>{if $leaveFiles}<p><b>Other files recorded on this request</b></p><table border="0" cellpadding="1" cellspacing="1" style="width: 700px";><tbody>{foreach from=$leaveFiles item=value key=label}<tr><td>{$value.name}: Added on{$value.upload_date}</td></tr>{/foreach}</tbody></table>{/if}</body></html>',
      'is_reserved' => 1
    ],
  ],
  [
    'name' => 'Email Template: Sickness Request',
    'entity' => 'MessageTemplate',
    'params' => [
      'version' => 3,
      'msg_title' => 'CiviHR Sickness Record Notification',
      'msg_subject' => 'Sickness Request',
      'msg_text' =>   'CiviHR Sickness Record Sickness Request Type Name{ts}Status:{/ts}{$leaveStatus}{ts}Staff Member:{/ts}{contact.display_name}{if $leaveRequest->from_date eq $leaveRequest->to_date}{ts}Date:{/ts}{$fromDate}{$fromDateType}{else}{ts}From Date:{/ts}{$fromDate}{$fromDateType}{ts}To Date:{/ts}{$toDate}{$toDateType}{/if}Additional Details:The Reason{foreach from=$sicknessReasons item=value key=id}{if $id eq $leaveRequest->sickness_reason}{$value}{/if}{/foreach}{if $leaveRequiredDocuments}{foreach from=$sicknessRequiredDocuments item=value key=id}{if in_array($id, $leaveRequiredDocuments)}{$value}{/if}{/foreach}{/if}{if $leaveComments}Request Comments{foreach from=$leaveComments item=value key=label}{$value.commenter}:{$value.created_at}{$value.text}{/foreach}{/if}{if $leaveFiles}Other files recorded on this request{foreach from=$leaveFiles item=value key=label}{$value.name}: Added on{$value.upload_date}{/foreach}{/if}',
      'msg_html' =>   '<html><head><title></title></head><body><h3>CiviHR Sickness Record</h3><p><strong>Sickness Request Type Name</strong></p><table><tbody><tr><td>{ts}Status:{/ts}</td><td>{$leaveStatus}</td></tr><tr><td>{ts}Staff Member:{/ts}</td><td>{contact.display_name}</td></tr>{if $leaveRequest->from_date eq $leaveRequest->to_date}<tr><td>{ts}Date:{/ts}</td><td>{$fromDate}{$fromDateType}</td></tr>{else}<tr><td>{ts}From Date:{/ts}</td><td>{$fromDate}{$fromDateType}</td></tr><tr><td>{ts}To Date:{/ts}</td><td>{$toDate}{$toDateType}</td></tr>{/if}</tbody></table><p>Additional Details:</p>The Reason: <table border="0" cellpadding="1" cellspacing="1" style="width: 700px;"><tbody>{foreach from=$sicknessReasons item=value key=id}<tr><td><input type="checkbox"{if $id eq $leaveRequest->sickness_reason}checked{/if}>{$value}</td></tr>{/foreach}</tbody></table>{if $leaveRequiredDocuments}Documents: <table border="0" cellpadding="1" cellspacing="1" style="width: 700px;"><tbody>{foreach from=$sicknessRequiredDocuments item=value key=id}<tr><td><input type="checkbox"{if in_array($id, $leaveRequiredDocuments)}checked{/if}>{$value}</td></tr>{/foreach}</tbody></table>{/if}<p><a href="{$leaveRequestLink}">View This Request</a></p>{if $leaveComments}<p><strong>Request Comments</strong></p><table border="0" cellpadding="1" cellspacing="1" style="width: 700px;"><tbody>{foreach from=$leaveComments item=value key=label}<tr><td>{$value.commenter}:{$value.created_at}</td></tr><tr><td>{$value.text}</td></tr>{/foreach}</tbody></table>{/if}<p></p>{if $leaveFiles}<p><b>Other files recorded on this request</b></p><table border="0" cellpadding="1" cellspacing="1" style="width: 700px";><tbody>{foreach from=$leaveFiles item=value key=label}<tr><td>{$value.name}: Added on{$value.upload_date}</td></tr>{/foreach}</tbody></table>{/if}</body></html>',
      'is_reserved' => 1
    ],
  ]
];

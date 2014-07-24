# Intent SMS (Push API)
`intent=sms` is the default intent, which sends SMS to the intended recipient. 

## Required parameters

###`client_id`  
    supplied during account signup  

###`username`
    supplied during account signup  

###`password`
    supplied during account signup  

###`to`
    recipient number  
    Multiple recipients can be supplied, separating each recipient by comma `,`

###`text`
    message to be sent  

## Optional Parameters

###`intent=sms`
    sms is the default intent, therefore is an optional parameter.

###`from`
    required only if mulitple shortcodes are assigned to an account  

###`identity`
    required only if multiple alphanumeric sources are assigned to an account  

###`subaccount`
    Can be used for reporting purpose. This value will be stored in logs as it is.  
__Recommended usage__ : If there are multiple clients or sub-ordinates which use single API, `subaccount` parameter can be used to isolate between different sub-ordinates

###`tag`
    Can be used for reporting purpose. This value will be stored in logs as it is.
__Recommended usage__: If any push list can be identified as a batch of recipients, `tag` can be used to group a list of requests made to the system.



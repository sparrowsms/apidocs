For signup or account request visit [api.sparrowsms.com](http://api.sparrowsms.com/).

# API Endpoints  
Sparrow SMS receives requests via a single standard endpoint as below:  
__URL__ : [api.sparrowsms.com/call_in.php](http://api.sparrowsms.com/call_in.php)  
_(#deprecated - will be removed very soon.)_ 

__URL__ : [api.sparrowsms.com/v1](http://api.sparrowsms.com/v1)  
   _(#recommended)_

# Intents
Intents are the services available via the Sparrow SMS API endpoint. Each intent is uniquely identified by the `intent` parameter supplied during request.

Following intents are available currently.  
### `	` - ?intent=sms  
Send SMS to the intended recipient  
default intent. (if intent parameter is not supplied, it is assumed to be sms intent)  
[check documentation for this intent](/intent_sms)

### `	` - ?intent=credits  
Check available, remaining credits and expiry date for the credits [check documentation for this intent](/intent_credits)

### `	` - ?intent=simulate _(proposed)_  
Do no send the actual request, simulate. (will generate `curl` commands)

### `	` - ?intent=topup _(proposed)_  
Send a topup request with an the topup amount.
 

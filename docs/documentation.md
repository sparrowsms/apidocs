# Sparrow SMS API Documentation  
`Last updated - 2014.06.04`

For signup or account request visit [api.sparrowsms.com](http://api.sparrowsms.com/).

## API Endpoint (MT _aka._ Outgoing)

__URL__ : [api.sparrowsms.com/call_in.php](http://api.sparrowsms.com/call_in.php)  
_(#deprecated)_

__URL__ : [api.sparrowsms.com/v1](http://api.sparrowsms.com/v1)  
   _(#revised)_
  

## Required parameters

###`client_id`
    supplied during account signup  

###`username`
	supplied during account signup  

###`password`
	supplied during account signup  

###`to`
	recipient number  

###`text`
	message to be sent  

## Optional Parameters
###`from`
	required only if mulitple shortcodes are assigned to an account  

###`identity`
	required only if multiple alphanumeric sources are assigned to an account  

###`subaccount`
	Can be used for reporting purpose. This value will be stored in logs as it is.  

###`tag`
	Can be used for reporting purpose. This value will be stored in logs as it is.



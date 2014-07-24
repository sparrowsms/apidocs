# Examples (`intent=sms`)
As explained earlier, `intent=sms` is the default intent and is optional parameter. Following are the examples of different cases for `sms` intent

## Basic Request
    curl -s 'http://api.sparrowsms.com/v1' -d 'client_id=demo&username=demo&password=demo&to=98xxxxxxxx&text=I+am+testing+Sparrow+SMS+API.'

### Expected parameters are :  

    - client_id
    - username
    - password
    - to
    - text

## If mutiple shortcodes / routes provided to your account
    curl -s 'http://api.sparrowsms.com/v1' -d 'client_id=demo&username=demo&password=demo&from=5001&to=98xxxxxxxx&text=I+am+testing+Sparrow+SMS+API.'

### Expected parameters are :

    - client_id
    - username
    - password
    - to
    - text
    - from

## If your account has multiple alphanumeric identities allocated

### Expected Parameters : 
    
    client_id
    username
    password
    to
    text
    identity


## If any system is unable to submit client_id parameter
Join the `client_id` and `username` parameters with a `colon : ` and supply as `username`

For example: if `client_id` = `apisignup`, and `username` = `namaste`
replace the `username` as `apisignup:namaste` and make the request. Remove the `client_id` parameter from the request.
    
    curl -s 'http://api.sparrowsms.com/v1' -d 'username=apisignup:namaste&password=demo&to=98xxxxxxxx&text=I+am+testing+Sparrow+SMS+API.'

### Expected Parameters : 
    
    username as client_id:username (combined)
    password

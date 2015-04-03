# Receive SMS / Incoming / Pull / MO (Mobile Originated)

##Shortcode
Shortcode is four digit number to which user can send SMS from any telecom. Benefits of Shortcodes are:  
1. Easy to remember  
2. Provides direct connectivity to Telecom  
3. Shortcode can have different tarrifs like (Rs. 1-5)  

## Keyword
First word of SMS sent by user is Keyword, it is used to identify the action / service requested. 

## Sub Keyword
Second Keyword of SMS sent by user is called Sub Keyword. Its optional and depends upon the campaign


## Parameters

**_Settings_**
```

    URL           : Public URL where the incoming SMS has to be forwarded.
    Keyword       : Keyword that has to be forwarded.
    Shortcode     : Shortcode to which, user has to send SMS.
    Default Reply : Default response that has to be sent to user, 
                    incase request to url fail.

```

**_Request_**

```

    GET request is sent to the URL provided with following arguments:

    from    : Subscribers number sending SMS.
    to      : Shortcode to which subscriber has sent SMS.
    text    : Complete SMS sent by user.
    keyword : Keyword of SMS sent.


```

## Response
URL must process the request and send text response of maximum 160 characters with status code 200 or 202. Incase of any other response code, default reply will be sent to user as SMS reply.

[**Proceed to examples**](/examples_incoming/)
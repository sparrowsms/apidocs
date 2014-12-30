# Send SMS / Outgoing / Push / MT (Mobile Terminated)


## Supported HTTP request methods:
```

    GET
    POST

```

## Method
```

    /sms/

```
## Parameters

**_Mandatory Fields_**
```

    token : Token generated from our website.
    from  : It should be the identity provided to you.
    to    : Comma Separated 10-digit mobile numbers.
    text  : SMS Message to be sent.

```

**_Optional Fields_**
```

```
## Responses

### Valid Response 

`Status Code: 200`

**Response Message: **

```

    {
        "count": number_of_sms_sent, 
        "response_code": 200,
        "response": "number_of_sms_sent mesages has been queued for delivery"
    }

```

### Invalid Response 

`Status Code: 403`

**Error Messages: **

```

    {"response_code":1000,"response":"A required field is missing"}
    {"response_code":1001,"response":"Invalid IP Address"}
    {"response_code":1002,"response":"Invalid Token"}
    {"response_code":1003,"response":"Account Inactive"}
    {"response_code":1004,"response":"Account Inactive"}
    {"response_code":1005,"response":"Account has been expired"}
    {"response_code":1006,"response":"Account has been expired"}
    {"response_code":1007,"response":"Invalid Receiver"}
    {"response_code":1008,"response":"Invalid Sender"}
    {"response_code":1010,"response":"Text cannot be empty"}
    {"response_code":1011,"response":"No valid receiver"}
    {"response_code":1012,"response":"No Credits Available"}
    {"response_code":1013,"response":"Insufficient Credits"}

```

[**Proceed to examples**](/examples_outgoing/)
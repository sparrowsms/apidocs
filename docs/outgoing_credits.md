# Credits
It can be used to know about the available credits, consumed credits.

## Supported HTTP request method:
```

    GET

```

## Method
```

    /credit/

```
## Parameters

```

    token : Token generated from our website.

```
## Responses

### Valid Response 

`Status Code: 200`

**Response Message: **

```

    {
        "credits_available" : <credits-available>,
        "credits_consumed"  : <credits-consumed>,
        "response_code"     : 200
    }

```

### Invalid Response 

`Status Code: 403`

**Error Messages: **

```

    {"response_code":1001,"response":"Invalid IP Address"}
    {"response_code":1002,"response":"Invalid Token"}
    {"response_code":1003,"response":"Account Inactive"}
    {"response_code":1004,"response":"Account Inactive"}
    {"response_code":1005,"response":"Account has been expired"}
    {"response_code":1006,"response":"Account has been expired"}
    {"response_code":1012,"response":"No Credits Available"}

```

[**Proceed to examples**](/examples_credits/)
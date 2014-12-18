# Examples (Credits)

## Curl

```

    curl -s http://api.sparrowsms.com/v2/credit \
        -F token='<token-provided>' \

```

-------

## Php

```

    $api_url = "http://api.sparrowsms.com/v2/credit".
        http_build_query(array(
            'token' => '<token-provided>',
    
    $response = file_get_contents($api_url);
    

```

-------

## Python

```python
    
    import requests

    r = requests.get(
            "http://api.sparrowsms.com/v2/credit",
            params={'token' : '<token-provided>'})

    status_code = r.status_code
    response = r.text
    response_json = r.json()
    

```
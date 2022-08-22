# Examples (Credits)

## Curl

```

    curl -s http://api.sparrowsms.com/v2/credit/ \
        -F token='<token-provided>' \

```

-------

## Php

```

    $api_url = "http://api.sparrowsms.com/v2/credit/?".
        http_build_query(array(
            'token' => '<token-provided>',
    
    $response = file_get_contents($api_url);
    

```

-------

## Python

```python
    
    import requests

    r = requests.get(
            "http://api.sparrowsms.com/v2/credit/",
            params={'token' : '<token-provided>'})

    status_code = r.status_code
    response = r.text
    response_json = r.json()
    

```

-------

## C\# (C-sharp)

```

    using System.Collections.Specialized;
    using System.IO;
    using System.Net;
    using System.Text;

    namespace SparrowSMSTest{

    class Program{
        static void Main(string[] args)
        {
            var getResponseTest = GetCredits('<token-provided>');
        }
        
        private static string GetCredits(string token)
        {
            using (var client = new WebClient())
            {
                string parameters = "?";
                parameters += "token=" + token;
                var responseString = client.DownloadString("http://api.sparrowsms.com/v2/credit/" + parameters);
                return responseString;
            }
        }
    }

```
# Examples (Outgoing SMS)

## Curl

```

    curl -s http://api.sparrowsms.com/v2/sms/ \
        -F token='<token-provided>' \
        -F from='<Identity>' \
        -F to='<comma_separated 10-digit mobile numbers>' \
        -F text='SMS Message to be sent'

```

-------

## Php

**GET Method: **

```

    $api_url = "http://api.sparrowsms.com/v2/sms/?".
        http_build_query(array(
            'token' => '<token-provided>',
            'from'  => '<Identity>',
            'to'    => '<comma_separated 10-digit mobile numbers>',
            'text'  => 'SMS Message to be sent'));
    
    $response = file_get_contents($api_url);
    

```

**POST Method: **

```

    $args = http_build_query(array(
        'token' => '<token-provided>',
        'from'  => '<Identity>',
        'to'    => '<comma_separated 10-digit mobile numbers>',
        'text'  => 'SMS Message to be sent'));
    
    $url = "http://api.sparrowsms.com/v2/sms/";

    # Make the call using API.
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Response
    $response = curl_exec($ch);
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    

```

-------

## Python

**GET Method: **

```python
    
    import requests

    r = requests.get(
            "http://api.sparrowsms.com/v2/sms/",
            params={'token' : '<token-provided>',
                  'from'  : '<Identity>',
                  'to'    : '<comma_separated 10-digit mobile numbers>',
                  'text'  : 'SMS Message to be sent'})

    status_code = r.status_code
    response = r.text
    response_json = r.json()
    

```

**POST Method: **

```python
    
    import requests

    r = requests.post(
            "http://api.sparrowsms.com/v2/sms/",
            data={'token' : '<token-provided>',
                  'from'  : '<Identity>',
                  'to'    : '<comma_separated 10-digit mobile numbers>',
                  'text'  : 'SMS Message to be sent'})
                  
    status_code = r.status_code
    response = r.text
    response_json = r.json()

```

-------

## C\# (C-sharp)

**GET Method: **

```
    
    using System.Collections.Specialized;
    using System.IO;
    using System.Net;
    using System.Text;

    namespace SparrowSMSTest{

    class Program{
        static void Main(string[] args)
        {
            var getResponseTest = GetSendSMS('<Identity>', '<token-provided>', '<comma_separated 10-digit mobile numbers>', 'SMS Message to be sent');
        }

        private static string GetSendSMS(string from, string token, string to, string text)
        {
            using (var client = new WebClient())
            {
                string parameters = "?";
                parameters += "from=" + from;
                parameters += "&to=" + to;
                parameters += "&text=" + text;
                parameters += "&token=" + token;
                var responseString = client.DownloadString("http://api.sparrowsms.com/v2/sms/" + parameters);
                return responseString;
            }
        }
    }

```


**POST Method: **

```

    using System.Collections.Specialized;
    using System.Net;
    using System.Text;

    namespace SparrowSMSTest{
        class Program{
            static void Main(string[] args){
                var responseTest = PostSendSMS('<Identity>', '<token-provided>', '<comma_separated 10-digit mobile numbers>', 'SMS Message to be sent');
            }

            private static string PostSendSMS(string from, string token, string to, string text){
                using (var client = new WebClient()){
                    var values = new NameValueCollection();
                    values["from"] = from;
                    values["token"] = token;
                    values["to"] = to;
                    values["text"] = text;
                    var response = client.UploadValues("http://api.sparrowsms.com/v2/sms/", "Post", values);
                    var responseString = Encoding.Default.GetString(response);
                    return responseString;
                }
            }
        }
    }

```
# Credits API (`intent=credits`)
`intent=credits` can be used to know about the available credits, consumed credits, credit charging policy and the expiry date.

## Required parameters

###`client_id`  
    supplied during account signup  

###`username`
    supplied during account signup  

###`password`
    supplied during account signup  

###`intent=credits`
    required to specifiy the request intent is a credits information request

## Response

Credit response is always JSON response.
    
    {
      status: "200",
      message: 
      {
        client_id: "demo",
        username: "demo",
        credits: {
          available: "59",
          consumed: "933",
          policy: "prepaid",
          expires: "0000-00-00 00:00:00"
        }
      },
      headers: ["HTTP/1.1 200 OK"]
    }
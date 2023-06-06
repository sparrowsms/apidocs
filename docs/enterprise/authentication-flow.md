# Enterprise Application Authentication Flow

__API Endpoint__

- https://ent-api.sparrowsms.com/

__Dashboard__

- https://ent.sparrowsms.com


## Authorization Headers
`Authorization : Bearer xxxxxxxxxxxxxxxxxxxx`

Bearer token is required in the headers for the API authentication. To receive the Bearer authorization token, the API token and Partner token shall be required. 

|Token Type| Desc | Token Property|
|--|--|--|
|API Token | Can be generated from the account management portal | Multiple tokens can be generated per user |
|Partner Token | Provided separately during agreement.  | Persistent and remains same throughout the account |

## The Authentication Flow
### Step 1
Login to the portal https://ent.sparrowsms.com with your account login credentials
 Navigate to the Token Management page and create / retrieve a token

### Step 2
Make an API request as below. 
__Endpoint__
`{{URL}}v1/autho/apitoken/login/`
__Method__
POST

__Payload__
```
{
    "api_token": "<api-token-obtained-from-generator>",
    "partner_token": "<partner-token-provided>"
}
```
__Expected response__
JWT Token
__JWT Token expiry__
24 hours
__Sample Response__
```
{
   "data": {
       "message": "Success",
       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9",
       "expires_on": "2022-08-21T18:00:55.400174+05:45",
   },
   "meta": {},
   "result": "00",
   "status": "OK"
}
```

### Step 3
For any other APIs, the Bearer Token received from above request shall be used as Authorization Header argument
        
    
### Dashboard Login
[https://ent.sparrowsms.com](https://ent.sparrowsms.com)


### How to get a Partner Token
To receive a partner_token, API agreement needs to be made with the company. One partner_token is provided per account and needs to be handled with care. 

However, in case of api_token, multiple tokens can be generated from the portal as per the use case required. 

## Error Messages
|Error Message| Desc | Resolution|
|--|--|--|
|Invalid Partner Token | The partner token input is incorrectly typed or doesn't exist at all | Verify the partner token |
|Must include "partner_token" and "api_token" | One of the tokens is missing in the input | Verify the parameters |
|Account is Expired| Partner token is valid, but the partner account is already expired.| Please talk to business / support for renewal process|
|Invalid API Token|Partner token is valid, API Token is not| |
|API Token Expired|API Token expiry time exceeded.| Generate again from the portal|
|Unable to log in with provided credentials.|Credentails invalid| Please recheck both api_token and partner_token |
|Invalid User|Account is no longer active|Please contact support for any sales / business related queries|

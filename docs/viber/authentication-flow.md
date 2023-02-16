# Enterprise Application Authentication Flow

__API Endpoint__

- https://mockingbird-api.sparrowsms.com/ (Deprecated)
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


# Viber Business Messaging service in Nepal

`Last Updated - 5th January, 2023 Version 1.0.3`

## API Endpoints

|Environment|URL|
|--|--|
|Production|https://mockingbird-api.sparrowsms.com/v1/viber/|
|Sandbox|Coming soon|


## Available APIs
|Name|API|HTTP Method|
|--|--|--|
|Promotional Message Compose API|message/compose/|POST
|Transactional Message Compose API|message/transactional/|POST
|Campaign Status Report|campaign/report/:compose-uuid/|POST


## Authorization Headers
`Authorization : Bearer xxxxxxxxxxxxxxxxxxxx`

Bearer token is required in the headers for the API authentication. To receive the Bearer authorization token, the API token and Partner token shall be required. 

|Token Type| Desc | Token Property|
|--|--|--|
|API Token | Can be generated from the account management portal | Multiple tokens can be generated per user |
|Partner Token | Provided separately during agreement.  | Persistent and remains same throughout the account |


## The Authentication Flow
### Step 1
Login to the portal https://mockingbird.sparrowsms.com with your account login credentials
 Navigate to the Token Management and create / retrieve a token

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
[https://mockingbird.sparrowsms.com](https://mockingbird.sparrowsms.com)

## Message types 
All business accounts will be able to send any of the following message types based on their needs. Our message type selection contains text-based messages and richer content options,  which includes images, action button and file sharing. 

- __Transactional__ : message contains rich text only
- __Promotional__ : message contains any of the following
    - Image
    - Download file
    - Action Button

## Full Data Payload
```
{
   "data"  : {
       "text":  "",
       "image": ""
    }, 
    "action" : {
       "url" : "",
       "caption" : "",
       "filename": ""
   }, 
   "session" : {
       "sender_name": "",
       "tag": ["tag1", "tag2"], 
       "recipients": [  … …  … ] 
   }
}
```

## Description
|Field||Value / Sample|
|--|--|--|
|data| |<pre>{ "text": "", "image": "" }</pre>__text__ - A text message to sent <br />__image__ - Image attachment if to be included in the message 
|action || <pre>{ "url" : "", "caption" : "", "filename": "" } </pre> | If a call to action or file download is to be sent 
|session|recipients (required) |  eg . `[no1,no2,no3…]` List of distinct recipients, receiving the message.
|session|sender_name |  Sender Name as allowed by Viber agreement
|session|tag | List of Strings later used for reporting purposes


### Coming soon
- ttl = Not defined Defaults to 48 hrs
- ttl = Value in seconds - Keep the max value in seconds equivalent to 48 hours

### SMS Fallback (Coming soon)
`sms_fallback`
Fallback SMS Content shall be forwarded if message wasn’t delivered within the TTL specified


## Response
The following is a list of status responses that you will receive after sending a message

| Status Code | Result Code | HTTP Response | Detailed description
| -- | -- | -- | -- |
| OK| 00| 200| Successfully sent.
| DRAFT| 01| 200| Partial Success (Billing Error)| 
DATA_ERROR| 11| 400| Message Sending Failed


### Success Response
```
{
   "data": {
       "message": "Queued successfully",
       "batch_id": "5c32728e-340f-43b6-898d-d2b24e8e1426",
       "credits_required": 2,
       "valid_recipients": 2,
       "invalid_recipients": []
   },
   "result": "00",
   "status": "OK"
}
```

| Data Field | Detailed description 
| -- | -- | 
| message | Human readable message suggesting the status of the compose action
| batch_id | Unique Identifier for the batch. Callback and DLR lookups are provided based upon this identifier
| credits_required | Maximum credits required for the full batch to proceed
| valid_recipients | Total Valid recipients found in the list of recipients sent during API request
| invalid_recipients | List of invalid recipients that were included in the API request (mobile number invalid)


### Error Response

```
{
   "data": {
       "errors": "Billing Error"
   },
   "result": "11",
   "status": "DATA_ERROR"
}
```


## Campaign Reports
| Name| API| HTTP Method| Description
|--|--|--|--|
| Aggregated Report| campaign/report/__:uuid__| GET | Aggregated summary of the campaign
| Delivered / Seen| campaign/report/__:uuid__/delivery| GET| Either delivered or seen
| Expired / Rejected| campaign/report/__:uuid__/failed| GET| Expired or Rejected due to invalid / unsubscribed numbers


### Response Format
#### Aggregated Summary /campaign/report/:uuid
```
{
   "data": {
       "uuid": "b8d2516c-f78d-42d9-bdf4-6b5ec421402d",
       "sender_name": "Sparrow Test One Way",
       "campaign_name": "My Campaign",
       "msg_type": "p",
       "text": "Hello World",
       "image": "https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg",
       "created_at": "2022-08-21T18:00:55.400174+05:45",
       "tags": [
           "tag1",
           "tag2"
       ],
       "rejected": 1,
       "accepted": 0,
       "status": "dispatched",
       "total": 1,
       "accepted_percentage": 0,
       "rejected_percentage": 100,
       "performed_by": {
           "uuid": "a2773d0f-99d7-4aac-9937-7629e99bee8e",
           "name": "A Natural Person",
           "email": "someone@example.com"
       }
   },
   "meta": {},
   "result": "00",
   "status": "OK"
}
```

#### Aggregated Summary /campaign/report/:uuid/delivered
```
{
   "data": {
       "uuid": "b8d2516c-f78d-42d9-bdf4-6b5ec421402d",
       "sender_name": "Sparrow Test One Way",
       "campaign_name": "My Campaign",
       "created_at": "2022-08-21T18:00:55.400174+05:45",
       "records": {
           "delivered": [],
           "seen": []
       }
   },
   "meta": {},
   "result": "00",
   "status": "OK"
}
```

#### Aggregated Summary /campaign/report/:uuid/failed
```
{
   "data": {
       "uuid": "b8d2516c-f78d-42d9-bdf4-6b5ec421402d",
       "sender_name": "Sparrow Test One Way",
       "campaign_name": "My Campaign",
       "created_at": "2022-08-21T18:00:55.400174+05:45",
       "records": {
           "rejected": [],
           "expired": []
       }
   },
   "meta": {},
   "result": "00",
   "status": "OK"
}
```

## DLR Callback
There are two types of DLR messages that can be dispatched to the endpoints provided by API Consumer.

- Individual recipient DLR Status
- Batch Complete Status

### Individual recipient DLR
Each recipient in a batch can trigger DLR events. Following events trigger the DLR callback. 

  - Is Delivered Once
  - Is Seen Once
  - Is Expired

#### Why Once ?
A viber message recipient user can have multiple devices logged in at the same time. Viber considers each event in a device as an unique event and sends the DLR. However is the message is delivered to any one of the device and is seen through any one of the online devices, its sufficient that the recipient has seen the message.  Any future events of delivery can be discarded gracefully. 

The payload of each event looks like below
```
{
    "dlr_data": [
        {
            "ts": "timestamp-of-the-event",
            "to": "viber-recipient",
            "id": "uuid-of-the-message-batch",
            "status": "2-digit-integer-representation"
        },{
            "ts": "2023-01-23 14:31:30",
            "to": "97798xxxxxxxx",
            "id": "92dc85b5-2f3c-4523-aaea-6fb2ee762b93",
            "status": "00"
        },
        {"...": ""}
    ], 
    "dlr_type": "instant"
}
```

### Status Description
| Value| Description 
|--|--
| 00 | Delivered Once
| 01 | Seen Once 
| 02 | Expired and could'nt deliver to any of the devices



### Batch Complete DLR
When all the recpients in a batch has been analysed and dispatched to Viber, viber either rejects or accepts the message. The batch complete DLR sends the count of rejected and accepted messages, and the recipients that were rejected for number not being a registered number or some other reasons. 

The payload of Batch Complete DLR looks like below
```
{
    "dlr_data": {
        "uuid": "aef341a9-1e28-4238-98a0-f8c326bae334",
        "status": "dispatched",
        "accepted_count": "10",
        "rejected_count": "2",
        "rejected_numbers": ["98xxxxxxxx", "98xxxxxxxx"]
    }
    "dlr_type": "batch_complete"
}
```

<!-- ## Session Messaging (Duplex API) - HTTP API
Feature coming soon -->

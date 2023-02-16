# Viber Business Messaging service in Nepal

`Last Updated - 16th February, 2023 Version 1.0.3`

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

<!-- ## Session Messaging (Duplex API) - HTTP API
Feature coming soon -->

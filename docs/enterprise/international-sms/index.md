# International SMS Messaging for Nepal
# Viber Business Messaging service in Nepal

`Last Updated - 23rd May Version 1.0.4`

## API Endpoints

|Environment|URL|
|--|--|
|Production|https://ent-api.sparrowsms.com/v1/intlsms/|
|Sandbox|Coming soon|

## Available APIs
|Name|API|HTTP Method|
|--|--|--|
|International Message Compose API|/compose/|POST
|Compose Status Report|compose/report/:idx/|POST
|Destination and Rates|compose/tarrif/|GET

## Full Data Payload
The payload will follow the syntax similar to Viber Messaging. 
```
{
   "data"  : {
       "text":  "",
       "msg_type": ""
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
|data|  |<pre>{ "text": "" }</pre>
|data|text|The text message to sent
|data|msg_type|Different types of messages supported, eg. SMS, Flash, HLR, etc <br />*(availability of each type is dependent upon the destination and service availability from the carriers)*
||
|session|recipients (required) |  eg . `[no1,no2,no3…]` List of distinct recipients, receiving the message.
|session|sender_name |  Sender Name as allowed to the the API account as per agreement
|session|tag | List of Strings later used for reporting purposes

### Validation Conditions
- __Number Format__ : The recipient should always be in international standard __E.164__ format E.164 numbers can have a maximum of fifteen (15) digits and are usually written as follows:

  `[+][country code][subscriber number including area code]`. 
  
  An example of a US number in the E.164 format is __+161000000000__
  
  Similary, a Nepali Number in the E.164 format is __+977 98012xxxxx__

- __Dashes__ : The digits can be separated with dashes and the dashes will be ignored. eg. __+977-980-xxx-xxxx__
- __Spaces__ : The digits can also be separated with spaces, and the spaces will also be ignored. 
- __Parenthesis__ : Any parenthesis in the numbers will also be removed. eg. __+977-(1)-(5522942)__


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


## Compose Batch Reports
| Name| API| HTTP Method| Description
|--|--|--|--|
| Aggregated Report| compose/report/__:uuid__| GET | Aggregated summary of the compose batch
| Delivered / Seen| compose/report/__:uuid__/delivery| GET| Either delivered or seen
| Expired / Rejected| compose/report/__:uuid__/failed| GET| Expired or Rejected due to invalid / unsubscribed numbers


### Response Format
#### Aggregated Summary /campaign/report/:uuid
```
{
   "data": {
       "uuid": "b8d2516c-f78d-42d9-bdf4-6b5ec421402d",
       "sender_name": "MyCompany",
       "text": "Hello World",
       "msg_type": "xxx",
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
       "sender_name": "My Company",
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
       "sender_name": "My Company",
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

### Message Types
*(subjected to availability as per the carrier and destination)*
|SN|msg_type|description|
|--|--|--|
|1| |Plain text (GSM 3.38 Character encoding)
|2| |Flash (GSM 3.38 Character encoding)
|3| |Unicode
|4| |Reserved
|5| |WAP Push
|6| |Plain text (ISO-8859-1 Character encoding)
|7| |Unicode Flash
|8| |Flash (ISO-8859-1 Character encoding)

<!-- dlr (integer): Specifies whether the delivery report is required for each message. Use one of the following values:
0: No delivery report required
1: Delivery report required -->

# Viber Business Messaging service in Nepal

`Last Updated - 25th June, 2025 Version 2.0.0`

## API Endpoints

|Environment|URL|
|--|--|
|Production|https://ent-api.sparrowsms.com/v1/viber/|
|Sandbox|Coming soon|


## Available APIs
|Name|API|HTTP Method|
|--|--|--|
|Promotional Message Compose API|message/compose/|POST|
|Transactional Message Compose API|message/transactional/|POST|
|Campaign Status Report|campaign/report/:compose-uuid/|GET|


## Message types 
All business accounts will be able to send any of the following message types based on their needs.

- __Transactional__ : message contains rich text only. **Requires a pre-approved `template_id`.**
- __Promotional__ : message contains any of the following (no changes to existing integration)
    - Image
    - Download file
    - Action Button

> **Important:** Sparrow SMS now requires pre-verified templates for all Transactional and OTP messages on the Viber platform. This ensures higher deliverability and compliance with Viber's Business Messaging policies. Promotional Messages remain dynamic and require no changes to existing integration.


---

## Transactional Message API

### Endpoint
```
POST /v1/viber/message/transactional/
Content-Type: application/json
```

### How it Works (Two-Step Workflow)

Clients must follow a two-step process before sending transactional messages:

**Step 1: Create and Approve Template**  
Register your message template via the Sparrow portal for Viber verification. Templates can be static or contain `{{placeholder}}` variables.

**Step 2: Send Message**  
Once the template status is `APPROVED`, send messages by referencing the `template_id` UUID.

---

### Request Structure

The request is divided into two primary objects:

- **`session`** — Contains delivery metadata (Sender, Recipients, Campaign Tag)
- **`data`** — Contains the specific template reference and dynamic variables

### Payload Scenarios

#### Scenario 1: OTP / Verification (Highly Restricted)

Used for sending secure PIN codes. The template must contain the `{{pin}}` placeholder.

```json
{
  "session": {
    "sender_name": "SparrowSMS",
    "campaign_name": "User_Authentication",
    "tag": "otp",
    "recipients": ["97798XXXXXXXX"]
  },
  "data": {
    "template_id": "VVT26XXXXXXXX",
    "template_params": {
      "pin": "123456"
    }
  }
}
```

#### Scenario 2: Personalized Transactional (With Parameters)

Used for order updates, receipts, or personalized notifications.

```json
{
  "session": {
    "sender_name": "SparrowSMS",
    "campaign_name": "Order_Dispatch",
    "tag": "shipping",
    "recipients": ["97798XXXXXXXX"]
  },
  "data": {
    "template_id": "VVT26XXXXXXXX",
    "template_params": {
      "name": "Jane Doe",
      "order_id": "ORD-54321"
    }
  }
}
```

#### Scenario 3: Static Notification (No Parameters)

Used for generic system alerts where no personalization is required.

```json
{
  "session": {
    "sender_name": "SparrowSMS",
    "campaign_name": "Maintenance_Notice",
    "tag": "system_alert",
    "recipients": ["97798XXXXXXXX"]
  },
  "data": {
    "template_id": "VVT26XXXXXXXX",
    "template_params": {}
  }
}
```

---

### Field Specifications

| Field | Type | Required | Description |
|--|--|--|--|
| sender_name | String | Yes | Your approved Viber Business Sender ID. |
| campaign_name | String | Yes | Internal identifier for your reporting. |
| tag | String | No | A single string used for campaign categorization. |
| recipients | Array | Yes | List of mobile numbers in international format (e.g., `97798...`). |
| template_id | UUID | Yes | The unique identifier of your approved template. |
| template_params | Object | Yes | Key-value pairs matching template placeholders. Use `{}` for static templates. |

---

### Critical Validation Rules

To ensure message delivery, the following constraints are strictly enforced:

1. **Parameter Value Limit:** Each value inside `template_params` must not exceed **25 characters**.
2. **URL Restriction:** Dynamic parameters cannot contain URLs. Links must be hardcoded into the static body of the template during the creation phase.
3. **Template Status:** Messages will only be processed if the `template_id` status is `APPROVED`. Messages sent with `PENDING` or `REJECTED` templates will return a `DATA_ERROR`.

---

## Promotional Message API

Promotional messages remain dynamic and require no changes to existing integration. 

### Full Data Payload
```json
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

### Field Description
| Field | | Value / Sample |
|--|--|--|
| data | | `{ "text": "", "image": "" }` **text** - A text message to sent <br />**image** - Image attachment if to be included in the message |
| action | | `{ "url" : "", "caption" : "", "filename": "" }` | If a call to action or file download is to be sent |
| session | recipients (required) | eg . `[no1,no2,no3…]` List of distinct recipients, receiving the message. |
| session | sender_name | Sender Name as allowed by Viber agreement |
| session | tag | List of Strings later used for reporting purposes |


---

## Response

The following is a list of status responses that you will receive after sending a message:

| Status Code | Result Code | HTTP Response | Detailed description |
| -- | -- | -- | -- |
| OK | 00 | 200 | Successfully sent. |
| DRAFT | 01 | 200 | Partial Success (Billing Error) |
| DATA_ERROR | 11 | 400 | Message Sending Failed |


### Success Response
```json
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

| Data Field | Detailed description |
| -- | -- |
| message | Human readable message suggesting the status of the compose action |
| batch_id | Unique Identifier for the batch. Callback and DLR lookups are provided based upon this identifier |
| credits_required | Maximum credits required for the full batch to proceed |
| valid_recipients | Total Valid recipients found in the list of recipients sent during API request |
| invalid_recipients | List of invalid recipients that were included in the API request (mobile number invalid) |


### Error Response

```json
{
   "data": {
       "errors": "Billing Error"
   },
   "result": "11",
   "status": "DATA_ERROR"
}
```


## Campaign Reports
| Name| API| HTTP Method| Description |
|--|--|--|--|
| Aggregated Report | campaign/report/__:uuid__ | GET | Aggregated summary of the campaign |
| Delivered / Seen | campaign/report/__:uuid__/delivery | GET | Either delivered or seen |
| Expired / Rejected | campaign/report/__:uuid__/failed | GET | Expired or Rejected due to invalid / unsubscribed numbers |


### Response Format
#### Aggregated Summary /campaign/report/:uuid
```json
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
```json
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
```json
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

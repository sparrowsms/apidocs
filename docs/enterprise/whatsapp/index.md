# Send Message WhatsApp Business API

**Base URL:** `https://ent-api.sparrowsms.com/`

The Sparrow WhatsApp API allows you to send automated messages to your customers using pre-approved WhatsApp templates and session messages.

---

## Send Message

**Endpoint:** `POST /v1/whatsapp/messages/`

This is a synchronous endpoint that validates your request and queues the message for delivery via the WhatsApp Business Platform.

The Sparrow WhatsApp API allows you to send messages using two types:

- **Template Messages:** Used to start a conversation with a customer at any time for Utility, Marketing, or Authentication purposes.
- **Session Messages:** Free-form messages sent in response to a customer within a 24-hour window.

---

## A. Template Messages (Business-Initiated)

Used to start a conversation at any time. Requires pre-approved templates.

### Request Body Fields

| Field | Type | Required | Description |
|---|---|---|---|
| `template_id` | string | Yes | The unique identifier of the approved WhatsApp template. |
| `recipient` | string | Yes | The recipient's phone number in E.164 format (digits only). |
| `parameters` | array | Conditional | Used to replace placeholders (`{{1}}`, `{{2}}`, etc.) in your template. Required if the template contains placeholders. |
| `media_url` | string | Conditional | Required if the template is an image type template. |

### Integration Rules

1. Numbers must contain digits only. Including a leading `+`, spaces, or special characters will cause a validation error (e.g., use `9779800000000`, not `+977 980-0000000`).
2. Messages can only be sent using templates with an **"APPROVED"** status.
3. The number of items in the `parameters` array must exactly match the number of placeholders in your template.
4. The order of values in the `parameters` array matters — the first value maps to `{{1}}`, the second to `{{2}}`, and so on.
5. If your template includes an image, you must provide a publicly accessible link in the `media_url` field.

### Implementation

#### 1. Simple Text Message

Used for simple text templates.

```json
{
  "template_id": "WWT49T8GQYCM",
  "recipient": "97798XXXXXXXX",
  "parameters": []
}
```

#### 2. Parameterized Message

Template text (reference):
> `"Hello {{1}}, your payment of NPR {{2}} to {{3}} was successful."`

```json
{
  "template_id": "WWT49T8GQYCM",
  "recipient": "97798XXXXXXXX",
  "parameters": ["Niraj Gurung", "2500", "Daraz Nepal"]
}
```

#### 3. Media Template

##### i. Image / Video Template

Used for templates that contain an image or video header.

```json
{
  "template_id": "WWT26AY8GQYCM",
  "recipient": "97798XXXXXXXX",
  "media_url": "https://example.com/images/map_kathmandu.jpg"
}
```

##### ii. Document Template

Used for sending template messages containing a document.

```json
{
  "template_id": "WWT26AJWKH68A",
  "recipient": "97798XXXXXXXX",
  "media_url": "https://example.com/media.pdf",
  "filename": "file_test_example.pdf"
}
```

### 4. Media Header Specifications

Used when your `template_id` was created with an Image, Video, or Document header.

| Field | Type | Required | Description |
|---|---|---|---|
| `media_url` | string | Yes | A direct, publicly accessible HTTPS link to the file (e.g., `.jpg`, `.mp4`, `.pdf`). |
| `filename` | string | Conditional | Required for `DOCUMENT` only. The display name the recipient sees when saving the file (e.g., `Monthly_Invoice.pdf`). |

---

## B. Session Messages

Use these to send free-form replies within a 24-hour window of the customer's last message. No template approval is required.

### Primary Request Fields

| Field | Type | Required | Description |
|---|---|---|---|
| `recipient` | string | Yes | The recipient's phone number in E.164 format (digits only). |
| `message_type` | string | Yes | Must be `"TEXT"`, `"IMAGE"`, `"VIDEO"`, or `"DOCUMENT"`. |
| `session_text` | string | Conditional | Required only if `message_type` is `TEXT`. The plain text message content. |
| `session_media` | object | Conditional | Required if `message_type` is `IMAGE`, `VIDEO`, or `DOCUMENT`. Contains media details. |

### `session_media` Object Fields

| Field | Type | Required | Description |
|---|---|---|---|
| `url` | string | Yes | A direct, publicly accessible HTTPS link to the file. |
| `caption` | string | No | Text that appears below the image, video, or document. |
| `filename` | string | Conditional | Used for `DOCUMENT` only. The name the file will have when saved (e.g., `invoice.pdf`). |

### Implementation

#### 1. Free Text

```json
{
  "recipient": "9779812345678",
  "message_type": "TEXT",
  "session_text": "Hello! How can we help you today?"
}
```

#### 2. Image Session Message

```json
{
  "recipient": "9779812345678",
  "message_type": "IMAGE",
  "session_media": {
    "url": "https://example.com/image.png",
    "caption": "Check out our new catalog!"
  }
}
```

#### 3. Video Session Message

```json
{
  "recipient": "9779812345612",
  "message_type": "VIDEO",
  "session_media": {
    "url": "https://example.com/demo.mp4",
    "caption": "Product Walkthrough"
  }
}
```

#### 4. Document Session Message

```json
{
  "recipient": "9779812345612",
  "message_type": "DOCUMENT",
  "session_media": {
    "url": "https://example.com/sample.pdf",
    "caption": "Your monthly report",
    "filename": "report_january.pdf"
  }
}
```

---

## C. Responses

### Success (200 OK)

The message has been accepted by the gateway and queued for delivery.

```json
{
  "data": {
    "message_id": "WWM2656VREEVY"
  },
  "meta": {},
  "result": "00",
  "status": "OK"
}
```

### Error Codes

| Status | Error Message | Cause / Solution |
|---|---|---|
| 400 | The recipient number must contain digits only. | Remove the `+` sign, spaces, or dashes from the phone number. |
| 400 | Approved template not found | The `template_id` is misspelled or the template is not yet approved. |
| 400 | This field is required. | You are missing the `recipient` or `template_id` in your JSON body. |
| 400 | Media_url is required | For image templates, you need to send a separate `media_url`. |
| 401 | Authentication credentials... not provided. | The Authorization header is missing or incorrect. |
| 401 | Invalid token header. | The API token provided is invalid. |
| 400 | Parameter count mismatch | The number of values in your array does not match the `{{n}}` placeholders. |

---

## D. Rate Limit

- **3 requests per second** per account. Exceeding this will return `HTTP 429 Too Many Requests`.

---

## E. Supported Media Specifications

All media files must be hosted on a public HTTPS server and adhere to the following constraints:

| Media Category | Supported Formats | Max Size |
|---|---|---|
| Image | `.jpeg`, `.png` | 5 MB |
| Video | `.mp4`, `.3gp` | 16 MB |
| Document | `.pdf`, `.txt`, `.csv`, `.doc`, `.docx`, `.xls`, `.xlsx`, `.ppt`, `.pptx` | 100 MB |

---

## Webhook Details

When webhook is enabled, your webhook URL will receive HTTP POST requests whenever a WhatsApp message status changes or a user replies to a message.

### Payload

```json
[
  {
    "message_id": "message_id",
    "wa_id": "wamid.HBgNOTc3OT...",
    "recipient": "97798XXXX",
    "status": "delivered",
    "timestamp": "1769059620",
    "message": {}
  }
]
```

### Payload Fields

| Field | Type | Description |
|---|---|---|
| `message_id` | string \| null | Unique identifier for messages (can be null for incoming messages). |
| `wa_id` | string | WhatsApp message ID. |
| `recipient` | string | User phone number (E.164 format). |
| `status` | string | Statuses: `sent`, `delivered`, `read`, `failed`. For incoming: `received`. |
| `timestamp` | string | Unix timestamp. |
| `message` | object | Present only for incoming messages. |

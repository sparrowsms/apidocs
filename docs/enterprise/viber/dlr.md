# Viber Business Messaging DLR Callback

There are two types of DLR messages that can be dispatched to the endpoints provided by API Consumer.

- Individual recipient DLR Status
- Batch Complete Status

## Individual recipient DLR
Each recipient in a batch can trigger DLR events. Following events trigger the DLR callback. 

  - Is Delivered Once
  - Is Seen Once
  - Is Expired

### Why Once ?
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

## DLR Status Description
| Value| Description 
|--|--
| 00 | Delivered Once
| 01 | Seen Once 
| 02 | Expired and could'nt deliver to any of the devices



## Batch Complete DLR
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

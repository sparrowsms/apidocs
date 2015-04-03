# Examples (Incoming SMS)

## Php

```

    // STEP 1
	// incoming request parameters
	
	$from = $_GET["from"]; // sms sender
	$to = $_GET["to"]; // shortcode
	$keyword = $_GET["keyword"]; // first word
	$text = $_GET["text"]; // the complete text
	$timestamp = time();
	
	// STEP 2
	// build your logic on how to respond the incoming request

	switch($keyword){
		case "one":
			$reply = "You (". $from .") have been subscribed to campaign one";
			break;
		case "two":
			$reply = "You (". $from .") have been subscribed to campaign two";
			break;
		default:
			$reply = "Invalid campaign name";
			break;
	}

	// STEP 3
	// may be you need to save the request to your own database
	// @optional

	mysql_connect("localhost", "username", "password");
	mysql_select_db("sparrow_sms");

	mysql_query("insert into logs_incoming
	(`from`, `to`, `keyword`, `text`, `timestamp`)
	values ('".mysql_real_escape_string($from)."',
	'".mysql_real_escape_string($to)."',
	'".mysql_real_escape_string($keyword)."',
	'".mysql_real_escape_string($text)."',
	'".$timestamp."'
	)");

	// STEP 4
	// send reply back to Sparrow SMS
	// This has to be STRICTLY 160 chars (max)

	die($reply);
    

```

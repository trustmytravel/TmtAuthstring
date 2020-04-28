# TMT Authstring
A helper class for creating valid authstrings for use with the [Trust My Travel Payment Modal](https://demo.trustmytravel.com/modal/).

## Create Authstring
To create a valid authstring for use with the Payment Modal you will need to pass the following values to the `getAuthstring` method in the `TmtAuthstring\Create` class:
* channel_id
* channel_currency
* booking_total
* channel_secret

Please refer to the Payment Modal documentation for detail on how to obtain these values.

### Example
```
require 'TmtAuthstring/Create.php';

$tmtAuthstring     = new \TmtAuthstring\Create();
$channel_id        = 23;
$channel_currency  = 'USD';
$booking_total     = 1000;
$channel_secret    = '$2y$10$ABCDEFEGHIJKLMNOPQRSTUVWXYZ';
$final_auth_string = $tmtAuthstring->getAuthstring($channel_id, $channel_currency, $booking_total, $channel_secret);
```

The `$final_auth_string` would then be included in a hidden input, or included in a data object, depending on the Payment Modal implementation you are using.


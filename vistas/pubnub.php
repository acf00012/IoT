<!DOCTYPE html>
<head>
    <meta charset="utf-8"/>
    <title>Hello, PubNub</title>
    <!-- Update this block with the URL to the content delivery network version of the SDK -->
    <script src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.29.9.js"></script>
</head>
<body>
<script>

    function init() {

        // Update this block with your publish/subscribe keys
        pubnub = new PubNub({
            publishKey : "pub-c-8a810838-4f03-4c13-b24c-160bcd214e98",
            subscribeKey : "sub-c-98c74b22-222d-11eb-a1de-7e3cab0b1713",
            uuid: "myUniqueUUID"
        });

        pubnub.addListener({
            status: function(statusEvent) {
                if (statusEvent.category === "PNConnectedCategory") {
                    publish("Status","¡lets go!");
                }
            },
            message: function(msg) {
                console.log(msg.message.temperatura);
                console.log(msg.message.humedad);
                console.log(msg.message.error);
            },
            presence: function(presenceEvent) {
                // This is where you handle presence. Not important for now :)
            }
        });

        pubnub.subscribe({
            channels: ['Bluee_ito_iv']
        });

    }
    function publish(title,msj) {
        var publishPayload = {
            channel : "Bluee_ito_iv",
            message: {
                title: title,
                data: msj
            }
        }
        pubnub.publish(publishPayload, function(status, response) {
            console.log(status, response);
        });
    }

</script>
</body>
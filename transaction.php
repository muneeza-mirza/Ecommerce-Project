<!DOCTYPE html>
<html lang="en">
<head>
    <title>PHP Payment API Example</title>
</head>
<body>
    <form id="myCCForm" action="payment.php" method="post">
            <input id="token" name="token" type="hidden" value="">
            <div>
                <label>
                    <span>Card Number</span>
                </label>
                <input id="ccNo" type="text" size="20" value="" autocomplete="off" required />
            </div>
            <div>
                <label>
                    <span>Expiration Date (MM/YYYY)</span>
                </label>
                <input type="text" size="2" id="expMonth" required />
                <span> / </span>
                <input type="text" size="2" id="expYear" required />
            </div>
            <div>
                <label>
                    <span>CVC</span>
                </label>
                <input id="cvv" size="4" type="text" value="" autocomplete="off" required />
            </div>
            <input type="submit" value="Submit Payment">
        </form>

        <script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

        <script>
            // Called when token created successfully.
            var successCallback = function(data) {
                var myForm = document.getElementById('myCCForm');

                // Set the token as the value for the token input
                myForm.token.value = data.response.token.token;

                // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
                myForm.submit();
            };

            // Called when token creation fails.
            var errorCallback = function(data) {
                if (data.errorCode === 200) {
                    tokenRequest();
                } else {
                    alert(data.errorMsg);
                }
            };

            var tokenRequest = function() {
                // Setup token request arguments
                var args = {
                    sellerId: "901405323",
                    publishableKey: "93412104-466F-4F65-954A-BCCD03052B63",
                    ccNo: $("#ccNo").val(),
                    cvv: $("#cvv").val(),
                    expMonth: $("#expMonth").val(),
                    expYear: $("#expYear").val()
                };

                // Make the token request
                TCO.requestToken(successCallback, errorCallback, args);
            };

            $(function() {
                // Pull in the public encryption key for our environment
                TCO.loadPubKey('sandbox');

                $("#myCCForm").submit(function(e) {
                    // Call our token request function
                    tokenRequest();

                    // Prevent form from submitting
                    return false;
                });
            });
        </script>
</body>
</html>
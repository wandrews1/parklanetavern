<?php
    // Modifications to mailer script from:
    // http://blog.teamtreehouse.com/create-ajax-contact-form
    // Added input sanitizing to prevent injection

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $date = ($_POST["date"]);
        $time = ($_POST["time"]);
        $guests = ($_POST["guests"]);
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);

        // Check that data was sent to the mailer.
        if ( empty($date) OR empty($time) OR empty($guests) OR empty($name) OR empty($phone) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            //http_response_code(400);
            header("HTTP/1.0 404 Not Found?");
            //You can customise this message
            echo "Oops! There was a problem with your submission. Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        //IMPORTANT TODO: CHANGE THIS TO YOUR EMAIL ADDRESS!!
        $recipient = "promotions@parklanetavern.com";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Date: $date\n\n";
        $email_content .= "Time: $time\n\n";
        $email_content .= "Guests: $guests\n\n";
        $email_content .= "Name: $name\n\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Phone: $phone\n\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            //http_response_code(200); 
            header('HTTP/1.0 200 OK');
            //You can customise this message
            echo "Thank You! Your reservation request has been sent successfully. We will check availability and send you an email confirmation of your booking.";
        } else {
            // Set a 500 (internal server error) response code.
            //http_response_code(500);
            header('HTTP/1.0 500 Internal Server Error');
            //You can customise this message
            echo "Oops! Something went wrong and we couldn't send your message.";//You can customise this message
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        //http_response_code(403);
        header('HTTP/1.0 403 Forbidden');
        //You can customise this message
        echo "There was a problem with your submission, please try again.";//You can customise this message
    }

?>

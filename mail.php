<?php

    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $arrive_date = strip_tags(trim($_POST["arrive_date"]));
        $departure_date = strip_tags(trim($_POST["arrive_date"]));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $guests = trim($_POST["guest"]);

        $message = "The guest from email - ".
                $email . " has made a booking request from arrive date - ".
                $arrive_date ." to " . $departure_date . " having guests ". 
                $guests;

        // Check that data was sent to the mailer.
        if ( empty($arrive_date) OR empty($departure_date) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "shobhitk8055@gmail.com";

        // Set the email subject.
        $subject = "New contact from $email";

        // Build the email content.
        $email_content = "";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $email <$email>";

        // Send the email.
        if (mail($recipient, $subject, $email_content, $email_headers)) {
            // Set a 200 (okay) response code.
            http_response_code(200);
            echo "Thank You! Your booking request has been sent.";
        } else {
            // Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! Something went wrong and we couldn't send your message.";
        }

    } else {
        // Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>

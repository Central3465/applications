<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $position = $_POST["position"];
    $inspiration = $_POST["inspire"];
    
    // Additional fields and processing as needed

    // Send email (modify the email address and content accordingly)
    $to = "your_email@example.com";
    $subject = "New Job Application - $position";
    $message = "Name: $name\nEmail: $email\nPosition: $position\nInspiration: $inspiration";

    mail($to, $subject, $message);

    // Send to Discord webhook (modify the URL and content accordingly)
    $discordWebhookUrl = "YOUR_DISCORD_WEBHOOK_URL";
    $discordMessage = "New Job Application\nName: $name\nEmail: $email\nPosition: $position\nInspiration: $inspiration";

    $discordData = array("content" => $discordMessage);

    $discordOptions = array(
        "http" => array(
            "header"  => "Content-type: application/x-www-form-urlencoded\r\n",
            "method"  => "POST",
            "content" => http_build_query($discordData)
        )
    );

    $discordContext  = stream_context_create($discordOptions);
    $discordResult = file_get_contents($discordWebhookUrl, false, $discordContext);

    // Redirect to confirmation page
    header("Location: submit_application.html");
    exit();
} else {
    // If the form is not submitted, redirect to the form page
    header("Location: job_application_form.html");
    exit();
}
?>

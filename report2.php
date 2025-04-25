<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
  position: absolute;
  inset: -1em;
  --c: 7px;
  background-color: #000;
  background-image: radial-gradient(
      circle at 50% 50%,
      #0000 1.5px,
      #000 0 var(--c),
      #0000 var(--c)
    ),
    radial-gradient(
      circle at 50% 50%,
      #0000 1.5px,
      #000 0 var(--c),
      #0000 var(--c)
    ),
    radial-gradient(circle at 50% 50%, #f00, #f000 60%),
    radial-gradient(circle at 50% 50%, #ff0, #ff00 60%),
    radial-gradient(circle at 50% 50%, #0f0, #0f00 60%),
    radial-gradient(ellipse at 50% 50%, #00f, #00f0 60%);
  background-size:
    12px 20.7846097px,
    12px 20.7846097px,
    200% 200%,
    200% 200%,
    200% 200%,
    200% 20.7846097px;
  --p: 0px 0px, 6px 10.39230485px;
  background-position:
    var(--p),
    0% 0%,
    0% 0%,
    0% 0px;
  animation:
    wee 40s linear infinite,
    filt 6s linear infinite;
}

@keyframes filt {
  0% {
    filter: hue-rotate(0deg);
  }
  to {
    filter: hue-rotate(360deg);
  }
}

@keyframes wee {
  0% {
    background-position:
      var(--p),
      800% 400%,
      1000% -400%,
      -1200% -600%,
      400% 41.5692194px;
  }
  to {
    background-position:
      var(--p),
      0% 0%,
      0% 0%,
      0% 0%,
      0% 0%;
  }
}

    </style>
</head>
<body>
    <div class="container"></div>
    <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $to = $_POST['to'];  // Recipient Email
          $subject = $_POST['subject'];  // Email Subject
          $message = $_POST['message'];  // Email Message
          
          $headers = "From: " . $_POST['from'] . "\r\n" .
                     "Reply-To: " . $_POST['from'] . "\r\n" .
                     "X-Mailer: PHP/" . phpversion();
          
          if (mail($to, $subject, $message, $headers)) {
              echo "<p style='color:green;'>Email sent successfully!</p>";
          } else {
              echo "<p style='color:red;'>Failed to send email.</p>";
          }
      }
      ?><div class="container">

        <h2>Report a Road Issue</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="Your full name" required />
    
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="you@example.com" required />
    
          <label for="location">Location</label>
          <input type="text" id="location" name="location" placeholder="e.g. Main Street near Park" required />
    
          <label for="type">Issue Type</label>
          <select id="type" name="type" required>
            <option value="" disabled selected>Select an issue type</option>
            <option>Pothole</option>
            <option>Broken Streetlight</option>
            <option>Blocked Drain</option>
            <option>Faded Zebra Crossing</option>
            <option>Other</option>
          </select>
          
    
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" placeholder="Brief description of the issue..." required></textarea>
    
          <label for="image">Upload Image (optional)</label>
          <input type="file" id="image" name="image" accept="image/*" />
    
          <button type="submit" name="submit">Submit Complaint</button>
        </form>
    
    
    
      
    
        <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
      // Basic sanitation
      $name = htmlspecialchars($_POST['name']);
      $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
      $location = htmlspecialchars($_POST['location']);
      $type = htmlspecialchars($_POST['type']);
      $description = htmlspecialchars($_POST['description']);
    
      // Compose message
      $to = "roadcare@example.com"; // Replace with your actual email
      $subject = "New Road Issue Reported: $type";
      $boundary = md5(time());
      $headers = "From: $email\r\n";
      $headers .= "Reply-To: $email\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: multipart/mixed; boundary=\"{$boundary}\"\r\n";
    
      $body = "--{$boundary}\r\n";
      $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
      $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
      $body .= "Name: $name\nEmail: $email\nLocation: $location\nIssue Type: $type\n\nDescription:\n$description\r\n\r\n";
    
      // Handle file upload if exists
      if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_name = $_FILES['image']['name'];
        $file_type = mime_content_type($file_tmp);
        $file_data = chunk_split(base64_encode(file_get_contents($file_tmp)));
    
        $body .= "--{$boundary}\r\n";
        $body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $file_data . "\r\n\r\n";
      }
    
      $body .= "--{$boundary}--";
    
      // Send email
      if (mail($to, $subject, $body, $headers)) {
        echo "<p style='color:green;'>Thank you! Your complaint has been submitted with the image.</p>";
      } else {
        echo "<p style='color:red;'>Sorry, there was a problem sending your report. Please try again.</p>";
      }
    }
    ?>
    
      </div>


    
</body>
</html>
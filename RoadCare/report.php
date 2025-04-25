<!-- <!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Report Road Issue - RoadCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Urbanist', sans-serif;
      background: #f7fbfc;
      margin: 0;
      padding: 20px;
    }
    .container {
      max-width: 700px;
      margin: auto;
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 20px;
    }
    form label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    form input, form textarea, form select {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    form button {
      background-color: #007bff;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    form button:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Report a Road Issue</h2>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required />

      <label for="location">Location</label>
      <input type="text" id="location" name="location" required />

      <label for="type">Issue Type</label>
      <select id="type" name="type" required>
        <option>Pothole</option>
        <option>Broken Streetlight</option>
        <option>Blocked Drain</option>
        <option>Faded Zebra Crossing</option>
        <option>Other</option>
      </select>

      <label for="description">Description</label>
      <textarea id="description" name="description" rows="4" required></textarea>

      <label for="image">Upload Image (optional)</label>
      <input type="file" id="image" name="image" accept="image/*" />
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
      ?>
      <button type="submit">Submit Complaint</button>
    </form>
    
  </div>
</body>
</html> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Report Road Issue - RoadCare</title>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;700&display=swap" rel="stylesheet">
  <style>
    
    
    body {
      font-family: 'Urbanist', sans-serif;
      
      background-size: cover;
      background-size: contain; 
      margin: 0;
      padding: 20px;
    } 
    .container {
      max-width: 600px;
      margin: auto;
      background: beige;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }
    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 20px;
    }
    form label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
    }
    form input, form textarea, form select {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    form button {
      background-color: #007bff;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }
    form button:hover {
      background-color: #0056b3;
    }
    


    
  </style>
</head>
<body>
  <div class="cont"></div>
    <div class="container">

    <h2>Report a Road Issue</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
      <label for="name">Name</label>
      <input type="text" id="name" name="name" placeholder="Your full name" required />

      <label for="email">Email</label>
      <input type="email" id="email" name="email" placeholder="name@gmail.com" required />

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


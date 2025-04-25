<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact Us - RoadCare</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Urbanist', sans-serif;
      background: linear-gradient(to right, #f0f4f7, #e0ecf4);
      color: #333;
      line-height: 1.6;
    }

    .container {
      width: 90%;
      max-width: 1100px;
      margin: 60px auto;
      background: #fff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
    }

    h1 {
      text-align: center;
      margin-bottom: 40px;
      font-size: 36px;
      color: #007bff;
    }

    .grid {
      display: grid;
      grid-template-columns: 1fr;
      gap: 30px;
    }

    @media (min-width: 768px) {
      .grid {
        grid-template-columns: 1fr 1fr;
      }
    }

    .contact-info, .contact-form {
      padding: 30px;
      border-radius: 12px;
      background: #fafafa;
      border: 1px solid #ddd;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 20px;
      margin-bottom: 25px;
    }

    .icon {
      background: #007bff;
      color: #fff;
      padding: 12px;
      font-size: 20px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      height: 45px;
    }

    .contact-item h3 {
      margin: 0;
      font-size: 18px;
      font-weight: 600;
    }

    .contact-form h2 {
      margin-bottom: 20px;
      color: #007bff;
    }

    .contact-form label {
      font-weight: 600;
      margin-bottom: 6px;
      display: block;
    }

    .contact-form input,
    .contact-form textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      margin-bottom: 20px;
      font-size: 15px;
    }

    .contact-form button {
      width: 100%;
      background: linear-gradient(135deg, #007bff, #0056b3);
      color: white;
      border: none;
      padding: 14px;
      font-size: 16px;
      font-weight: bold;
      border-radius: 8px;
      cursor: pointer;
      transition: 0.3s;
    }

    .contact-form button:hover {
      opacity: 0.9;
    }

    .message-success {
      margin-top: 20px;
      color: green;
      font-weight: bold;
    }

    .message-error {
      margin-top: 20px;
      color: red;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Contact Us</h1>
    <div class="grid">
      <div class="contact-info">
        <h2>Get in Touch</h2>
        <div class="contact-item">
          <span class="icon">📞</span>
          <div>
            <h3>Phone</h3>
            <p>1-800-555-0123</p>
            <small>Available 24/7 for emergencies</small>
          </div>
        </div>
        <div class="contact-item">
          <span class="icon">✉️</span>
          <div>
            <h3>Email</h3>
            <p>support@roadcare.com</p>
            <small>We'll respond within 24 hours</small>
          </div>
        </div>
        <div class="contact-item">
          <span class="icon">📍</span>
          <div>
            <h3>Office Address</h3>
            <p>Lovely Professional University</p>
          </div>
        </div>
      </div>

      <div class="contact-form">
        <h2>Send us a Message</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="Your name" required />

          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="name@gmail.com" required />

          <label for="subject">Subject</label>
          <input type="text" id="subject" name="subject" placeholder="What's this about?" required />

          <label for="message">Message</label>
          <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

          <button type="submit" name="submit">Send Message</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
          $name = htmlspecialchars($_POST['name']);
          $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
          $subject = htmlspecialchars($_POST['subject']);
          $message = htmlspecialchars($_POST['message']);

          $to = "roadcare@example.com"; // change this to your real email
          $fullMessage = "Name: $name\nEmail: $email\n\nMessage:\n$message";
          $headers = "From: $email\r\nReply-To: $email";

          if (mail($to, $subject, $fullMessage, $headers)) {
            echo "<p class='message-success'>Thank you! Your message has been sent successfully.</p>";
          } else {
            echo "<p class='message-error'>Oops! Something went wrong. Please try again later.</p>";
          }
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>

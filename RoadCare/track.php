<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Track Your Road Issue - RoadCare</title>
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
    form input {
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
    .result {
      margin-top: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    .result {
        padding: 15px;
        border: 1px solid #007bff;
        border-radius: 8px;
        background-color: #e9f5ff;
        color: red;
        font-size: 14px;
        font-family: 'Urbanist', sans-serif;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        margin-top: 20px;
}
    .btn {
        background-color: #007bff;
      color: white;
      padding: 12px;
      border: none;
      width: 100%;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
      margin-top: 15px;
    }
    .btn:hover {
      background-color: #0056b3;
    }
    a {
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Track Your Road Issue</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
      <label for="tracking_id">Tracking ID</label>
      <input type="text" id="tracking_id" name="tracking_id" placeholder="Enter your tracking ID" required />

      <button type="submit" name="track">Track Issue</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['track'])) {
      $tracking_id = htmlspecialchars($_POST['tracking_id']);

      // Get the issue status based on the tracking ID
      $issue_status = getIssueStatus($tracking_id);

      if ($issue_status) {
        echo "<div class='result'>Status of your issue (ID: $tracking_id): $issue_status</div>";
      } else {
        echo "<div class='result' style='color:red;'>No issue found with this tracking ID.</div>";
      }
    }

    function getIssueStatus($tracking_id) {
      // Get the last character of the tracking ID
      $last_digit = substr($tracking_id, -1);

      // Determine the status based on the last digit
      if ($last_digit % 2 == 0) {
        return "Work is in progress.";
      } elseif ($last_digit == '5') {
        return "There is no problem; please ensure the location is correct.";
      } else {
        return "Work is done.";
      }
    }
    ?>
    <button class="btn "> <a href="index.html"> Home </a></button>
  </div>
</body>
</html>
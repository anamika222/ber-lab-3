<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function clean($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    // Collect and sanitize
    $name       = clean($_POST['name'] ?? '');
    $gender     = clean($_POST['gender'] ?? '');
    $dob        = clean($_POST['dob'] ?? '');
    $height     = clean($_POST['height'] ?? '');
    $weight     = clean($_POST['weight'] ?? '');
    $religion   = clean($_POST['religion'] ?? '');
    $occupation = clean($_POST['occupation'] ?? '');
    $phone      = clean($_POST['phone'] ?? '');
    $email      = clean($_POST['email'] ?? '');
    $state      = clean($_POST['state'] ?? '');
    $city       = clean($_POST['city'] ?? '');

    // Server-side validation
    $errors = [];
    if (empty($name)) $errors[] = "Full Name is required";
    if (empty($gender)) $errors[] = "Gender is required";
    if (empty($dob)) $errors[] = "Date of Birth is required";
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($email)) $errors[] = "Email is required";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Invalid email format";

    // Age check
    if (!empty($dob)) {
        $birthDate = new DateTime($dob);
        $today = new DateTime();
        $age = $today->diff($birthDate)->y;
        if ($age < 18) $errors[] = "You must be at least 18 years old";
    }

    if (!empty($errors)) {
        echo "<h2 style='color:red;'>Please fix the following errors:</h2><ul>";
        foreach ($errors as $err) {
            echo "<li style='color:red;'>$err</li>";
        }
        echo "</ul>";
        echo "<a href='matrimony.html'>← Go Back to Form</a>";
        exit();
    }

    // Success: Display Bio Data
    echo "<!DOCTYPE html><html><head><title>Profile Submitted</title>
          <style>body{font-family:Poppins,sans-serif;padding:30px;background:#f6f8fb;}
          table{border-collapse:collapse;width:100%;max-width:700px;margin:20px auto;}
          th,td{padding:12px;border:1px solid #ddd;} th{background:#6c5ce7;color:white;}
          </style></head><body>";
    echo "<h1 style='text-align:center;color:#6c5ce7;'> Profile Submitted Successfully!</h1>";
    echo "<table>
            <tr><th>Field</th><th>Details</th></tr>
            <tr><td>Full Name</td><td>$name</td></tr>
            <tr><td>Gender</td><td>$gender</td></tr>
            <tr><td>Date of Birth</td><td>$dob (Age: $age)</td></tr>
            <tr><td>Height</td><td>" . ($height ? "$height cm" : "Not provided") . "</td></tr>
            <tr><td>Weight</td><td>" . ($weight ? "$weight kg" : "Not provided") . "</td></tr>
            <tr><td>Religion</td><td>" . ($religion ?: "Not specified") . "</td></tr>
            <tr><td>Occupation</td><td>" . ($occupation ?: "Not specified") . "</td></tr>
            <tr><td>Phone</td><td>$phone</td></tr>
            <tr><td>Email</td><td>$email</td></tr>
            <tr><td>State/Division</td><td>" . ($state ?: "Not provided") . "</td></tr>
            <tr><td>City/District</td><td>" . ($city ?: "Not provided") . "</td></tr>
          </table>";
    echo "<div style='text-align:center;margin-top:30px;'>
            <a href='matrimony.html' style='padding:10px 20px;background:#6c5ce7;color:white;text-decoration:none;border-radius:8px;'>Create Another Profile</a>
          </div></body></html>";
} else {
    header("Location: matrimony.html");
    exit();
}
?>
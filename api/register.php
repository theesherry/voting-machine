<?php
include("connect.php");

// Debug to check the request method
//echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //  echo "Form submitted via POST.<br>";

    // Proceed with handling the form data
    $name = $_POST['name'];
    $address = $_POST['Address'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmpassword'];
    $mobile = $_POST['phoneNumber'];
    $role = $_POST['role'];
    $photo = $_FILES['photo']['name'];
    $tmp_name = $_FILES['photo']['tmp_name'];
    $upload_dir = "../uploads/";

    // Validate password match
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Secure password hashing
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Validate and move uploaded image
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    $file_extension = pathinfo($photo, PATHINFO_EXTENSION);

    if (in_array($file_extension, $allowed_extensions)) {
        $upload_path = $upload_dir . basename($photo);
        if (move_uploaded_file($tmp_name, $upload_path)) {
            // Insert into database
            $sql = "INSERT INTO user (name, address, password, mobile, role, photo) 
                    VALUES ('$name', '$address', '$hashedPassword','$mobile', '$role', '$photo ')";

            if (mysqli_query($connect, $sql)) {
                echo '
                     <script>
    alert ("registration successfull");
    window.location="../login.html";
    </script>';
            } else {
    //            echo "Error: " . mysqli_error($connect);
            }
        } else {
      //      echo "Failed to upload image.";
        }
    } else {
        //echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
    }
} else {
    //echo "Invalid request method: " . $_SERVER['REQUEST_METHOD'];
}

mysqli_close($connect);
?>

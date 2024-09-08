<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission here. Store the data or save it as draft.
    if (isset($_POST['save_draft'])) {
        // Save form data as draft (to database or session, for example).
        echo "Form saved as draft!";
    } elseif (isset($_POST['submit'])) {
        // Validate and handle form submission
        if (!isset($_POST['terms'])) {
            echo "You must agree to the terms and conditions to submit!";
        } else {
            // Handle file uploads and form data processing here
            echo "Form submitted successfully!";
            // You can redirect to a success page or process the data as needed.
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Media Practitioner Registration</title>
</head>

<body>

    <form action="registration_form.php" method="POST" enctype="multipart/form-data">
        <h1>Media Practitioner Registration</h1>

        <!-- Personal Information -->
        <label for="surname">Surname:</label>
        <input type="text" id="surname" name="surname" required><br><br>

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" required><br><br>

        <label for="dob">Date of Birth:</label>
        <input type="date" id="dob" name="dob" required><br><br>

        <!-- Organization Information -->
        <label for="organization">Organization Name:</label>
        <input type="text" id="organization" name="organization" required><br><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required><br><br>

        <!-- Media Type Specialization -->
        <label for="media_type">Media Type Specialization:</label><br>
        <input type="checkbox" name="media_type[]" value="Journalism"> Journalism<br>
        <input type="checkbox" name="media_type[]" value="Public Relations"> Public Relations<br>
        <input type="checkbox" name="media_type[]" value="Broadcasting"> Broadcasting<br>
        <input type="checkbox" name="media_type[]" value="Digital Media"> Digital Media<br>
        <input type="checkbox" name="media_type[]" value="Photography"> Photography<br>
        <input type="checkbox" name="media_type[]" value="Videography"> Videography<br>
        <input type="checkbox" name="media_type[]" value="Social Media Management"> Social Media Management<br>
        <input type="checkbox" name="media_type[]" value="Content Creation"> Content Creation<br>
        <input type="checkbox" name="media_type[]" value="Advertising"> Advertising<br><br>

        <!-- Social Media Platforms -->
        <label for="social_media">Social Media Platforms You Use Professionally:</label><br>
        <input type="checkbox" name="social_media[]" value="Facebook"> Facebook<br>
        <input type="checkbox" name="social_media[]" value="Twitter"> Twitter<br>
        <input type="checkbox" name="social_media[]" value="Instagram"> Instagram<br>
        <input type="checkbox" name="social_media[]" value="LinkedIn"> LinkedIn<br>
        <input type="checkbox" name="social_media[]" value="YouTube"> YouTube<br>
        <input type="checkbox" name="social_media[]" value="TikTok"> TikTok<br>
        <input type="checkbox" name="social_media[]" value="Snapchat"> Snapchat<br><br>

        <!-- Portfolio Link -->
        <label for="portfolio_link">Portfolio Links:</label>
        <textarea id="portfolio_link" name="portfolio_link" placeholder="Provide link(s) to your portfolio..."></textarea><br><br>

        <!-- Area of Expertise and Location -->
        <label for="expertise">Specifying Area of Expertise:</label><br>
        <input type="text" id="expertise" name="expertise"><br><br>

        <label for="location">Where are you located:</label><br>
        <input type="text" id="location" name="location"><br><br>

        <!-- Additional Questions or Comments -->
        <label for="comments">Additional Questions or Comments:</label><br>
        <textarea id="comments" name="comments" placeholder="Any additional questions or comments..."></textarea><br><br>

        <!-- File Uploads -->
        <label for="profile_pic">Upload Profile Picture:</label>
        <input type="file" id="profile_pic" name="profile_pic" accept="image/*"><br><br>

        <label for="id_doc">Upload ID/Driver's License:</label>
        <input type="file" id="id_doc" name="id_doc" accept=".pdf,.jpg,.jpeg,.png"><br><br>

        <label for="other_docs">Other Relevant Documents:</label>
        <input type="file" id="other_docs" name="other_docs" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"><br><br>

        <!-- Agree to Terms -->
        <label for="terms">
            <input type="checkbox" id="terms" name="terms"> I agree to the terms and conditions
        </label><br><br>

        <!-- Save as Draft and Submit Options -->
        <button type="submit" name="save_draft">Save as Draft</button>
        <button type="submit" name="submit">Submit</button>

        <!-- Back Button -->
        <button type="button" onclick="window.history.back()">Go Back</button>

    </form>

</body>

</html>
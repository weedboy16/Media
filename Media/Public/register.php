<?php
include 'components/db_connect.php';
include 'components/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the user clicked the "Save as Draft" button
    $is_draft = isset($_POST['save_draft']) ? 1 : 0;

    // Collect all form data
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $dob = $_POST['dob'];
    $organization_name = $_POST['organization_name'];
    $role = $_POST['role'];
    $media_types = implode(',', $_POST['media_type']);
    $social_media_platforms = implode(',', $_POST['social_media_platforms']);
    $portfolio_link = $_POST['portfolio_link'];
    $area_of_expertise = $_POST['area_of_expertise'];
    $location = $_POST['location'];
    $additional_comments = $_POST['additional_comments'];
    $portfolio_links = $_POST['portfolio_links'];

    // File upload processing
    $profile_pic = $_FILES['profile_pic']['name'];
    $id_document = $_FILES['id_document']['name'];
    $other_documents = $_FILES['other_documents']['name'];
    $target_dir = "uploads/";
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_dir . basename($profile_pic));
    move_uploaded_file($_FILES['id_document']['tmp_name'], $target_dir . basename($id_document));
    move_uploaded_file($_FILES['other_documents']['tmp_name'], $target_dir . basename($other_documents));

    if ($is_draft) {
        // Save as draft
        $sql = "INSERT INTO media_practitioners (first_name, last_name, email, phone_number, dob, card_delivery_method, created_at, is_draft)
                VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$dob', 'courier', NOW(), 1)";
    } else {
        // Submit final form
        $sql = "INSERT INTO media_practitioners (first_name, last_name, email, phone_number, dob, card_delivery_method, created_at, is_draft)
                VALUES ('$first_name', '$last_name', '$email', '$phone_number', '$dob', 'courier', NOW(), 0)";
    }

    if ($conn->query($sql) === TRUE) {
        $practitioner_id = $conn->insert_id;

        // Insert into location table
        $location_sql = "INSERT INTO location (media_practitioner_id, street_address, city, region, postal_code)
                         VALUES ('$practitioner_id', '', '$location', '', '')";
        $conn->query($location_sql);

        foreach ($_POST['media_type'] as $media_type) {
            $media_type_sql = "INSERT INTO media_type_specializations (media_practitioner_id, media_type) VALUES ('$practitioner_id', '$media_type')";
            $conn->query($media_type_sql);
        }
        foreach ($_POST['social_media_platforms'] as $platform) {
            $social_media_sql = "INSERT INTO social_media_platforms (media_practitioner_id, platform) VALUES ('$practitioner_id', '$platform')";
            $conn->query($social_media_sql);
        }

        // Redirect to success or draft saved page
        $redirect_page = $is_draft ? "draft_success.php" : "success.php";
        header("Location: $redirect_page");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>


<!-- HTML form structure from previous steps -->
<div class="form-container">
    <form id="registrationForm" action="register.php" method="POST" enctype="multipart/form-data">
        <!-- Step 1: Personal Information -->
        <div class="form-step active" id="step1">
            <h2>Personal Information</h2>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required><br>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="phone_number">Phone Number:</label>
            <input type="text" name="phone_number" required><br>

            <label for="dob">Date of Birth:</label>
            <input type="date" name="dob" required><br>

            <button type="button" onclick="nextStep(1)">Next</button>
        </div>

        <!-- Step 2: Media Organization and Role -->
        <div class="form-step" id="step2">
            <h2>Organization Details</h2>
            <label for="organization_name">Organization Name:</label>
            <input type="text" name="organization_name" required><br>

            <label for="role">Role:</label>
            <input type="text" name="role" required><br>

            <button type="button" onclick="prevStep(1)">Previous</button>
            <button type="button" onclick="nextStep(2)">Next</button>
        </div>

        <!-- Step 3: Media Type Specialization -->
        <div class="form-step" id="step3">
            <h2>Media Type Specialization</h2>
            <label for="media_type">Media Type:</label><br>
            <input type="checkbox" name="media_type[]" value="Journalism"> Journalism<br>
            <input type="checkbox" name="media_type[]" value="Public Relations"> Public Relations<br>
            <input type="checkbox" name="media_type[]" value="Broadcasting"> Broadcasting<br>
            <input type="checkbox" name="media_type[]" value="Digital Media"> Digital Media<br>
            <input type="checkbox" name="media_type[]" value="Photography"> Photography<br>
            <input type="checkbox" name="media_type[]" value="Videography"> Videography<br>
            <input type="checkbox" name="media_type[]" value="Social Media Management"> Social Media Management<br>
            <input type="checkbox" name="media_type[]" value="Content Creation"> Content Creation<br>
            <input type="checkbox" name="media_type[]" value="Advertising"> Advertising<br>

            <button type="button" onclick="prevStep(2)">Previous</button>
            <button type="button" onclick="nextStep(3)">Next</button>
        </div>

        <!-- Step 4: Social Media Platforms -->
        <div class="form-step" id="step4">
            <h2>Social Media Platforms</h2>
            <label>Which platforms do you use professionally?</label><br>
            <input type="checkbox" name="social_media_platforms[]" value="Facebook"> Facebook<br>
            <input type="checkbox" name="social_media_platforms[]" value="Twitter"> Twitter<br>
            <input type="checkbox" name="social_media_platforms[]" value="Instagram"> Instagram<br>
            <input type="checkbox" name="social_media_platforms[]" value="LinkedIn"> LinkedIn<br>
            <input type="checkbox" name="social_media_platforms[]" value="YouTube"> YouTube<br>
            <input type="checkbox" name="social_media_platforms[]" value="TikTok"> TikTok<br>
            <input type="checkbox" name="social_media_platforms[]" value="Snapchat"> Snapchat<br>

            <label for="portfolio_links">Portfolio Link:</label>
            <input type="url" name="portfolio_link"><br>

            <label for="portfolio_links">Additional Portfolio Links:</label>
            <textarea name="portfolio_links"></textarea><br>


            <button type="button" onclick="prevStep(3)">Previous</button>
            <button type="button" onclick="nextStep(4)">Next</button>
        </div>

        <!-- Step 5: Additional Information -->
        <div class="form-step" id="step5">
            <h2>Additional Information</h2>
            <label for="area_of_expertise">Area of Expertise:</label>
            <input type="text" name="area_of_expertise"><br>

            <label for="location">Location:</label>
            <input type="text" name="location"><br>

            <label for="additional_comments">Additional Comments or Questions:</label>
            <textarea name="additional_comments"></textarea><br>

            <button type="button" onclick="prevStep(4)">Previous</button>
            <button type="button" onclick="nextStep(5)">Next</button>
        </div>

        <!-- Step 6: Upload Credentials -->
        <div class="form-step" id="step6">
            <h2>Upload Credentials</h2>
            <label for="profile_pic">Profile Picture:</label>
            <input type="file" name="profile_pic"><br>

            <label for="id_document">ID/Driver's License:</label>
            <input type="file" name="id_document" required><br>

            <label for="other_documents">Other Relevant Documents:</label>
            <input type="file" name="other_documents"><br>

            <button type="button" onclick="prevStep(5)">Previous</button>
            <button type="button" onclick="nextStep(6)">Next</button>
        </div>

        <!-- Step 7: Terms and Conditions and Submit -->
        <div class="form-step" id="step7">
            <h2>Final Step</h2>
            <label>
                <input type="checkbox" name="agree" required> I agree to the terms and conditions
            </label><br>

            <button type="button" onclick="prevStep(6)">Previous</button>
            <button type="button" name="save_draft" value="1">Save as Draft</button>
            <button type="submit">Submit</button>
        </div>
    </form>
</div>

<?php include 'components/footer.php'; ?>

<link rel="stylesheet" href="styles/styles.css" type="text/css">
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let currentStep = 1;
        const steps = document.querySelectorAll('.form-step');

        function showStep(step) {
            steps.forEach((el, index) => {
                el.style.display = (index + 1 === step) ? 'block' : 'none';
            });
        }

        function nextStep(step) {
            if (currentStep < steps.length) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep(step) {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        }

        document.querySelectorAll('button[type="button"]').forEach(button => {
            button.addEventListener('click', function() {
                if (this.textContent === 'Next') {
                    nextStep(currentStep);
                } else if (this.textContent === 'Previous') {
                    prevStep(currentStep);
                } else if (this.textContent === 'Save as Draft') {
                    // Handle save draft functionality here if needed
                    document.querySelector('form').submit(); // Submit form to save as draft
                }
            });
        });

        showStep(currentStep); // Show the first step initially
    });
</script>
<?php
include 'components/db_connect.php';
include 'components/header.php';

// Fetch all PROs
$sql_pros = "SELECT id, CONCAT(first_name, ' ', last_name) AS pro_name FROM public_relations_officers";
$result_pros = $conn->query($sql_pros);

// Fetch all agencies
$sql_agencies = "SELECT id, name FROM agencies";
$result_agencies = $conn->query($sql_agencies);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reporter_name = isset($_POST['reporter_name']) ? trim($_POST['reporter_name']) : NULL;
    $pro_id = isset($_POST['pro_id']) ? intval($_POST['pro_id']) : NULL;
    $agency_id = isset($_POST['agency_id']) ? intval($_POST['agency_id']) : NULL;
    $report_details = isset($_POST['report_details']) ? trim($_POST['report_details']) : NULL;
    $status = 'open';

    // Insert report into database
    $sql_insert = "INSERT INTO public_reports (reporter_name, pro_id, agency_id, report_details, submitted_at, status) 
                    VALUES (?, ?, ?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("sisss", $reporter_name, $pro_id, $agency_id, $report_details, $status);

    if ($stmt->execute()) {
        echo "<p>Report submitted successfully.</p>";
    } else {
        echo "<p>Error submitting the report: " . $stmt->error . "</p>";
    }
}
?>

<main>
<div class="container">
    <h2>Submit a Report</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="reporter_name">Reporter Name (Optional):</label>
            <input type="text" id="reporter_name" name="reporter_name" class="form-control">
        </div>

        <div class="form-group">
            <label for="pro_id">Select PRO (Optional):</label>
            <select id="pro_id" name="pro_id" class="form-control">
                <option value="">Select PRO</option>
                <?php while ($pro = $result_pros->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($pro['id']); ?>">
                        <?php echo htmlspecialchars($pro['pro_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="agency_id">Select Agency:</label>
            <select id="agency_id" name="agency_id" class="form-control" required>
                <option value="">Select Agency</option>
                <?php while ($agency = $result_agencies->fetch_assoc()) : ?>
                    <option value="<?php echo htmlspecialchars($agency['id']); ?>">
                        <?php echo htmlspecialchars($agency['name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="report_details">Report Details:</label>
            <textarea id="report_details" name="report_details" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Report</button>
    </form>
</div>
</main>

<?php include 'components/footer.php'; ?>

<!-- Updated CSS for Reports Page -->
<style>
.container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
}

.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
}
</style>

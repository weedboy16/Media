<?php
include 'components/db_connect.php';
include 'components/header.php';

// Get PRO ID from query parameter
$pro_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($pro_id <= 0) {
    echo "<p>Invalid Public Relations Officer ID.</p>";
    include 'components/footer.php';
    exit;
}

// Fetch PRO details and reports
$sql = "SELECT pro.first_name, pro.last_name, pro.profile_image, pr.quarterly_reports
        FROM public_relations_officers pro
        LEFT JOIN pro_register pr ON pro.id = pr.pro_id
        WHERE pro.id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "<p>Error preparing the statement: " . $conn->error . "</p>";
    include 'components/footer.php';
    exit;
}

$stmt->bind_param("i", $pro_id);
$stmt->execute();
$result = $stmt->get_result();
$pro = $result->fetch_assoc();

if (!$pro) {
    echo "<p>Public Relations Officer not found.</p>";
    include 'components/footer.php';
    exit;
}

// Check if quarterly_reports field has content
$quarterly_reports = !empty($pro['quarterly_reports']) ? $pro['quarterly_reports'] : null;

?>

<main>
<div class="container">
    <div class="profile-container">
        <div class="profile-image">
            <?php if (!empty($pro['profile_image'])): ?>
                <img src="<?php echo 'pro-img/' . htmlspecialchars($pro['profile_image']); ?>" alt="Profile Image">
            <?php else: ?>
                <img src="path_to_default_image.jpg" alt="Default Profile Image">
            <?php endif; ?>
        </div>
        <div class="profile-details">
            <h2><?php echo htmlspecialchars($pro['first_name'] . ' ' . $pro['last_name']); ?></h2>
        </div>
    </div>

    <div class="reports-header">
        <h3>Quarterly Reports</h3>
    </div>

    <div class="reports-container">
        <?php
        if ($quarterly_reports) {
            // If the quarterly_reports field contains line breaks, treat it as multiple reports
            $reports = explode("\n", $quarterly_reports); // Split reports by line breaks
            foreach ($reports as $report) {
                echo "<div class='report'>
                        <p>" . nl2br(htmlspecialchars($report)) . "</p>
                      </div>";
            }
        } else {
            echo "<p>No quarterly reports found.</p>";
        }
        ?>
    </div>
</div>
</main>

<?php include 'components/footer.php'; ?>

<!-- Updated CSS for Reports Page -->
<style>
.profile-container {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}

.profile-image img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    margin-right: 20px;
}

.profile-details {
    max-width: 600px;
}

.reports-header {
    margin-top: 40px;
    margin-bottom: 20px;
}

.reports-container {
    margin-top: 20px;
}

.report {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.report p {
    margin-bottom: 10px;
}

.btn-secondary {
    background-color: #6c757d;
    color: #fff;
}
</style>

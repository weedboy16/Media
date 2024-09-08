<?php
include 'components/db_connect.php';
include 'components/header.php';

// Fetch Public Relations Officers, their ratings, and organization names
$sql = "SELECT pro.id, pro.first_name, pro.last_name, a.name AS organization_name, AVG(f.rating) AS avg_rating, pro.profile_image
        FROM public_relations_officers pro
        LEFT JOIN agencies a ON pro.agency_id = a.id
        LEFT JOIN feedback f ON pro.id = f.pro_id
        GROUP BY pro.id";
$result = $conn->query($sql);
?>

<main>
    <div class="container">
        <h2>Public Relations Officers</h2>
        <table id="proTable">
            <thead>
                <tr>
                    <th>Profile Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Organization</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $rating = round($row['avg_rating']);
                        echo "<tr>
                                <td><img src='pro-img/{$row['profile_image']}' alt='Profile Image' class='profile-img'></td>
                                <td>{$row['first_name']}</td>
                                <td>{$row['last_name']}</td>
                                <td>{$row['organization_name']}</td>
                                <td>" . str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating) . "</td>
                                <td><a href='pro_profile.php?id={$row['id']}' class='view-profile-btn'>View Profile</a></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No Public Relations Officers found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<?php include 'components/footer.php'; ?>

<!-- Include DataTables JS and CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    $('#proTable').DataTable();
});
</script>


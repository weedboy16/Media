<?php
include 'components/db_connect.php';
include 'components/header.php';

// Get PRO ID from query parameter
$pro_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch PRO details
$sql = "SELECT pro.first_name, pro.last_name, pro.email, pro.phone_number, pro.credentials, pro.professional_history, pro.profile_image, a.name AS organization_name, AVG(f.rating) AS avg_rating, COUNT(f.id) AS num_ratings
        FROM public_relations_officers pro
        LEFT JOIN agencies a ON pro.agency_id = a.id
        LEFT JOIN feedback f ON pro.id = f.pro_id
        WHERE pro.id = ?
        GROUP BY pro.id";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pro_id);
$stmt->execute();
$result = $stmt->get_result();
$pro = $result->fetch_assoc();

if (!$pro) {
    echo "<p>Public Relations Officer not found.</p>";
    exit;
}

// Fetch PRO's feedback
$sql_feedback = "SELECT f.rating, f.feedback_text, f.submitted_at
                 FROM feedback f
                 WHERE f.pro_id = ?";
$stmt_feedback = $conn->prepare($sql_feedback);
$stmt_feedback->bind_param("i", $pro_id);
$stmt_feedback->execute();
$result_feedback = $stmt_feedback->get_result();
?>

<main>
<div class="container">
    <div class="profile-container">
        <div class="profile-image">
            <img src="<?php echo 'pro-img/' . htmlspecialchars($pro['profile_image']); ?>" alt="Profile Image">
        </div>
        <div class="profile-details">
            <h2><?php echo htmlspecialchars($pro['first_name'] . ' ' . $pro['last_name']); ?></h2>
            <p><strong>Organization:</strong> <?php echo htmlspecialchars($pro['organization_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($pro['email']); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($pro['phone_number']); ?></p>
            <p><strong>Credentials:</strong> <?php echo nl2br(htmlspecialchars($pro['credentials'])); ?></p>
            <p><strong>Professional History:</strong> <?php echo nl2br(htmlspecialchars($pro['professional_history'])); ?></p>
            <p><strong>Rating:</strong> 
                <?php
                $rating = round($pro['avg_rating']);
                echo str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating);
                echo " (" . $pro['num_ratings'] . " ratings)";
                ?>
            </p>
        </div>
    </div>

    <div class="reviews-header">
    <h3>Reviews</h3>
    <div>
        <button id="addReviewBtn" class="btn btn-primary">Add Review</button>
        <a href="view_reports.php?id=<?php echo $pro_id; ?>" class="btn btn-primary">View Reports</a>
    </div>
</div>


    <div class="reviews-container">
        <?php
        if ($result_feedback->num_rows > 0) {
            while($row_feedback = $result_feedback->fetch_assoc()) {
                $rating = $row_feedback['rating'];
                echo "<div class='review'>
                        <div class='review-rating'>" . str_repeat("&#9733;", $rating) . str_repeat("&#9734;", 5 - $rating) . "</div>
                        <div class='review-text'>" . htmlspecialchars($row_feedback['feedback_text']) . "</div>
                        <div class='review-date'>" . htmlspecialchars($row_feedback['submitted_at']) . "</div>
                      </div>";
            }
        } else {
            echo "<p>No reviews found.</p>";
        }
        ?>
    </div>

    <!-- Add Review Modal -->
    <div id="addReviewModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Add Review</h2>
            <form id="reviewForm" method="POST" action="submit_review.php">
                <input type="hidden" name="pro_id" value="<?php echo $pro_id; ?>">
                
                <label for="rating">Rating:</label>
                <div class="star-rating">
                    <input type="hidden" id="ratingValue" name="rating" value="1" required>
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                </div>

                <label for="feedback_text">Feedback:</label>
                <textarea id="feedback_text" name="feedback_text" rows="4" required></textarea>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>

</div>
</main>

<?php include 'components/footer.php'; ?>

<!-- Updated CSS -->
<style>
.profile-container {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
}

.profile-image img {
    width: 300px;
    height: 300px;
    border-radius: 10px;
    margin-right: 20px;
}

.profile-details {
    max-width: 600px;
}

.reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.reviews-container {
    margin-top: 20px;
}

.review {
    border-bottom: 1px solid #ddd;
    padding: 10px 0;
}

.review-rating {
    font-size: 1.2em;
    color: #f39c12;
}

.review-text {
    margin: 5px 0;
}

.review-date {
    font-size: 0.9em;
    color: #999;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    color: #fff;
    cursor: pointer;
    font-size: 16px;
}

.btn-primary {
    background-color: #007bff;
}

/* Star Rating CSS */
.star-rating {
    
    font-size: 2em;
}

.star {
    color: #ccc; /* Default star color */
    cursor: pointer;
    transition: color 0.3s;
}



.star.selected {
    color: #f39c12; /* Selected star color */
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
    padding-top: 60px;
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
}

.close-btn {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close-btn:hover,
.close-btn:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}
</style>

<!-- Updated JavaScript -->
<script>
document.getElementById('addReviewBtn').onclick = function() {
    document.getElementById('addReviewModal').style.display = 'block';
}

document.querySelector('.close-btn').onclick = function() {
    document.getElementById('addReviewModal').style.display = 'none';
}

window.onclick = function(event) {
    if (event.target === document.getElementById('addReviewModal')) {
        document.getElementById('addReviewModal').style.display = 'none';
    }
}

// Star rating script
const stars = document.querySelectorAll('.star');
let selectedRating = 1; // Set default rating to 1

// Initialize the first star as selected
document.getElementById('ratingValue').value = selectedRating;
document.querySelector(`[data-value="1"]`).classList.add('selected');

stars.forEach(star => {
    star.addEventListener('click', () => {
        selectedRating = star.getAttribute('data-value');
        document.getElementById('ratingValue').value = selectedRating;

        // Update selected stars
        stars.forEach(s => s.classList.remove('selected'));
        stars.forEach(s => {
            if (s.getAttribute('data-value') <= selectedRating) {
                s.classList.add('selected');
            }
        });
    });

    star.addEventListener('mouseover', () => {
        resetStars();
        const hoverRating = star.getAttribute('data-value');
        stars.forEach(s => {
            if (s.getAttribute('data-value') <= hoverRating) {
                s.classList.add('hovered');
            }
        });
    });

    star.addEventListener('mouseout', resetStars);
});

function resetStars() {
    stars.forEach(s => s.classList.remove('hovered'));
    // Keep selected stars colored
    stars.forEach(s => {
        if (s.getAttribute('data-value') <= selectedRating) {
            s.classList.add('selected');
        }
    });
}
</script>

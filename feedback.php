<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background-image: url('images/bg-myatt.png');
    }
/* Customize header */
.navbar {
    height: 60px; /* Adjust height */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add subtle shadow */
}

.navbar-brand {
    font-size: 1.5rem; /* Increase font size */
    font-weight: bold; /* Make it bold */
}

        
        /* Custom star styling */
#starRating i {
    font-size: 2rem;
    cursor: pointer;
    color: #ccc;
    transition: color 0.2s;
}

#starRating i.active {
    color: #ffc107; /* Yellow for active stars */
}

/* Form shadow effect */
form {
    max-width: 500px;
    margin: 0 auto;
}

    </style>
</head>
<body>
       <!-- Blue Header -->
       <nav class="navbar navbar-dark bg-primary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">CJCRSG</span>
            <a href="#" class="logo">
            <img src="images/logo.png" alt="logo">
        </a>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">We Value Your Feedback!</h1>
        <form id="feedbackForm" class="p-4 shadow-lg bg-white rounded">
            <!-- Star Rating -->
            <div class="mb-3 text-center">
                <label for="starRating" class="form-label">Rate your experience</label>
                <div id="starRating" class="d-flex justify-content-center">
                    <i class="bi bi-star" data-star="1"></i>
                    <i class="bi bi-star" data-star="2"></i>
                    <i class="bi bi-star" data-star="3"></i>
                    <i class="bi bi-star" data-star="4"></i>
                    <i class="bi bi-star" data-star="5"></i>
                </div>
            </div>
            <!-- Additional Comments -->
            <div class="mb-3">
                <label for="comments" class="form-label">Additional Comments (optional)</label>
                <textarea class="form-control" id="comments" rows="4" placeholder="Tell us more about your experience"></textarea>
            </div>
            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Submit Feedback</button>
            </div>
        </form>
        <div id="feedbackMessage" class="mt-3 text-center"></div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript -->
    <script src="script.js"></script>
    <script> 
        document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('#starRating i');
    const feedbackMessage = document.getElementById('feedbackMessage');
    let selectedRating = 0;

    // Handle star click
    stars.forEach(star => {
        star.addEventListener('click', () => {
            selectedRating = star.dataset.star;
            updateStars(selectedRating);
        });

        star.addEventListener('mouseover', () => {
            updateStars(star.dataset.star);
        });

        star.addEventListener('mouseout', () => {
            updateStars(selectedRating);
        });
    });

    // Update star colors
    function updateStars(rating) {
        stars.forEach(star => {
            if (star.dataset.star <= rating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }

    // Handle form submission
    document.getElementById('feedbackForm').addEventListener('submit', (e) => {
        e.preventDefault();
        const comments = document.getElementById('comments').value;

        // Display feedback message
        feedbackMessage.innerHTML = `
            <div class="alert alert-success">
                Thank you for your feedback! <br>
                Rating: ${selectedRating} star(s) <br>
                ${comments ? `Comments: ${comments}` : ''}
            </div>
        `;

        // Reset form
        selectedRating = 0;
        updateStars(selectedRating);
        document.getElementById('comments').value = '';
    });
});

    </script>
</body>
</html>

<?php
include 'api/connection.php';

// Get the ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Default member name
$memberName = 'User';

// Query to find the member by ID and get their name
$sql = "SELECT name FROM member WHERE memberID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->store_result();

// If the member is found
if ($stmt->num_rows > 0) {
    $stmt->bind_result($fullName);
    $stmt->fetch();
    // Extract the first name from the full name
    $memberName = explode(' ', $fullName)[0];
}




// Query to count the total number of members
$sql = "SELECT COUNT(*) AS memberCount FROM member";
$result = $conn->query($sql);

// Fetch the member count
$memberCount = ($result->num_rows > 0) ? $result->fetch_assoc()['memberCount'] : 0;

// Close the database connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>CJCRSG</title>
    <!-- Linking Google fonts for icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="stylesheet" href="css/event.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
 
  <!-- DataTables CSS -->
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
/* Style for the Post button */
.post-button {
    background-color: #3E519C !important;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
.post-button:hover {
background-color: #344687 !important; /* Darker shade for hover effect */
}

/* Style for the Edit and Delete buttons */
.edit-button
{

    border: none;
    color: #3E519C;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}

.delete-button{
    color: maroon;
}

</style>




 
  <body>





  <header>
    <nav class="navbar">
        <span class="hamburger-btn material-symbols-rounded">menu</span>
        <a href="#" class="logo">
            <img src="images/logo.png" alt="logo">
            <h2>CJCRSG</h2>
        </a>
        <ul class="links">
            <span class="close-btn material-symbols-rounded">close</span>
            <li><a href="dashboard.php?id=<?php echo $_GET['id']; ?>">Dashboard</a></li>
            <li><a href="member.php?id=<?php echo $_GET['id']; ?>">Member</a></li>
            <li><a href="record.php?id=<?php echo $_GET['id']; ?>">Attendance</a></li>
            <li><a href="event.php?id=<?php echo $_GET['id']; ?>">Event</a></li>
        </ul>

          <!-- Dropdown Menu -->
          <div class="dropdown">
        <button
            class="btn dropdown-toggle"
            type="button"
            id="userDropdown"
            data-bs-toggle="dropdown"
            aria-expanded="false"
            style="background-color: white; color: black; border: 1px solid #ccc;"
        >
            <i class="bi bi-person-circle" style="color: #275360; margin-right: 5px;"></i> 
            <?php echo htmlspecialchars($memberName); ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="profile.php?id=<?php echo $_GET['id']; ?>">Profile</a></li>
            <li><a class="dropdown-item" href="#">Settings</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a></li>

        </ul>


        <!-- Logout Confirmation Modal -->


    </div>
    
      </nav>
  </header>
  <!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to logout?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <a href="api/logout.php" class="btn btn-primary" style="background-color: #465CB1; border-color: #465CB1; color: white;">Yes</a>
      </div>
    </div>
  </div>
</div>


<div class="form-popup"></div>
      

  


<div class="main-container">
        <!-- Create Post Container -->
        <div class="post-create-container">
            <textarea id="post-content" class="post-textarea" placeholder="Write something..."></textarea>
            <input type="file" id="image-upload" class="image-upload">
            <button class="post-button" type="button" onclick="createPost()">Post</button>

        </div>

        <!-- Post Feed Container -->
        <div class="post-feed-container">
            <div id="post-feed" class="post-feed"></div>
        </div>
    </div>




    <script>
       function createPost() {
    const postText = document.getElementById("post-content").value;
    const imageInput = document.getElementById("image-upload");
    const imageFile = imageInput.files[0];

    // Prevent posting if the textarea is empty and no image is selected
    if (!postText.trim() && !imageFile) {
        alert("Please write something or upload an image to post.");
        return;
    }

    const formData = new FormData();
    formData.append('postText', postText);
    if (imageFile) {
        formData.append('postImage', imageFile);
    }

    fetch('api/post.php', {
        method: 'POST',
        body: formData,
        headers: {
            'Accept': 'application/json',
        }
    })
    .then(response => {
        return response.text(); // Capture raw response first
    })
    .then(data => {
        try {
            const jsonData = JSON.parse(data); // Try parsing as JSON
            if (jsonData.success) {
                window.location.reload(); // Refresh the page after successful post creation
            } else {
                alert('Error: ' + jsonData.error);
            }
        } catch (error) {
            console.error('Error parsing JSON:', error);
            console.log('Raw response:', data); // Log the raw response to identify the issue
            alert('An unexpected error occurred. Please try again later.');
        }
    })
    .catch(error => {
        console.error('Error creating post:', error);
    });
}




function loadPosts() {
    fetch('api/loadPosts.php') // Fetching posts from the backend
        .then(response => response.json()) // Parse JSON response
        .then(posts => {
            const postFeed = document.getElementById("post-feed");
            postFeed.innerHTML = ''; // Clear current posts

            posts.forEach(post => {
                const postItem = document.createElement("div");
                postItem.classList.add("post-item");

                // Create post header with profile image and name
                const postHeader = document.createElement("div");
                postHeader.classList.add("post-header");

                const profileImg = document.createElement("img");
                profileImg.src = "images/logo.png"; // Placeholder for profile image
                profileImg.classList.add("profile-img");
                postHeader.appendChild(profileImg);

                const profileInfo = document.createElement("div");
                profileInfo.classList.add("profile-info");

                const name = document.createElement("div");
                name.classList.add("name");
                name.textContent = "Church of Jesus Christ the Risen Son of God Phils. Inc"; // Static name for now
                profileInfo.appendChild(name);

                const timestamp = document.createElement("div");
                timestamp.classList.add("timestamp");
                const postTime = new Date(post.timestamp * 1000); // Convert timestamp to Date
                timestamp.textContent = formatTime(postTime); // Function to format the timestamp
                profileInfo.appendChild(timestamp);

                postHeader.appendChild(profileInfo);
                postItem.appendChild(postHeader);

                const postContent = document.createElement("p");
postContent.innerHTML = post.text.replace(/\n/g, '<br>'); // Replace newlines with <br> tags
postContent.classList.add("post-text");
postItem.appendChild(postContent);

                // Check if there's an image and display it
                if (post.image) {
                    const img = document.createElement("img");
                    img.src = 'uploads/' + post.image;
                    img.classList.add("post-image");
                    postItem.appendChild(img);
                }

                // Add footer with edit and delete
                const postFooter = document.createElement("div");
                postFooter.classList.add("post-footer");

                // Edit button
                const editButton = document.createElement("button");
                editButton.classList.add("edit-button");
                editButton.innerHTML = '<i class="fas fa-edit"></i> Edit';

                editButton.addEventListener("click", () => {
                    const newText = prompt("Edit your post:", post.text);
                    if (newText && newText.trim() !== "") {
                        // Call API to update the post
                        fetch('api/editPost.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ text: newText, timestamp: post.timestamp }),
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    postContent.textContent = newText; // Update text in the DOM
                                    alert("Post updated successfully!");
                                } else {
                                    alert("Failed to update post: " + data.error);
                                }
                            })
                            .catch(error => console.error('Error editing post:', error));
                    }
                });

                postFooter.appendChild(editButton);

                // Delete button
                const deleteButton = document.createElement("button");
                deleteButton.classList.add("delete-button");
                deleteButton.innerHTML = '<i class="fas fa-trash"></i> Delete';

                deleteButton.addEventListener("click", () => {
                    if (confirm("Are you sure you want to delete this post?")) {
                        // Call API to delete the post
                        fetch('api/deletePost.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ timestamp: post.timestamp }),
                        })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    postItem.remove(); // Remove post from DOM
                                    alert("Post deleted successfully!");
                                } else {
                                    alert("Failed to delete post: " + data.error);
                                }
                            })
                            .catch(error => console.error('Error deleting post:', error));
                    }
                });

                postFooter.appendChild(deleteButton);

                postItem.appendChild(postFooter);

                // Append the new post to the feed
                postFeed.insertBefore(postItem, postFeed.firstChild);
            });
        })
        .catch(error => {
            console.error('Error loading posts:', error);
        });
}


function formatTime(date) {
    const hours = date.getHours();
    const minutes = date.getMinutes();
    const day = date.getDate();
    const month = date.getMonth() + 1;  // Months are zero-indexed
    const year = date.getFullYear();
    return `${month}/${day}/${year} ${hours}:${minutes < 10 ? '0' + minutes : minutes}`;
}

// Call loadPosts when the page is loaded
document.addEventListener("DOMContentLoaded", loadPosts);




function editPost(timestamp, newText) {
    console.log("Editing post with timestamp:", timestamp); // Debug log
    fetch('api/editPost.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ timestamp, text: newText })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Post updated successfully!');
        } else {
            console.error('Failed to update post:', data.error);
            alert('Error: ' + data.error);
        }
    })
    .catch(error => console.error('Error editing post:', error));
}


</script>

    <!-- Linking custom script -->
    <script src="js/dashbooard.js"></script>
</body>
</html>
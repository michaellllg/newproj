<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
       /* General Styles */
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #f4f6f9;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

header {
    width: 100%;
}

main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
}

.announcement-box {
    width: 90%;
    max-width: 600px;
    background: #fff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin: 0 auto;
}

.announcement-box h2 {
    color: #275360;
    margin-bottom: 1.5rem;
}

.announcement-box img {
    width: 200px; /* Set the desired size of the icon */
    height: 150px;
}

.announcement-box ul {
    padding: 0;
    list-style: none;
    text-align: left;
}

.announcement-box ul li {
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
}

.announcement-box ul li:last-child {
    border-bottom: none;
}

/* Heart Button Styling */
.heart-button {
    border: none;
    background-color: transparent;
    color: #3E519C;
    cursor: pointer;
    font-size: 1rem;
    padding: 5px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.heart-button i {
    font-size: 1.5rem;  /* Adjust size */
}

/* Default heart icon (empty) */
.heart-button i.bi-heart {
    color: #3E519C;
}

/* Filled heart when liked */
.heart-button.liked i.bi-heart-fill {
    color: red;
}

/* Comment Button Styling */
.comment-button {
    border: none;
    background-color: transparent;
    color: #3E519C;
    cursor: pointer;
    font-size: 1rem;
    padding: 5px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.comment-button i {
    font-size: 1.2rem;
}

/* Post Feed Styles */
.post-feed-container {
    width: 100%;
    max-width: 600px;
    margin-top: 20px;
}

.post-item {
    background-color: #fff;
    padding: 15px;
    margin-bottom: 15px;
    border-radius: 10px;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.post-header {
    display: flex;
    align-items: center;
}

.profile-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    margin-right: 10px;
}

.profile-info {
    flex-grow: 1;
}

.name {
    font-weight: bold;
}

.timestamp {
    color: #888;
    font-size: 0.9rem;
}

.post-text {
    margin-top: 10px;
    font-size: 1rem;
}

.post-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 15px;
}

.post-image {
    max-width: 100%;
    height: auto;
    margin-top: 10px;
}

/* Buttons (Post and Delete) */
.edit-button,
.delete-button {
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 0.9rem;
}

.edit-button {
    background-color: transparent;
    color: #3E519C;
    border: 1px solid #3E519C;
}

.delete-button {
    background-color: transparent;
    color: maroon;
    border: 1px solid maroon; 
}

.edit-button:hover,
.delete-button:hover {
    opacity: 0.7;
}

/* Additional Styles for Buttons */
.post-button {
    background-color: #3E519C !important;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.post-button:hover {
    background-color: #344687 !important;
}

    </style>
</head>
<body>
    <header>
        <?php include('nav.php'); ?>
    </header>
    <main>
        <div class="announcement-box">
        <img src="images/a-icon.png" alt="announcement-Icon">
            <h2>Announcement!</h2>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>


<div class="main-container">

        <!-- Post Feed Container -->
        <div class="post-feed-container">
            <div id="post-feed" class="post-feed"></div>
        </div>

        
    </div>

    <script>
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

                    // Add footer with heart react and comment buttons
                    const postFooter = document.createElement("div");
                    postFooter.classList.add("post-footer");

                    // Heart button (like react)
                    const heartButton = document.createElement("button");
                    heartButton.classList.add("heart-button");
                    heartButton.innerHTML = '<i class="bi bi-heart"></i> Like';
                    heartButton.addEventListener("click", () => {
                        const heartIcon = heartButton.querySelector("i");
                        if (heartIcon.classList.contains("bi-heart")) {
                            heartIcon.classList.remove("bi-heart");
                            heartIcon.classList.add("bi-heart-fill"); // Turn to filled heart (red)
                        } else {
                            heartIcon.classList.remove("bi-heart-fill");
                            heartIcon.classList.add("bi-heart"); // Revert to empty heart
                        }
                    });
                    postFooter.appendChild(heartButton);

                    // Comment button
                    const commentButton = document.createElement("button");
                    commentButton.classList.add("comment-button");
                    commentButton.innerHTML = '<i class="bi bi-chat"></i> Comment';
                    commentButton.addEventListener("click", () => {
                        // Open a prompt to add a comment (or open a comment box, this can be extended)
                        const commentText = prompt("Add a comment:");
                        if (commentText) {
                            alert("Comment added: " + commentText);
                        }
                    });
                    postFooter.appendChild(commentButton);

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

    // Function to edit posts (this is a placeholder for any backend logic)
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



</body>
</html>

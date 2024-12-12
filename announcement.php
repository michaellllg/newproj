<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<style>
    
.announcement-box {
    width: 90%;
    max-width: 500px;
    background: #ffff;
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


.post-footer {
    display: flex;
    align-items: center;
    margin-top: 10px;
    gap: 15px;
}

.reaction-wrapper {
    display: inline-flex;
    align-items: center;
    gap: 5px; /* Add space between icon and label */
    cursor: pointer;
}

.reaction-icon {
    font-size: 1.8em;
    color: #888;
    transition: transform 0.2s, color 0.2s;
}

.reaction-icon:hover {
    color: #ff4757; /* Hover color for heart */
    transform: scale(1.2); /* Enlarge slightly on hover */
}

.reaction-icon.liked {
    color: #ff4757; /* Liked color for heart */
    animation: like-bounce 0.4s ease;
}

.reaction-label {
    font-size: 0.9em;
    color: #555;
    transition: color 0.2s;
}

.reaction-wrapper:hover .reaction-label {
    color: #000; /* Darker color on hover */
}

@keyframes like-bounce {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.3);
    }
}


</style>
<body>
<?php include('nav.php'); ?>
    </header>
    <main>
        <div class="announcement-box">
        <img src="images/a-icon.png" alt="announcement-Icon">
            <h2>Announcement!</h2>
        </div>

        

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

                // Add footer for reactions
                const postFooter = document.createElement("div");
                postFooter.classList.add("post-footer");

                // Heart reaction
                const heartWrapper = document.createElement("div");
                heartWrapper.classList.add("reaction-wrapper");

                const heartIcon = document.createElement("i");
                heartIcon.classList.add("fas", "fa-heart", "reaction-icon"); // FontAwesome heart icon
                heartWrapper.appendChild(heartIcon);

                const likeLabel = document.createElement("span");
                likeLabel.classList.add("reaction-label");
                likeLabel.textContent = "Like";
                heartWrapper.appendChild(likeLabel);

                heartWrapper.addEventListener("click", () => {
                    // Toggle like animation and backend update
                    heartIcon.classList.toggle("liked");
                    fetch('api/likePost.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ timestamp: post.timestamp }),
                    }).catch(error => console.error('Error liking post:', error));
                });

                postFooter.appendChild(heartWrapper);

                // Share reaction
                const shareWrapper = document.createElement("div");
                shareWrapper.classList.add("reaction-wrapper");

                const shareIcon = document.createElement("i");
                shareIcon.classList.add("fas", "fa-paper-plane", "reaction-icon"); // FontAwesome share icon
                shareWrapper.appendChild(shareIcon);

                const shareLabel = document.createElement("span");
                shareLabel.classList.add("reaction-label");
                shareLabel.textContent = "Share";
                shareWrapper.appendChild(shareLabel);

                shareWrapper.addEventListener("click", () => {
                    // Logic to share the post (e.g., copy link or open a share modal)
                    const shareLink = `${window.location.origin}/post/${post.id}`;
                    navigator.clipboard.writeText(shareLink)
                        .then(() => {
                            alert("Post link copied to clipboard!");
                        })
                        .catch(error => {
                            console.error("Error sharing post:", error);
                            alert("Failed to copy share link.");
                        });
                });

                postFooter.appendChild(shareWrapper);

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
</script>


</body>
</html>
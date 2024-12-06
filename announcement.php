<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Announcement</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
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
            width: 150px; /* Set the desired size of the icon */
            height: 100px;
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
    </style>
</head>
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
<<<<<<< HEAD
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
=======
<?php include('nav.php'); ?>


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

>>>>>>> c29f2c7c27a5a8293f7e4d4546c71e3e677d2204
</body>
</html>

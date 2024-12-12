<?php
error_reporting(E_ALL); // Enable all error reporting for debugging

include 'api/connection.php';


$memberID = isset($_GET['id']) ? (int) $_GET['id'] : 0; // Default to 0 if id is not set

// Initialize an image path variable
$imagePath = 'https://dummyimage.com/600x400/000/fff'; // Default placeholder

// Fetch the stored image path from the database
if ($memberID > 0) {
    $query = "SELECT image FROM accountinfo WHERE memberID = $memberID";
    $result = mysqli_query($conn, $query);

    if ($result && $data = mysqli_fetch_assoc($result)) {
        if (!empty($data['image'])) {
            $imagePath = './uploads/' . $data['image']; // Use the stored image path
        }
    }
}
if (isset($_FILES['uploadfile']) && $memberID > 0) {
    $filename = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "uploads/" . $filename;  // Path to the 'uploads' folder

    // Escape special characters in the filename to prevent SQL injection
    $filename = mysqli_real_escape_string($conn, $filename);

    // Fetch the current image path from the database
    $query = "SELECT image FROM accountinfo WHERE memberID = $memberID";
    $result = mysqli_query($conn, $query);
    $currentImage = null;

    if ($result && $data = mysqli_fetch_assoc($result)) {
        $currentImage = $data['image']; // Get the current image name
    }

    // Update the image column for the given memberID
    $sql = "UPDATE accountinfo SET image='$filename' WHERE memberID = $memberID";

    // Execute the query and check for errors
    if (mysqli_query($conn, $sql)) {
        $msg = "Image updated successfully in the database!";

        // If there's an old image, delete it from the uploads folder
        if ($currentImage && file_exists("uploads/" . $currentImage)) {
            unlink("uploads/" . $currentImage);
        }

        // Move the uploaded image into the 'uploads' folder
        if (move_uploaded_file($tempname, $folder)) {
            $msg .= " New image uploaded successfully to folder!";
        } else {
            $msg .= " Failed to upload new image to folder!";
        }
    } else {
        $msg = "Error updating image in the database: " . mysqli_error($conn);
    }

    // Return response
    echo json_encode(['message' => $msg]);
    exit;
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/x-icon" href="images/logo.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/profile.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Include QRious library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
</head>

<style>
    /* Custom styles for the confirmation modal */
    #confirmationModal .modal-content {
       
            box-shadow: 5px 5px 15px rgba(0, 0, 0, 0.3); /* Border shadow */

            width: 75%; /* Reduce the width by 1/4 (making it 75% of the original size) */
            margin: auto; /* Center the modal */
    }


/* Dimmed effect for modals underneath */
.modal.dimmed {
    filter: brightness(50%); /* Darkens the modal to simulate dimming */

     /* Ensure modal width remains constant */
  #qrCodeModal .modal-dialog {
    max-width: 400px; /* Set a fixed maximum width */
    width: 100%; /* Make it responsive */
  }

  /* Ensure image inside modal does not stretch */
  #qrCodeImage {
    width: 100%; /* Ensures the image is responsive */
    height: auto; /* Keep aspect ratio intact */
  }

  /* Optional: Ensure button stays properly aligned */
  #downloadQRCodeBtn {
    width: 100%; /* Ensures button remains responsive */
  }
}


</style>
<body>
    <header>
        <nav class="navbar">
           
            <a href="#" class="logo">
                <img src="images/logo.png" alt="logo">
                <h2>CJCRSG</h2>
            </a>
           
            <button onclick="goBack()" class="login-btn">← Go Back</button>
        </nav>
    </header>


    
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                <div class="profile-img">
            <!-- Dynamically set the src attribute based on the PHP variable -->
           <img id="displayedImage" src="<?php echo $imagePath; ?>" alt="" style="width: 200px; height: 150px; margin: 10px;" />

            <div class="file btn btn-lg btn-primary">
                Change Photo
                <input type="file" id="uploadfile" name="file" />
            </div>
        </div>
                </div>


                <script>
        document.getElementById('uploadfile').addEventListener('change', function () {
            const formData = new FormData();
            formData.append('uploadfile', this.files[0]);

            // Preview the selected image
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('displayedImage').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }

            // Upload the file to the server
            fetch('', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    // Optionally reload the page to reflect database changes
                    location.reload();
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            <span id="memberName">Michael Nacion</span>
                        </h5>
                        <h6 id="roleType">Admin</h6>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Qr Code</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="profile-edit-btn" data-toggle="modal" data-target="#editProfileModal">Edit Profile</button>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-work">
                        <p>SOCIAL MEDIA LINK</p>
                        <a href="">Facebook Link</a><br/>
                        <a href="">Instagram Profile</a><br/>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                        <div class="row">
                        <div class="col-md-6">
                            <label>Member ID</label>
                        </div>
                        <div class="col-md-6">
                            <p id="memberID"></p>
                         </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="email"></p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="phone"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Status</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="status"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Life Stage</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="lifeStage"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="address"></p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<!-- QR Code Modal Trigger Button -->
<button type="button" class="btn btn-primary" id="generateQRCodeBtn">View your QR Code</button>

<!-- QR Code Modal -->
<div class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog" aria-labelledby="qrCodeModalLabel" aria-hidden="true" style="max-width: 400px; width: 100%; margin: auto;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="qrCodeModalLabel">Your QR Code</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <!-- QR Code Image -->
        <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid" />
        <br />
        <!-- Download Button -->
        <a href="" id="downloadQRCodeBtn" class="btn btn-success mt-2" download="qrcode.png">Download</a>
      </div>
    </div>
  </div>
</div>



                        </div>
                    </div>
                </div>
            </div>
        </form>           
    </div>
    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editProfileForm">
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" class="form-control" id="editName" placeholder="Enter name">
                        </div>

                        
                        <div class="form-group">
                            <label for="editStatus">Status</label>
                            <select class="form-control" id="editStatus">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="editLifeStage">Life Stage</label>
                            <input type="text" class="form-control" id="editLifeStage" placeholder="Enter life stage">
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email address</label>
                            <input type="email" class="form-control" id="editEmail" aria-describedby="emailHelp" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Phone number</label>
                            <input type="text" class="form-control" id="editPhone" placeholder="Enter phone number">
                        </div>
                        <div class="form-group">
                            <label for="editAddress">Address</label>
                            <input type="text" class="form-control" id="editAddress" placeholder="Enter address">
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color: #0F3E84;">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Changes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to save the changes?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="confirmSaveButton">Yes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


    <script>
    // JavaScript to navigate back when the button is clicked
    function goBack() {
      window.history.back(); // Navigate to the previous page
    }
  </script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <!-- Include QRious library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrious/4.0.2/qrious.min.js"></script>



    <script>

// Fetch the memberID from the URL
function getParameterByName(name) {
    var urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(name) || '';
}

// Fetch and display memberID (padded with leading zeros)
$(document).ready(function () {
    var memberID = getParameterByName('id'); // Get the memberID from the URL
    if (memberID) {
        // Pad the memberID to be 4 digits
        var paddedMemberID = ('000' + memberID).slice(-4);
        $('#memberID').text(paddedMemberID); // Display it in the profile
    }
});








        $(document).ready(function () {
    let formData = {}; // Declare formData in a wider scope for reuse

    $('#editProfileForm').submit(function (event) {
        event.preventDefault(); // Prevent immediate submission

        // Get form data
        formData = {
            memberID: getParameterByName('id'),
            name: $('#editName').val(),
            status: $('#editStatus').val(),
            lifeStage: $('#editLifeStage').val(),
            email: $('#editEmail').val(),
            phone: $('#editPhone').val(),
            address: $('#editAddress').val()
        };

        // Show the confirmation modal
        $('#confirmationModal').modal('show');
    });

    // Handle confirmation modal "Yes" button
    $('#confirmSaveButton').click(function () {
        const memberID = formData.memberID;

        // Send form data to server using AJAX
        $.ajax({
            type: 'POST',
            url: 'api/update.php?memberID=' + memberID, // Include memberID in the URL
            data: formData,
            success: function (response) {
                if (response.success) {
                    // Update profile details displayed on the page
                    $('#memberName').text(formData.name);
                    $('#email').text(formData.email);
                    $('#phone').text(formData.phone);
                    $('#status').text(formData.status);
                    $('#lifeStage').text(formData.lifeStage);
                    $('#address').text(formData.address);
                    $('#roleType').text(formData.roleType);

                    // Hide both modals
                $('#editProfileModal').modal('hide');
                $('#confirmationModal').modal('hide');

                // Manually remove the backdrop
                $('.modal-backdrop').remove();
                } else {
                    console.error('Error updating profile:', response.error);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error updating profile:', error);
            }
        });
    });

    // Helper function to parse URL parameters
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }


    // Event listener for the button click to trigger QR code generation
    document.getElementById('generateQRCodeBtn').addEventListener('click', function () {
        var memberID = getParameterByName('id'); // Replace with your actual member ID logic
        generateQRCode(memberID); // Call function to generate QR code

        // Show the modal with the QR code
        $('#qrCodeModal').modal('show');
    });

    // Function to get URL parameter by name
    function getParameterByName(name) {
        var urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name) || '';
    }

    // Function to generate QR code using QRious library
    function generateQRCode(memberID) {
        // Ensure memberID is always 4 digits, padding with zeros if necessary
        var paddedMemberID = ('00' + memberID).slice(-4);

        var qr = new QRious({
            value: paddedMemberID, // QR code content
            size: 512, // Size of the QR code
            background: 'white',
            foreground: 'black'
        });

        // Update the modal with the generated QR code
        document.getElementById('qrCodeImage').src = qr.toDataURL();

        // Set the download link for the QR code image
        document.getElementById('downloadQRCodeBtn').href = qr.toDataURL();
    }

            // Update the fetchMemberData function to handle the role type
            function fetchMemberData() {
                var memberID = getParameterByName('id');
                if (memberID) {
                    var xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.responseText);
                            if (data.member) {
                                var member = data.member;
                                // Update the role type displayed in the <h6> element
                                $('#memberName').text(member.name);
                                $('#email').text(member.email);
                                $('#phone').text(member.phone);
                                $('#status').text(member.status);
                                $('#lifeStage').text(member.life_stage);
                                $('#address').text(member.address);
                                $('#editName').val(member.name);
                                $('#editStatus').val(member.status);
                                $('#editLifeStage').val(member.life_stage);
                                $('#editEmail').val(member.email);
                                $('#editPhone').val(member.phone);
                                $('#editAddress').val(member.address);
                                $('#roleType').text(member.roletype); // Update the role type here
                                // Generate QR code
                                generateQRCode(memberID);
                            }
                        }
                    };
                    xhr.open('GET', 'api/db.php?memberID=' + memberID, true);
                    xhr.send();
                }
            }

            // Call fetchMemberData function when the edit profile modal is shown
            $('#editProfileModal').on('show.bs.modal', function (event) {
                fetchMemberData();
            });

            // Call fetchMemberData function when the page is loaded
            fetchMemberData();
        });
    </script>


<script>
$(document).ready(function () {
    // Open the confirmation modal and dim the Edit Profile Modal
    $('#editProfileForm').submit(function (event) {
        event.preventDefault();

        // Show the confirmation modal
        $('#confirmationModal').modal({
            backdrop: 'static', // Prevent closing when clicking outside
            keyboard: false     // Prevent closing with ESC key
        });

        // Dim the Edit Profile Modal
        $('#editProfileModal').addClass('dimmed');

        // Ensure proper stacking of the backdrops
        $('#confirmationModal').on('shown.bs.modal', function () {
            $('.modal-backdrop').not('.stacked-backdrop').addClass('stacked-backdrop').css('z-index', 1048);
        });
    });

    // Remove dimming when confirmation modal is closed
    $('#confirmationModal').on('hidden.bs.modal', function () {
        $('#editProfileModal').removeClass('dimmed'); // Remove dimming from the Edit Profile Modal
        $('.stacked-backdrop').removeClass('stacked-backdrop'); // Reset backdrop stacking
    });

    // Close both modals when saving changes
    $('#confirmSaveButton').click(function () {
        $('#confirmationModal').modal('hide'); // Hide confirmation modal
        $('#editProfileModal').modal('hide'); // Optionally hide Edit Profile Modal
    });
});

</script>

    
  
</body>
</html>
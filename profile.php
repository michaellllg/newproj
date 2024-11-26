<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            border: 3px solid black; /* Add a black border with 3px thickness */
            width: 75%; /* Reduce the width by 1/4 (making it 75% of the original size) */
            margin: auto; /* Center the modal */
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
                        <img src="https://dummyimage.com/600x400/000/fff" alt=""/>
                        <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file"/>
                        </div>
                    </div>
                </div>
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
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="email">nacionm007@gmail.com</p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Phone</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="phone">09123456789</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Status</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="status">Active</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Life Stage</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="lifeStage">College Student</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Address</label>
                                </div>
                                <div class="col-md-6">
                                    <p id="address">San Roque</p>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <img id="qrcode"></img>
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

    <script>
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

    // Fetch member data and other existing functionality remains unchanged

            function generateQRCode(memberID) {
            // Add two leading zeros to memberID
            var paddedMemberID = ('00' + memberID).slice(-4);

            var qr = new QRious({
                value: paddedMemberID,
                size: 128,
                background: 'white',
                foreground: 'black'
            });

            // Set the src attribute of the image to the data URL
            $('#qrcode').attr('src', qr.toDataURL());
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

    
  
</body>
</html>
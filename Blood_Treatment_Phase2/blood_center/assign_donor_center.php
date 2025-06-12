<?php
require '../includes/auth.php';
require '../includes/db.php';
requireRole('blood_center');

$staff_id = $_SESSION['user_id'];

// Step 1: Get logged-in staff's name
$stmt = $conn->prepare("SELECT name FROM staff WHERE id = ?");
$stmt->bind_param("i", $staff_id);
$stmt->execute();
$res = $stmt->get_result();
$staff = $res->fetch_assoc();
$staff_name = $staff['name'] ?? null;

// Step 2: Match that name with blood_centers.name
$blood_center = null;
$blood_center_id = null;

if ($staff_name) {
    $stmt = $conn->prepare("SELECT id, name FROM blood_centers WHERE name = ?");
    $stmt->bind_param("s", $staff_name);
    $stmt->execute();
    $res = $stmt->get_result();
    $blood_center = $res->fetch_assoc();
    $blood_center_id = $blood_center['id'] ?? null;
}
$blood_center_id = $blood_center['id'] ?? null;
$user_list = [];

if ($blood_center_id) {
    $stmt = $conn->prepare("
        SELECT u.id, u.name ,u.age,u.gender,u.dob,u.blood_group,u.mobile_number,u.email,u.address
        FROM users u
        JOIN user_test_results utr ON u.id = utr.user_id
      WHERE (u.blood_center_id = ? AND u.referred_blood_center IS NULL AND utr.status = 'positive') 
   OR (u.referred_blood_center = ? AND utr.status = 'positive')

    ");
    $stmt->bind_param("ii", $blood_center_id, $blood_center_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_list = $result->fetch_all(MYSQLI_ASSOC);
}

$b_center_id = $blood_center_id;
$room_id = $_POST['room_id'] ?? null;
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_POST['user_id'] ?? null;
    $treatment_center_id = $_POST['treatment_center_id'] ?? null;
    $b_center_id = $blood_center_id;
    $district_id = $_POST['district_id'] ?? null;
    $block_id = $_POST['block_id'] ?? null;
    $room_id = $_POST['room_id'] ?? null;


    // Step 1: Get block and room details
    $stmt = $conn->prepare("SELECT block_name FROM blocks WHERE id = ?");
    $stmt->bind_param("i", $block_id);
    $stmt->execute();
    $blockResult = $stmt->get_result();
    $block = $blockResult->fetch_assoc();
    $block_name = $block['block_name'] ?? null;

    $stmt = $conn->prepare("SELECT room_name, doctor_name, doctor_contact FROM rooms WHERE id = ?");
    $stmt->bind_param("i", $room_id);
    $stmt->execute();
    $roomResult = $stmt->get_result();
    $room = $roomResult->fetch_assoc();
    $room_name = $room['room_name'] ?? null;
    $doctor_name = $room['doctor_name'] ?? null;
    $doctor_contact = $room['doctor_contact'] ?? null;


    // Step 2: Prevent duplicate treatment entry
    $checkStmt = $conn->prepare("SELECT id FROM treatments WHERE user_id = ?");
    $checkStmt->bind_param("i", $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();


    // Check required fields
    if ($user_id && $treatment_center_id && $block_id && $room_id && isset($_FILES['consent_file'])) {
        $file_tmp = $_FILES['consent_file']['tmp_name'];

        $target_dir = "../uploads/consents/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $file_name = basename($_FILES["consent_file"]["name"]);
        $target_file = $target_dir . time() . "_" . $file_name;

        $upload_ok = true;

        // Validate file type
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/png'];
        if (!in_array($_FILES['consent_file']['type'], $allowed_types)) {
            $message = "<div class='alert alert-danger'>Invalid file type. Only PDF, JPG, and PNG are allowed.</div>";
            $upload_ok = false;
        }

        if ($checkResult->num_rows > 0) {
            $message = "<div class='alert alert-warning'>This user is already assigned to a Treatment Center.</div>";
        } else {
            // Step 3: Insert treatment
            if ($upload_ok && move_uploaded_file($file_tmp, $target_file)) {
                $insert = $conn->prepare("INSERT INTO treatments (user_id, treatment_center_id, blood_center_id, district_id, file_path,room_no, block, doctor_name, doctor_contact) VALUES (?, ?, ?, ?, ?,?,?,?,?)");
                $insert->bind_param("iiiisssss", $user_id, $treatment_center_id, $b_center_id, $district_id, $target_file, $room_name, $block_name, $doctor_name, $doctor_contact);
                if ($insert->execute()) {
                    // Remove user from dropdown by filtering again
                    $user_list = array_filter($user_list, function ($u) use ($user_id) {
                        return $u['id'] != $user_id;
                    });
                    $message = "<div class='alert alert-success'>Treatment Center assigned to User Successfully!</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Failed to assign Treatment Center.</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Failed to upload file. Please try again.</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Please fill in all required fields.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Assign Donor to Treatment Center</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="../includes/css/font-awesome.min.css">
    <!-- Sandstone Bootstrap CSS -->


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

</head>

<body>
    <?php include('../includes/dashboard_layout/header.php'); ?>

    <div class="ts-main-content">
        <?php include('../includes/leftbar.php'); ?>
        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <h2 class="page-title">Assign Donor's to Treatment Center</h2>
                        <form method="POST" id="assignForm" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="blood_center_name">Your Blood Center</label>
                                <input type="text" readonly class="form-control" value="<?= htmlspecialchars($blood_center['name'] ?? 'N/A') ?>">
                                <input type="hidden" name="blood_center_id" value="<?= $blood_center_id ?>">
                            </div>


                            <div class="mb-3">
                                <label for="user_id">User List</label>
                                <select name="user_id" id="user_id" class="form-control" required>
                                    <option value="">Select User</option>
                                    <?php foreach ($user_list as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>



                            <div class="mb-3">
                                <label for="district_id">Select District</label>
                                <select name="district_id" id="district_id" class="form-control" required>
                                    <option value="">Select District</option>
                                    <?php
                                    $districtQuery = $conn->query("SELECT id, name FROM districts");
                                    while ($district = $districtQuery->fetch_assoc()):
                                    ?>
                                        <option value="<?= $district['id'] ?>"><?= htmlspecialchars($district['name']) ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Treatment Centers</label>
                                <select name="treatment_center_id" id="treatment_center" class="form-control" required>
                                    <option value="">Select Treatment Center</option>
                                </select>
                            </div>


                            <div class="mb-3">
                                <label>Blocks List</label>
                                <select name="block_id" id="blockSelect" class="form-select" required>
                                    <option value="">Select Block</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Room List</label>
                                <select name="room_id" id="roomSelect" class="form-select" required>
                                    <option value="">Select Room</option>
                                    <!-- Rooms will be loaded dynamically via AJAX -->
                                </select>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="consentCheckbox">
                                <label class="form-check-label" for="consentCheckbox">
                                    I consent to share my data with the Blood Center and its Treatment Center.
                                </label>
                            </div>

                            <!-- Hidden Button to View Consent Form -->
                            <div class="mb-3" id="consentButtonWrapper" style="display: none;">
                                <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#consentModal">
                                    View Consent Form
                                </button>
                            </div>

                            <!-- Consent Modal -->
                            <div class="modal" id="consentModal" tabindex="-1" aria-labelledby="consentModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="consentModalLabel">Consent Form</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body" id="consentContent">

                                            <h2 class="text-danger" style="text-align: center; text-decoration: underline;">Consent Form</h2>

                                            <p class="font-bold mb-2"><u><h4>Donor Details</h4></u></p>
                                            <div><strong>Name:</strong> <span id="userName"></span></div>
                                            <div><strong>Donor Email:</strong> <span id="userEmail"></span></div>
                                            <div><strong>Donor Age:</strong> <span id="userAge"></span></div>
                                            <div><strong>Donor D.O.B:</strong> <span id="userDob"></span></div>
                                            <div><strong>Blood Group:</strong> <span id="userBloodGroup"></span></div>
                                            <div><strong>Gender:</strong> <span id="userGender"></span></div>
                                            <div><strong>Donor Address:</strong> <span id="userAddress"></span></div>

                                            <p class="font-bold mb-2 mt-3"><u><h4>Treatment Details</h4></u></p>
                                            <div><strong>District:</strong> <span id="selectedDistrict"></span></div>
                                            <div><strong>Blood Center:</strong> <?= htmlspecialchars($blood_center['name'] ?? 'N/A') ?></div>
                                            <div><strong>Treatment Center:</strong> <span id="selectedTreatmentCenter"></span></div>
                                            <div><strong>Block:</strong> <span id="selectedBlock"></span></div>
                                            <div><strong>Room No:</strong> <span id="selectedRoom"></span></div>
                                            <div><strong>Doctor Name:</strong> <span id="doctorNameField">Loading...</span></div>
                                            <div><strong>Doctor Contact:</strong> <span id="doctorContactField">Loading...</span></div>

                                            <hr>

                                            <p style="margin-top: 20px;">
                                                I, <strong><span id="userNameRepeat"></span></strong>, give my consent to the above-mentioned Blood Center to share my health and treatment-related details with the appropriate Treatment Center, if required. I understand the purpose of this and agree to the terms voluntarily.
                                            </p>

                                            <p style="margin-top: 30px;">Signature: ______________________</p>
                                            <p>Date: <?= date("d/m/Y") ?></p>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-success" id="downloadBtn" onclick="downloadConsent()" disabled>
                                                Submit & Download PDF
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <label>Upload Signed Consent Form</label>
                            <input type="file" name="consent_file" accept=".pdf,.jpg,.png" class="form-control mb-3 mt-3" required>
                            <button class="btn btn-primary" id="finalSubmitBtn" disabled>Submit</button>
                        </form>
                        <?php if (!empty($message)) echo "<div id='formMessage' class='my-3'>$message</div>"; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    //format date
    function formatDate(dateString) {
        if (!dateString) return '';
        const parts = dateString.split('-'); // ["2025", "05", "07"]
        return `${parts[2]}-${parts[1]}-${parts[0]}`; // "07-05-2025"
    }

    //check the fields are filled or not for consent form
    $(document).ready(function() {
        function checkFormCompletion() {
            const userSelected = $('#user_id').val() !== "";
            const treatmentCenterSelected = $('#treatment_center').val() !== "";
            const blockSelected = $('#blockSelect').val() !== "";
            const roomSelected = $('#roomSelect').val() !== "";

            if (userSelected && treatmentCenterSelected && blockSelected && roomSelected) {
                $('#downloadBtn').prop('disabled', false);
            } else {
                $('#downloadBtn').prop('disabled', true);
            }
        }

        // Run check on page load
        checkFormCompletion();

        // Run check when any relevant select changes
        $('#user_id, #treatment_center, #blockSelect, #roomSelect').on('change', function() {
            checkFormCompletion();
        });



        //fetch treatment centers


        $('#district_id').on('change', function() {
            var districtId = $(this).val();

            if (districtId) {
                $('#blockSelect').html('<option value="">Select Block</option>');
                $.ajax({
                    url: 'fetch_treatment_center.php',
                    method: 'POST',
                    data: {
                        district_id: districtId
                    },
                    dataType: 'json',
                    success: function(response) {
                        const districtName = response.district_name;

                        $('#selectedDistrict').text(districtName);

                        if (response.status === 'success' && Array.isArray(response.data)) {
                            var treatmentCenters = response.data;

                            // Clear the treatment center dropdown
                            $('#treatment_center').html('<option value="">Select Treatment Center</option>');

                            // Append each treatment center to the dropdown
                            treatmentCenters.forEach(function(center) {
                                $('#treatment_center').append(
                                    $('<option>', {
                                        value: center.id,
                                        text: center.center_name
                                    })
                                );
                            });
                        } else {
                            alert("Invalid response data");
                            $('#treatment_center').html('<option value="">Select Treatment Center</option>');
                        }
                    },
                    error: function(xhr) {
                        console.log("AJAX Error: ", xhr.status, xhr.statusText);
                        console.log("Response Text: ", xhr.responseText);
                    }
                });
            } else {
                $('#treatment_center').html('<option value="">Select Treatment Center</option>');
            }
        });

    });


    document.addEventListener('DOMContentLoaded', function() {
        const messageBox = document.getElementById('formMessage');
        const form = document.getElementById('assignForm');

        if (messageBox && messageBox.innerText.includes("already been allotted")) {
            setTimeout(() => {
                form.reset();
            }, 3000); // 3 seconds
        }

        //download consent form
        const finalSubmitBtn = document.getElementById('finalSubmitBtn');


    });

    async function downloadConsent() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    const consentElement = document.getElementById("consentContent");

    await doc.html(consentElement, {
        callback: function (doc) {
            doc.save("Consent_Form.pdf");

            // Enable the final form submission button
            finalSubmitBtn.disabled = false;

            // Close modal after download
            const modal = bootstrap.Modal.getInstance(document.getElementById('consentModal'));
            modal.hide();
        },
        x: 10,
        y: 10,
        width: 190,  // control page width (A4 width ~210mm)
        windowWidth: consentElement.scrollWidth, // ensures better rendering
    });
}


</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        //fetch user details
        $('#user_id').on('change', function() {
            var userId = $(this).val();

            if (userId) {
                $.ajax({
                    url: 'get_user_details.php',
                    method: 'POST',
                    data: {
                        user_id: userId
                    },
                    dataType: 'json', // tells jQuery to expect JSON
                    success: function(response) {
                        if (response.status === 'success') {
                            var user = response.data;

                            console.log(user);
                            // Update each span in the modal
                            $('#userEmail').text(user.email);
                            $('#userAge').text(user.age);
                            $('#userDob').text(formatDate(user.dob));
                            $('#userBloodGroup').text(user.blood_group);
                            $('#userGender').text(user.gender);
                            $('#userAddress').text(user.address);

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        console.log("AJAX Error: ", xhr.status, xhr.statusText);
                        console.log("Response Text: ", xhr.responseText);
                    }
                });
            } else {
                // Clear fields if no user selected

            }
        });






        //fetch treatment center blocks and rooms
        const treatmentSelect = document.getElementById('treatment_center');
        const blockSelect = document.getElementById('blockSelect');
        const roomSelect = document.getElementById('roomSelect');

        treatmentSelect.addEventListener('change', function() {
            const treatmentCenterId = this.value;

            if (treatmentCenterId) {
                fetch('fetch_blocks.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'treatment_center_id=' + encodeURIComponent(treatmentCenterId)
                    })
                    .then(response => response.text())
                    .then(data => {
                        blockSelect.innerHTML = '<option value="">Select Block</option>' + data;
                        roomSelect.innerHTML = '<option value="">Select Room</option>'; // reset rooms
                    });
            } else {
                blockSelect.innerHTML = '<option value="">Select Block</option>';
                roomSelect.innerHTML = '<option value="">Select Room</option>';
            }
        });

        blockSelect.addEventListener('change', function() {
            const blockId = this.value;

            if (blockId) {
                fetch('fetch_rooms.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'block_id=' + encodeURIComponent(blockId)
                    })
                    .then(response => response.text())
                    .then(data => {
                        roomSelect.innerHTML = '<option value="">Select Room</option>' + data;
                    });
            } else {
                roomSelect.innerHTML = '<option value="">Select Room</option>';
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const consentButtonWrapper = document.getElementById('consentButtonWrapper');

        const userSelect = document.getElementById('user_id');
        const treatmentSelect = document.getElementById('treatment_center');
        const blockSelect = document.getElementById('blockSelect');
        const roomSelect = document.getElementById('roomSelect');


        $('#consentCheckbox').on('change', function() {
            if ($(this).is(':checked')) {
                $('#consentButtonWrapper').show();
            } else {
                $('#consentButtonWrapper').hide();

            }
        });




        // Populate modal on button click
        document.querySelector('[data-bs-target="#consentModal"]').addEventListener('click', function() {

            const roomId = document.getElementById('roomSelect').value;

            // Set room number
            const selectedRoom = document.getElementById('roomSelect');
            const selectedRoomText = selectedRoom.options[selectedRoom.selectedIndex]?.text || 'N/A';
            document.getElementById('selectedRoom').textContent = selectedRoomText;

            // Fetch doctor details
            if (roomId) {
                fetch('get_doctor_details.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: `room_id=${roomId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('doctorContactField').textContent = data.doctor_contact || 'N/A';
                        document.getElementById('doctorNameField').textContent = data.doctor_name || 'N/A';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('doctorAddressField').textContent = 'Error loading address';
                        document.getElementById('doctorContactField').textContent = 'Error loading contact';
                        document.getElementById('doctorNameField').textContent = 'Error loading name';
                    });
            } else {
                document.getElementById('doctorAddressField').textContent = 'No room selected';
                document.getElementById('doctorContactField').textContent = 'N/A';
                document.getElementById('doctorNameField').textContent = 'N/A';
            }


            const userName = userSelect.options[userSelect.selectedIndex].text || 'N/A';
            const treatment = treatmentSelect.options[treatmentSelect.selectedIndex]?.text || 'N/A';
            const block = blockSelect.options[blockSelect.selectedIndex]?.text || 'N/A';
            const room = roomSelect.options[roomSelect.selectedIndex]?.text || 'N/A';

            document.getElementById('userName').innerText = userName;
            document.getElementById('userNameRepeat').innerText = userName;
            document.getElementById('selectedTreatmentCenter').innerText = treatment;
            document.getElementById('selectedBlock').innerText = block;
            document.getElementById('selectedRoom').innerText = room;
        });
    });
</script>
function domReady(fn) {
    if (
        document.readyState === "complete" ||
        document.readyState === "interactive"
    ) {
        setTimeout(fn, 1000);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

domReady(function () {
    function onScanSuccess(decodeText) {
        // Assuming the QR code contains the memberID
        const memberID = decodeText.trim();

        if (memberID !== "") {
            // Send the memberID to the server for attendance recording
            fetch("https://cjcrsg.site/api/insert.php", { // Fixed URL with HTTPS
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ memberID: memberID }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    // Check if attendance recorded successfully
                    if (data.success) {
                        window.location.href = "attendanceRecorded.html";
                    } else {
                        // Handle other responses, such as invalid member ID
                        alert(data.message || "Error recording attendance");
                    }
                })
                .catch((error) => {
                    // Handle fetch error
                    alert("Error: " + error.message);
                });
        } else {
            alert("Scanned QR code is invalid or empty.");
        }
    }

    // Initialize the QR code scanner
    let htmlscanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 10, qrbox: 250 }
    );
    htmlscanner.render(onScanSuccess);
});

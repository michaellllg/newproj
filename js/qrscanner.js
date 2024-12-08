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
        const memberID = decodeText.trim();

        if (memberID !== "") {
            console.log("Sending request to server with memberID:", memberID);
            
            fetch("https://cjcrsg.site/api/insert.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ memberID: memberID }),
            })
                .then(response => {
                    console.log("Response status:", response.status);
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Server response data:", data);
                    if (data.success) {
                        window.location.href = "attendanceRecorded.html";
                    } else {
                        alert(data.message || "Error recording attendance");
                    }
                })
                .catch(error => {
                    console.error("Error during fetch request:", error);
                    alert("Error: " + error.message);
                });
        } else {
            alert("Scanned QR code is invalid or empty.");
        }
    }

    let htmlscanner = new Html5QrcodeScanner(
        "my-qr-reader",
        { fps: 10, qrbox: 250 }
    );
    htmlscanner.render(onScanSuccess);
});

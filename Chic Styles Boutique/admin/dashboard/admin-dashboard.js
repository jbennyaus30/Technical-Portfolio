// Fulfill Order
document.getElementById("fulfill-order-btn").addEventListener("click", function () {
    const orderStatus = document.getElementById("order-status").value;
    const trackingNo = document.getElementById("tracking-no").value;

    // Perform update logic here (e.g., send to server via AJAX or fetch)
    alert(`Order Status: ${orderStatus}\nTracking No.: ${trackingNo}`);

    // Example: Update the displayed status text
    document.querySelector(".status-shipped").innerText = orderStatus;
});

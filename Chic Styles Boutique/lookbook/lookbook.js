document.addEventListener('DOMContentLoaded', () => {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            tabButtons.forEach(btn => btn.classList.remove('active'));
            // Hide all tab contents
            tabContents.forEach(content => content.classList.remove('active'));
            // Add active class to clicked button
            button.classList.add('active');
            // Show corresponding tab content
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });

    // Initialize the first tab as active
    document.querySelector('.tab-btn').click();
});

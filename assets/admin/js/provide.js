document.addEventListener('DOMContentLoaded', function() {
    // Function to update the countdown timer
    function startCountdown(rowElement, durationInSeconds) {
        const countdownElement = rowElement.querySelector('.countdown');

        const countdownInterval = setInterval(() => {
            const hours = Math.floor(durationInSeconds / 3600);
            const minutes = Math.floor((durationInSeconds % 3600) / 60);
            const seconds = Math.floor(durationInSeconds % 60);

            countdownElement.textContent = `${hours}:${minutes}:${seconds}`;

            if (durationInSeconds <= 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = '00:00:00';
            } else {
                durationInSeconds--;
            }
        }, 1000); // Update every second
    }

    // Get all table rows
    // const tableRows = document.querySelectorAll('.table tbody tr');
    const tableRows = document.querySelectorAll('#provide-admin tbody tr');

    // Loop through each row and start countdown
    tableRows.forEach((row, index) => {
        const duration = row.getAttribute('data-timer-duration');
        startCountdown(row, duration);
    });
});

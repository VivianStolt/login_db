<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <title>
        <?php if(isset($page_title)){ echo "$page_title";} ?> - Logo Name
    </title>
</head>
<body>

    <div class="progress-bar-container">
    <div id="progress-bar" class="progress-bar" style="width: 2+px;"></div>
    </div>

    <h2>Mikä on sukupuolesi?</h2>


    <script>
        // This function updates the progress bar based on the current step and total steps
        function updateProgressBar(currentStep, totalSteps) {
            const progressBar = document.getElementById('progress-bar');
            const progressPercentage = (currentStep / totalSteps) * 100;
            progressBar.style.width = progressPercentage + '%';
        }

        // Example of usage on page load
        document.addEventListener('DOMContentLoaded', function() {
            // Assuming the current step and total steps are passed to this script
            const totalSteps = 6; // Define total steps (gender, body details, hobbies, etc.)
            const currentStep = parseInt('<?php echo $currentStep; ?>'); // Assuming PHP variable to track the step

            // Update the progress bar on page load
            updateProgressBar(currentStep, totalSteps);
        });
    </script>
</body>
</html>
<?php include "../../dbconn.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recycling Guidelines</title>
    <link rel="stylesheet" href="../assets/collector.css">
    <link rel="stylesheet" href="../assets/collector.css">
</head>
<body>

    <?php include "navbar.php"; ?>

    <main class="page">
        <a href="collector_dashboard.php" class="back-button">&larr; Back</a>
        <h1>Recycling Guidelines</h1>
        <p>Follow these guides to check whether an item can be recycled.</p>

        <div class="guideline-grid">
    <figure class="guideline-figure">
        <button type="button" class="zoom-trigger"
                data-full="../image/recycling_guidelines_1.png"
                aria-label="Enlarge recycling guideline picture 1">
            <img src="../image/recycling_guidelines_1.png"
                 alt="Item can and cannot be recycled"
                 class="guideline-img">
        </button>
    </figure>

    <figure class="guideline-figure">
        <button type="button" class="zoom-trigger"
                data-full="../image/recycling_guidelines_2.png"
                aria-label="Enlarge recycling guideline picture 2">
            <img src="../image/recycling_guidelines_2.png"
                 alt="Do before recycling"
                 class="guideline-img">
        </button>
    </figure>
</div>

<p class="form-hint">Tap a picture to enlarge it.</p>

<dialog id="imageDialog" class="image-dialog" aria-label="Enlarged guideline picture">
    <button type="button" id="closeDialog" class="button">Close</button>
    <div class="dialog-scroll">
        <img id="dialogImg" src="" alt="">
    </div>
</dialog>
    </main>

    <script src="../assets/script.js"></script>
</body>
</html>
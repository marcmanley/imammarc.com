<?php include('header-main.php'); ?>

<?php include('meta-1.php'); ?>

<?php // Social Media Thumbnail ?>

<meta property="og:title" content="Imam Marc Manley">
	<meta property="og:description" content="Imam Marc Manley's Official Website">
	<meta property="og:image" content="https://imammarc.com/media/imgs/imammarcmanley-website-social-media-thumbnial.png">
	<meta property="og:url" content="https://imammarc.com">
	<meta name="twitter:card" content="summary_large_image">

<?php include('meta-2.php'); ?>

<title>Search Results</title>
</head>
<body>
<div class="color-band"></div>
  <div id="wrapper">
    <header class="header">
      <h1>Search Results</h1>
    </header>

<div class="main-content">

<?php

// Function to perform recursive search
function searchFiles($directory, $query, &$results) {
    // The directory to search in
    $directory = $directory;

    // The search query
    $query = $query;

    // The array to store search results
    $results = $results;

    // Recursively search the directory for files that contain the search query
    $files = scandir($directory);

    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            // The path to the file
            $path = $directory . '/' . $file;

            // If the file is a regular file
            if (is_file($path)) {
                // Get the content of the file
                $content = file_get_contents($path);

                // If the content of the file contains the search query
                if (stristr($content, $query) !== false) {
                    // Add the file to the search results array
                    $results[] = $path;
                }
            } else {
                // If the file is a directory
                if (is_dir($path)) {
                    // Recursively search the directory
                    searchFiles($path, $query, $results);
                }
            }
        }
    }
}

// Check if the search form was submitted
if (isset($_GET['query']) && !empty($_GET['query'])) {
    // The search query
    $query = $_GET['query'];

    // The directory to search in (root directory of your website)
    $searchDirectory = $_SERVER['DOCUMENT_ROOT'];

    // The array to store search results
    $searchResults = $searchResults;

    // Perform recursive search in the entire website directory
    searchFiles($searchDirectory, $query, $searchResults);

    // Check if any search results were found
    if (!empty($searchResults)) {
        // Display search results
        foreach ($searchResults as $file) {
            // The relative path to the file
            $relativePath = str_replace($searchDirectory, '', $file);

            // Display the file as a link
            echo "<h2><a href=\"" . $relativePath . "\">$file</a></h2>";
        }
    } else {
        // Display the message "No results found"
        echo "No results found.";
    }
}
?>


<?php include('footer-universal.php'); ?>

<script>
    (function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date(); a = s.createElement(o),
        m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)
    })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

    ga('create', 'UA-62075617-1', 'auto');
    ga('send', 'pageview');

  </script>

</body>
</html>

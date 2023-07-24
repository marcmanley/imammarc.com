<?php

function getFileCreationTime($file) {
    if (file_exists($file)) {
        return filectime($file);
    } else {
        return 0;
    }
}

function getTitleFromPHPFile($file) {
    $contents = file_get_contents($file);
    preg_match("/<h1>(.*?)<\/h1>/", $contents, $matches);
    if (isset($matches[1])) {
        return $matches[1];
    } else {
        return basename($file, '.php');
    }
}

$dir = __DIR__ . '/pages/';
$articles_dir = $dir . 'articles/';
$non_articles_dir = $dir . 'non-articles/';

$articles = glob($articles_dir . '*.php');
$non_articles = glob($non_articles_dir . '*.php');

$files = array_merge($articles, $non_articles);

usort($files, function ($a, $b) {
    $time_a = getFileCreationTime($a);
    $time_b = getFileCreationTime($b);

    return $time_b - $time_a;
});

$rss_feed = '<?xml version="1.0" encoding="UTF-8"?>
<rss version="2.0">
<channel>
  <title>ImamMarc.Com RSS Feed</title>
  <link>https://imammarc.com</link>
  <description>RSS feed for articles and posts on imammarc.com</description>';

foreach ($files as $file) {
    $title = getTitleFromPHPFile($file);
    $link = 'https://imammarc.com/pages/' . basename($file);
    $creation_time = getFileCreationTime($file);

    // Skip .DS_Store files
    if (basename($file) === '.DS_Store') {
        continue;
    }

    if ($creation_time > 0) {
        $rss_feed .= '
        <item>
          <title>' . $title . '</title>
          <link>' . $link . '</link>
          <pubDate>' . date('D, d M Y H:i:s O', $creation_time) . '</pubDate>
        </item>';
    }
}

$rss_feed .= '
</channel>
</rss>';

file_put_contents('feed.xml', $rss_feed);

?>

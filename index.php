<?php
$rss = simplexml_load_file('https://feeds.thefossrant.com/rss_feed.xml');
$articles = [];

foreach ($rss->channel->item as $item) {
    $articles[] = [
        'title' => (string) $item->title,
        'link' => (string) $item->link,
        'description' => (string) $item->content,
        'summary' => (string) $item->summary,
        'pubDate' => strtotime((string) $item->pubDate),
        'image' => (string) $item->enclosure['url']
    ];
}

usort($articles, function($a, $b) {
    return $b['pubDate'] - $a['pubDate'];
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sid's Blog</title>
    <link rel="stylesheet" href="main.css">

    <style>
        img {
            width: 30%;
        }

        #g {
            width: 5%;
        }
    </style>

    <script src="https://feeds.thefossrant.com/analytics.js"></script>
</head>
<body>
<h1>Sid's Blog</h1>
<a href="https://feeds.thefossrant.com/rss_feed.xml"><img id="g" src="https://imgs.search.brave.com/rQlxtQgVqJ3Idh2u_XDI3BSXVxH0zckNhfwmVD7zi7U/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMtMDAuaWNvbmR1/Y2suY29tL2Fzc2V0/cy4wMC9yc3MtaWNv/bi0yNTZ4MjU2LWZs/dDJkdXQ5LnBuZw" width="36" alt="RSS"></a>
<?php foreach ($articles as $article): ?>
    <div class="article-summary glass">
        <h2><a href="article.php?id=<?php echo urlencode($article['title']); ?>"><?php echo $article['title']; ?></a></h2>
        <p><?php echo $article['summary']; ?></p>
        <img src="<?php echo $article['image']; ?>" alt="Image unavailable">
        <p>Published on: <?php echo date('Y-m-d H:i:s', $article['pubDate']); ?> UTC</p>
    </div>
<?php endforeach; ?>
</body>
</html>
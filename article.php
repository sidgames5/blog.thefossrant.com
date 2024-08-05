<?php
$rss = simplexml_load_file('https://feeds.thefossrant.com/rss_feed.xml');
$articles = [];

foreach ($rss->channel->item as $item) {
    $articles[] = [
        'title' => (string) $item->title,
        'link' => (string) $item->link,
        'content' => (string) $item->content,
        'pubDate' => strtotime((string) $item->pubDate),
        'image' => (string) $item->enclosure['url']
    ];
}
?>
<?php
$id = urldecode($_GET['id']);
$article = null;

foreach ($rss->channel->item as $item) {
    if ((string) $item->title === $id) {
        $article = [
            'title' => (string) $item->title,
            'link' => (string) $item->link,
            'pubDate' => strtotime((string) $item->pubDate),
            'image' => (string) $item->enclosure['url'],
            'content' => (string) $item->content,
            'tags' => (string) $item->tags
        ];
        break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $article['title']; ?></title>
    <link rel="stylesheet" href="main.css">

    <style>
        img {
            width: 50%;
        }
    </style>

    <script src="https://feeds.thefossrant.com/analytics.js"></script>
</head>
<body>
<h1><?php echo $article['title']; ?></h1>
<p>Published on: <?php echo date('Y-m-d H:i:s', $article['pubDate']); ?> UTC</p>
<button onclick="history.back()">Back</button>
<p>Tags: <?php echo $article['tags']; ?></p>
<img src="<?php echo $article['image']; ?>" alt="Image unavailable">
<div><p><?php echo $article['content']; ?></p></div>
</body>
</html>
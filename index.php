<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="./css/style.min.css" rel="stylesheet"/>
</head>
<body>
<?php
ini_set('display_errors', 1);
$loader = require __DIR__ . '/vendor/autoload.php';

use \Http\Client\Curl\Client as Curl;
use \Lib\Client;

$feed = "https://dev98.de/feed/";

$client = new Client(new Curl(), $feed);

$data = $client->getData();
$infos = $client->getInfos();
?>
<header>
    <a class="logo" href="<?php echo $infos['link'] ?>"><img src="<?php echo $infos['image']['url'] ?>"
                                                             alt="<?php echo $infos['image']['alt'] ?>"/>
    <h1><?php echo $infos['title'] ?></h1>
    </a>
    <nav>
        <a class="toggle" rel=".navigation">Menu</a>
        <div class="navigation">
        <a href="all">All</a>
        <a href="general">General</a>
        <a href="magento_1">Magento 1</a>
        <a href="magento_2">Magento 2</a>
        <a href="devop">Devop</a>
        </div>
    </nav>
</header>
<main>
    <article>
        <?php
        foreach ($data as $item) {
        //    print_r($item->children("content", true));
            $categories = [];
            foreach($item->category as $cat){
                $categories[] = str_replace(" ","_",$cat->__toString());
            }
            ?>
            <section class="<?php echo strtolower(implode(" ",$categories))?>">
                <h2><?php echo $item->title; ?></h2>
                <div class="minutes">
                <small>
                    <?php echo date('D, d.m.Y',strtotime($item->pubDate)); ?>
                </small>
                    <small class="categories"><?php echo str_replace("_"," ",$categories[0]) ?></small>
                </div>
                <div class="description">
                    <?php echo $item->description; ?>
                </div>
            </section>
            <?php
            //      $item->title; $item->link; $item->comments; $item->pubDate; $item->category; $item->guid; $item->description; $item->postId;
        }
        ?>
    </article>
</main>
<footer>
    <small class="copyright">&copy; Iva Korlevic for netz98</small>
</footer>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous"></script>
<script src="./js/script.min.js"></script>
</html>
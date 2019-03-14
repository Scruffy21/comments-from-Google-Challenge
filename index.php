<?php 

require 'assets/lib/details.php';

$conn = new mysqli($servername, $username, $password, $dbName);

$sql = 'SELECT * FROM `comments` ORDER BY `ID`';
$result = $conn->query($sql);

$commentsSection = '';

while ($row = mysqli_fetch_assoc ($result)) {
    $name = $row["Name"];
    $website = $row["Website"];
    $comment = $row["Comment"];
    $photo = $row["Photo"];
    $flag = $row["Flag"];
    $country = $row["Country"];
    $timestamp = $row["Time"];

    //dealing with time and date
    $dateTime = date_create();
    date_timestamp_set($dateTime, $timestamp);
    date_timezone_set($dateTime, timezone_open('Europe/Warsaw'));
    $time = $dateTime->format('H:i');
    $date = $dateTime->format('d.m.Y');
    
    $commentsSection = fillData($name, $website, $comment, $photo, $flag, $country, $time, $date) . $commentsSection;

}

function fillData($name, $website, $comment, $photo, $flag, $country, $time, $date) {
    $result =
        "<div class='cmnt'>
    
    <div class='cmnt-info'><img src='assets/flags/{$flag}.png' alt='{$country} flag' class='flag' title='{$country}'>
        <span class='user-name'>";

    if ($website == "") {
        $result = $result . "{$name}</span>";
    }
    else {
        $result = $result . "<a href='{$website}'>{$name}</a></span>";
    }
    $result = $result . "
                              
        <span class='datetime'><span class='time'>{$time}</span><span class='date'>{$date}</span></span>    
    </div>
    <div class='user-cmnt'><img src={$photo} alt='Poster image' class='user-img'>{$comment}</div>
    </div>";
    
    return $result;
}
?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Maven+Pro|Roboto" rel="stylesheet">
    <link href="assets/css/styles.css" rel="stylesheet" >

    <title>Farewell | Google Challenge Scholarship</title>
    <meta name="description" content="Place where the recipients of Google Developer Challenge Scholarship 2017/2018 could post their comments about the first Phase of the course. Made as a thank you to Google and Udacity for the opportunity we've been given, and also to have something to remember this course and community by and show how many people from different countries were affected by it.">
</head>

<body>
    <header>
        <h1><a href="https://www.udacity.com/google-scholarships" target="_blank">Google FEND Challenge Scholarship 2017/2018</a></h1>
        <div id="logo-cont">
            <a href="https://www.google.com" target="_blank"><img src="assets/logos/Google-svg-logo.svg" alt="Google logo" class="logo"></a>
            <h2>Goodbye to Phase One</h2>
            <a href="https://www.udacity.com" target="_blank"><img src="assets/logos/udacity-svg-white-logo.svg" alt="Udacity logo" class="logo"></a>
        </div>
    </header>

    <section id="commentsSection">
        <?php echo $commentsSection; ?>
    </section>

    <h3>Posting of comments is now disabled!</h3>
    <div id="frm-cont">
        <a href="#" id="top" class="slider visible">
            <i class="arrow ar-up"></i> <span>back to top</span>
        </a>
        <section id="postComment">
            <div id="preview-cont"><label for="photoInput" id="photoPreview">
                <i class="far fa-file-image"></i></label>
            </div>
            <label for="photoInput" id="photoLabel"><div>Choose image (optional)</div></label>
            <input type="file" id="photoInput" accept="image/*">
            <div id="nameInp-cont" class="inp-row">
                <label for="nameInput">Name:</label>
                <input type="text" id="nameInput" placeholder="Your name (required)">
            </div>
            <div id="urlInp-cont" class="inp-row">
                <label for="urlInput">Website:</label>
                <input type="url" id="urlInput" placeholder="Address of your website (optional)" title="Link will be attached to your name">
            </div>
            <textarea id="commentInput" placeholder="Write your comment here... (required)"></textarea>
            <button type="button" id="submit" disabled>POST<i class="fas fa-paper-plane"></i></button>
        </section>
    </div>
    <div id="cmntPosted" class="success-modal">Comment posted!</div>

    <a href="#frm-cont" id="openForm" class="slider">
        <i>+</i>
        <div>Post your comment</div>
    </a>

    <footer>
        <div>
            <p>Code on <a href="https://github.com/Scruffy21/comments-from-Google-Challenge" class="source" target="_blank">Github</a></P>
        </div>
        <div>
            <p>Comments by: </p>
            <p><a href="https://www.udacity.com/google-scholarships" class="recipients" target="_blank">Google Developer Challenge Scholarship</a> recipients</p>
        </div>
    </footer>

    <script src="assets/js/handleDb.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>
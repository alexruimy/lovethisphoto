<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Don't You Love This Photo?</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">

    <link rel="stylesheet" href="css/normalize.min.css">
    <link rel="stylesheet" href="css/main.css">

    <script src="js/vendor/modernizr-2.6.2.min.js"></script>
</head>
<body>
    <div id="wrap">
        <h1>Don't You Love This Photo?</h1>

        <table id="imageTable">
            <tr>
                <td><span class="arrow left" id="prev"></span></td>
                <td><img id="image" /></td>
                <td><span class="arrow right" id="next"></span></td>
            </tr>
        </table>
        
        <table id="ratingsTable">
            <tr>
                <td><span id="ratingUp" class="rating up"></span></td>
                <td><span id="voteUp" class="vote up"></span></td>
                <td><span id="voteDown" class="vote down"></span></td>
                <td><span id="ratingDown" class="rating down"></span></td>
            </tr>
        </table>
    </div>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

    <script src="js/main.js"></script>

</body>
</html>
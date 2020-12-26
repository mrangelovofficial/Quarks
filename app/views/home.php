<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>HomeController</title>
    <link rel="stylesheet" href="<?= URL_APP ?>resources/css/main.css">    
</head>
<body>
    <section class="wrapper">
        <header>
            <div id="Logo">
                <img src="<?= URL_APP ?>resources/images/logo.png">
            </div>
        </header>
        <div class="mainContent">
            <div class="mainForm">
                <form action="" method="POST" onsubmit="return onSubmitForm();">
                    <input type="url" id="urlPointing" placeholder="Type your URL">
                    <input type="submit" id="submitURL">
                    <label for="submitURL"><img src="<?= URL_APP ?>resources/images/btn-transfer.png" alt="Submit"></label>
                </form>
                <div class="congratulation">
                    <h2><span>Great!</span> You created your quick link.</h2>
                    <p></p>
                    <div class="congratulationBTN">
                        <span id="createAnother">Create Another</span>
                        <span id="copyContent">Copy URL</span>
                    </div>
                </div>
            </div>
        </div>
        <footer><a href="https://mrangelov.ga">Creator</a></footer>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.5.18/webfont.js" integrity="sha384-lN5TfD3NZM4jZQNnPZvggNwf0cQifyDyp09pFyiOrHXWNLOj43xGf2SnHO5K006r" crossorigin="anonymous"></script>
    <script src="<?= URL_APP ?>resources/js/app.js"></script>    
</body>
</html>
<!DOCTYPE html>
<html>

<head>
    <title>Footer with social icons</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="include/footer.css">
</head>

<body>
    <script>
        var iDiv = document.createElement('div');

    iDiv.id = 'block';
    iDiv.className = 'container';
    document.getElementsByTagName('body')[0].appendChild(iDiv);

    var hasVScroll = document.body.scrollHeight > document.body.clientHeight;
    if(!hasVScroll){
    
        var div2 = document.createElement('div');

        div2.className = 'content';
        iDiv.appendChild(div2);
    }
        </script>
    <footer id="myFooter">
        
        <div class="social-networks">
            <a href="#" class="twitter"><i class="fa fa-twitter">Kontaktai</i></a>
            <a href="#" class="twitter"><i class="fa fa-twitter">Sąlygos</i></a>
            <a href="#" class="twitter"><i class="fa fa-twitter">Pranešk apie klaidą</i></a>
        </div>
        </div>
        <?php /*
        <div class="social-networks">
            <a href="#" class="twitter"><i class="fa fa-twitter"><img src="include/icons/fb.png"  alt="" class="rounded-circle"></i></a>
            <a href="#" class="facebook"><i class="fa fa-facebook-official"></i></a>
            <a href="#" class="google"><i class="fa fa-google-plus"></i></a>
        </div>
        */ ?>
        <div class="footer-copyright">
            <p>©  2019, Korepetitas.lt</p>
        </div>
    </footer>

</body>

</html>

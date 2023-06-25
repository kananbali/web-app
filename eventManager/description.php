<?php 
// session_start();
// $_SESSION['fname'] = "6229dbe8d7b65.txt";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <div id="editorjs"></div>
    <script src="https://cdn.jsdelivr.net/npm/editorjs-html@3.4.0/build/edjsHTML.browser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/editorjs-parser@1/build/Parser.browser.min.js"></script>

    <script>
        var dat = "";
        $.ajax({
            url: "getdesc.php",
            type: "GET",
            dataType: "json",
            data: {
                fname: "<?php echo $_SESSION['fname']; ?>"
            },
            dataType: 'json',
            success: function(data) {
                // console.log(data);
                $('#editorjs').html(data);
            },
        })
    </script>
</body>

</html>
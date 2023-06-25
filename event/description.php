<?php 
// session_start();
// $_SESSION['fname'] = "6230bf5983b63.txt";
?>
    <style>
        img {
            /* width: 100vw; */
            max-height: calc(300px + 10vw);
            /* height: 100%; */
        }
        table {
            /* border-collapse: collapse; */
            width: 100%;
            color: #012970; 
            border: #000;
        }
    </style>
    <div id="editorjs"></div>
    <!-- <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.23.2/dist/editor.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/editorjs-html@3.4.0/build/edjsHTML.browser.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/editorjs-parser@1/build/Parser.browser.min.js"></script>

    <script>
        var parser = new edjsParser();
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
                $('#editorjs').html(parser.parse(data));
            },
            error: function(data) {
                $('#editorjs').html("<p class='paragraph'>No Description Available</p>");
            }
        })
    </script>

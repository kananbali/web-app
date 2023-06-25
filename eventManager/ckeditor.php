<?php
// session_start();
if (isset($_SESSION['fname'])) {
    $file_name = $_SESSION['fname'];
    unset($_SESSION['fname']);
} else {
    $file_name = uniqid() . '.txt';
}

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

    <div id="editor">
        <!-- <p>Here goes the initial content of the editor.</p> -->
        <textarea name="textarea" id="txtedit" cols="30" rows="10"></textarea>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/classic/ckeditor.js"></script>
    <script src="https://ckeditor.com/apps/ckfinder/3.5.0/ckfinder.js"></script>

    <script>
        class MyUploadAdapter {
            constructor(loader) {
                // CKEditor 5's FileLoader instance.
                this.loader = loader;

                // URL where to send files.
                this.url = './upload.php';
            }

            // Starts the upload process.
            upload() {
                return new Promise((resolve, reject) => {
                    this._initRequest();
                    this._initListeners(resolve, reject);
                    this._sendRequest();
                });
            }

            // Aborts the upload process.
            abort() {
                if (this.xhr) {
                    this.xhr.abort();
                }
            }

            // Example implementation using XMLHttpRequest.
            _initRequest() {
                const xhr = this.xhr = new XMLHttpRequest();

                xhr.open('POST', this.url, true);
                xhr.responseType = 'json';
            }

            // Initializes XMLHttpRequest listeners.
            _initListeners(resolve, reject) {
                const xhr = this.xhr;
                const loader = this.loader;
                const genericErrorText = 'Couldn\'t upload file:' + ` ${ loader.file.name }.`;

                xhr.addEventListener('error', () => reject(genericErrorText));
                xhr.addEventListener('abort', () => reject());
                xhr.addEventListener('load', () => {
                    const response = xhr.response;

                    if (!response || response.error) {
                        return reject(response && response.error ? response.error.message : genericErrorText);
                    }

                    // If the upload is successful, resolve the upload promise with an object containing
                    // at least the "default" URL, pointing to the image on the server.
                    resolve({
                        default: response.url
                    });
                });

                if (xhr.upload) {
                    xhr.upload.addEventListener('progress', evt => {
                        if (evt.lengthComputable) {
                            loader.uploadTotal = evt.total;
                            loader.uploaded = evt.loaded;
                        }
                    });
                }
            }

            // Prepares the data and sends the request.
            _sendRequest() {
                const data = new FormData();

                data.append('upload', this.loader.file);

                this.xhr.send(data);
            }
        }

        function MyCustomUploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new MyUploadAdapter(loader);
            };
        }

        ClassicEditor
            .create(document.querySelector('#txtedit'), {
                // removePlugins: ['CKFinderUploadAdapter', 'CKFinder', 'EasyImage', 'Image', 'ImageCaption', 'ImageStyle', 'ImageToolbar', 'ImageUpload'],
                mediaEmbed: {
                    previewsInData: true
                },
                extraPlugins: [ MyCustomUploadAdapterPlugin ],
                // CKFinder:{
                //     url:'./upload.php',
                // }

            })
            .then(editor => {
                myEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        function savebtn() {
            // console.log(myEditor.getData());
            var fnam = '<?= $file_name ?>'
            document.cookie = "fname=" + fnam;
            $.ajax({
                url: 'savedesc.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    content: myEditor.getData(),
                    fname: fnam,
                },
                success: function(data) {
                    // console.log(data);
                }
            })

        }

        
    </script>

</body>

</html>

    <div id="editorjs"></div>
    <!-- <button onclick="savebtn()">Save</button> -->
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.23.2/dist/editor.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.7.0/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/header@2.6.2/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/embed@2.5.1/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@2.4.0/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@1.2.0/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/table@2.0.1/dist/table.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/marker@1.2.2/dist/bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@2.8.0/dist/bundle.min.js"></script>
    <script src=" https://cdn.jsdelivr.net/npm/@editorjs/image@2.3.0"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/editorjs-parser@1/build/Parser.browser.min.js"></script> -->

    <script>
        var editor = new EditorJS({
            holder: 'editorjs',
            tools: {
                header: Header,
                delimiter: Delimiter,
                paragraph: {
                    class: Paragraph,
                    inlineToolbar: true,
                },
                list: {
                    class: List,
                    inlineToolbar: true,
                },
                table: {
                    class: Table,
                    inlineToolbar: true,
                },
                marker: {
                    class: Marker,
                    shortcut: 'CMD+SHIFT+M',
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'CMD+SHIFT+O',
                    config: {
                        quotePlaceholder: 'Enter a quote',
                        captionPlaceholder: 'Quote\'s author',
                    },
                },
                list: List,
                image: {
                    class: ImageTool,
                    config: {
                        endpoints: {
                            byFile: './uploadeditorjs.php', // Your backend file uploader endpoint
                            byUrl: './uploadeditorjs.php', // Your endpoint that provides uploading by Url
                        }
                    }
                }
            },
            data:{},
            
        });


        function savebtn() {
            // const parser = new edjsParser();
            editor.save().then(outputData => {
                // console.log('Article data: ', outputData);
                $.ajax({
                    url: 'savedesc.php',
                    type: 'POST',
     
                    data: {
                        content: outputData,
                        fname: "<?php echo uniqid() . '.txt'; ?>",
                    },
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                    }
                });
            }).catch((error) => {
                console.log('Saving failed: ', error)
            });
        }
    </script>
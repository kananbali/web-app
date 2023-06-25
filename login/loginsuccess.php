<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Popup Login Success</title>
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
<script>
    Swal.fire({
        title:'Login Success',
        text:'You have successfully logged in!',
        icon:'success',

        showCancelButton: false,
        showCloseButton: false,
        showConfirmButton: false,

    })
</script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <h1>Login</h1>
    <form method="post">
        <input type="text" name="username" placeholder="Username"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit">Login</button>
    </form>

    <?php if (!empty($error)): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= addslashes($error) ?>'
        });
    </script>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?= addslashes($success) ?>'
        }).then(() => {
            window.location.href = '<?= $redirect ?? "/" ?>';
        });
    </script>
    <?php endif; ?>
</body>
</html>

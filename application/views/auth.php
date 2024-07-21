<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>

        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?= base_url() ?>assets/plugins/fontawesome-free/css/all.min.css">

        <!-- jQuery -->
        <script src="<?= base_url() ?>assets/plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap core CSS -->
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= base_url() ?>assets/css/signin.css" rel="stylesheet">
    </head>
    <body class="text-center">
        <?php if ($this->session->flashdata('status') == 'error_message') : ?>
            <script>
                alert('<?= $this->session->flashdata('message') ?>');
            </script>
        <?php endif; ?>

        <form class="form-signin" action="<?= base_url('auth/login') ?>" method="post">
            <img class="mb-4" src="<?= base_url() ?>assets/img/KMJ2.png" alt="" width="108" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Login Inventory GA</h1>
            <label for="inputEmail" class="sr-only">Email address</label>
            <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <label for="inputPassword" class="sr-only">Password</label>
            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
            <button class="btn btn-lg btn-primary btn-block mt-3" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
        </form>
    </body>
</html>


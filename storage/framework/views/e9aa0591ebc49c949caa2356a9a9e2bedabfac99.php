<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Acceso</title>

    <!-- Styles -->
    <link href="<?php echo e(asset('public/css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/main.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('public/css/font-awesome.min.css')); ?>" rel="stylesheet"> 

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
    </script>
</head>
<body>
    <div id="app">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Scripts -->
    <script type="text/javascript" src="<?php echo asset('public/js/jquery-3.2.0.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo asset('public/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
</body>
</html>

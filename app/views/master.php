<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title><?=$this->e($title)?></title>
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/public/css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link rel="preconnect" href="https://www.google.com" crossorigin>
    <link rel="preconnect" href="https://www.gstatic.com" crossorigin>
    <script>
        function onSubmit() {
            document.querySelector('.form').submit();
        };
    </script>
</head>
<body>
    <?=$this->section('content')?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" async></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" async></script>
    <script src="/public/js/main.js"></script>
</body>
</html>
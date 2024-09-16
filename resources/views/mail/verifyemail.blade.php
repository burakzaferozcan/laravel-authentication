<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Doğrulama</title>
</head>
<body>
<h1>Email Doğrulama</h1>
<p>doğrulamak için tıklayınız: </p>
<a href="{{url('email/verify/'.$user->email_token)}}">Siteye git</a>
</body>
</html>

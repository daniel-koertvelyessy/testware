<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    >
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge"
    >
    <style>
        html, body {
            background-color: #fff;
            color: #222222;
            font-family: 'Helvetica', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
            font-size: 10pt;
        }

        h1 {
            font-size: 22pt;
            font-weight: lighter;
        }

        h2 {
            font-size: 18pt;
            font-weight: lighter;
        }

        h3 {
            font-size: 15pt;
            font-weight: lighter;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .pagebreak {
            clear: both;
            page-break-after: always;
        }

        p, h1, h2, td, th {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Helvetica', sans-serif;
        }
    </style>
    <title>@yield('pagetitle')</title>
</head>
<body style="margin: 0;padding: 0; height: 100%">
@yield('content')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FEU ITSO Equipment Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            background: url('https://instructure-uploads-apse1.s3-ap-southeast-1.amazonaws.com/account_98220000000000001/attachments/2/bg2.jpg?AWSAccessKeyId=AKIAIDDUVOH2KGZFBNAQ&Expires=1949782073&Signature=M3%2F62xgXrP0XPaLngXD1nidfIYM%3D&response-cache-control=Cache-Control%3Amax-age%3D473364000.0%2C%20public&response-expires=473364000.0') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 100%;
            max-width: 600px;
            padding: 40px;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-container h1 {
            color: #004d40;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            transition: border-color 0.3s ease, padding-top 0.3s ease, padding-bottom 0.3s ease;
        }

        .form-group select {
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #aaa;
            background: white;
            padding: 0 5px;
            transition: 0.3s ease all;
            pointer-events: none;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label,
        .form-group select:focus + label,
        .form-group select:not(:placeholder-shown) + label {
            top: -10px;
            left: 15px;
            color: #004d40;
            font-size: 12px;
            transform: translateY(0);
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #004d40;
        }

        .login-container button {
            width: 100%;
            padding: 15px;
            background-color: #004d40;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .login-container button:hover {
            background-color: #00796b;
        }

        .alert {
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 20px;
            text-align: left; /* Left-align the alert text */
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
        }

        .no-underline {
            text-decoration: none;
            color: #00796b;
            font-weight: bold;
        }

        .no-underline:hover {
            text-decoration: underline;
        }

        .modal-content {
            background: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(60px);
        }

        .modal-body .icon-check {
            display: inline-block;
            width: 50px;
            height: 50px;
            line-height: 50px;
            background-color: #28a745;
            color: #ffffff;
            border-radius: 50%;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .modal-body p {
            margin-bottom: 20px;
            color: #333333;
        }
    </style>
</head>
<body>

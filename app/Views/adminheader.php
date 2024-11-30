<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ITSO Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/442b633764.js" crossorigin="anonymous"></script>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            height: 100vh;
        }

        #sidebar {
            background-color: rgba(0, 77, 64, 0.9);
            color: #ffffff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            width: 220px;
            transition: all 0.3s;
            padding-top: 20px;
            padding-bottom: 20px;
            overflow: hidden;
        }

        #sidebar.collapsed {
            width: 60px;
        }

        #sidebar .nav-link {
            color: #ffffff;
            display: flex;
            align-items: center;
            padding: 15px 20px;
            font-size: 1rem;
            transition: all 0.3s;
            text-decoration: none;
        }

        #sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        #sidebar .nav-link .nav-text {
            display: inline-block;
        }

        #sidebar.collapsed .nav-link .nav-text {
            display: none;
        }

        #sidebar .nav-link:hover,
        #sidebar .nav-link.active {
            background-color: #00796b;
            color: #ffffff;
        }

        #sidebar .toggle-btn {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 20px;
            margin-left: 20px;
            cursor: pointer;
        }

        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            height: calc(100vh - 40px);
            padding-top: 20px;
            overflow-x: hidden;
            overflow-y: auto;
        }

        .nav-item {
            list-style: none;
            margin-bottom: 10px;
        }

        .profile-sidebar {
            position: absolute;
            bottom: 20px;
            width: 100%;
            text-align: center;
            transition: all 0.3s;
        }

        .profile-sidebar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }

        .profile-info-sidebar {
            margin-top: 10px;
            font-size: 14px;
            display: block;
        }

        #sidebar.collapsed .profile-info-sidebar {
            display: none;
        }

        .container-fluid {
            padding-left: 240px; /* Ensure content starts after the sidebar */
            transition: padding-left 0.3s;
        }

        .container-fluid.collapsed {
            padding-left: 80px;
        }

        .container-fluid .content {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            margin-right: 20px;
            min-height: calc(100vh - 40px);
        }

        .container-fluid .content .row {
            margin-left: 0;
            margin-right: 0;
        }

        .btn-primary {
            background-color: #004d40;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #00796b;
        }

        .btn-danger {
            background-color: #d9534f;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .d-flex {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .border-bottom {
            border-bottom: 1px solid #eaeaea;
        }

        .pt-3 {
            padding-top: 1rem;
        }

        .pb-2 {
            padding-bottom: 0.5rem;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .profile {
            display: flex;
            align-items: center;
            font-size: 14px;
            color: #333;
            padding-right: 50px;
        }

        .profile i {
            font-size: 24px;
            margin-right: 10px;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-info p {
            margin: 0;
        }

        .profile-info .name {
            font-weight: bold;
        }

        .profile-info .email {
            font-size: 12px;
        }

        .container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #004d40;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #00796b;
        }

        .btn-danger {
            background-color: #d9534f;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #004d40;
            color: white;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        @media (max-width: 768px) {
            .container-fluid {
                padding-left: 60px;
            }

            #sidebar {
                width: 60px;
            }

            #sidebar .nav-link .nav-text {
                display: none;
            }

            .profile-info-sidebar {
                display: none;
            }

            .profile-info {
                display: none;
            }
        }
    </style>
</head>
<body>
<div id="sidebar" class="sidebar">
    <button class="toggle-btn">&#9776;</button>
    <div class="sidebar-sticky">
        <ul class="nav flex-column" style="padding-left:0px;">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="<?= base_url('itso_dashboard') ?>">
                    <i class="fa-solid fa-gauge" style="color: #ffffff;"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('user_management') ?>">
                    <i class="fa-solid fa-user-cog" style="color: #ffffff;"></i>
                    <span class="nav-text">User Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('equipment_management') ?>">
                    <i class="fa-solid fa-laptop" style="color: #ffffff;"></i>
                    <span class="nav-text">Equipment Management</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('reports') ?>">
                    <i class="fa-solid fa-file-alt" style="color: #ffffff;"></i>
                    <span class="nav-text">Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('logout') ?>">
                    <i class="fa-solid fa-sign-out-alt" style="color: #ffffff;"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>

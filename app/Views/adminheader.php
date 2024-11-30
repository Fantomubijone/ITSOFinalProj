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


        
.form-container {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
    transition: border 0.2s ease-in-out;
}

.form-control:focus {
    border-color: #00796b;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

.btn-primary {
    background-color: #00796b;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #005b4e;
}

h1.h2 {
    color: #00796b;
}

.profile {
    display: flex;
    align-items: center;
}

.profile-info p {
    margin: 0;
    color: #333;
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


<style>
.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #00796b;
    color: white;
}

.btn-primary {
    background-color: #00796b;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #005b4e;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-group .btn {
    margin-right: 5px;
}

details {
    margin-bottom: 15px;
}

details summary {
    font-weight: bold;
    cursor: pointer;
    list-style: none;
    outline: none;
}

details summary::marker {
    content: "";
}

details[open] summary::after {
    content: "▲";
    float: right;
}

details summary::after {
    content: "▼";
    float: right;
}

.list-group {
    padding-left: 20px;
    list-style-type: none;
}

.list-group li {
    padding: 8px 0;
    border-bottom: 1px solid #ddd;
}

.list-group li:last-child {
    border-bottom: none;
}

.list-group-header {
    font-weight: bold;
    text-align: left;
    padding: 8px 0;
}


.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #00796b;
    color: white;
}

.table tr:hover {
    background-color: light gray;
}

.btn-primary {
    background-color: #00796b;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
    background-color: #005b4e;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.pagination {
    display: flex;
    justify-content: center;
    padding: 10px;
    list-style-type: none;
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-link {
    color: #00796b;
    border: 1px solid #00796b;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.pagination .page-link:hover {
    background-color: #e9f1f5;
}

.pagination .page-item.active .page-link {
    background-color: #00796b;
    color: white;
    border: 1px solid #00796b;
}

.group-header {
    cursor: pointer;
}

.detail-header, .detail-row {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.detail-header {
    background-color: white;
    font-weight: bold;
}

.table {
    width: 100%;
    margin-bottom: 20px;
    border-collapse: collapse;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin: 30px;
}

.table th, .table td {
    padding: 12px 15px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #00796b;
    color: white;
}

.table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.table tr:hover {
    background-color: #e9f1f5;
}

.btn-primary {
    background-color: #00796b;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    text-decoration: none;
}

.btn-primary:hover {
    background-color: #005b4e;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    color: white;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    text-decoration: none;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

.btn-group {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
}

.pagination {
    display: flex;
    justify-content: center;
    padding: 10px;
    list-style-type: none;
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-link {
    color: #00796b;
    border: 1px solid #00796b;
    padding: 10px 15px;
    border-radius: 4px;
    cursor: pointer;
    text-decoration: none;
}

.pagination .page-link:hover {
    background-color: #e9f1f5;
}

.group-header {
    cursor: pointer;
    background-color: #f5f5f5;
}

.group-details {
    display: none;
}

.detail-header, .detail-row {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
    gap: 10px;
    padding: 10px 0;
}

.detail-header {
    font-weight: bold;
}

.detail-row {
    border-top: 1px solid #ddd;
}

.action-buttons a,
.action-buttons button {
    margin-right: 5px;
    text-decoration: none;
}

.btn-warning {
    background-color: #ffc107;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    text-decoration: none;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    text-decoration: none;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-success {
    background-color: #28a745;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    color: white;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
    text-decoration: none;
}

.btn-success:hover {
    background-color: #218838;
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

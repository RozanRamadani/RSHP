<?php // menu.php ?>
<nav style="background:#36a2c2;padding:0;box-shadow:0 2px 4px rgba(0,0,0,0.04);">
    <style>
        .navbar-rshp {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            height: 64px;
        }
        .navbar-left {
            display: flex;
            align-items: center;
        }
        .navbar-rshp ul {
            list-style: none;
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
        }
        .navbar-rshp li { position: relative; }
        .navbar-rshp a {
            display: block;
            padding: 12px 20px;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
            border-radius: 4px;
            transition: background 0.2s;
        }
        .navbar-rshp a:hover, .navbar-rshp .dropdown:hover > a { background: #2587a3; }
        .navbar-rshp .dropdown-content {
            display: none;
            position: absolute;
            left: 0;
            top: 100%;
            background: #36a2c2;
            min-width: 180px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 0 0 6px 6px;
            z-index: 10;
        }
        .navbar-rshp .dropdown-content a { color: #fff; padding: 12px 20px; border-radius: 0; font-weight: 400; }
        .navbar-rshp .dropdown:hover .dropdown-content { display: block; }
        .navbar-rshp .logout {
            margin-left: 32px;
            background: #fff;
            color: #36a2c2;
            font-weight: bold;
            border-radius: 4px;
            transition: background 0.2s, color 0.2s;
        }
        .navbar-rshp .logout:hover { background: #2587a3; color: #fff; }
        .navbar-logo {
            height: 54px;
            width: 54px;
            margin-right: 14px;
            padding: 0;
            background: none;
            border-radius: 0;
            box-shadow: none;
            border: none;
            object-fit: contain;
        }
        @media (max-width: 700px) {
            .navbar-rshp { flex-direction: column; height: auto; padding: 0 8px; }
            .navbar-left { flex-direction: column; align-items: flex-start; }
            .navbar-rshp ul { flex-direction: column; width: 100%; }
            .navbar-rshp li { width: 100%; }
            .navbar-rshp a, .navbar-rshp .logout { width: 100%; text-align: left; }
            .navbar-rshp .logout { margin-left: 0; }
        }
    </style>
    <div class="navbar-rshp">
        <div style="display:flex; align-items:center; gap:18px;">
            <img src="img/uner.png" alt="Logo UNER" class="navbar-logo" />
            <ul style="margin:0; padding:0;">
                <li>
                    <a href="dashboard.php">Dashboard</a>
                </li>
                <li class="dropdown">
                    <a href="#">Data Master &#9662;</a>
                    <div class="dropdown-content">
                        <a href="data_user.php">Data User</a>
                        <a href="datamaster_role_user.php">Manajemen Role</a>
                    </div>
                </li>
            </ul>
        </div>
        <ul>
            <li>
                <a href="logout.php" class="logout">Logout</a>
            </li>
        </ul>
    </div>
</nav>

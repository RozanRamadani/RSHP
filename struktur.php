<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Struktur Organisasi - Rumah Sakit Hewan Pendidikan Universitas Airlangga</title>
        <style>
        .navbar {
            background: #0077b6;
            margin: 0;
            padding: 0;
        }
        .navbar ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .navbar li {
            margin: 0;
        }
        .navbar a {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 16px 24px;
            transition: background 0.2s;
        }
        .navbar a:hover {
            background: #023e8a;
        }

        .logo {
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            max-width: 600px;
            height: auto;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            border-radius: 16px;
            margin-bottom: 24px;
        }
        .container {
            max-width: 800px;
            margin: 32px auto;
            background: #fff;
            padding: 32px 24px;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.10);
        }
        h1 {
            color: #023e8a;
            font-size: 2.2em;
            margin-bottom: 16px;
            letter-spacing: 1px;
            text-align: center;
        }

        .navbar .login {
            margin-left: auto;
        }
        </style>
    </head>
    <body>
        <nav class="navbar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="struktur.php">Struktur Organisasi</a></li>
                <li><a href="layanan.php">Layanan Umum</a></li>
                <li><a href="visi.php">Visi Misi dan Tujuan</a></li>
                <li class="login"><a href="login.php">Login</a></li>
            </ul>
        </nav>
        <div class="container">
            <img src="img/rshp_uner.webp" alt="Logo RSHP" class="logo">
            <h1>Struktur Organisasi RSHP</h1>
            <table style="margin: 0 auto; border-collapse: separate; border-spacing: 40px 10px;">
                <tr>
                    <td colspan="2" style="text-align: center;">
                        <strong>DIREKTUR</strong><br>
                        <img src="img/person.jpg" alt="Direktur" style="width:150px;height:200px;object-fit:cover;border:2px solid #000;"><br>
                        drh. Joko Susilo, M.Vet
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <strong>WAKIL DIREKTUR 1</strong><br>
                        PELAYANAN MEDIS, PENDIDIKAN DAN PENELITIAN<br>
                        <img src="img/person.jpg" alt="Wakil Direktur 1" style="width:150px;height:200px;object-fit:cover;border:2px solid #000;"><br>
                        drh. Rahmat Darmawan
                    </td>
                    <td style="text-align: center;">
                        <strong>WAKIL DIREKTUR 2</strong><br>
                        SUMBER DAYA MANUSIA, SARANA PRASARANA DAN KEUANGAN<br>
                        <img src="img/person.jpg" alt="Wakil Direktur 2" style="width:150px;height:200px;object-fit:cover;border:2px solid #000;"><br>
                        drh. Budi Santoso
                    </td>
                </tr>
            </table>
        </div>
    </body>
</html>
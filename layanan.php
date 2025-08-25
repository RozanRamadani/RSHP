<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Layanan Umum - Rumah Sakit Hewan Pendidikan Universitas Airlangga</title>
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
	section#layanan {
		text-align: center;
	}
	h1 {
		color: #023e8a;
		font-size: 2.2em;
		margin-bottom: 16px;
		letter-spacing: 1px;
	}
	p {
		color: #333;
		font-size: 1.08em;
		line-height: 1.7;
		margin-bottom: 18px;
	}
	.service-list {
		text-align: left;
		margin: 0 auto;
		max-width: 600px;
		padding: 0;
		list-style: none;
	}
	.service-list li {
		background: #e7f5ff;
		margin-bottom: 12px;
		padding: 14px 18px;
		border-radius: 10px;
		color: #023e8a;
		font-size: 1.08em;
		box-shadow: 0 2px 8px rgba(0,0,0,0.04);
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
		<section id="layanan">
			<img src="img/rshp_uner.webp" alt="Logo RSHP" class="logo">
			<h1>Layanan Umum RSHP</h1>
			<p>Rumah Sakit Hewan Pendidikan Universitas Airlangga menyediakan berbagai layanan kesehatan hewan yang profesional dan komprehensif, antara lain:</p>
			<ul class="service-list">
				<li>Pemeriksaan kesehatan hewan rutin</li>
				<li>Vaksinasi dan imunisasi</li>
				<li>Bedah minor dan mayor</li>
				<li>Rawat inap hewan</li>
				<li>Laboratorium diagnostik</li>
				<li>Konsultasi kesehatan hewan</li>
				<li>Penanganan kasus darurat</li>
				<li>Perawatan gigi dan mulut hewan</li>
				<li>Rehabilitasi dan fisioterapi</li>
				<li>Layanan kesehatan hewan eksotik</li>
			</ul>
			<p>Seluruh layanan didukung oleh tenaga medis profesional dan fasilitas modern untuk memastikan kesehatan dan kesejahteraan hewan Anda.</p>
		</section>
	</div>
</body>
</html>

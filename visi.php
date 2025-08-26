<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Visi, Misi, dan Tujuan - Rumah Sakit Hewan Pendidikan Universitas Airlangga</title>
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
		margin: 3px auto;
		background: #fff;
		padding: 32px 24px;
		border-radius: 16px;
		box-shadow: 0 4px 24px rgba(0,0,0,0.10);
	}
	section#visi {
		text-align: center;
	}
	h1 {
		color: #023e8a;
		font-size: 2.2em;
		margin-bottom: 16px;
		letter-spacing: 1px;
	}
	h2 {
		color: #0077b6;
		margin-top: 32px;
		margin-bottom: 12px;
	}
	p, li {
		color: #333;
		font-size: 1.08em;
		line-height: 1.7;
	}
	ul.misi-list, ul.tujuan-list {
		text-align: left;
		margin: 0 auto 18px auto;
		max-width: 600px;
		padding: 0 0 0 18px;
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
		<section id="visi">
			<img src="img/rshp_uner.webp" alt="Logo RSHP" class="logo">
			<h1>Visi, Misi, dan Tujuan RSHP</h1>
			<h2>Visi</h2>
			<p>Menjadi rumah sakit hewan pendidikan terdepan di Indonesia yang unggul dalam pelayanan kesehatan hewan, pendidikan, dan penelitian bertaraf internasional.</p>
			<h2>Misi</h2>
			<ul class="misi-list">
				<li>Menyelenggarakan pelayanan kesehatan hewan yang profesional, modern, dan berorientasi pada kesejahteraan hewan.</li>
				<li>Menjadi pusat pendidikan dan pelatihan klinis bagi mahasiswa kedokteran hewan.</li>
				<li>Mendukung dan mengembangkan penelitian di bidang kedokteran hewan dan kesehatan masyarakat veteriner.</li>
				<li>Memberikan edukasi dan pengabdian kepada masyarakat tentang pentingnya kesehatan hewan.</li>
			</ul>
			<h2>Tujuan</h2>
			<ul class="tujuan-list">
				<li>Meningkatkan kualitas pelayanan kesehatan hewan di Indonesia.</li>
				<li>Menghasilkan lulusan kedokteran hewan yang kompeten dan berpengalaman klinis.</li>
				<li>Mendorong inovasi dan penelitian di bidang kedokteran hewan.</li>
				<li>Menjadi rujukan utama dalam penanganan kasus-kasus hewan di tingkat nasional.</li>
			</ul>
		</section>
	</div>
</body>
<?php include('footer.php'); ?>
</html>

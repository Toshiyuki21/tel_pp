<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Pengelolaan Data PC</title>

    <!-- Import Google Font "Lora" -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            font-family: 'Lora', serif; /* Menggunakan font Lora */
            background-color: #f0f5f0;
            color: #333;
            line-height: 1.6;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: center; /* Mengatur agar judul berada di tengah */
            padding: 20px; /* Menambah padding untuk header */
            background-color: #2a9d8f;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Shadow untuk header */
        }

        h1 {
            margin: 0;
            color: #fff;
            font-size: 2.5em;
            text-align: center; /* Memastikan teks judul berada di tengah */
        }

        .logo {
            position: absolute; /* Menggunakan posisi absolut untuk meletakkan logo */
            left: 20px; /* Jarak logo dari kiri */
            top: 20px; /* Jarak logo dari atas */
            width: 100px; /* Sesuaikan ukuran logo */
            height: auto; /* Mempertahankan proporsi logo */
        }

        nav {
            margin-top: 20px;
            text-align: center;
            flex-grow: 1;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            display: inline-block;
            margin: 0 20px;
        }

        ul li a {
            text-decoration: none;
            color: #fff;
            background-color: #2a9d8f;
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 18px;
            transition: background-color 0.3s, box-shadow 0.3s; /* Tambahkan transisi untuk shadow */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Shadow untuk tombol */
        }

        ul li a:hover {
            background-color: #21867a;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Shadow lebih kuat saat hover */
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: #2a9d8f;
            color: #ffffff;
            font-size: 1.2em;
            box-shadow: 0 -4px 8px rgba(0, 0, 0, 0.2); /* Shadow untuk footer */
            position: relative; /* Mengatur posisi relative untuk footer */
        }

        /* Gaya untuk video animasi */
        .animation-video {
            position: absolute;
            bottom: 60px; /* Sesuaikan posisi video di atas footer */
            left: 50%; /* Memposisikan video di tengah */
            transform: translateX(-50%); /* Menyelaraskan video di tengah */
            width: 150px; /* Ukuran video */
            height: auto; /* Mempertahankan proporsi video */
            z-index: 1; /* Pastikan video di atas footer */
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            ul li {
                display: block;
                margin: 20px 0;
            }

            ul li a {
                font-size: 16px;
                padding: 12px 25px;
            }

            .logo {
                width: 80px; /* Ukuran logo lebih kecil pada layar kecil */
            }

            .animation-video {
                width: 100px; /* Ukuran video lebih kecil pada layar kecil */
            }
        }
    </style>
</head>
<body>
    <header>
        <img src="logo_tel.png" alt="Logo" class="logo">
        <h1>Selamat Datang di Website Pengelolaan Data PC</h1>
    </header>

    <nav>
        <ul>
            <li><a href="input_data.php">INPUT DATA</a></li>
            <li><a href="search_data.php">PENCARIAN DATA</a></li>
            <li><a href="scanner.php">SCANNER</a></li>
            <li><a href="pm_data.php">DATA PREVENTIVE MAINTENANCE (PM)</a></li>
        </ul>
    </nav>

    <footer>
        
        <p>PT. Tanjung Enim Lestari &copy; 2024</p>
    </footer>
</body>
</html>

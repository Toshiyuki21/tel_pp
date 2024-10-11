<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'data_pc');

    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form input
    $nama_pc = $_POST['nama_pc'];
    $tanggal_input = $_POST['tanggal_input'];
    $kondisi_pc = $_POST['kondisi_pc'];
    $jenis_pc = $_POST['jenis_pc'];
    $lokasi_pc = $_POST['lokasi_pc'];

    // Simpan data ke database
    $sql = "INSERT INTO pc_tel (nama_pc, tanggal_input, kondisi_pc, jenis_pc, lokasi_pc) 
            VALUES ('$nama_pc', '$tanggal_input', '$kondisi_pc', '$jenis_pc', '$lokasi_pc')";

    if ($conn->query($sql) === TRUE) {
        // Ambil ID PC yang baru saja disimpan
        $last_id = $conn->insert_id; 

        // Gabungkan data menjadi satu string terstruktur untuk QR code
        $qrData = "$last_id|$nama_pc|$kondisi_pc|$tanggal_input|$lokasi_pc|$jenis_pc"; 

        echo "Data berhasil disimpan!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data PC</title>

    <!-- Import Google Font "Lora" -->
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <style>
        body {
            font-family: 'Lora', serif; /* Menggunakan font Lora */
            background-color: #f0f5f0;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #2a9d8f;
            margin-top: 20px;
        }

        form {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
        }

        label {
            color: #2a9d8f;
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="datetime-local"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #2a9d8f;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #21867a;
        }

        .back-button {
            text-decoration: none;
            color: #ffffff;
            background-color: #2a9d8f;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }

        .back-button:hover {
            background-color: #21867a;
        }

        #qrcode {
            text-align: center;
            margin-top: 20px;
        }

        #downloadQR {
            display: block;
            background-color: #2a9d8f;
            color: #fff;
            text-align: center;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px auto;
            max-width: 150px;
        }

        #downloadQR:hover {
            background-color: #21867a;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            background-color: #2a9d8f;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <h2>Input Data PC</h2>
    <form method="POST" action="">
        <label for="nama_pc">Nama PC:</label>
        <input type="text" id="nama_pc" name="nama_pc" required><br>

        <label for="kondisi_pc">Kondisi PC:</label>
        <select id="kondisi_pc" name="kondisi_pc" required>
            <option value="Baik">Baik</option>
            <option value="Cukup Baik">Cukup Baik</option>
            <option value="Kurang Baik">Kurang Baik</option>
        </select><br>

        <label for="tanggal_input">Tanggal Input:</label>
        <input type="datetime-local" id="tanggal_input" name="tanggal_input" required><br>

        <label for="lokasi_pc">Lokasi PC:</label>
        <input type="text" id="lokasi_pc" name="lokasi_pc" required><br>

        <label for="jenis_pc">Jenis PC:</label>
        <input type="text" id="jenis_pc" name="jenis_pc" required><br>

        <input type="submit" value="Simpan Data">
        <a href="index.php" class="back-button">Kembali ke Halaman Utama</a>
    </form>

    <!-- QR Code Section -->
    <?php if (isset($qrData)): ?>
        <div id="qrcode"></div>
        <button id="downloadQR">Unduh QR Code</button>
        <script>
            $(document).ready(function() {
                // Generate QR code
                $("#qrcode").qrcode({
                    text: "<?php echo $qrData; ?>",  // Data terstruktur yang dimasukkan ke QR code
                    width: 128,
                    height: 128
                });

                // Unduh QR code sebagai gambar
                $('#downloadQR').on('click', function() {
                    html2canvas(document.querySelector('#qrcode')).then(canvas => {
                        let link = document.createElement('a');
                        link.href = canvas.toDataURL('image/png');
                        link.download = 'qr_code_pc.png';
                        link.click();
                    });
                });
            });
        </script>
    <?php endif; ?>
</body>
</html>

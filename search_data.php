<?php
include 'koneksi.php';

$search = isset($_POST['search']) ? $_POST['search'] : '';

// Proses penghapusan data
if (isset($_POST['delete_selected'])) {
    if (!empty($_POST['selected_ids'])) {
        $ids = implode(",", array_map('intval', $_POST['selected_ids']));
        $sql_delete = "DELETE FROM pc_tel WHERE id IN ($ids)";
        $conn->query($sql_delete);
    }
}

$sql = "SELECT * FROM pc_tel WHERE nama_pc LIKE '%$search%' OR kondisi_pc LIKE '%$search%' OR lokasi_pc LIKE '%$search%' OR jenis_pc LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Data PC</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f5f0;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2a9d8f;
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #2a9d8f;
            border-radius: 5px 0 0 5px;
            width: 300px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #2a9d8f;
            color: white;
            border: none;
            border-radius: 5px;
            margin-left: 10px; /* Menambahkan jarak antara tombol */
        }
        button:hover {
            background-color: #248f7f;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Tambahkan efek bayangan */
            border-radius: 10px; /* Tambahkan border-radius untuk sudut tabel yang membulat */
            overflow: hidden; /* Pastikan border-radius terlihat */
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            background-color: white; /* Pastikan latar belakang sel adalah putih */
        }
        th {
            background-color: #2a9d8f;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-links a {
            color: #2a9d8f;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-links a:hover {
            text-decoration: underline;
        }
        /* Gaya untuk tombol kembali */
        .back-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
            background-color: #2a9d8f; /* Warna latar belakang tombol */
        }
        .back-link {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }
        .back-link:hover {
            background-color: #248f7f; /* Warna saat hover */
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Pencarian Data PC</h2>
        <form method="POST">
            <input type="text" name="search" placeholder="Cari Data..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>

        <form method="POST">
            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>ID PC</th>
                    <th>Nama PC</th>
                    <th>Kondisi PC</th>
                    <th>Tanggal Input</th>
                    <th>Lokasi PC</th>
                    <th>Jenis PC</th>
                    <th>Aksi</th>
                    <th>QR Code</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="selected_ids[]" value="<?php echo $row['id']; ?>"></td>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_pc']); ?></td>
                            <td><?php echo htmlspecialchars($row['kondisi_pc']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_input']); ?></td>
                            <td><?php echo htmlspecialchars($row['lokasi_pc']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_pc']); ?></td>
                            <td class="action-links">
                                <a href="edit_data.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete_data.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                            <td>
                                <div id="qrcode-<?php echo $row['id']; ?>"></div>
                                <script>
                                    $(document).ready(function() {
                                        $("#qrcode-<?php echo $row['id']; ?>").qrcode({
                                            text: "<?php echo $row['id'] . '|' . $row['nama_pc'] . '|' . $row['kondisi_pc'] . '|' . $row['tanggal_input'] . '|' . $row['lokasi_pc'] . '|' . $row['jenis_pc']; ?>",
                                            width: 100,
                                            height: 100
                                        });
                                    });
                                </script>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">Tidak ada data ditemukan.</td>
                    </tr>
                <?php endif; ?>
            </table>

            <div class="button-container">
                <button type="submit" name="delete_selected" onclick="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?');">Hapus yang Dipilih</button>
            </div>
        </form>

        <!-- Kontainer untuk tombol kembali -->
        <div class="back-container">
            <a href="index.php" class="back-link">Kembali ke Menu Utama</a>
        </div>
    </div>

    <script>
        // Fungsi untuk memilih semua checkbox
        $(document).ready(function() {
            $('#select-all').click(function() {
                $('input[name="selected_ids[]"]').prop('checked', this.checked);
            });
        });
    </script>
</body>
</html>

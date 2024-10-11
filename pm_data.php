<?php
include 'koneksi.php'; // Pastikan koneksi database sudah benar

// Variabel untuk menyimpan pesan
$message = '';

// Proses penghapusan data jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $ids_to_delete = isset($_POST['delete_ids']) ? $_POST['delete_ids'] : [];
    if (!empty($ids_to_delete)) {
        $ids = implode(',', array_map('intval', $ids_to_delete));
        $delete_sql = "DELETE FROM pm_tel WHERE id IN ($ids)";
        if ($conn->query($delete_sql) === TRUE) {
            $message = "Data berhasil dihapus.";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}

// Proses pencarian data
$search_term = '';
if (isset($_POST['search'])) {
    $search_term = $_POST['search_term'];
}

// Proses ekspor PDF
if (isset($_POST['export_pdf'])) {
    $file_name = isset($_POST['file_name']) ? $_POST['file_name'] : 'data_pm';
    // Redirect ke file ekspor PDF dengan nama yang ditentukan
    header("Location: export_pdf.php?file_name=" . urlencode($file_name));
    exit();
}

// SQL query untuk menampilkan data PM
$sql = "SELECT pm.id, tel.nama_pc, pm.kondisi_setelah, pm.kondisi_sebelum, pm.tanggal_sebelum, pm.tanggal_setelah, tel.lokasi_pc, pm.jenis_pc 
        FROM pm_tel pm
        JOIN pc_tel tel ON pm.pc_id = tel.id";

if (!empty($search_term)) {
    $search_term = $conn->real_escape_string($search_term);
    $sql .= " WHERE tel.nama_pc LIKE '%$search_term%' OR pm.kondisi_setelah LIKE '%$search_term%' OR pm.kondisi_sebelum LIKE '%$search_term%'";
}

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Preventive Maintenance (PM)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }
        h2 {
            color: #2a9d8f;
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #2a9d8f;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .action-btn {
            background-color: #e76f51;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .action-btn:hover {
            background-color: #d65f3e;
        }
        .back-btn, .delete-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #2a9d8f;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .back-btn:hover, .delete-btn:hover {
            background-color: #248f7f;
        }
        .message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .search-form {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .search-form input[type="text"], .export-form input[type="text"] {
            padding: 10px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .search-form button, .export-form button {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            background-color: #2a9d8f;
            color: white;
            cursor: pointer;
            margin-left: 10px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Data Preventive Maintenance (PM)</h2>
        
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <!-- Form Pencarian -->
        <form method="post" class="search-form">
            <input type="text" name="search_term" placeholder="Cari berdasarkan Nama PC, Kondisi" value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit" name="search">Cari</button>
        </form>

        <form method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data yang dipilih?');">
            <table>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Nama PC</th>
                    <th>Kondisi Setelah</th>
                    <th>Kondisi Sebelum</th>
                    <th>Tanggal Sebelum</th>
                    <th>Tanggal Setelah</th>
                    <th>Lokasi PC</th>
                    <th>Jenis PC</th>
                    <th>QR Code</th>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox" name="delete_ids[]" value="<?php echo $row['id']; ?>"></td>
                            <td><?php echo htmlspecialchars($row['nama_pc']); ?></td>
                            <td><?php echo htmlspecialchars($row['kondisi_setelah']); ?></td>
                            <td><?php echo htmlspecialchars($row['kondisi_sebelum']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_sebelum']); ?></td>
                            <td><?php echo htmlspecialchars($row['tanggal_setelah']); ?></td>
                            <td><?php echo htmlspecialchars($row['lokasi_pc']); ?></td>
                            <td><?php echo htmlspecialchars($row['jenis_pc']); ?></td>
                            <td>
                                <div id="qrcode-<?php echo $row['id']; ?>"></div>
                                <script>
                                    $(document).ready(function() {
                                        $("#qrcode-<?php echo $row['id']; ?>").qrcode({
                                            text: "<?php echo $row['id'] . '|' . $row['nama_pc']; ?>",
                                            width: 64,
                                            height: 64
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
            <button type="submit" name="delete" class="delete-btn">Hapus Data Terpilih</button>
        </form>

        <form method="post" class="export-form" style="margin-top: 20px;">
            <input type="text" name="file_name" placeholder="Nama file PDF" required>
            <button type="submit" name="export_pdf">Ekspor PDF</button>
        </form>

        <a href="index.php" class="back-btn">Kembali ke Menu Utama</a>
    </div>

    <script>
        // Script untuk checkbox "Select All"
        document.getElementById('select-all').onclick = function() {
            var checkboxes = document.getElementsByName('delete_ids[]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        }
    </script>
</body>
</html>

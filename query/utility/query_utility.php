<?php
    include '../../koneksi/koneksi.php';

    session_start();
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : 'user'; // Role default 'user' jika tidak ditemukan
    $roles = $_GET['role'];
    $id_kelas = $_SESSION['id_kelas'] ?? ''; // Misalnya id_kelas disimpan dalam session
    $nama_kelas = $_SESSION['kelas'] ?? '';
    $nama_user = $_SESSION['nama'] ?? '';
    $jurusan = $_SESSION['jurusan'] ?? '';

    // Validasi tabel yang diizinkan
    $allowedTables = ['siswa', 'guru', 'jadwal', 'absen'];
    $tabel = in_array($_GET['tabel'], $allowedTables) ? $_GET['tabel'] : 'siswa';

    // Ambil parameter page, limit, search, sort_by, dan sort_order dari URL atau POST
    $page = intval($_GET['page'] ?? 1);
    $limit = intval($_GET['limit'] ?? 10);
    $search = $_POST['search'] ?? '';
    $sortBy = $_GET['sort_by'] ?? "id_{$tabel}";  // Default kolom untuk sorting
    $sortOrder = $_GET['sort_order']?? 'ASC'; // Default urutan: ascending
    $offset = ($page - 1) * $limit;

    // Validasi nilai sort_orde
    $sortOrder = ($sortOrder === 'DESC') ? 'DESC' : 'ASC';

    // Tabel yang digunakan untuk query
    $tabelSelect = 'v'.ucfirst($tabel);

    // Mapping kolom berdasarkan tabel
    $cols_map = [
        'siswa' => ['nama', 'jenis_kelamin', 'nama_kelas_s', 'alamat', 'nisn', 'no_telepon'],
        'guru' => ['nama_guru_g', 'jenis_kelamin', 'nama_mapel_g', 'alamat_guru_g', 'nip', 'nama_kelas_g'],
        'jadwal' => ['jam_mulai', 'jam_selesai', 'nama_hari_j', 'nama_guru_j', 'nama_kelas_j', 'nama_mapel_j'],
        'absen' => ['nama_siswa_a', 'nama_mapel_a', 'waktu', 'tanggal', 'keterangan_a', 'nama_kelas_a']
    ];

    // Pilih kolom yang sesuai berdasarkan tabel yang dipilih
    $cols = $cols_map[$tabel] ?? [];

    function cari($conn, $tabelSelect, $cols, $keyword, $limit, $offset, $sortBy, $sortOrder, $nama_kelas, $nama_user, $role, $jurusan) {
        // Build search conditions for each column
        $conditions = array_map(fn($col) => "$col LIKE ?", $cols);
        $params = [];
                        
        // Tambahkan filter khusus untuk role non-admin
        if ($role === 'user') {
            $filter = '';
            if ($tabelSelect === 'vSiswa') {
                $filter = "nama_kelas_s = ?";
                $params[] = $nama_kelas;
            } elseif ($tabelSelect === 'vJadwal') {
                $filter = "nama_kelas_j = ?";
                $params[] = $nama_kelas;
            } elseif ($tabelSelect === 'vAbsen') {
                $filter = "nama_siswa_a = ?";
                $params[] = $nama_user;
            } elseif ($tabelSelect === 'vGuru') {
                $filter = "nama_jurusan_g = ?";
                $params[] = $jurusan;
            }
    
            // Jika ada filter, tambahkan ke query
            $sql = "SELECT * FROM {$tabelSelect} WHERE (" . implode(' OR ', $conditions) . ") AND {$filter}";
        } else {
            // Untuk admin, tidak ada filter
            $sql = "SELECT * FROM {$tabelSelect} WHERE (" . implode(' OR ', $conditions) . ")";
        }
            
     
        $sql .= " ORDER BY {$sortBy} {$sortOrder} LIMIT ? OFFSET ?";
        // var_dump($sql);
        // Prepare statement
        $stmt = $conn->prepare($sql);
        // var_dump($stmt);
        // Prepare parameters for binding
        $likeKeyword = "%{$keyword}%";
        $likeParams = array_fill(0, count($cols), $likeKeyword);
        
        $params = array_merge($likeParams, $params);
        // Add parameters for pagination
        $params[] = $limit;
        $params[] = $offset;
        
    // Tambahkan bind types (s untuk LIKE, i untuk limit/offset)
// Tentukan jenis parameter binding berdasarkan role
        if ($role === 'user') {
            // User role: bind parameter untuk pencarian + filter
            $bindTypes = str_repeat("s", count($likeParams)) . str_repeat("s", count($params) - count($likeParams) - 2) . "ii";
        } else {
            // Admin role: hanya bind parameter untuk pencarian
            $bindTypes = str_repeat("s", count($likeParams)) . "ii";
        }       
        $stmt->bind_param($bindTypes, ...$params);
        // Execute statement
        $stmt->execute();
        return $stmt->get_result();
    }
        

    // Eksekusi pencarian dengan sorting
    $result = cari($conn, $tabelSelect, $cols, $search, $limit, $offset, $sortBy, $sortOrder, $nama_kelas, $nama_user, $role, $jurusan);
    // Ambil data hasil query
    $data = [];
    $no = 1;
    while ($row = $result->fetch_assoc()){
        $row['no'] = $no++;
        $data[] = $row;
    }

// Query untuk menghitung total data
$totalSql = "SELECT COUNT(*) AS total FROM {$tabelSelect}";
$totalConditions = [];
$params = [];  // Array untuk parameter yang akan di-bind

// Menambahkan kondisi pencarian jika ada
if (!empty($search)) {
    // Buat kondisi LIKE untuk kolom yang relevan
    $totalConditions = array_map(fn($col) => "$col LIKE ?", $cols);
    // Tambahkan parameter pencarian ke array params
    foreach ($cols as $col) {
        $params[] = "%$search%";  // Menambahkan pencarian untuk setiap kolom
    }
}


// Menambahkan filter berdasarkan role dan tabel
if ($role === 'user') {  
    $filter = '';// Hanya user yang dikenakan filter
    if ($tabelSelect == 'vSiswa') {
        $filter = "nama_kelas_s = ?";  // Filter berdasarkan kelas
        $params[] = $nama_kelas;  // Tambahkan kelas ke parameter
    } elseif ($tabelSelect == 'vJadwal') {
        $filter = "nama_kelas_j = ?";  // Filter berdasarkan kelas
        $params[] = $nama_kelas;  // Tambahkan kelas ke parameter
    } elseif ($tabelSelect == 'vAbsen') {
        $filter = "nama_siswa_a = ?";  // Filter berdasarkan siswa
        $params[] = $nama_user;  // Tambahkan nama_user ke parameter
    } elseif ($tabelSelect == 'vGuru') {
        $filter = "nama_jurusan_g = ?";  // Filter berdasarkan guru
        $params[] = $jurusan;  
    }
}

// Gabungkan kondisi pencarian dan filter dalam query
if ($totalConditions) {
    $totalSql .= " WHERE " . implode(' OR ', $totalConditions);  // Kondisi pencarian
}


if ($role === 'user' && $filter) {
    // Tambahkan filter ke query jika ada
    if (strpos($totalSql, 'WHERE') !== false) {
        $totalSql .= " AND " . $filter;
    } else {
        $totalSql .= " WHERE " . $filter;
    }

}
// var_dump($params);
// var_dump($totalSql);

// Persiapkan statement untuk total count
$totalStmt = $conn->prepare($totalSql);


// Semua string
if (!empty($params)) {
    $paramTypes = str_repeat("s", count($params));
    $totalStmt->bind_param($paramTypes, ...$params);
}

$totalStmt->execute();
// Eksekusi query
$totalResult = $totalStmt->get_result();
$totalRecords = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Format hasil dalam JSON
echo json_encode([
    $tabel => $data,
    'pagination' => [
        'totalPages' => $totalPages,
        'currentPage' => $page,
        'limit' => $limit,
        'totalRecords' => $totalRecords,
        'searchKeyword' => $search,
        'sortBy' => $sortBy,
        'sortOrder' => $sortOrder,
        'role' => $role
    ]
]);



?>
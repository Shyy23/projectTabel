<?php
    include '../../koneksi/koneksi.php';
    include 'function_utility.php';

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
        'guru' => ['nama_guru_g', 'jenis_kelamin', 'nama_mapel_g', 'alamat_guru_g', 'nip'],
        'jadwal' => ['jam_mulai', 'jam_selesai', 'nama_hari_j', 'nama_guru_j', 'nama_kelas_j', 'nama_mapel_j'],
        'absen' => ['nama_siswa_a', 'nama_mapel_a', 'waktu', 'tanggal', 'keterangan_a']
    ];

    // Pilih kolom yang sesuai berdasarkan tabel yang dipilih
    $cols = $cols_map[$tabel] ?? [];

    function cari($conn, $tabelSelect, $cols, $keyword, $limit, $offset, $sortBy, $sortOrder){
            // Bangun kondisi pencarian untuk setiap kolom
        $conditions = array_map(function($col) {
            return "$col LIKE ?";
        }, $cols);

        // Query untuk mencari data berdasarkan keyword dan mengurutkan hasilnya
        $sql = "SELECT * FROM {$tabelSelect} WHERE ". implode(' OR ', $conditions);
        $sql .= " ORDER BY {$sortBy} {$sortOrder} LIMIT ? OFFSET ?";

        // Persiapkan statement
        $stmt = $conn->prepare($sql);
        $likeKeyword = "%{$keyword}%";
        $params = array_fill(0, count($cols), $likeKeyword);

        $params[] = $limit;
        $params[] = $offset;
        // Bind parameter untuk pencarian, pagination, dan sorting
        $stmt->bind_param(str_repeat("s", count($cols)) . "ii", ...$params);
        $stmt->execute();
        
        return $stmt->get_result();
    }

    // Eksekusi pencarian dengan sorting
    $result = cari($conn, $tabelSelect, $cols, $search, $limit, $offset, $sortBy, $sortOrder);

    // Ambil data hasil query
    $data = [];
    $no = 1;
    while ($row = $result->fetch_assoc()){
        $row['no'] = $no++;
        $data[] = $row;
    }

    // Query untuk menghitung total data
    $totalSql = "SELECT COUNT(*) AS total FROM {$tabelSelect}";
    if(!empty($search)){
        $totalSql .= " WHERE ". implode(' OR ', array_map(function($col){
            return "$col LIKE ?";
        }, $cols));
    }

    // Persiapkan statement untuk total count
    $totalStmt = $conn->prepare($totalSql);
    if(!empty($search)){
        // Bind parameter untuk pencarian
        $totalStmt->bind_param(str_repeat("s", count($cols)), ...array_fill(0, count($cols), "%$search%"));
    }
    $totalStmt->execute();
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
        ]
        ]);
?>
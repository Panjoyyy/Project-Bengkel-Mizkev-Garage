# Requirements Document

## Introduction

Inbox Approval Case Finance adalah fitur baru yang menyediakan mekanisme approval untuk transaksi case finance antara user kantor pusat (head office) dan user cabang (branch). User kantor pusat memiliki wewenang untuk melakukan aksi approval (approve/reject), sedangkan user cabang hanya dapat melihat status approval dan berkomunikasi melalui fitur chat. Fitur ini mencakup definisi struktur database, workflow approval, role-based access, dan komunikasi real-time antara cabang dan pusat.

## Glossary

- **Sistem_Inbox**: Modul utama yang menampilkan daftar case finance yang memerlukan approval
- **Sistem_Approval**: Komponen yang memproses aksi approval (approve/reject) dari user kantor pusat
- **Sistem_Chat**: Komponen yang mengelola komunikasi pesan antara user cabang dan user kantor pusat
- **User_Pusat**: Pengguna dari kantor pusat yang memiliki hak akses untuk melakukan approval
- **User_Cabang**: Pengguna dari kantor cabang yang hanya dapat melihat status approval dan mengirim pesan chat
- **Case_Finance**: Transaksi keuangan yang memerlukan persetujuan dari kantor pusat
- **Status_Approval**: Kondisi persetujuan suatu case (PENDING, APPROVED, REJECTED, RETURNED)
- **REP_CAB_ID**: Kode identifikasi cabang yang digunakan di seluruh sistem existing

## Requirements

### Requirement 1: Struktur Database Tabel Case Finance Header

**User Story:** Sebagai developer, saya ingin mendefinisikan tabel database untuk menyimpan data case finance header, sehingga setiap case yang diajukan cabang tercatat dengan lengkap.

#### Acceptance Criteria

1. THE Sistem_Inbox SHALL menyimpan data case finance di tabel GL.CASE_FINANCE_HDR dengan kolom: CASE_ID (VARCHAR2(30) PRIMARY KEY), REP_CAB_ID (VARCHAR2(10) NOT NULL), CASE_NO (VARCHAR2(30) NOT NULL), CASE_DATE (DATE NOT NULL), CASE_DESC (VARCHAR2(200)), CASE_AMOUNT (NUMBER(18,2)), CASE_TYPE (VARCHAR2(10)), STS_APPROVAL (VARCHAR2(1) DEFAULT 'P'), APPROVAL_DATE (DATE), APPROVAL_BY (VARCHAR2(30)), APPROVAL_REMARKS (VARCHAR2(500)), USR_INP (VARCHAR2(30)), TGL_INP (DATE), USR_UPD (VARCHAR2(30)), TGL_UPD (DATE)
2. THE Sistem_Inbox SHALL menggunakan nilai STS_APPROVAL: 'P' untuk Pending, 'A' untuk Approved, 'R' untuk Rejected, 'T' untuk Returned
3. WHEN record baru CASE_FINANCE_HDR dibuat, THE Sistem_Inbox SHALL meng-generate CASE_ID menggunakan format: REP_CAB_ID || TO_CHAR(SYSDATE,'MMYYYY') || LPAD(GL.CASE_FINANCE_HDR_SEQ.NEXTVAL, 5, '0')
4. IF CASE_ID yang di-generate sudah ada di tabel, THEN THE Sistem_Inbox SHALL menolak penyimpanan record dan menampilkan pesan error yang mengindikasikan duplikasi CASE_ID

### Requirement 2: Struktur Database Tabel Case Finance Detail

**User Story:** Sebagai developer, saya ingin mendefinisikan tabel database untuk menyimpan detail dokumen pendukung case finance, sehingga setiap case memiliki kelengkapan informasi.

#### Acceptance Criteria

1. THE Sistem_Inbox SHALL menyimpan detail case finance di tabel CASE_FINANCE_DTL dengan kolom: CASE_ID (VARCHAR2(50) NOT NULL, FK ke CASE_FINANCE_HDR), DTL_ENTNO (NUMBER(4,0) NOT NULL), DTL_DESC (VARCHAR2(500) NOT NULL), DTL_AMOUNT (NUMBER(19,2) NOT NULL), DTL_ACCOUNT_NO (VARCHAR2(14)), DTL_REMARKS (VARCHAR2(500)), USR_INP (VARCHAR2(10)), TGL_INP (DATE), USR_UPD (VARCHAR2(10)), TGL_UPD (DATE)
2. THE Sistem_Inbox SHALL menggunakan composite primary key dari CASE_ID dan DTL_ENTNO pada tabel CASE_FINANCE_DTL
3. THE Sistem_Inbox SHALL meng-generate nilai DTL_ENTNO secara sequential per CASE_ID, dimulai dari 1, menggunakan formula MAX(DTL_ENTNO) + 1 untuk CASE_ID yang sama
4. IF record CASE_FINANCE_DTL di-insert dengan CASE_ID yang tidak ada di CASE_FINANCE_HDR, THEN THE Sistem_Inbox SHALL menolak operasi insert tersebut dengan error constraint violation

### Requirement 3: Struktur Database Tabel Chat

**User Story:** Sebagai developer, saya ingin mendefinisikan tabel database untuk menyimpan pesan chat antara user cabang dan kantor pusat, sehingga komunikasi terkait case finance terdokumentasi.

#### Acceptance Criteria

1. THE Sistem_Chat SHALL menyimpan pesan chat di tabel CASE_FINANCE_CHAT dengan kolom: CHAT_ID (NUMBER PRIMARY KEY, generated dari sequence GL.CASE_FINANCE_CHAT_SEQ), CASE_ID (VARCHAR2(30) NOT NULL, FK ke CASE_FINANCE_HDR), CHAT_MSG (VARCHAR2(2000) NOT NULL), CHAT_BY (VARCHAR2(30) NOT NULL), CHAT_DATE (DATE NOT NULL), CHAT_FROM_TYPE (VARCHAR2(1) NOT NULL), READ_STATUS (VARCHAR2(1) DEFAULT 'N'), USR_INP (VARCHAR2(30)), TGL_INP (DATE)
2. THE Sistem_Chat SHALL menggunakan nilai CHAT_FROM_TYPE: 'P' untuk pesan dari User_Pusat dan 'C' untuk pesan dari User_Cabang
3. THE Sistem_Chat SHALL menggunakan nilai READ_STATUS: 'N' untuk belum dibaca dan 'Y' untuk sudah dibaca
4. IF record CASE_FINANCE_CHAT di-insert dengan CASE_ID yang tidak ada di CASE_FINANCE_HDR, THEN THE Sistem_Chat SHALL menolak operasi insert tersebut dengan error FK constraint violation

### Requirement 4: Struktur Database Tabel Approval History

**User Story:** Sebagai developer, saya ingin mendefinisikan tabel database untuk menyimpan riwayat approval, sehingga setiap perubahan status approval tercatat.

#### Acceptance Criteria

1. THE Sistem_Approval SHALL menyimpan riwayat approval di tabel CASE_FINANCE_APPROVAL_HIST dengan kolom: HIST_ID (NUMBER PRIMARY KEY), CASE_ID (VARCHAR2 FK ke CASE_FINANCE_HDR), ACTION_TYPE (VARCHAR2 NOT NULL), ACTION_BY (VARCHAR2 NOT NULL), ACTION_DATE (DATE NOT NULL), ACTION_REMARKS (VARCHAR2), PREV_STATUS (VARCHAR2), NEW_STATUS (VARCHAR2), USR_INP (VARCHAR2), TGL_INP (DATE)
2. THE Sistem_Approval SHALL menggunakan nilai ACTION_TYPE: 'A' untuk Approve, 'R' untuk Reject, 'T' untuk Return
3. THE Sistem_Approval SHALL meng-generate HIST_ID secara unik menggunakan sequence number GL.CASE_FINANCE_HIST_SEQ
4. WHEN User_Pusat melakukan aksi approval (Approve, Reject, atau Return), THE Sistem_Approval SHALL menyimpan satu record baru di tabel CASE_FINANCE_APPROVAL_HIST dengan PREV_STATUS berisi nilai STS_APPROVAL sebelum perubahan, NEW_STATUS berisi nilai STS_APPROVAL setelah perubahan, ACTION_BY berisi user ID dari User_Pusat yang melakukan aksi, dan ACTION_DATE berisi tanggal saat aksi dilakukan

### Requirement 5: Inbox Display untuk User Kantor Pusat

**User Story:** Sebagai User_Pusat, saya ingin melihat daftar case finance yang memerlukan approval, sehingga saya dapat memproses persetujuan dengan efisien.

#### Acceptance Criteria

1. WHEN User_Pusat membuka halaman Inbox Approval, THE Sistem_Inbox SHALL menampilkan daftar case finance dengan status "Pending" yang diurutkan berdasarkan tanggal pengajuan secara ascending (terlama di atas), dengan maksimum 25 baris per halaman menggunakan paging
2. THE Sistem_Inbox SHALL menampilkan kolom-kolom berikut pada tabel daftar case: nomor case, tanggal pengajuan (format dd-MM-yyyy), cabang pengirim (REP_CAB_ID dan nama cabang), deskripsi case (maksimum 100 karakter ditampilkan dengan ellipsis jika melebihi), jumlah nominal (format currency dengan separator ribuan), dan status approval
3. WHEN User_Pusat memilih satu case dari daftar, THE Sistem_Inbox SHALL menampilkan panel detail yang berisi seluruh informasi kolom tabel ditambah nama pemohon, catatan pengajuan, dan daftar dokumen pendukung
4. THE Sistem_Inbox SHALL menyediakan fitur filter berdasarkan REP_CAB_ID (dropdown), rentang tanggal pengajuan (date picker dari-sampai, maksimum rentang 12 bulan), dan status approval (pilihan: Semua, Pending, Approved, Rejected, Returned)
5. IF hasil filter atau daftar inbox tidak memiliki data yang sesuai, THEN THE Sistem_Inbox SHALL menampilkan pesan "No data to display." pada area tabel
6. IF dokumen pendukung tidak tersedia atau gagal dimuat saat case dipilih, THEN THE Sistem_Inbox SHALL menampilkan pesan yang mengindikasikan dokumen tidak dapat ditampilkan tanpa menghalangi akses ke informasi detail case lainnya

### Requirement 6: Aksi Approval oleh User Kantor Pusat

**User Story:** Sebagai User_Pusat, saya ingin dapat melakukan approve, reject, atau return suatu case finance, sehingga proses persetujuan berjalan sesuai prosedur.

#### Acceptance Criteria

1. WHILE case finance memiliki STS_APPROVAL 'P', WHEN User_Pusat menekan tombol Approve, THE Sistem_Approval SHALL mengubah STS_APPROVAL menjadi 'A', mencatat APPROVAL_DATE dengan waktu server saat aksi dilakukan, dan mencatat APPROVAL_BY dengan user ID dari session login
2. WHILE case finance memiliki STS_APPROVAL 'P', WHEN User_Pusat menekan tombol Reject, THE Sistem_Approval SHALL mengubah STS_APPROVAL menjadi 'R', mencatat APPROVAL_DATE dan APPROVAL_BY, dan mewajibkan pengisian APPROVAL_REMARKS minimal 1 karakter sebelum proses dieksekusi
3. WHILE case finance memiliki STS_APPROVAL 'P', WHEN User_Pusat menekan tombol Return, THE Sistem_Approval SHALL mengubah STS_APPROVAL menjadi 'T', mencatat APPROVAL_DATE dan APPROVAL_BY, dan mewajibkan pengisian APPROVAL_REMARKS minimal 1 karakter sebelum proses dieksekusi
4. IF User_Pusat melakukan Reject atau Return tanpa mengisi APPROVAL_REMARKS atau mengisi kurang dari 1 karakter, THEN THE Sistem_Approval SHALL menampilkan pesan validasi yang mengindikasikan bahwa remarks wajib diisi, dan menolak pemrosesan aksi tersebut
5. WHEN status approval berubah, THE Sistem_Approval SHALL menyimpan satu record baru di tabel CASE_FINANCE_APPROVAL_HIST dengan ACTION_TYPE berisi nilai aksi ('APPROVE', 'REJECT', atau 'RETURN'), PREV_STATUS berisi status sebelum perubahan, dan NEW_STATUS berisi status setelah perubahan
6. IF proses penyimpanan aksi approval gagal (stored procedure error atau kegagalan database), THEN THE Sistem_Approval SHALL menampilkan pesan error yang mengindikasikan kegagalan proses, tidak mengubah STS_APPROVAL dari nilai sebelumnya, dan tidak menyimpan record di tabel CASE_FINANCE_APPROVAL_HIST

### Requirement 7: Inbox View untuk User Cabang

**User Story:** Sebagai User_Cabang, saya ingin melihat status approval case finance yang telah diajukan, sehingga saya mengetahui perkembangan proses persetujuan.

#### Acceptance Criteria

1. WHEN User_Cabang membuka halaman Inbox, THE Sistem_Inbox SHALL menampilkan daftar case finance milik cabang tersebut berdasarkan REP_CAB_ID dari session, diurutkan berdasarkan CASE_DATE dari yang terbaru, dengan maksimal 50 baris per halaman
2. THE Sistem_Inbox SHALL menampilkan kolom berikut pada af:table: nomor case (CASE_NO), tanggal pengajuan (CASE_DATE), deskripsi (CASE_DESC), jumlah nominal (CASE_AMOUNT), status approval dalam label terbaca (Pending/Approved/Rejected/Returned), dan tanggal approval (APPROVAL_DATE)
3. WHILE User_Cabang mengakses halaman Inbox, THE Sistem_Inbox SHALL menonaktifkan aksi edit dan delete pada case dengan status Approved ('A'), Rejected ('R'), atau Pending ('P')
4. IF status approval suatu case adalah Returned ('T'), THEN THE Sistem_Inbox SHALL menampilkan APPROVAL_REMARKS dari User_Pusat dan mengaktifkan aksi edit pada case tersebut
5. WHEN User_Cabang mengajukan ulang case yang berstatus Returned, THE Sistem_Inbox SHALL mengubah STS_APPROVAL kembali menjadi 'P' (Pending), mengosongkan APPROVAL_DATE dan APPROVAL_BY, serta menyimpan record riwayat di tabel CASE_FINANCE_APPROVAL_HIST

### Requirement 8: Fitur Chat antara Cabang dan Kantor Pusat

**User Story:** Sebagai User_Cabang dan User_Pusat, saya ingin berkomunikasi melalui chat terkait suatu case finance, sehingga klarifikasi dan diskusi terdokumentasi.

#### Acceptance Criteria

1. WHEN user membuka detail case finance, THE Sistem_Chat SHALL menampilkan panel chat yang berisi riwayat pesan terkait case tersebut, diambil berdasarkan CASE_ID yang sedang dibuka
2. THE Sistem_Chat SHALL menampilkan pesan diurutkan berdasarkan CHAT_DATE dari yang terlama ke terbaru, dengan setiap pesan menampilkan isi pesan, nama pengirim (CHAT_BY), tipe pengirim (Pusat/Cabang berdasarkan CHAT_FROM_TYPE), dan waktu pengiriman (CHAT_DATE)
3. WHEN user mengirim pesan baru, THE Sistem_Chat SHALL menyimpan pesan ke tabel CASE_FINANCE_CHAT dengan CHAT_FROM_TYPE sesuai tipe user pengirim ('P' untuk User_Pusat, 'C' untuk User_Cabang), CHAT_DATE diisi waktu saat pengiriman, dan READ_STATUS 'N'
4. IF user mengirim pesan dengan isi kosong atau melebihi 2000 karakter, THEN THE Sistem_Chat SHALL menampilkan pesan validasi dan menolak pengiriman tanpa menyimpan data ke database
5. WHEN user membuka panel chat yang memiliki pesan dengan READ_STATUS 'N' dari pihak lawan, THE Sistem_Chat SHALL mengubah READ_STATUS menjadi 'Y' untuk pesan-pesan tersebut
6. WHEN user menekan tombol refresh atau melakukan aksi PPR pada panel chat, THE Sistem_Chat SHALL memuat ulang daftar pesan terbaru dari database untuk menampilkan pesan baru yang masuk

### Requirement 9: Role-Based Access Control

**User Story:** Sebagai administrator sistem, saya ingin membatasi akses berdasarkan peran user, sehingga hanya user yang berwenang yang dapat melakukan aksi tertentu.

#### Acceptance Criteria

1. THE Sistem_Inbox SHALL membedakan hak akses berdasarkan tipe user: User_Pusat (REP_CAB_ID = '001') memiliki akses approval dan User_Cabang (REP_CAB_ID selain '001') hanya memiliki akses view
2. WHILE User_Cabang mengakses halaman Inbox, THE Sistem_Inbox SHALL menyembunyikan tombol Approve, Reject, dan Return baik di level UI maupun menolak request di level server-side
3. WHILE User_Pusat mengakses halaman Inbox, THE Sistem_Inbox SHALL menampilkan tombol Approve, Reject, dan Return hanya pada case dengan STS_APPROVAL = 'P' (Pending)
4. THE Sistem_Inbox SHALL menentukan tipe user berdasarkan REP_CAB_ID yang diperoleh dari UserProfile session login
5. IF session login tidak tersedia atau REP_CAB_ID bernilai null, THEN THE Sistem_Inbox SHALL menolak akses ke halaman Inbox dan mengarahkan user ke halaman login

### Requirement 10: Pengajuan Case Finance oleh User Cabang

**User Story:** Sebagai User_Cabang, saya ingin mengajukan case finance baru untuk approval kantor pusat, sehingga proses keuangan dapat berjalan sesuai prosedur.

#### Acceptance Criteria

1. WHEN User_Cabang mengisi form case finance dan menekan tombol Submit, THE Sistem_Inbox SHALL menyimpan data ke tabel CASE_FINANCE_HDR dan CASE_FINANCE_DTL dengan STS_APPROVAL 'P', serta mengisi USR_INP dari user ID session dan TGL_INP dari waktu server
2. THE Sistem_Inbox SHALL memvalidasi bahwa field wajib (CASE_NO, CASE_DATE, CASE_DESC, minimal satu baris detail dengan DTL_DESC dan DTL_AMOUNT terisi) telah diisi sebelum menyimpan
3. IF field wajib belum diisi lengkap, THEN THE Sistem_Inbox SHALL menampilkan pesan error spesifik yang menunjukkan field mana yang belum diisi, tanpa menyimpan data ke database
4. WHEN case berhasil disimpan, THE Sistem_Inbox SHALL menampilkan pesan konfirmasi yang menyertakan CASE_ID yang di-generate, dan mereset form pengajuan ke keadaan kosong
5. IF proses penyimpanan gagal karena error database, THEN THE Sistem_Inbox SHALL menampilkan pesan error dan melakukan rollback seluruh transaksi tanpa menyimpan data parsial

### Requirement 11: Notifikasi Perubahan Status

**User Story:** Sebagai User_Cabang, saya ingin mendapatkan notifikasi ketika status approval berubah, sehingga saya dapat segera mengetahui hasil keputusan kantor pusat.

#### Acceptance Criteria

1. WHEN status approval suatu case berubah (dari Pending ke Approved, Rejected, atau Returned), THE Sistem_Inbox SHALL menambahkan satu notifikasi belum dibaca dan menampilkan indikator badge pada menu Inbox user cabang terkait yang menunjukkan total jumlah notifikasi belum dibaca, dengan nilai maksimum tampilan 99 (ditampilkan sebagai "99+" jika melebihi 99)
2. WHEN User_Cabang membuka halaman detail case yang memiliki notifikasi belum dibaca, THE Sistem_Inbox SHALL menandai seluruh notifikasi terkait case tersebut sebagai sudah dibaca dan mengurangi jumlah badge sesuai jumlah notifikasi yang ditandai
3. WHEN ada pesan chat baru dari pihak kantor pusat pada suatu case, THE Sistem_Chat SHALL menampilkan indikator jumlah pesan belum dibaca pada case terkait di daftar Inbox, dengan nilai maksimum tampilan 99 (ditampilkan sebagai "99+" jika melebihi 99)
4. WHEN seluruh notifikasi telah ditandai sebagai sudah dibaca (jumlah notifikasi belum dibaca = 0), THE Sistem_Inbox SHALL menyembunyikan indikator badge dari menu Inbox
5. WHEN User_Cabang memuat atau me-refresh halaman Inbox, THE Sistem_Inbox SHALL menghitung ulang jumlah notifikasi belum dibaca dari database dan memperbarui indikator badge sesuai nilai terkini

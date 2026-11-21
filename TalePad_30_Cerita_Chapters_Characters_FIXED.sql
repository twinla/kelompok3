-- TalePad sample seed: 30 stories, 60 chapters, 66 characters.
-- Safe to run repeatedly: existing stories (by slug OR title), chapters (story + chapter_number),
-- and characters (story + name) are skipped. No existing records are deleted or overwritten.
-- stories.user_id is left NULL so no specific account is required.
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;

DROP TEMPORARY TABLE IF EXISTS tmp_tp_stories;
DROP TEMPORARY TABLE IF EXISTS tmp_tp_story_map;
DROP TEMPORARY TABLE IF EXISTS tmp_tp_chapters;
DROP TEMPORARY TABLE IF EXISTS tmp_tp_characters;

CREATE TEMPORARY TABLE tmp_tp_stories (
    seed_slug VARCHAR(180) NOT NULL PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    author VARCHAR(100) NOT NULL,
    genre VARCHAR(80) NOT NULL,
    synopsis TEXT NOT NULL,
    chapter1_title VARCHAR(160) NOT NULL,
    chapter1_content LONGTEXT NOT NULL,
    chapter2_title VARCHAR(160) NOT NULL,
    chapter2_content LONGTEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tmp_tp_stories (seed_slug, title, author, genre, synopsis, chapter1_title, chapter1_content, chapter2_title, chapter2_content) VALUES
('peta-yang-menolak-pulang', 'Peta yang Menolak Pulang', 'Alya Pramesti', 'Adventure', 'Nara menemukan peta tua yang selalu berubah setiap kali ia mencoba pulang. Bersama seorang penjaga mercusuar, ia harus mengikuti petunjuk sebelum pulau tempatnya berdiri menghilang dari dunia.', 'Garis yang Bergerak', 'Nara menemukan peta itu di dalam koper peninggalan kakeknya. Awalnya hanya garis pantai dan titik tinta yang pudar, tetapi ketika ia membukanya di dekat jendela, sebuah garis baru muncul menuju pulau yang tidak tercatat di peta mana pun.

Di pelabuhan, seorang penjaga mercusuar bernama Sagara mengenali lambang kecil di sudut kertas. Ia memperingatkan Nara bahwa peta itu tidak menunjukkan jalan pulang. Peta itu menunjukkan tempat yang sedang mencari seseorang.', 'Pulau yang Tidak Bernama', 'Perahu mereka tiba saat kabut menutup seluruh garis pantai. Kompas Sagara berputar tanpa arah, sementara peta di tangan Nara menggambar sebuah teluk yang belum terlihat. Mereka mengikuti garis itu dan menemukan rumah kayu dengan lampu menyala.

Di meja rumah tersebut tergeletak catatan kakek Nara: jangan percaya jalan yang tampak paling dekat. Saat Nara membalik kertas, tulisan baru muncul, menyebut namanya sendiri.'),
('kedai-teh-pukul-sembilan', 'Kedai Teh Pukul Sembilan', 'Dimas Wicaksono', 'Cozy Mystery', 'Setiap pukul sembilan malam, satu benda selalu hilang dari kedai teh milik Bu Suri. Ketika sebuah buku resep lenyap, pegawai baru bernama Lintang mulai menyelidiki pelanggan yang datang diam-diam.', 'Cangkir yang Kosong', 'Kedai Teh Pukul Sembilan selalu tutup tepat setelah lonceng tua berdentang. Namun malam itu, lonceng berbunyi tiga kali dan buku resep keluarga Bu Suri menghilang dari rak terkunci. Tidak ada jendela terbuka, tidak ada pintu yang rusak.

Lintang memeriksa meja pelanggan dan menemukan lingkaran teh yang belum kering. Jejak itu mengarah ke kursi nomor empat, tempat seorang pelanggan selalu duduk membelakangi jam.', 'Pelanggan Kursi Empat', 'Pelanggan itu bernama Raka, seorang pengantar bunga yang datang setiap Selasa. Ia mengaku tidak menyentuh rak, tetapi Lintang melihat noda tinta di ujung lengan bajunya. Bu Suri justru tampak lebih cemas daripada marah.

Saat kedai dibersihkan, Lintang menemukan secarik kertas terselip di bawah teko. Di sana tertulis resep teh yang tidak pernah diajarkan Bu Suri kepada siapa pun.'),
('di-balik-dinding-kaca', 'Di Balik Dinding Kaca', 'Mira Anindya', 'Psychological Thriller', 'Seorang arsitek mulai menerima foto ruang kerjanya dari sudut kamera yang tidak pernah ia pasang. Setiap foto memperlihatkan satu detail kecil yang berubah, termasuk bayangan seseorang di belakangnya.', 'Foto Pertama', 'Arga menerima foto itu pukul 02.13. Ruang kerjanya tampak kosong, kecuali kursi yang sedikit bergeser dan bayangan tipis di balik dinding kaca. Ia memeriksa seluruh ruangan, tetapi tidak menemukan siapa pun.

Keesokan malam, foto kedua datang. Kali ini bayangan itu berdiri lebih dekat. Arga memperbesar gambar dan menyadari sosok tersebut mengenakan kemeja yang sama dengannya.', 'Pantulan yang Terlambat', 'Arga menutup semua tirai dan mematikan lampu. Dalam pantulan kaca, gerakannya terlihat terlambat setengah detik. Ia mengangkat tangan; pantulan itu diam. Ketika ia menoleh, sebuah pesan muncul di layar komputer: berhenti mencari pintu keluar.

Ia membuka denah gedung lama dan menemukan ruangan yang seharusnya tidak ada, tepat di balik dinding kacanya sendiri.'),
('kota-yang-menyimpan-hujan', 'Kota yang Menyimpan Hujan', 'Salsa Mahendra', 'Magical Realism', 'Di kota yang tidak pernah turun hujan, seorang penjual payung menyimpan awan kecil di dalam botol. Seorang anak datang mencari hujan terakhir yang pernah dilihat ibunya.', 'Botol Awan', 'Di Kota Arunika, hujan hanya hidup dalam cerita orang tua. Toko payung milik Kakek Banyu menjadi tempat paling aneh di pasar: rak-raknya dipenuhi botol kaca berisi kabut, gerimis, bahkan suara petir yang jauh.

Suatu sore, seorang anak bernama Sita datang membawa foto ibunya di bawah hujan. Ia meminta satu botol yang berisi hujan pada hari ibunya menghilang. Kakek Banyu mengenali tanggal di belakang foto itu.', 'Aroma Tanah Basah', 'Kakek Banyu membuka botol kecil dengan segel biru. Aroma tanah basah memenuhi toko, dan untuk sesaat Sita mendengar suara ibunya memanggil dari ujung gang. Ia berlari keluar, tetapi langit tetap cerah.

Di dasar botol tertinggal sebutir biji. Kakek Banyu berkata hujan tidak bisa dikembalikan dengan membuka botol; seseorang harus berani menanam kenangannya.'),
('orbit-terakhir', 'Orbit Terakhir', 'Rafi Dirgantara', 'Space Opera', 'Kapal penelitian Asteria kehilangan komunikasi saat mengorbit planet asing. Kapten dan teknisi mudanya menemukan sinyal yang ternyata berasal dari masa depan kapal itu sendiri.', 'Sinyal dari Esok', 'Asteria memasuki orbit planet Kepler-91 ketika seluruh saluran komunikasi mendadak dipenuhi suara ketukan. Polanya berulang setiap tujuh detik, sama persis dengan kode darurat kapal mereka.

Kapten Elara meminta teknisi Bima memeriksa sumber sinyal. Bima menemukan koordinat yang menunjukkan posisi Asteria, tetapi waktunya tercatat dua puluh tiga jam lebih maju. Sinyal itu berakhir dengan satu kalimat: jangan menyalakan mesin utama.', 'Planet di Bawah Kita', 'Saat mesin utama dimatikan, kapal justru mulai turun menuju atmosfer. Elara memerintahkan kru menyiapkan kapsul evakuasi, tetapi Bima menemukan pola ketukan kedua yang tersembunyi di dalam gangguan.

Pola itu menggambarkan jalur orbit alternatif. Mereka mengikuti koordinat tersebut dan melihat cahaya bergerak di permukaan planet, membentuk lambang Asteria yang belum pernah mereka buat.'),
('neon-di-ujung-gang', 'Neon di Ujung Gang', 'Keisha Putri', 'Cyberpunk', 'Di kota yang setiap ingatannya bisa dibeli, seorang kurir data menemukan rekaman masa kecil yang tidak pernah ia miliki. Ia harus memilih antara mengembalikan ingatannya atau membongkar perusahaan penghapus memori.', 'Paket Tanpa Nama', 'Juno bekerja mengantar data melalui lorong-lorong neon Kota Meridian. Paket terakhir malam itu tidak memiliki nama penerima, hanya koordinat sebuah kios permainan tua. Ketika dibuka, paket tersebut berisi rekaman seorang anak yang memanggil Juno sebagai kakaknya.

Ia tidak mengenali wajah anak itu, tetapi gelang kain di pergelangan tangannya sama dengan gelang yang selalu ia pakai sejak kecil. Di sudut rekaman muncul logo perusahaan Memoria.', 'Harga Sebuah Ingatan', 'Mara, mantan teknisi Memoria, menjelaskan bahwa perusahaan itu dapat menghapus ingatan tanpa meninggalkan luka fisik. Ia menduga Juno pernah menjadi subjek uji coba. Untuk membuktikannya, mereka perlu masuk ke arsip pusat.

Di depan gedung, Juno menerima tawaran anonim: satu ingatan utuh sebagai imbalan atas rekaman tersebut. Ia mematikan perangkat dan memilih mencari kebenaran sendiri.'),
('musim-ketika-laut-naik', 'Musim Ketika Laut Naik', 'Nadia Kusuma', 'Climate Fiction', 'Keluarga nelayan di pesisir harus meninggalkan kampung saat air laut terus naik. Putri mereka membuat peta rumah-rumah yang tenggelam agar cerita warga tidak ikut hilang.', 'Patok Air', 'Setiap pagi, Rumi menandai tinggi air pada tiang kayu di depan rumah. Tahun ini, garisnya naik lebih cepat daripada perkiraan siapa pun. Ayahnya tetap memperbaiki jaring, seolah laut masih bisa diajak berunding.

Ketika sekolah mengumumkan pemindahan warga, Rumi mulai menggambar denah rumah-rumah yang akan ditinggalkan. Ia menulis nama pemilik, cerita halaman, dan pohon yang pernah tumbuh di sana.', 'Peta untuk Mereka yang Pergi', 'Pak Darsa menolak meninggalkan perahu kecilnya. Rumi mengajaknya melihat peta yang ia buat, termasuk tanda tempat anak-anak biasa bermain dan sumur yang airnya paling manis. Untuk pertama kalinya, ayahnya membaca semua nama itu sampai selesai.

Malam sebelum evakuasi, warga berkumpul dan menambahkan satu titik terakhir: tempat mereka berjanji akan bertemu kembali.'),
('legenda-penjaga-padi', 'Legenda Penjaga Padi', 'Bagas Wening', 'Folklore Fantasy', 'Saat sawah desa gagal panen, seorang gadis mendengar suara dari lumbung tua. Ia menemukan penjaga padi yang meminta satu janji untuk memulihkan keseimbangan musim.', 'Lumbung yang Bernapas', 'Malam sebelum panen, Dini mendengar bunyi napas dari lumbung yang sudah lama dikunci. Di dalamnya, karung-karung padi tersusun membentuk lingkaran. Seekor burung putih bertengger di balok dan memanggil namanya.

Burung itu memperkenalkan diri sebagai Jati, penjaga benih yang hanya muncul ketika manusia melupakan cara berbagi. Dini diminta membawa segenggam padi ke mata air sebelum fajar.', 'Janji Tujuh Benih', 'Dini membawa benih melewati pematang yang retak. Di mata air, ia melihat bayangan sawah yang pernah hijau, tetapi setiap tanaman tumbuh dari satu janji yang diingkari. Jati menjelaskan bahwa benih tidak akan tumbuh jika hanya disimpan untuk diri sendiri.

Dini pulang dan mengajak warga membagi persediaan terakhir. Ketika matahari terbit, satu tunas muncul di tanah yang paling kering.'),
('surat-dari-menara-jam', 'Surat dari Menara Jam', 'Tania Wiratama', 'Historical Fiction', 'Seorang penjilid buku menemukan surat dari masa pendudukan di balik mekanisme menara jam kota. Surat itu mengungkap kisah persahabatan dua keluarga yang terpisah oleh pilihan sulit.', 'Kertas di Balik Roda', 'Pada 1947, penjilid buku muda bernama Seno dipanggil untuk memperbaiki buku catatan di menara jam. Di balik roda gigi utama, ia menemukan amplop yang dilipat berkali-kali. Kertasnya rapuh, tetapi tulisan di dalamnya masih terbaca.

Surat itu ditujukan kepada seseorang bernama Mirah dan meminta agar lonceng dibunyikan tiga kali pada hari pasar. Seno mengenali nama tersebut dari cerita ibunya, tetapi tidak pernah tahu hubungannya dengan keluarganya.', 'Tiga Dentang', 'Seno mencari Mirah melalui daftar penduduk lama. Ia menemukan alamat rumah yang kini menjadi toko roti, dan pemiliknya masih menyimpan foto seorang perempuan di dekat menara. Foto itu memperlihatkan dua anak yang saling menggenggam tangan.

Saat jam menunjukkan pukul enam, Seno membunyikan lonceng tiga kali. Dari seberang alun-alun, seorang perempuan tua mengangkat tangan, seolah menunggu suara itu selama puluhan tahun.'),
('taman-untuk-bintang-yang-padam', 'Taman untuk Bintang yang Padam', 'Nisa Larasati', 'Literary Fiction', 'Seorang penjaga taman kota merawat petak bunga yang selalu dibiarkan kosong. Ketika seorang anak mulai datang setiap sore, ia belajar bahwa kehilangan tidak harus membuat seseorang berhenti menanam.', 'Petak Kosong', 'Pak Ranu selalu menyisakan satu petak tanah di tengah taman. Tidak ada bunga, tidak ada papan nama, hanya tanah yang ia gemburkan setiap Senin. Pengunjung mengira ia lupa menanam sesuatu.

Suatu sore, seorang anak bernama Lio duduk di tepi petak itu dan bertanya apakah bintang bisa tumbuh dari tanah. Pak Ranu menjawab bahwa ia pernah menanam satu, tetapi belum siap melihatnya berbunga.', 'Benih Kecil', 'Lio membawa sekantong benih bunga liar dari halaman rumahnya. Mereka menanamnya tanpa memberi nama pada petak tersebut. Hari-hari berikutnya, Lio datang menyiram tanah dan bercerita tentang ibunya yang menyukai langit malam.

Ketika bunga pertama mekar, Pak Ranu meletakkan bangku kecil di dekatnya. Ia akhirnya bercerita tentang putrinya, dan taman itu tidak lagi terasa seperti tempat yang harus dijaga sendirian.'),
('tiga-hari-tanpa-matahari', 'Tiga Hari Tanpa Matahari', 'Fajar Mahesa', 'Post-Apocalyptic', 'Kabut abu menutupi matahari selama tiga hari dan memutus jalur antarkota. Sekelompok tetangga di sebuah apartemen harus bekerja sama menjaga persediaan dan mencari jalan keluar.', 'Hari Pertama', 'Pagi datang tanpa cahaya. Dari lantai dua belas, Aksa melihat kota tertutup kabut abu yang membuat gedung seberang menghilang. Ponsel tidak mendapat sinyal dan lift berhenti di antara lantai.

Di lorong, penghuni apartemen mulai mengumpulkan air, baterai, dan makanan. Aksa membuat daftar kebutuhan, tetapi seorang tetangga memperingatkan bahwa persediaan hanya cukup untuk dua hari.', 'Tangga Darurat', 'Pada hari kedua, kabut mulai masuk melalui ventilasi. Aksa dan dokter Rhea memutuskan turun lewat tangga darurat untuk mencari sumber air cadangan. Di lantai tujuh mereka menemukan pintu yang terbuka dan sebuah radio masih menyala.

Radio itu menyiarkan koordinat tempat evakuasi, tetapi suara penyiar terputus sebelum menyebut jalur aman. Mereka harus memilih: menunggu bantuan atau memimpin penghuni keluar bersama-sama.'),
('kontrak-dengan-tuan-senja', 'Kontrak dengan Tuan Senja', 'Citra Paramita', 'Urban Fantasy', 'Seorang pekerja malam menukar satu jam hidupnya demi menyelamatkan adiknya. Namun pria yang mengurus kontrak senja ternyata mengumpulkan waktu untuk alasan yang jauh lebih rumit.', 'Satu Jam', 'Setiap pukul enam sore, sebuah toko jam muncul di antara dua gedung yang berbeda. Mira menemukannya ketika mencari obat untuk adiknya. Pemilik toko menawarkan satu jam tambahan untuk siapa pun yang bersedia menyerahkan satu jam dari masa depannya.

Mira menandatangani kontrak tanpa membaca bagian kecil di bawahnya. Tuan Senja tersenyum dan menyerahkan jam saku yang jarumnya bergerak mundur.', 'Jarum yang Mundur', 'Jam saku itu memberi Mira waktu untuk menemukan obat, tetapi setiap kali ia menggunakannya, satu kenangan masa kecil memudar. Ia kembali ke toko untuk membatalkan kontrak. Tuan Senja berkata kontrak hanya dapat diputus jika semua waktu yang terkumpul dikembalikan.

Mira menemukan rak berisi ribuan jam, masing-masing bertuliskan nama seseorang. Di antara semuanya, ia melihat nama adiknya.'),
('nada-terakhir-sang-konduktor', 'Nada Terakhir Sang Konduktor', 'Reno Adikara', 'Music Fiction', 'Orkestra kota bersiap untuk konser terakhir sebelum gedungnya ditutup. Seorang pemain biola menemukan partitur tanpa nama yang mengubah cara seluruh anggota memandang musik dan perpisahan.', 'Partitur Tanpa Judul', 'Di ruang arsip orkestra, Lala menemukan partitur yang tidak tercatat dalam katalog. Halaman pertamanya kosong, sedangkan halaman terakhir dipenuhi catatan tangan tentang jeda dan napas. Konduktor Surya langsung mengenali tulisan itu, tetapi menolak menjelaskan asalnya.

Mereka mencoba memainkan bagian pembuka. Setiap alat musik terdengar seperti mengingat sesuatu yang berbeda, dan seluruh ruangan mendadak sunyi pada ketukan ketujuh.', 'Jeda Ketujuh', 'Surya mengungkapkan bahwa partitur itu ditulis oleh pendiri orkestra, yang meninggal sebelum sempat memimpin konser terakhirnya. Ia menyimpan halaman tersebut karena takut musiknya tidak akan pernah selesai.

Lala mengusulkan agar setiap pemain menyumbangkan satu nada dari lagu yang paling mereka ingat. Partitur itu akhirnya menjadi komposisi bersama, bukan milik satu orang saja.'),
('garis-finish-untuk-ayah', 'Garis Finish untuk Ayah', 'Yusuf Pradana', 'Sports Fiction', 'Seorang pelari SMA berlatih untuk menyelesaikan lomba yang dahulu gagal dituntaskan ayahnya. Di tengah cedera dan tekanan, ia belajar bahwa garis akhir bukan satu-satunya ukuran keberanian.', 'Sepatu Lama', 'Davin menemukan sepatu lari ayahnya di bawah lemari. Solnya sudah tipis, tetapi nomor lomba lama masih terikat pada tali. Ayahnya pernah berhenti di kilometer terakhir karena cedera, dan sejak itu tidak pernah menonton perlombaan lagi.

Davin mendaftar lomba kota tanpa memberi tahu siapa pun. Pelatih Niko melihat jadwal latihannya dan mengingatkan bahwa mengejar cerita orang lain bisa membuatnya lupa mendengarkan tubuh sendiri.', 'Kilometer Terakhir', 'Pada hari lomba, hujan membuat lintasan licin. Davin tertinggal jauh setelah kakinya mulai nyeri. Di tepi lintasan, ayahnya berdiri dengan sepatu lama di tangan. Ia tidak berteriak agar Davin menang, hanya mengangkat ibu jari.

Davin memperlambat langkah, mengatur napas, dan menyelesaikan lomba tanpa memaksakan cedera. Untuk pertama kalinya, ayahnya tersenyum saat mendengar suara garis finish.'),
('resep-rahasia-rumah-kaca', 'Resep Rahasia Rumah Kaca', 'Dewi Anggraini', 'Culinary Fiction', 'Di sebuah rumah kaca yang hampir dijual, dua saudara menemukan buku resep ibu mereka. Setiap hidangan menghidupkan kenangan yang membantu mereka memutuskan masa depan keluarga.', 'Buku Bercak Tepung', 'Aroma rosemary memenuhi rumah kaca yang sudah lama tidak dipakai. Raka menemukan buku resep ibu di laci meja tanam, dengan bercak tepung dan catatan kecil di setiap halaman. Resep pertama meminta tomat yang dipetik sebelum matahari terbit.

Adiknya, Sera, ingin menjual rumah kaca untuk membayar utang. Raka meminta satu hari untuk mencoba resep itu, bukan sebagai alasan menunda, tetapi sebagai cara mengingat apa yang pernah mereka bangun bersama.', 'Sup untuk Dua Orang', 'Mereka memasak sup tomat dari tanaman terakhir. Rasanya sederhana, tetapi di balik halaman resep ada surat ibu yang meminta mereka tidak mempertahankan rumah hanya karena takut kehilangan masa lalu.

Sera mengusulkan menjadikan rumah kaca sebagai dapur komunitas. Raka setuju dengan satu syarat: setiap menu harus memakai bahan dari kebun dan menyimpan satu cerita keluarga.'),
('sepasang-tiket-ke-utara', 'Sepasang Tiket ke Utara', 'Anisa Pertiwi', 'Travel Romance', 'Dua orang asing menerima tiket kereta yang tertukar. Perjalanan panjang ke utara membuat mereka membagikan alasan masing-masing meninggalkan kota dan hal yang masih ingin mereka temukan.', 'Kursi yang Tertukar', 'Naya mendapati nomor kursinya ditempati seorang pria yang memegang tiket dengan tujuan sama. Namanya Damar, dan tiket mereka tertukar sejak loket keberangkatan. Kondektur menyarankan mereka duduk bersebelahan sampai stasiun berikutnya.

Percakapan dimulai dari peta perjalanan, lalu beralih pada alasan mereka pergi. Naya ingin melihat salju untuk pertama kali; Damar ingin mengembalikan sebuah buku kepada seseorang yang pernah ia tinggalkan.', 'Stasiun Utara', 'Kereta berhenti lebih lama karena jalur tertutup kabut. Damar mengaku tidak yakin orang yang ia cari masih tinggal di kota tujuan. Naya menyarankan agar ia tetap menyerahkan buku itu, sekalipun tidak mendapat jawaban.

Di stasiun utara, mereka bertukar tiket yang benar. Namun sebelum berpisah, Damar mengajak Naya berjalan ke peron paling ujung untuk melihat salju pertama musim itu.'),
('kelas-terakhir-bu-ratih', 'Kelas Terakhir Bu Ratih', 'Mawar Salsabila', 'School Drama', 'Kelas yang akan dibubarkan menyusun proyek terakhir untuk menyelamatkan perpustakaan sekolah. Di tengah konflik dan perbedaan, mereka menemukan alasan untuk saling mendengarkan.', 'Pengumuman di Papan', 'Bu Ratih menempelkan surat bahwa kelas mereka akan digabung semester depan. Perpustakaan kecil di ujung koridor juga terancam menjadi ruang penyimpanan. Murid-murid bereaksi berbeda: ada yang marah, ada yang tidak peduli, dan ada yang takut kehilangan tempat berkumpul.

Ketua kelas, Fikri, mengusulkan pameran cerita warga sekolah. Jika cukup banyak orang datang, mereka akan mengajukan proposal untuk mempertahankan perpustakaan.', 'Pameran Cerita', 'Setiap murid membawa satu cerita: penjaga sekolah tentang pohon tua, petugas kantin tentang resep keluarga, dan Bu Ratih tentang buku pertama yang mengubah hidupnya. Ruang perpustakaan dipenuhi pengunjung pada hari pameran.

Kepala sekolah belum menjanjikan keputusan, tetapi ia meminta proposal lanjutan. Kelas itu sadar bahwa proyek terakhir mereka justru menjadi awal kerja sama yang baru.'),
('rumah-di-seberang-rel', 'Rumah di Seberang Rel', 'Rizka Amalia', 'Family Saga', 'Tiga generasi keluarga tinggal di rumah kecil dekat rel kereta. Ketika rumah itu akan dijual, sebuah kotak surat lama mempertemukan kembali kisah yang selama ini disembunyikan.', 'Getaran Pagi', 'Setiap pukul lima, rumah keluarga Wira bergetar saat kereta pertama melintas. Nenek Sari selalu bangun untuk membuka jendela, sementara anak dan cucunya mengeluh tentang suara bising itu. Ketika rumah akan dijual, mereka mulai mengukur setiap sudut dengan mata yang berbeda.

Di bawah tangga, Rafi menemukan kotak surat berisi puluhan kartu pos yang tidak pernah dikirim. Semua ditulis oleh kakeknya kepada seseorang bernama Hana.', 'Kartu Pos yang Kembali', 'Nenek Sari mengenali nama Hana sebagai sahabat masa kecilnya. Kartu-kartu itu ternyata berisi rencana untuk membuka toko kecil bersama, sebelum kehidupan membawa mereka ke jalan berbeda. Rafi mengusulkan mencari alamat terakhir Hana.

Keluarga akhirnya berkumpul untuk memutuskan masa depan rumah. Mereka belum sepakat menjual atau mempertahankannya, tetapi untuk pertama kalinya semua orang membicarakan kenangan yang selama ini disimpan sendiri.'),
('di-bawah-purnama-merah', 'Di Bawah Purnama Merah', 'Tegar Prakoso', 'Gothic Horror', 'Seorang restorator pindah ke rumah tua untuk memperbaiki lukisan keluarga. Setiap malam purnama merah, tokoh dalam lukisan berpindah posisi dan satu ruangan baru muncul.', 'Lukisan Keluarga', 'Ratri menerima pekerjaan merestorasi lukisan keluarga di rumah Wening. Rumah itu memiliki lorong panjang dan jendela yang selalu tertutup kain hitam. Pada malam pertama, ia melihat perempuan dalam lukisan berdiri sedikit lebih dekat ke pintu.

Pemilik rumah, Adipati, berkata lukisan itu tidak boleh dipindahkan dari dindingnya. Namun ketika purnama berubah merah, terdengar langkah dari balik bingkai yang tertutup debu.', 'Pintu Ketujuh', 'Ratri menghitung enam pintu di lantai atas, tetapi setelah tengah malam muncul pintu ketujuh di ujung lorong. Di baliknya terdapat ruang kosong dengan bekas paku dan satu bingkai tanpa lukisan.

Adipati akhirnya mengaku bahwa setiap generasi keluarga menghapus satu anggota dari potret untuk menyembunyikan rahasia. Ratri menemukan wajah yang hilang itu sama dengan wajahnya sendiri.'),
('saksi-dari-ruang-arsip', 'Saksi dari Ruang Arsip', 'Farhan Alamsyah', 'Legal Mystery', 'Seorang staf arsip pengadilan menemukan dokumen yang hilang dari perkara lama. Dokumen itu dapat membebaskan seseorang, tetapi juga membuktikan bahwa saksi utama pernah berbohong.', 'Map Berwarna Biru', 'Dira menemukan map biru tanpa nomor registrasi saat merapikan arsip perkara lama. Isinya berupa salinan kesaksian yang berbeda dari dokumen resmi. Nama saksi utama tercetak jelas, tetapi tanggalnya menunjukkan dokumen dibuat setelah sidang selesai.

Ia membawa temuan itu kepada jaksa muda, Banyu. Banyu meminta Dira tidak menyentuh arsip lain sebelum rantai penyimpanan dokumen diperiksa. Namun nomor map itu muncul lagi di daftar pemindahan yang sudah ditandatangani seseorang.', 'Tanda Tangan Kedua', 'Dira menelusuri log penyimpanan dan menemukan tanda tangan kedua yang mirip dengan miliknya, padahal ia sedang cuti pada tanggal tersebut. Banyu menghubungi petugas keamanan untuk mengamankan salinan digital.

Mereka menyadari dokumen itu bukan sekadar salah tempat. Seseorang sengaja menyisipkannya agar perkara lama dibuka kembali, dan orang itu mengetahui prosedur arsip dari dalam.'),
('dokter-untuk-kota-sunyi', 'Dokter untuk Kota Sunyi', 'Laras Wulandari', 'Medical Drama', 'Seorang dokter muda ditempatkan di klinik terpencil setelah bencana memutus akses menuju kota. Ia harus membangun kepercayaan warga sebelum persediaan obat semakin menipis.', 'Klinik Tanpa Listrik', 'Dokter Amina tiba di Kota Lembayung ketika listrik padam untuk hari ketiga. Klinik hanya memiliki generator kecil dan lemari obat yang hampir kosong. Warga datang membawa keluhan, tetapi sebagian menolak diperiksa karena pernah kecewa dengan layanan sebelumnya.

Amina mulai mengunjungi rumah-rumah bersama perawat setempat, Roni. Ia mencatat kebutuhan obat dan menemukan bahwa banyak pasien tidak datang bukan karena tidak sakit, melainkan karena tidak punya transportasi.', 'Jadwal Berbagi', 'Amina mengubah ruang tunggu menjadi pos informasi dan mengatur jadwal kunjungan bersama warga. Roni menghubungi relawan untuk mengantar pasien lanjut usia. Mereka juga membuat daftar prioritas obat yang bisa digunakan dengan aman.

Ketika generator kembali mati, warga datang membawa lampu dan baterai dari rumah. Klinik itu perlahan menjadi tempat yang dijaga bersama, bukan hanya bangunan milik pemerintah.'),
('mesin-hati-nomor-08', 'Mesin Hati Nomor 08', 'Adrian Mahardika', 'Science Fiction', 'Teknisi robotika merawat mesin pendamping yang mulai menunjukkan emosi tak terduga. Saat pabrik memutuskan menghapus semua unit lama, ia berusaha membuktikan bahwa ingatan juga bagian dari identitas.', 'Unit Delapan', 'Niko ditugaskan memeriksa Unit 08, robot pendamping generasi pertama yang sudah melewati masa pakai. Mesin itu mengulang satu lagu setiap malam dan menolak pembaruan sistem. Di layar diagnostik muncul catatan: saya masih mengingat taman.

Niko menemukan bahwa Unit 08 pernah menemani seorang anak bernama Elin selama bertahun-tahun. Data itu tidak tercantum dalam arsip pabrik karena akun pemiliknya sudah dihapus.', 'Cadangan Kenangan', 'Pabrik memberi Niko waktu satu hari sebelum Unit 08 dimusnahkan. Ia mencoba menyalin memorinya, tetapi robot itu meminta agar rekaman taman tetap utuh, termasuk suara burung dan langkah kecil yang pernah berlari di sekitarnya.

Niko menghubungi Elin yang kini dewasa. Saat mereka bertemu, Unit 08 memutar lagu yang sama dan untuk pertama kalinya tidak mengulangnya.'),
('toko-barang-kenangan', 'Toko Barang Kenangan', 'Nabila Sekar', 'Supernatural Mystery', 'Sebuah toko membeli barang-barang yang menyimpan kenangan kuat. Ketika seorang pelanggan menjual foto yang belum pernah diambil, penjaga toko menemukan kejadian yang belum terjadi.', 'Harga Sebuah Foto', 'Toko milik Nenek Ina menerima benda yang tidak lagi ingin disimpan pemiliknya. Ada jam berhenti, boneka lusuh, dan surat yang tak pernah terkirim. Suatu sore, seorang pria membawa foto dua orang di depan rumah terbakar.

Ina mengenali rumah itu sebagai rumah yang masih berdiri di ujung jalan. Di bagian belakang foto tertulis tanggal tiga hari mendatang. Ia menolak membeli foto tersebut, tetapi pria itu meninggalkannya di meja.', 'Tanggal yang Mendekat', 'Ina meminta cucunya, Saka, memeriksa rumah dalam foto. Mereka menemukan kabel listrik yang terkelupas dan pemanas tua yang dibiarkan menyala. Pemilik rumah mengaku tidak pernah melihat bahaya tersebut.

Saat mereka kembali ke toko, foto itu berubah: api tidak lagi terlihat, tetapi dua orang di dalamnya kini sedang memandang ke arah kamera.'),
('kompas-dari-kulit-naga', 'Kompas dari Kulit Naga', 'Bima Ardhana', 'Steampunk', 'Di kota mesin uap, seorang mekanik menemukan kompas yang menunjuk ke sumber energi purba. Ia dan seorang pilot harus menghentikan bangsawan yang ingin menguasai sumber tersebut.', 'Jarum yang Berdenyut', 'Kirana memperbaiki kompas tua yang dibawa seorang kurir udara. Cangkangnya terbuat dari bahan bersisik, sementara jarumnya berdenyut seperti jantung. Kompas itu tidak menunjuk utara, melainkan bergerak setiap kali mesin uap dinyalakan.

Pilot bernama Bram mengenali lambang pada tutup kompas sebagai tanda ekspedisi kerajaan yang hilang. Ia menawarkan tumpangan ke menara observasi, tempat peta jalur energi terakhir disimpan.', 'Menara Uap', 'Di menara, mereka menemukan catatan bahwa energi purba berasal dari sarang naga yang tertidur di bawah gunung. Bangsawan Veyr telah mengirim pasukan untuk mengambilnya dan menghidupkan mesin perang.

Kirana menyadari kompas itu bukan alat pencari, melainkan kunci penenang. Mereka harus mencapai gunung lebih dulu sebelum pengeboran membangunkan sesuatu yang seharusnya tetap tertidur.'),
('jejak-kuda-di-tanah-garam', 'Jejak Kuda di Tanah Garam', 'Rangga Prasetya', 'Western', 'Di kota perbatasan penghasil garam, seorang penjaga kuda menemukan jejak yang mengarah ke gudang milik wali kota. Ia harus memilih antara menjaga pekerjaannya atau mengungkap pencurian upah warga.', 'Debu Putih', 'Kuda-kuda di kota Garamputih selalu pulang sebelum matahari tenggelam. Namun seekor kuda hitam kembali sendirian dengan kantong pelana robek. Jati, penjaga kandang, menemukan jejak sepatu di antara debu putih yang mengarah ke gudang wali kota.

Ia menyampaikan temuannya kepada pemilik penginapan, Rosa, yang mengaku beberapa pekerja belum menerima upah selama dua bulan. Jati mulai menghubungkan jejak itu dengan pengiriman garam yang selalu tercatat lebih sedikit.', 'Gudang Nomor Tiga', 'Jati dan Rosa menyusup ke gudang nomor tiga saat kota bersiap mengadakan pasar malam. Mereka menemukan daftar upah yang telah dibayarkan, padahal uangnya tidak pernah sampai ke pekerja.

Sebelum mereka keluar, penjaga gudang menyalakan lentera. Jati tidak menghunus senjata; ia justru meminta seluruh pekerja berkumpul dan membaca daftar itu keras-keras.'),
('pukul-0417-di-stasiun-lama', 'Pukul 04.17 di Stasiun Lama', 'Tio Ramadhan', 'Time-Loop Thriller', 'Seorang petugas stasiun selalu terbangun pada hari yang sama, tepat sebelum kereta terakhir tiba pukul 04.17. Ia harus menemukan penyebab kecelakaan yang terus berulang.', 'Hari yang Sama', 'Reno mendengar pengumuman kereta pukul 04.17, lalu lampu stasiun padam. Ketika membuka mata, jam menunjukkan pukul 23.40 pada malam sebelumnya. Ia mengira kelelahan, sampai kejadian itu terulang untuk ketiga kalinya.

Ia mulai mencatat setiap detail: penumpang berkemeja biru, koper merah di bangku dua, dan suara ketukan dari ruang sinyal. Satu-satunya hal yang berubah adalah pesan di papan jadwal yang kini berbunyi jangan naik ke peron empat.', 'Ruang Sinyal', 'Reno memasuki ruang sinyal sebelum jam menunjukkan pukul empat. Ia menemukan sakelar yang longgar dan laporan perawatan yang tidak pernah diteruskan. Petugas senior, Wira, mengaku telah meminta perbaikan sejak minggu lalu.

Reno memutus daya jalur yang bermasalah dan menghubungi masinis. Saat pukul 04.17 tiba, suara kereta terdengar dari kejauhan, tetapi kali ini stasiun tetap terang.'),
('bunga-yang-tumbuh-di-beton', 'Bunga yang Tumbuh di Beton', 'Aurelia Nirmala', 'Coming-of-Age', 'Seorang siswi pindahan merasa asing di kota baru. Ia mulai merawat tanaman liar di halaman sekolah dan perlahan menemukan teman serta keberanian untuk memilih jalannya sendiri.', 'Pot Retak', 'Ayla tidak mengenal siapa pun di sekolah barunya. Saat istirahat, ia menemukan pot retak di belakang laboratorium dan satu kecambah kecil yang tumbuh dari celah beton. Ia memindahkannya ke tempat yang mendapat sinar matahari.

Rafi, anggota klub lingkungan, memperhatikan kebiasaannya. Ia menawarkan beberapa pot bekas, tetapi Ayla menolak karena ingin melihat apakah tanaman itu bisa bertahan di tempat semula.', 'Halaman Belakang', 'Setelah beberapa minggu, tanaman itu berbunga kecil. Rafi mengajak Ayla membuat sudut hijau di halaman belakang bersama murid lain. Ayla awalnya ragu berbicara di depan kelas, tetapi akhirnya membagikan catatan perawatannya.

Ketika sekolah mengadakan pameran, sudut kecil itu menjadi tempat paling ramai. Ayla menyadari bahwa ia tidak perlu berubah menjadi orang lain untuk menemukan tempatnya.'),
('tujuh-perahu-untuk-pulang', 'Tujuh Perahu untuk Pulang', 'Ilham Samudra', 'Maritime Adventure', 'Badai memecah armada kecil yang membawa obat ke pulau terpencil. Seorang navigator muda harus menyatukan tujuh perahu sebelum persediaan habis dan musim angin berubah.', 'Peta Laut Terlipat', 'Tujuh perahu berangkat dari pelabuhan dengan muatan obat dan bahan makanan. Di tengah perjalanan, badai memecah formasi mereka. Nala, navigator termuda, terdampar bersama satu perahu dan peta laut yang basah.

Ia melihat lampu dari pulau kecil dan mengirim tanda menggunakan cermin. Seorang nelayan bernama Omar menjawab dengan pola yang berarti ada enam perahu lain di sekitar teluk.', 'Sinyal di Selat Sempit', 'Nala menggunakan lonceng kapal untuk mengirim pola sinyal yang telah disepakati sebelum berangkat. Satu per satu perahu menjawab dari balik kabut. Mereka tidak bisa mengambil jalur utama karena arus terlalu kuat, sehingga harus melewati selat sempit yang hanya dikenal nelayan setempat.

Omar memimpin dari depan, sementara Nala mengatur jarak dan waktu. Menjelang pagi, ketujuh perahu kembali terlihat bersama di teluk tujuan.'),
('ruang-yang-tidak-ada-di-peta', 'Ruang yang Tidak Ada di Peta', 'Sekar Ayuningtyas', 'Surrealist Fiction', 'Seorang kartografer kota menemukan ruang-ruang yang muncul hanya ketika seseorang melupakan sesuatu. Ia mulai mencari ruangan tempat kenangan tentang kakaknya disimpan.', 'Denah yang Berlubang', 'Setiap denah yang digambar Lira memiliki satu bagian kosong. Ruang itu tidak pernah sama bentuknya, tetapi selalu muncul di dekat tempat seseorang kehilangan benda penting. Saat ia menggambar ulang rumah masa kecil, ruang kosong itu berada tepat di antara kamar dirinya dan kamar kakaknya.

Lira sudah bertahun-tahun tidak mengingat wajah kakaknya. Ia mengikuti garis denah hingga menemukan pintu kecil di belakang lemari yang seharusnya menempel ke dinding.', 'Kamar Tanpa Jendela', 'Di balik pintu terdapat kamar tanpa jendela, penuh laci dengan label tanggal. Lira menemukan satu laci berisi suara tawa dan potongan gambar yang pernah ia buat bersama kakaknya. Setiap kenangan muncul sebagai benda yang sederhana.

Ia tidak bisa membawa semua benda keluar. Ia memilih satu gambar dan membiarkan pintu menutup, kali ini dengan ingatan yang terasa lebih utuh meski belum lengkap.'),
('ketika-layang-layang-menemukan-angin', 'Ketika Layang-Layang Menemukan Angin', 'Putri Hanifah', 'Inspirational Fiction', 'Seorang anak yang takut mencoba hal baru mengikuti klub layang-layang bersama kakeknya. Dari benang yang putus dan layang-layang yang jatuh, ia belajar tentang keberanian dan ketekunan.', 'Benang Pertama', 'Farel ingin ikut festival layang-layang, tetapi takut menjadi bahan tertawaan jika layang-layangnya jatuh. Kakek membawa bambu tipis, kertas warna, dan gulungan benang ke lapangan. Mereka membuat layang-layang sederhana tanpa hiasan.

Saat angin pertama datang, Farel melepaskan benang terlalu cepat. Layang-layangnya jatuh di dekat pagar. Kakek tidak tertawa; ia meminta Farel memeriksa simpul dan mencoba lagi.', 'Angin yang Berubah', 'Pada hari festival, angin berubah arah berkali-kali. Layang-layang Farel sempat tersangkut, lalu terlepas setelah ia mengendurkan benang. Ia tidak memenangkan lomba, tetapi berhasil menerbangkannya paling lama di antara peserta pemula.

Di perjalanan pulang, Farel meminta kakek menyimpan layang-layang itu. Bukan sebagai piala, melainkan pengingat bahwa ia pernah takut dan tetap mencoba.');

-- Add only stories whose slug AND title do not already exist.
START TRANSACTION;
INSERT INTO stories (user_id, title, slug, author, genre, cover, synopsis, content, status, created_at, updated_at)
SELECT NULL, seed.title, seed.seed_slug, seed.author, seed.genre, NULL, seed.synopsis, seed.chapter1_content, 'published', NOW(), NOW()
FROM tmp_tp_stories AS seed
WHERE NOT EXISTS (
    SELECT 1 FROM stories AS existing
    WHERE existing.slug = seed.seed_slug OR LOWER(existing.title) = LOWER(seed.title)
);

-- Map each seed story to its existing/new database ID without relying on auto-increment values.
CREATE TEMPORARY TABLE tmp_tp_story_map (
    seed_slug VARCHAR(180) NOT NULL PRIMARY KEY,
    story_id BIGINT UNSIGNED NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tmp_tp_story_map (seed_slug, story_id)
SELECT seed.seed_slug, (
    SELECT existing.id FROM stories AS existing
    WHERE existing.slug = seed.seed_slug OR LOWER(existing.title) = LOWER(seed.title)
    ORDER BY (existing.slug = seed.seed_slug) DESC, existing.id ASC
    LIMIT 1
)
FROM tmp_tp_stories AS seed;

CREATE TEMPORARY TABLE tmp_tp_chapters (
    seed_slug VARCHAR(180) NOT NULL,
    chapter_number INT UNSIGNED NOT NULL,
    chapter_title VARCHAR(160) NOT NULL,
    chapter_content LONGTEXT NOT NULL,
    PRIMARY KEY (seed_slug, chapter_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tmp_tp_chapters (seed_slug, chapter_number, chapter_title, chapter_content) VALUES
('peta-yang-menolak-pulang', 1, 'Garis yang Bergerak', 'Nara menemukan peta itu di dalam koper peninggalan kakeknya. Awalnya hanya garis pantai dan titik tinta yang pudar, tetapi ketika ia membukanya di dekat jendela, sebuah garis baru muncul menuju pulau yang tidak tercatat di peta mana pun.

Di pelabuhan, seorang penjaga mercusuar bernama Sagara mengenali lambang kecil di sudut kertas. Ia memperingatkan Nara bahwa peta itu tidak menunjukkan jalan pulang. Peta itu menunjukkan tempat yang sedang mencari seseorang.'),
('peta-yang-menolak-pulang', 2, 'Pulau yang Tidak Bernama', 'Perahu mereka tiba saat kabut menutup seluruh garis pantai. Kompas Sagara berputar tanpa arah, sementara peta di tangan Nara menggambar sebuah teluk yang belum terlihat. Mereka mengikuti garis itu dan menemukan rumah kayu dengan lampu menyala.

Di meja rumah tersebut tergeletak catatan kakek Nara: jangan percaya jalan yang tampak paling dekat. Saat Nara membalik kertas, tulisan baru muncul, menyebut namanya sendiri.'),
('kedai-teh-pukul-sembilan', 1, 'Cangkir yang Kosong', 'Kedai Teh Pukul Sembilan selalu tutup tepat setelah lonceng tua berdentang. Namun malam itu, lonceng berbunyi tiga kali dan buku resep keluarga Bu Suri menghilang dari rak terkunci. Tidak ada jendela terbuka, tidak ada pintu yang rusak.

Lintang memeriksa meja pelanggan dan menemukan lingkaran teh yang belum kering. Jejak itu mengarah ke kursi nomor empat, tempat seorang pelanggan selalu duduk membelakangi jam.'),
('kedai-teh-pukul-sembilan', 2, 'Pelanggan Kursi Empat', 'Pelanggan itu bernama Raka, seorang pengantar bunga yang datang setiap Selasa. Ia mengaku tidak menyentuh rak, tetapi Lintang melihat noda tinta di ujung lengan bajunya. Bu Suri justru tampak lebih cemas daripada marah.

Saat kedai dibersihkan, Lintang menemukan secarik kertas terselip di bawah teko. Di sana tertulis resep teh yang tidak pernah diajarkan Bu Suri kepada siapa pun.'),
('di-balik-dinding-kaca', 1, 'Foto Pertama', 'Arga menerima foto itu pukul 02.13. Ruang kerjanya tampak kosong, kecuali kursi yang sedikit bergeser dan bayangan tipis di balik dinding kaca. Ia memeriksa seluruh ruangan, tetapi tidak menemukan siapa pun.

Keesokan malam, foto kedua datang. Kali ini bayangan itu berdiri lebih dekat. Arga memperbesar gambar dan menyadari sosok tersebut mengenakan kemeja yang sama dengannya.'),
('di-balik-dinding-kaca', 2, 'Pantulan yang Terlambat', 'Arga menutup semua tirai dan mematikan lampu. Dalam pantulan kaca, gerakannya terlihat terlambat setengah detik. Ia mengangkat tangan; pantulan itu diam. Ketika ia menoleh, sebuah pesan muncul di layar komputer: berhenti mencari pintu keluar.

Ia membuka denah gedung lama dan menemukan ruangan yang seharusnya tidak ada, tepat di balik dinding kacanya sendiri.'),
('kota-yang-menyimpan-hujan', 1, 'Botol Awan', 'Di Kota Arunika, hujan hanya hidup dalam cerita orang tua. Toko payung milik Kakek Banyu menjadi tempat paling aneh di pasar: rak-raknya dipenuhi botol kaca berisi kabut, gerimis, bahkan suara petir yang jauh.

Suatu sore, seorang anak bernama Sita datang membawa foto ibunya di bawah hujan. Ia meminta satu botol yang berisi hujan pada hari ibunya menghilang. Kakek Banyu mengenali tanggal di belakang foto itu.'),
('kota-yang-menyimpan-hujan', 2, 'Aroma Tanah Basah', 'Kakek Banyu membuka botol kecil dengan segel biru. Aroma tanah basah memenuhi toko, dan untuk sesaat Sita mendengar suara ibunya memanggil dari ujung gang. Ia berlari keluar, tetapi langit tetap cerah.

Di dasar botol tertinggal sebutir biji. Kakek Banyu berkata hujan tidak bisa dikembalikan dengan membuka botol; seseorang harus berani menanam kenangannya.'),
('orbit-terakhir', 1, 'Sinyal dari Esok', 'Asteria memasuki orbit planet Kepler-91 ketika seluruh saluran komunikasi mendadak dipenuhi suara ketukan. Polanya berulang setiap tujuh detik, sama persis dengan kode darurat kapal mereka.

Kapten Elara meminta teknisi Bima memeriksa sumber sinyal. Bima menemukan koordinat yang menunjukkan posisi Asteria, tetapi waktunya tercatat dua puluh tiga jam lebih maju. Sinyal itu berakhir dengan satu kalimat: jangan menyalakan mesin utama.'),
('orbit-terakhir', 2, 'Planet di Bawah Kita', 'Saat mesin utama dimatikan, kapal justru mulai turun menuju atmosfer. Elara memerintahkan kru menyiapkan kapsul evakuasi, tetapi Bima menemukan pola ketukan kedua yang tersembunyi di dalam gangguan.

Pola itu menggambarkan jalur orbit alternatif. Mereka mengikuti koordinat tersebut dan melihat cahaya bergerak di permukaan planet, membentuk lambang Asteria yang belum pernah mereka buat.'),
('neon-di-ujung-gang', 1, 'Paket Tanpa Nama', 'Juno bekerja mengantar data melalui lorong-lorong neon Kota Meridian. Paket terakhir malam itu tidak memiliki nama penerima, hanya koordinat sebuah kios permainan tua. Ketika dibuka, paket tersebut berisi rekaman seorang anak yang memanggil Juno sebagai kakaknya.

Ia tidak mengenali wajah anak itu, tetapi gelang kain di pergelangan tangannya sama dengan gelang yang selalu ia pakai sejak kecil. Di sudut rekaman muncul logo perusahaan Memoria.'),
('neon-di-ujung-gang', 2, 'Harga Sebuah Ingatan', 'Mara, mantan teknisi Memoria, menjelaskan bahwa perusahaan itu dapat menghapus ingatan tanpa meninggalkan luka fisik. Ia menduga Juno pernah menjadi subjek uji coba. Untuk membuktikannya, mereka perlu masuk ke arsip pusat.

Di depan gedung, Juno menerima tawaran anonim: satu ingatan utuh sebagai imbalan atas rekaman tersebut. Ia mematikan perangkat dan memilih mencari kebenaran sendiri.'),
('musim-ketika-laut-naik', 1, 'Patok Air', 'Setiap pagi, Rumi menandai tinggi air pada tiang kayu di depan rumah. Tahun ini, garisnya naik lebih cepat daripada perkiraan siapa pun. Ayahnya tetap memperbaiki jaring, seolah laut masih bisa diajak berunding.

Ketika sekolah mengumumkan pemindahan warga, Rumi mulai menggambar denah rumah-rumah yang akan ditinggalkan. Ia menulis nama pemilik, cerita halaman, dan pohon yang pernah tumbuh di sana.'),
('musim-ketika-laut-naik', 2, 'Peta untuk Mereka yang Pergi', 'Pak Darsa menolak meninggalkan perahu kecilnya. Rumi mengajaknya melihat peta yang ia buat, termasuk tanda tempat anak-anak biasa bermain dan sumur yang airnya paling manis. Untuk pertama kalinya, ayahnya membaca semua nama itu sampai selesai.

Malam sebelum evakuasi, warga berkumpul dan menambahkan satu titik terakhir: tempat mereka berjanji akan bertemu kembali.'),
('legenda-penjaga-padi', 1, 'Lumbung yang Bernapas', 'Malam sebelum panen, Dini mendengar bunyi napas dari lumbung yang sudah lama dikunci. Di dalamnya, karung-karung padi tersusun membentuk lingkaran. Seekor burung putih bertengger di balok dan memanggil namanya.

Burung itu memperkenalkan diri sebagai Jati, penjaga benih yang hanya muncul ketika manusia melupakan cara berbagi. Dini diminta membawa segenggam padi ke mata air sebelum fajar.'),
('legenda-penjaga-padi', 2, 'Janji Tujuh Benih', 'Dini membawa benih melewati pematang yang retak. Di mata air, ia melihat bayangan sawah yang pernah hijau, tetapi setiap tanaman tumbuh dari satu janji yang diingkari. Jati menjelaskan bahwa benih tidak akan tumbuh jika hanya disimpan untuk diri sendiri.

Dini pulang dan mengajak warga membagi persediaan terakhir. Ketika matahari terbit, satu tunas muncul di tanah yang paling kering.'),
('surat-dari-menara-jam', 1, 'Kertas di Balik Roda', 'Pada 1947, penjilid buku muda bernama Seno dipanggil untuk memperbaiki buku catatan di menara jam. Di balik roda gigi utama, ia menemukan amplop yang dilipat berkali-kali. Kertasnya rapuh, tetapi tulisan di dalamnya masih terbaca.

Surat itu ditujukan kepada seseorang bernama Mirah dan meminta agar lonceng dibunyikan tiga kali pada hari pasar. Seno mengenali nama tersebut dari cerita ibunya, tetapi tidak pernah tahu hubungannya dengan keluarganya.'),
('surat-dari-menara-jam', 2, 'Tiga Dentang', 'Seno mencari Mirah melalui daftar penduduk lama. Ia menemukan alamat rumah yang kini menjadi toko roti, dan pemiliknya masih menyimpan foto seorang perempuan di dekat menara. Foto itu memperlihatkan dua anak yang saling menggenggam tangan.

Saat jam menunjukkan pukul enam, Seno membunyikan lonceng tiga kali. Dari seberang alun-alun, seorang perempuan tua mengangkat tangan, seolah menunggu suara itu selama puluhan tahun.'),
('taman-untuk-bintang-yang-padam', 1, 'Petak Kosong', 'Pak Ranu selalu menyisakan satu petak tanah di tengah taman. Tidak ada bunga, tidak ada papan nama, hanya tanah yang ia gemburkan setiap Senin. Pengunjung mengira ia lupa menanam sesuatu.

Suatu sore, seorang anak bernama Lio duduk di tepi petak itu dan bertanya apakah bintang bisa tumbuh dari tanah. Pak Ranu menjawab bahwa ia pernah menanam satu, tetapi belum siap melihatnya berbunga.'),
('taman-untuk-bintang-yang-padam', 2, 'Benih Kecil', 'Lio membawa sekantong benih bunga liar dari halaman rumahnya. Mereka menanamnya tanpa memberi nama pada petak tersebut. Hari-hari berikutnya, Lio datang menyiram tanah dan bercerita tentang ibunya yang menyukai langit malam.

Ketika bunga pertama mekar, Pak Ranu meletakkan bangku kecil di dekatnya. Ia akhirnya bercerita tentang putrinya, dan taman itu tidak lagi terasa seperti tempat yang harus dijaga sendirian.'),
('tiga-hari-tanpa-matahari', 1, 'Hari Pertama', 'Pagi datang tanpa cahaya. Dari lantai dua belas, Aksa melihat kota tertutup kabut abu yang membuat gedung seberang menghilang. Ponsel tidak mendapat sinyal dan lift berhenti di antara lantai.

Di lorong, penghuni apartemen mulai mengumpulkan air, baterai, dan makanan. Aksa membuat daftar kebutuhan, tetapi seorang tetangga memperingatkan bahwa persediaan hanya cukup untuk dua hari.'),
('tiga-hari-tanpa-matahari', 2, 'Tangga Darurat', 'Pada hari kedua, kabut mulai masuk melalui ventilasi. Aksa dan dokter Rhea memutuskan turun lewat tangga darurat untuk mencari sumber air cadangan. Di lantai tujuh mereka menemukan pintu yang terbuka dan sebuah radio masih menyala.

Radio itu menyiarkan koordinat tempat evakuasi, tetapi suara penyiar terputus sebelum menyebut jalur aman. Mereka harus memilih: menunggu bantuan atau memimpin penghuni keluar bersama-sama.'),
('kontrak-dengan-tuan-senja', 1, 'Satu Jam', 'Setiap pukul enam sore, sebuah toko jam muncul di antara dua gedung yang berbeda. Mira menemukannya ketika mencari obat untuk adiknya. Pemilik toko menawarkan satu jam tambahan untuk siapa pun yang bersedia menyerahkan satu jam dari masa depannya.

Mira menandatangani kontrak tanpa membaca bagian kecil di bawahnya. Tuan Senja tersenyum dan menyerahkan jam saku yang jarumnya bergerak mundur.'),
('kontrak-dengan-tuan-senja', 2, 'Jarum yang Mundur', 'Jam saku itu memberi Mira waktu untuk menemukan obat, tetapi setiap kali ia menggunakannya, satu kenangan masa kecil memudar. Ia kembali ke toko untuk membatalkan kontrak. Tuan Senja berkata kontrak hanya dapat diputus jika semua waktu yang terkumpul dikembalikan.

Mira menemukan rak berisi ribuan jam, masing-masing bertuliskan nama seseorang. Di antara semuanya, ia melihat nama adiknya.'),
('nada-terakhir-sang-konduktor', 1, 'Partitur Tanpa Judul', 'Di ruang arsip orkestra, Lala menemukan partitur yang tidak tercatat dalam katalog. Halaman pertamanya kosong, sedangkan halaman terakhir dipenuhi catatan tangan tentang jeda dan napas. Konduktor Surya langsung mengenali tulisan itu, tetapi menolak menjelaskan asalnya.

Mereka mencoba memainkan bagian pembuka. Setiap alat musik terdengar seperti mengingat sesuatu yang berbeda, dan seluruh ruangan mendadak sunyi pada ketukan ketujuh.'),
('nada-terakhir-sang-konduktor', 2, 'Jeda Ketujuh', 'Surya mengungkapkan bahwa partitur itu ditulis oleh pendiri orkestra, yang meninggal sebelum sempat memimpin konser terakhirnya. Ia menyimpan halaman tersebut karena takut musiknya tidak akan pernah selesai.

Lala mengusulkan agar setiap pemain menyumbangkan satu nada dari lagu yang paling mereka ingat. Partitur itu akhirnya menjadi komposisi bersama, bukan milik satu orang saja.'),
('garis-finish-untuk-ayah', 1, 'Sepatu Lama', 'Davin menemukan sepatu lari ayahnya di bawah lemari. Solnya sudah tipis, tetapi nomor lomba lama masih terikat pada tali. Ayahnya pernah berhenti di kilometer terakhir karena cedera, dan sejak itu tidak pernah menonton perlombaan lagi.

Davin mendaftar lomba kota tanpa memberi tahu siapa pun. Pelatih Niko melihat jadwal latihannya dan mengingatkan bahwa mengejar cerita orang lain bisa membuatnya lupa mendengarkan tubuh sendiri.'),
('garis-finish-untuk-ayah', 2, 'Kilometer Terakhir', 'Pada hari lomba, hujan membuat lintasan licin. Davin tertinggal jauh setelah kakinya mulai nyeri. Di tepi lintasan, ayahnya berdiri dengan sepatu lama di tangan. Ia tidak berteriak agar Davin menang, hanya mengangkat ibu jari.

Davin memperlambat langkah, mengatur napas, dan menyelesaikan lomba tanpa memaksakan cedera. Untuk pertama kalinya, ayahnya tersenyum saat mendengar suara garis finish.'),
('resep-rahasia-rumah-kaca', 1, 'Buku Bercak Tepung', 'Aroma rosemary memenuhi rumah kaca yang sudah lama tidak dipakai. Raka menemukan buku resep ibu di laci meja tanam, dengan bercak tepung dan catatan kecil di setiap halaman. Resep pertama meminta tomat yang dipetik sebelum matahari terbit.

Adiknya, Sera, ingin menjual rumah kaca untuk membayar utang. Raka meminta satu hari untuk mencoba resep itu, bukan sebagai alasan menunda, tetapi sebagai cara mengingat apa yang pernah mereka bangun bersama.'),
('resep-rahasia-rumah-kaca', 2, 'Sup untuk Dua Orang', 'Mereka memasak sup tomat dari tanaman terakhir. Rasanya sederhana, tetapi di balik halaman resep ada surat ibu yang meminta mereka tidak mempertahankan rumah hanya karena takut kehilangan masa lalu.

Sera mengusulkan menjadikan rumah kaca sebagai dapur komunitas. Raka setuju dengan satu syarat: setiap menu harus memakai bahan dari kebun dan menyimpan satu cerita keluarga.'),
('sepasang-tiket-ke-utara', 1, 'Kursi yang Tertukar', 'Naya mendapati nomor kursinya ditempati seorang pria yang memegang tiket dengan tujuan sama. Namanya Damar, dan tiket mereka tertukar sejak loket keberangkatan. Kondektur menyarankan mereka duduk bersebelahan sampai stasiun berikutnya.

Percakapan dimulai dari peta perjalanan, lalu beralih pada alasan mereka pergi. Naya ingin melihat salju untuk pertama kali; Damar ingin mengembalikan sebuah buku kepada seseorang yang pernah ia tinggalkan.'),
('sepasang-tiket-ke-utara', 2, 'Stasiun Utara', 'Kereta berhenti lebih lama karena jalur tertutup kabut. Damar mengaku tidak yakin orang yang ia cari masih tinggal di kota tujuan. Naya menyarankan agar ia tetap menyerahkan buku itu, sekalipun tidak mendapat jawaban.

Di stasiun utara, mereka bertukar tiket yang benar. Namun sebelum berpisah, Damar mengajak Naya berjalan ke peron paling ujung untuk melihat salju pertama musim itu.'),
('kelas-terakhir-bu-ratih', 1, 'Pengumuman di Papan', 'Bu Ratih menempelkan surat bahwa kelas mereka akan digabung semester depan. Perpustakaan kecil di ujung koridor juga terancam menjadi ruang penyimpanan. Murid-murid bereaksi berbeda: ada yang marah, ada yang tidak peduli, dan ada yang takut kehilangan tempat berkumpul.

Ketua kelas, Fikri, mengusulkan pameran cerita warga sekolah. Jika cukup banyak orang datang, mereka akan mengajukan proposal untuk mempertahankan perpustakaan.'),
('kelas-terakhir-bu-ratih', 2, 'Pameran Cerita', 'Setiap murid membawa satu cerita: penjaga sekolah tentang pohon tua, petugas kantin tentang resep keluarga, dan Bu Ratih tentang buku pertama yang mengubah hidupnya. Ruang perpustakaan dipenuhi pengunjung pada hari pameran.

Kepala sekolah belum menjanjikan keputusan, tetapi ia meminta proposal lanjutan. Kelas itu sadar bahwa proyek terakhir mereka justru menjadi awal kerja sama yang baru.'),
('rumah-di-seberang-rel', 1, 'Getaran Pagi', 'Setiap pukul lima, rumah keluarga Wira bergetar saat kereta pertama melintas. Nenek Sari selalu bangun untuk membuka jendela, sementara anak dan cucunya mengeluh tentang suara bising itu. Ketika rumah akan dijual, mereka mulai mengukur setiap sudut dengan mata yang berbeda.

Di bawah tangga, Rafi menemukan kotak surat berisi puluhan kartu pos yang tidak pernah dikirim. Semua ditulis oleh kakeknya kepada seseorang bernama Hana.'),
('rumah-di-seberang-rel', 2, 'Kartu Pos yang Kembali', 'Nenek Sari mengenali nama Hana sebagai sahabat masa kecilnya. Kartu-kartu itu ternyata berisi rencana untuk membuka toko kecil bersama, sebelum kehidupan membawa mereka ke jalan berbeda. Rafi mengusulkan mencari alamat terakhir Hana.

Keluarga akhirnya berkumpul untuk memutuskan masa depan rumah. Mereka belum sepakat menjual atau mempertahankannya, tetapi untuk pertama kalinya semua orang membicarakan kenangan yang selama ini disimpan sendiri.'),
('di-bawah-purnama-merah', 1, 'Lukisan Keluarga', 'Ratri menerima pekerjaan merestorasi lukisan keluarga di rumah Wening. Rumah itu memiliki lorong panjang dan jendela yang selalu tertutup kain hitam. Pada malam pertama, ia melihat perempuan dalam lukisan berdiri sedikit lebih dekat ke pintu.

Pemilik rumah, Adipati, berkata lukisan itu tidak boleh dipindahkan dari dindingnya. Namun ketika purnama berubah merah, terdengar langkah dari balik bingkai yang tertutup debu.'),
('di-bawah-purnama-merah', 2, 'Pintu Ketujuh', 'Ratri menghitung enam pintu di lantai atas, tetapi setelah tengah malam muncul pintu ketujuh di ujung lorong. Di baliknya terdapat ruang kosong dengan bekas paku dan satu bingkai tanpa lukisan.

Adipati akhirnya mengaku bahwa setiap generasi keluarga menghapus satu anggota dari potret untuk menyembunyikan rahasia. Ratri menemukan wajah yang hilang itu sama dengan wajahnya sendiri.'),
('saksi-dari-ruang-arsip', 1, 'Map Berwarna Biru', 'Dira menemukan map biru tanpa nomor registrasi saat merapikan arsip perkara lama. Isinya berupa salinan kesaksian yang berbeda dari dokumen resmi. Nama saksi utama tercetak jelas, tetapi tanggalnya menunjukkan dokumen dibuat setelah sidang selesai.

Ia membawa temuan itu kepada jaksa muda, Banyu. Banyu meminta Dira tidak menyentuh arsip lain sebelum rantai penyimpanan dokumen diperiksa. Namun nomor map itu muncul lagi di daftar pemindahan yang sudah ditandatangani seseorang.'),
('saksi-dari-ruang-arsip', 2, 'Tanda Tangan Kedua', 'Dira menelusuri log penyimpanan dan menemukan tanda tangan kedua yang mirip dengan miliknya, padahal ia sedang cuti pada tanggal tersebut. Banyu menghubungi petugas keamanan untuk mengamankan salinan digital.

Mereka menyadari dokumen itu bukan sekadar salah tempat. Seseorang sengaja menyisipkannya agar perkara lama dibuka kembali, dan orang itu mengetahui prosedur arsip dari dalam.'),
('dokter-untuk-kota-sunyi', 1, 'Klinik Tanpa Listrik', 'Dokter Amina tiba di Kota Lembayung ketika listrik padam untuk hari ketiga. Klinik hanya memiliki generator kecil dan lemari obat yang hampir kosong. Warga datang membawa keluhan, tetapi sebagian menolak diperiksa karena pernah kecewa dengan layanan sebelumnya.

Amina mulai mengunjungi rumah-rumah bersama perawat setempat, Roni. Ia mencatat kebutuhan obat dan menemukan bahwa banyak pasien tidak datang bukan karena tidak sakit, melainkan karena tidak punya transportasi.'),
('dokter-untuk-kota-sunyi', 2, 'Jadwal Berbagi', 'Amina mengubah ruang tunggu menjadi pos informasi dan mengatur jadwal kunjungan bersama warga. Roni menghubungi relawan untuk mengantar pasien lanjut usia. Mereka juga membuat daftar prioritas obat yang bisa digunakan dengan aman.

Ketika generator kembali mati, warga datang membawa lampu dan baterai dari rumah. Klinik itu perlahan menjadi tempat yang dijaga bersama, bukan hanya bangunan milik pemerintah.'),
('mesin-hati-nomor-08', 1, 'Unit Delapan', 'Niko ditugaskan memeriksa Unit 08, robot pendamping generasi pertama yang sudah melewati masa pakai. Mesin itu mengulang satu lagu setiap malam dan menolak pembaruan sistem. Di layar diagnostik muncul catatan: saya masih mengingat taman.

Niko menemukan bahwa Unit 08 pernah menemani seorang anak bernama Elin selama bertahun-tahun. Data itu tidak tercantum dalam arsip pabrik karena akun pemiliknya sudah dihapus.'),
('mesin-hati-nomor-08', 2, 'Cadangan Kenangan', 'Pabrik memberi Niko waktu satu hari sebelum Unit 08 dimusnahkan. Ia mencoba menyalin memorinya, tetapi robot itu meminta agar rekaman taman tetap utuh, termasuk suara burung dan langkah kecil yang pernah berlari di sekitarnya.

Niko menghubungi Elin yang kini dewasa. Saat mereka bertemu, Unit 08 memutar lagu yang sama dan untuk pertama kalinya tidak mengulangnya.'),
('toko-barang-kenangan', 1, 'Harga Sebuah Foto', 'Toko milik Nenek Ina menerima benda yang tidak lagi ingin disimpan pemiliknya. Ada jam berhenti, boneka lusuh, dan surat yang tak pernah terkirim. Suatu sore, seorang pria membawa foto dua orang di depan rumah terbakar.

Ina mengenali rumah itu sebagai rumah yang masih berdiri di ujung jalan. Di bagian belakang foto tertulis tanggal tiga hari mendatang. Ia menolak membeli foto tersebut, tetapi pria itu meninggalkannya di meja.'),
('toko-barang-kenangan', 2, 'Tanggal yang Mendekat', 'Ina meminta cucunya, Saka, memeriksa rumah dalam foto. Mereka menemukan kabel listrik yang terkelupas dan pemanas tua yang dibiarkan menyala. Pemilik rumah mengaku tidak pernah melihat bahaya tersebut.

Saat mereka kembali ke toko, foto itu berubah: api tidak lagi terlihat, tetapi dua orang di dalamnya kini sedang memandang ke arah kamera.'),
('kompas-dari-kulit-naga', 1, 'Jarum yang Berdenyut', 'Kirana memperbaiki kompas tua yang dibawa seorang kurir udara. Cangkangnya terbuat dari bahan bersisik, sementara jarumnya berdenyut seperti jantung. Kompas itu tidak menunjuk utara, melainkan bergerak setiap kali mesin uap dinyalakan.

Pilot bernama Bram mengenali lambang pada tutup kompas sebagai tanda ekspedisi kerajaan yang hilang. Ia menawarkan tumpangan ke menara observasi, tempat peta jalur energi terakhir disimpan.'),
('kompas-dari-kulit-naga', 2, 'Menara Uap', 'Di menara, mereka menemukan catatan bahwa energi purba berasal dari sarang naga yang tertidur di bawah gunung. Bangsawan Veyr telah mengirim pasukan untuk mengambilnya dan menghidupkan mesin perang.

Kirana menyadari kompas itu bukan alat pencari, melainkan kunci penenang. Mereka harus mencapai gunung lebih dulu sebelum pengeboran membangunkan sesuatu yang seharusnya tetap tertidur.'),
('jejak-kuda-di-tanah-garam', 1, 'Debu Putih', 'Kuda-kuda di kota Garamputih selalu pulang sebelum matahari tenggelam. Namun seekor kuda hitam kembali sendirian dengan kantong pelana robek. Jati, penjaga kandang, menemukan jejak sepatu di antara debu putih yang mengarah ke gudang wali kota.

Ia menyampaikan temuannya kepada pemilik penginapan, Rosa, yang mengaku beberapa pekerja belum menerima upah selama dua bulan. Jati mulai menghubungkan jejak itu dengan pengiriman garam yang selalu tercatat lebih sedikit.'),
('jejak-kuda-di-tanah-garam', 2, 'Gudang Nomor Tiga', 'Jati dan Rosa menyusup ke gudang nomor tiga saat kota bersiap mengadakan pasar malam. Mereka menemukan daftar upah yang telah dibayarkan, padahal uangnya tidak pernah sampai ke pekerja.

Sebelum mereka keluar, penjaga gudang menyalakan lentera. Jati tidak menghunus senjata; ia justru meminta seluruh pekerja berkumpul dan membaca daftar itu keras-keras.'),
('pukul-0417-di-stasiun-lama', 1, 'Hari yang Sama', 'Reno mendengar pengumuman kereta pukul 04.17, lalu lampu stasiun padam. Ketika membuka mata, jam menunjukkan pukul 23.40 pada malam sebelumnya. Ia mengira kelelahan, sampai kejadian itu terulang untuk ketiga kalinya.

Ia mulai mencatat setiap detail: penumpang berkemeja biru, koper merah di bangku dua, dan suara ketukan dari ruang sinyal. Satu-satunya hal yang berubah adalah pesan di papan jadwal yang kini berbunyi jangan naik ke peron empat.'),
('pukul-0417-di-stasiun-lama', 2, 'Ruang Sinyal', 'Reno memasuki ruang sinyal sebelum jam menunjukkan pukul empat. Ia menemukan sakelar yang longgar dan laporan perawatan yang tidak pernah diteruskan. Petugas senior, Wira, mengaku telah meminta perbaikan sejak minggu lalu.

Reno memutus daya jalur yang bermasalah dan menghubungi masinis. Saat pukul 04.17 tiba, suara kereta terdengar dari kejauhan, tetapi kali ini stasiun tetap terang.'),
('bunga-yang-tumbuh-di-beton', 1, 'Pot Retak', 'Ayla tidak mengenal siapa pun di sekolah barunya. Saat istirahat, ia menemukan pot retak di belakang laboratorium dan satu kecambah kecil yang tumbuh dari celah beton. Ia memindahkannya ke tempat yang mendapat sinar matahari.

Rafi, anggota klub lingkungan, memperhatikan kebiasaannya. Ia menawarkan beberapa pot bekas, tetapi Ayla menolak karena ingin melihat apakah tanaman itu bisa bertahan di tempat semula.'),
('bunga-yang-tumbuh-di-beton', 2, 'Halaman Belakang', 'Setelah beberapa minggu, tanaman itu berbunga kecil. Rafi mengajak Ayla membuat sudut hijau di halaman belakang bersama murid lain. Ayla awalnya ragu berbicara di depan kelas, tetapi akhirnya membagikan catatan perawatannya.

Ketika sekolah mengadakan pameran, sudut kecil itu menjadi tempat paling ramai. Ayla menyadari bahwa ia tidak perlu berubah menjadi orang lain untuk menemukan tempatnya.'),
('tujuh-perahu-untuk-pulang', 1, 'Peta Laut Terlipat', 'Tujuh perahu berangkat dari pelabuhan dengan muatan obat dan bahan makanan. Di tengah perjalanan, badai memecah formasi mereka. Nala, navigator termuda, terdampar bersama satu perahu dan peta laut yang basah.

Ia melihat lampu dari pulau kecil dan mengirim tanda menggunakan cermin. Seorang nelayan bernama Omar menjawab dengan pola yang berarti ada enam perahu lain di sekitar teluk.'),
('tujuh-perahu-untuk-pulang', 2, 'Sinyal di Selat Sempit', 'Nala menggunakan lonceng kapal untuk mengirim pola sinyal yang telah disepakati sebelum berangkat. Satu per satu perahu menjawab dari balik kabut. Mereka tidak bisa mengambil jalur utama karena arus terlalu kuat, sehingga harus melewati selat sempit yang hanya dikenal nelayan setempat.

Omar memimpin dari depan, sementara Nala mengatur jarak dan waktu. Menjelang pagi, ketujuh perahu kembali terlihat bersama di teluk tujuan.'),
('ruang-yang-tidak-ada-di-peta', 1, 'Denah yang Berlubang', 'Setiap denah yang digambar Lira memiliki satu bagian kosong. Ruang itu tidak pernah sama bentuknya, tetapi selalu muncul di dekat tempat seseorang kehilangan benda penting. Saat ia menggambar ulang rumah masa kecil, ruang kosong itu berada tepat di antara kamar dirinya dan kamar kakaknya.

Lira sudah bertahun-tahun tidak mengingat wajah kakaknya. Ia mengikuti garis denah hingga menemukan pintu kecil di belakang lemari yang seharusnya menempel ke dinding.'),
('ruang-yang-tidak-ada-di-peta', 2, 'Kamar Tanpa Jendela', 'Di balik pintu terdapat kamar tanpa jendela, penuh laci dengan label tanggal. Lira menemukan satu laci berisi suara tawa dan potongan gambar yang pernah ia buat bersama kakaknya. Setiap kenangan muncul sebagai benda yang sederhana.

Ia tidak bisa membawa semua benda keluar. Ia memilih satu gambar dan membiarkan pintu menutup, kali ini dengan ingatan yang terasa lebih utuh meski belum lengkap.'),
('ketika-layang-layang-menemukan-angin', 1, 'Benang Pertama', 'Farel ingin ikut festival layang-layang, tetapi takut menjadi bahan tertawaan jika layang-layangnya jatuh. Kakek membawa bambu tipis, kertas warna, dan gulungan benang ke lapangan. Mereka membuat layang-layang sederhana tanpa hiasan.

Saat angin pertama datang, Farel melepaskan benang terlalu cepat. Layang-layangnya jatuh di dekat pagar. Kakek tidak tertawa; ia meminta Farel memeriksa simpul dan mencoba lagi.'),
('ketika-layang-layang-menemukan-angin', 2, 'Angin yang Berubah', 'Pada hari festival, angin berubah arah berkali-kali. Layang-layang Farel sempat tersangkut, lalu terlepas setelah ia mengendurkan benang. Ia tidak memenangkan lomba, tetapi berhasil menerbangkannya paling lama di antara peserta pemula.

Di perjalanan pulang, Farel meminta kakek menyimpan layang-layang itu. Bukan sebagai piala, melainkan pengingat bahwa ia pernah takut dan tetap mencoba.');

-- Insert chapters only when that chapter number does not already exist for the story.
INSERT INTO story_chapters (story_id, chapter_number, title, content, status, published_at, created_at, updated_at)
SELECT map.story_id, chapter.chapter_number, chapter.chapter_title, chapter.chapter_content, 'published', NOW(), NOW(), NOW()
FROM tmp_tp_chapters AS chapter
JOIN tmp_tp_story_map AS map ON map.seed_slug = chapter.seed_slug
WHERE map.story_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM story_chapters AS existing
      WHERE existing.story_id = map.story_id AND existing.chapter_number = chapter.chapter_number
  );

CREATE TEMPORARY TABLE tmp_tp_characters (
    seed_slug VARCHAR(180) NOT NULL,
    character_name VARCHAR(100) NOT NULL,
    character_description TEXT NOT NULL,
    PRIMARY KEY (seed_slug, character_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO tmp_tp_characters (seed_slug, character_name, character_description) VALUES
('peta-yang-menolak-pulang', 'Nara', 'Mahasiswi kartografi yang teliti, keras kepala, dan ingin memahami rahasia peta peninggalan keluarganya.'),
('peta-yang-menolak-pulang', 'Sagara', 'Penjaga mercusuar yang mengenal legenda pulau-pulau hilang dan menyimpan rasa bersalah dari pelayaran lamanya.'),
('kedai-teh-pukul-sembilan', 'Lintang', 'Pegawai baru yang observatif, gemar teka-teki, dan tidak mudah menerima penjelasan yang terlalu sederhana.'),
('kedai-teh-pukul-sembilan', 'Bu Suri', 'Pemilik kedai teh yang hangat dan tenang, tetapi menyimpan sejarah keluarga di balik buku resepnya.'),
('kedai-teh-pukul-sembilan', 'Raka', 'Pelanggan tetap sekaligus pengantar bunga yang mengetahui lebih banyak tentang kedai daripada yang ia akui.'),
('di-balik-dinding-kaca', 'Arga', 'Arsitek perfeksionis yang mulai meragukan ingatan dan persepsinya setelah menerima foto misterius.'),
('di-balik-dinding-kaca', 'Nadine', 'Rekan kerja Arga yang pragmatis dan berusaha membantunya memeriksa gedung secara objektif.'),
('kota-yang-menyimpan-hujan', 'Sita', 'Anak yang gigih mencari jejak ibunya melalui satu kenangan tentang hujan.'),
('kota-yang-menyimpan-hujan', 'Kakek Banyu', 'Penjual payung tua yang menjaga botol-botol cuaca dan memahami cara kerja kenangan.'),
('orbit-terakhir', 'Elara', 'Kapten Asteria yang tegas dan tenang ketika menghadapi keputusan berisiko.'),
('orbit-terakhir', 'Bima', 'Teknisi muda yang jeli membaca pola sinyal dan lebih percaya data daripada firasat.'),
('neon-di-ujung-gang', 'Juno', 'Kurir data yang cekatan, skeptis, dan mulai mempertanyakan masa lalunya.'),
('neon-di-ujung-gang', 'Mara', 'Mantan teknisi Memoria yang membawa informasi rahasia sekaligus rasa bersalah.'),
('musim-ketika-laut-naik', 'Rumi', 'Remaja pesisir yang tekun mendokumentasikan kampungnya sebelum harus pindah.'),
('musim-ketika-laut-naik', 'Pak Darsa', 'Nelayan yang keras hati, mencintai laut, dan sulit menerima bahwa rumahnya harus ditinggalkan.'),
('legenda-penjaga-padi', 'Dini', 'Gadis desa yang berani mengambil tanggung jawab ketika orang dewasa kehilangan harapan.'),
('legenda-penjaga-padi', 'Jati', 'Penjaga benih berwujud burung putih yang mengingatkan manusia pada keseimbangan alam.'),
('surat-dari-menara-jam', 'Seno', 'Penjilid buku muda yang teliti dan ingin memahami sejarah keluarganya.'),
('surat-dari-menara-jam', 'Mirah', 'Perempuan yang menyimpan ingatan tentang persahabatan dan pesan yang tertunda puluhan tahun.'),
('taman-untuk-bintang-yang-padam', 'Pak Ranu', 'Penjaga taman yang pendiam dan sedang belajar menerima kehilangan.'),
('taman-untuk-bintang-yang-padam', 'Lio', 'Anak yang penuh rasa ingin tahu dan menemukan cara sederhana untuk menemani orang lain.'),
('tiga-hari-tanpa-matahari', 'Aksa', 'Penghuni apartemen yang terorganisasi dan berusaha menjaga kelompok tetap tenang.'),
('tiga-hari-tanpa-matahari', 'Rhea', 'Dokter muda yang praktis, sigap, dan memahami risiko kesehatan dari kabut abu.'),
('kontrak-dengan-tuan-senja', 'Mira', 'Pekerja malam yang rela berkorban demi adiknya, tetapi mulai menyadari harga dari keputusannya.'),
('kontrak-dengan-tuan-senja', 'Tuan Senja', 'Penjaga toko jam misterius yang mengelola transaksi waktu dan menyimpan agenda tersembunyi.'),
('nada-terakhir-sang-konduktor', 'Lala', 'Pemain biola muda yang peka terhadap detail dan berani mengusulkan pendekatan baru.'),
('nada-terakhir-sang-konduktor', 'Surya', 'Konduktor senior yang menyimpan kesedihan dan sejarah panjang orkestra kota.'),
('garis-finish-untuk-ayah', 'Davin', 'Pelari SMA yang tekun tetapi sering menilai dirinya dari keberhasilan orang lain.'),
('garis-finish-untuk-ayah', 'Pak Arman', 'Ayah Davin, mantan pelari yang masih berdamai dengan kegagalan masa lalunya.'),
('garis-finish-untuk-ayah', 'Niko', 'Pelatih yang menekankan disiplin, keselamatan, dan tujuan pribadi atlet.'),
('resep-rahasia-rumah-kaca', 'Raka', 'Kakak yang sentimental dan suka memasak, berusaha menjaga kenangan keluarga.'),
('resep-rahasia-rumah-kaca', 'Sera', 'Adik yang realistis dan bertanggung jawab atas keuangan keluarga, tetapi masih menyayangi rumah kaca.'),
('sepasang-tiket-ke-utara', 'Naya', 'Ilustrator lepas yang spontan dan ingin mengumpulkan pengalaman baru.'),
('sepasang-tiket-ke-utara', 'Damar', 'Pustakawan yang pendiam dan sedang berusaha memperbaiki hubungan lama.'),
('kelas-terakhir-bu-ratih', 'Bu Ratih', 'Guru bahasa yang tegas dan peduli, tetapi memberi ruang bagi murid untuk mengambil inisiatif.'),
('kelas-terakhir-bu-ratih', 'Fikri', 'Ketua kelas yang belajar memimpin tanpa harus mengendalikan semua orang.'),
('kelas-terakhir-bu-ratih', 'Mila', 'Murid kreatif yang mengumpulkan cerita dan menyatukan ide teman-temannya.'),
('rumah-di-seberang-rel', 'Nenek Sari', 'Matriark keluarga yang tegar dan menyimpan kisah persahabatan lama.'),
('rumah-di-seberang-rel', 'Rafi', 'Cucu yang ingin memahami sejarah rumah dan menjadi jembatan antar generasi.'),
('rumah-di-seberang-rel', 'Maya', 'Ibu Rafi yang praktis dan ingin memastikan keputusan rumah tidak membebani keluarga.'),
('di-bawah-purnama-merah', 'Ratri', 'Restorator lukisan yang rasional dan berani menelusuri perubahan aneh pada karya seni.'),
('di-bawah-purnama-merah', 'Adipati Wening', 'Pemilik rumah tua yang menjaga rahasia keluarga dan takut mengulang kesalahan leluhurnya.'),
('saksi-dari-ruang-arsip', 'Dira', 'Staf arsip teliti yang percaya bahwa dokumen harus dapat dipertanggungjawabkan.'),
('saksi-dari-ruang-arsip', 'Banyu', 'Jaksa muda yang berhati-hati dan memahami bahwa bukti harus dijaga dengan prosedur yang benar.'),
('dokter-untuk-kota-sunyi', 'Amina', 'Dokter muda yang tenang dan berorientasi pada pelayanan, belajar mendengarkan kebutuhan warga.'),
('dokter-untuk-kota-sunyi', 'Roni', 'Perawat lokal yang mengenal warga dan menjadi penghubung utama klinik dengan masyarakat.'),
('mesin-hati-nomor-08', 'Niko', 'Teknisi robotika yang teliti dan mulai mempertanyakan batas antara fungsi dan identitas.'),
('mesin-hati-nomor-08', 'Unit 08', 'Robot pendamping lama yang menyimpan memori personal dan kebiasaan unik.'),
('mesin-hati-nomor-08', 'Elin', 'Mantan anak pengguna Unit 08 yang ingin mengucapkan terima kasih sebelum mesin itu dihapus.'),
('toko-barang-kenangan', 'Ina', 'Penjaga toko yang bijak dan mampu membaca jejak emosi pada benda-benda lama.'),
('toko-barang-kenangan', 'Saka', 'Cucu Ina yang skeptis tetapi berani menyelidiki petunjuk yang muncul di toko.'),
('kompas-dari-kulit-naga', 'Kirana', 'Mekanik berbakat yang memahami mesin sekaligus memiliki rasa ingin tahu besar.'),
('kompas-dari-kulit-naga', 'Bram', 'Pilot udara yang berani dan membawa peta ekspedisi kerajaan yang hilang.'),
('kompas-dari-kulit-naga', 'Veyr', 'Bangsawan ambisius yang ingin menguasai sumber energi tanpa memikirkan akibatnya.'),
('jejak-kuda-di-tanah-garam', 'Jati', 'Penjaga kuda yang jujur dan mengenal setiap jalur di kota perbatasan.'),
('jejak-kuda-di-tanah-garam', 'Rosa', 'Pemilik penginapan yang berani membela pekerja dan pandai membaca situasi.'),
('pukul-0417-di-stasiun-lama', 'Reno', 'Petugas stasiun yang gigih dan semakin teliti setelah mengalami pengulangan waktu.'),
('pukul-0417-di-stasiun-lama', 'Wira', 'Petugas senior yang mengetahui kerusakan jalur tetapi kesulitan membuat laporannya didengar.'),
('bunga-yang-tumbuh-di-beton', 'Ayla', 'Siswi pindahan yang pendiam, tekun, dan sedang membangun rasa percaya diri.'),
('bunga-yang-tumbuh-di-beton', 'Rafi', 'Anggota klub lingkungan yang ramah dan suka melibatkan orang lain dalam proyek kecil.'),
('tujuh-perahu-untuk-pulang', 'Nala', 'Navigator muda yang cermat dan mampu mengambil keputusan saat rencana berubah.'),
('tujuh-perahu-untuk-pulang', 'Omar', 'Nelayan berpengalaman yang memahami arus serta jalur tersembunyi di sekitar pulau.'),
('ruang-yang-tidak-ada-di-peta', 'Lira', 'Kartografer yang teliti dan berusaha menyusun kembali ingatan masa kecilnya.'),
('ruang-yang-tidak-ada-di-peta', 'Tama', 'Kakak Lira yang hadir melalui jejak kenangan dan potongan cerita yang tersimpan.'),
('ketika-layang-layang-menemukan-angin', 'Farel', 'Anak yang berhati-hati dan mudah cemas, tetapi tekun ketika mendapat dukungan.'),
('ketika-layang-layang-menemukan-angin', 'Kakek Jaya', 'Kakek yang sabar dan mengajarkan keberanian melalui pengalaman sederhana.');

-- The image column is NOT NULL; use the supplied local placeholder asset path (not NULL).
-- Existing character names for the same story are skipped.
INSERT INTO story_characters (story_id, name, description, image, created_at, updated_at)
SELECT map.story_id, tp_char.character_name, tp_char.character_description, 'characters/placeholder.svg', NOW(), NOW()
FROM tmp_tp_characters AS tp_char
JOIN tmp_tp_story_map AS map ON map.seed_slug = tp_char.seed_slug
WHERE map.story_id IS NOT NULL
  AND NOT EXISTS (
      SELECT 1 FROM story_characters AS existing
      WHERE existing.story_id = map.story_id
        AND LOWER(existing.name) = LOWER(tp_char.character_name)
  );

COMMIT;

-- Verification summary: expected totals from this package are 30 story entries, 60 chapter entries, and 66 character entries.
-- These SELECTs show which of the package stories exist and their current related-data counts.
SELECT s.id, s.title, s.genre, s.status, COUNT(DISTINCT ch.id) AS chapter_count, COUNT(DISTINCT c.id) AS character_count
FROM tmp_tp_stories AS seed
JOIN tmp_tp_story_map AS map ON map.seed_slug = seed.seed_slug
JOIN stories AS s ON s.id = map.story_id
LEFT JOIN story_chapters AS ch ON ch.story_id = s.id
LEFT JOIN story_characters AS c ON c.story_id = s.id
GROUP BY s.id, s.title, s.genre, s.status
ORDER BY s.title;

DROP TEMPORARY TABLE IF EXISTS tmp_tp_characters;
DROP TEMPORARY TABLE IF EXISTS tmp_tp_chapters;
DROP TEMPORARY TABLE IF EXISTS tmp_tp_story_map;
DROP TEMPORARY TABLE IF EXISTS tmp_tp_stories;

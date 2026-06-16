const { Client, LocalAuth } = require("whatsapp-web.js");
const QRCode = require("qrcode");
const mysql = require("mysql2/promise");
const natural = require("natural");
const axios = require("axios");

// --- PENTING: Pastikan Anda mengisi nilai ini dengan benar ---
const GOOGLE_API_KEY = "AIzaSyDJMYaK-5DuiOs1x5mZGM4veb6vwVJhyHM";
// PERBAIKAN: Typo 'SARCH' menjadi 'SEARCH'
const SEARCH_ENGINE_ID = "34f5c1bb471694759";
// -----------------------------------------------------------

// PENYEMPURNAAN: Logika jam kerja disederhanakan dan dibuat lebih akurat
function isWithinWorkingHours() {
    const now = new Date(
        new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" })
    );
    const day = now.getDay(); // 0 = Minggu, 1 = Senin, ..., 5 = Jumat, 6 = Sabtu
    const hour = now.getHours();
    const minute = now.getMinutes();

    // Senin - Kamis (hari ke 1-4), jam 8 pagi (inklusif) sampai jam 4 sore (eksklusif)
    if (day >= 1 && day <= 4) {
        return hour >= 8 && hour < 16;
    }
    // Jumat (hari ke 5), jam 8 pagi (inklusif) sampai 16:30 (eksklusif)
    if (day === 5) {
        if (hour < 8) return false;
        if (hour > 16) return false;
        if (hour === 16 && minute >= 30) return false;
        return true;
    }
    // Di luar itu (Sabtu/Minggu) adalah hari libur
    return false;
}

// PERBAIKAN: Menggunakan fungsi pencarian final yang menggunakan Google API
async function searchBpsWithGoogle(keyword) {
    if (
        GOOGLE_API_KEY.startsWith("MASUKKAN") ||
        SEARCH_ENGINE_ID.startsWith("MASUKKAN")
    ) {
        console.error(
            "Kesalahan Konfigurasi: GOOGLE_API_KEY atau SEARCH_ENGINE_ID belum diisi."
        );
        return "ERROR: API Key atau Search Engine ID belum dikonfigurasi di dalam kode.";
    }

    const searchUrl = `https://www.googleapis.com/customsearch/v1`;
    try {
        console.log(
            `Mencari via Google Custom Search untuk kata kunci: ${keyword}`
        );
        const response = await axios.get(searchUrl, {
            params: {
                key: GOOGLE_API_KEY,
                cx: SEARCH_ENGINE_ID,
                q: keyword,
                num: 10,
            },
        });
        const results = response.data.items;
        if (!results || results.length === 0) {
            return `Tidak ditemukan hasil pencarian di situs BPS untuk kata kunci "${keyword}" melalui Google.`;
        }
        let replyMessage = `Berikut ${results.length} Hasil Pencarian Teratas dari situs BPS untuk *${keyword}*:\n\n`;
        results.forEach((item) => {
            replyMessage += `*${item.title}*\n`;
            replyMessage += `_${item.snippet.replace(/\n/g, " ")}_\n`;
            replyMessage += `🔗 Tautan: ${item.link}\n\n`;
        });
        return replyMessage.trim();
    } catch (error) {
        console.error(
            "Error fetching Google Custom Search API:",
            error.response ? error.response.data.error.message : error.message
        );
        return `Maaf, terjadi gangguan saat melakukan pencarian melalui Google.`;
    }
}

// ====== Menu Navigasi (tidak ada perubahan) ======
const menus = {
    main: {
        text: `Selamat datang! di Konsultasi BPS Bangka Belitung:\n\nJam Kerja BPS Bangka Belitung:\nSenin - Kamis: 08.00 - 16.00 WIB\nJumat: 08.00 - 16.30 WIB\nSabtu, Minggu, dan tanggal merah: Libur\n\nUntuk konsultasi dengan petugas, harap hubungi kami pada jam kerja. Di luar jam kerja, Anda dapat menggunakan chatbot ini.\n\nApakah Anda ingin melanjutkan?\n1. Ya\n(Abaikan jika tidak)`,
        options: { 1: "chatbot" },
    },
    chatbot: {
        text: `Silahkan Pilih Layanan Yang Diinginkan?:\n1. Konsultasi Data Statistik\n2. Buat Janji Temu Online\n3. Chat dengan Konsultan Statistik\n4. Perpustakaan\n5. Layanan Lainnya\n6. Tentang Kami\n7. 🔍 Pencarian Data\n0. ↩️ Kembali ke Awal`,
        options: {
            1: "menu_konsultasi",
            2: "janji_temu",
            3: "start_agent_chat",
            4: "perpustakaan",
            5: "layanan_lainnya",
            6: "menu_info",
            7: "pencarian_data",
            0: "main",
        },
    },
    pencarian_data: {
        text: "Anda memilih fitur pencarian data.\nSilakan sebutkan kata kunci yang ingin Anda cari (contoh: *inflasi*).\n\nKetik *0* atau *kembali* untuk batal.",
        options: { 0: "chatbot", kembali: "chatbot" },
    },
    // ... Sisa menu lainnya tidak berubah ...
    menu_konsultasi: {
        text: `Kategori Konsultasi:\nSilakan pilih topik yang Anda minati.\n\n1. 📈 Ekonomi & Perdagangan\n2. 👥 Sosial & Kependudukan\n3. 🌾 Pertanian & Pertambangan\n4. ❓ Topik tidak ditemukan?\n0. ↩️ Kembali`,
        options: {
            1: "menu_ekonomi",
            2: "menu_sosial",
            3: "menu_pertanian",
            4: "Jawaban: Maaf, data yang Anda cari belum tersedia di chatbot ini. Untuk informasi lebih lengkap, Anda dapat mengunjungi website resmi kami di: https://babel.bps.go.id atau datang langsung ke kantor kami.",
            0: "chatbot",
        },
    },
    menu_ekonomi: {
        text: `Kategori: 📈 Ekonomi & Perdagangan\n\n1. Pertumbuhan Ekonomi (PDRB)\n2. Inflasi\n3. Ekspor & Impor\n4. Pariwisata\n5. Indeks Harga Konsumen (IHK)\n0. ↩️ Kembali`,
        options: {
            1: "Jawaban: **Pertumbuhan Ekonomi (PDRB)**\nLaju pertumbuhan Produk Domestik Regional Bruto (PDRB) atas dasar harga konstan. Pada Triwulan I-2025, ekonomi Bangka Belitung tercatat tumbuh sebesar **4,60%** (y-on-y). Pertumbuhan ini didorong oleh sektor pertambangan, industri pengolahan, dan pertanian.",
            2: "Jawaban: **Inflasi**\nPerkembangan Indeks Harga Konsumen (IHK) gabungan dari Pangkalpinang dan Tanjung Pandan. Pada Mei 2025, inflasi tahunan (y-on-y) Bangka Belitung adalah sebesar **0,79%**. Inflasi bulanan (m-to-m) tercatat sebesar 0,25%.",
            3: "Jawaban: **Perdagangan Luar Negeri**\n- **Ekspor**: Nilai ekspor pada April 2025 mencapai **US$176,41 juta**, dengan komoditas utama timah dan CPO.\n- **Impor**: Nilai impor pada periode yang sama adalah **US$15,2 juta**, sebagian besar terdiri dari mesin dan bahan bakar.",
            4: "Jawaban: **Pariwisata**\nTingkat Penghunian Kamar (TPK) hotel berbintang pada April 2025 adalah sebesar **45,80%**. Jumlah kunjungan wisatawan mancanegara terus menunjukkan tren peningkatan seiring dengan pemulihan sektor pariwisata.",
            5: "Jawaban: **Indeks Harga Konsumen (IHK)**\nIHK merupakan indikator utama untuk mengukur tingkat inflasi. Pada Mei 2025, IHK gabungan dua kota di Bangka Belitung tercatat sebesar **106,5**. Kelompok pengeluaran yang memberikan andil terbesar pada inflasi adalah makanan, minuman, dan tembakau.",
            0: "menu_konsultasi",
        },
    },
    menu_sosial: {
        text: `Kategori: 👥 Sosial & Kependudukan\n\n1. Jumlah & Laju Pertumbuhan Penduduk\n2. Ketenagakerjaan (TPT)\n3. Kemiskinan\n4. Indeks Pembangunan Manusia (IPM)\n5. Rata-rata Lama Sekolah\n0. ↩️ Kembali`,
        options: {
            1: "Jawaban: **Populasi Penduduk**\nBerdasarkan Proyeksi Penduduk Interim 2020-2023, jumlah penduduk Provinsi Kepulauan Bangka Belitung pada tahun 2024 diperkirakan mencapai **1,53 juta jiwa** dengan laju pertumbuhan sekitar 1,45% per tahun.",
            2: "Jawaban: **Ketenagakerjaan**\nTingkat Pengangguran Terbuka (TPT) pada Februari 2025 adalah sebesar **4,17%**. Angka ini menunjukkan persentase angkatan kerja yang sedang mencari pekerjaan.",
            3: "Jawaban: **Tingkat Kemiskinan**\nPada September 2024, persentase penduduk miskin di Bangka Belitung adalah sebesar **4,52%**. Garis Kemiskinan ditetapkan sebesar **Rp812.543,-** per kapita per bulan.",
            4: "Jawaban: **Indeks Pembangunan Manusia (IPM)**\nIPM Bangka Belitung pada tahun 2024 mencapai **72,50**, masuk dalam kategori 'Tinggi'. IPM mengukur capaian pembangunan manusia dari tiga dimensi: kesehatan, pendidikan, dan standar hidup layak.",
            5: "Jawaban: **Pendidikan**\nRata-rata Lama Sekolah (RLS) di Bangka Belitung pada tahun 2024 adalah **8,55 tahun**, yang setara dengan pendidikan hingga kelas IX atau SMP kelas 2.",
            0: "menu_konsultasi",
        },
    },
    menu_pertanian: {
        text: `Kategori: 🌾 Pertanian & Pertambangan\n\n1. Nilai Tukar Petani (NTP)\n2. Produksi Tanaman Pangan Utama\n3. Produksi Mineral Utama (Timah)\n0. ↩️ Kembali`,
        options: {
            1: "Jawaban: **Nilai Tukar Petani (NTP)**\nNTP adalah indikator kesejahteraan petani. Pada Mei 2025, NTP Bangka Belitung tercatat sebesar **105,20**, menunjukkan bahwa pendapatan petani lebih besar dari pengeluarannya.",
            2: "Jawaban: **Produksi Tanaman Pangan**\nProduksi padi di Bangka Belitung pada tahun 2024 diproyeksikan mencapai **65,4 ribu ton** Gabah Kering Giling (GKG). Selain itu, komoditas perkebunan utama adalah kelapa sawit dan lada.",
            3: "Jawaban: **Produksi Timah**Sebagai salah satu produsen timah terbesar di dunia, data produksi timah sangat vital bagi ekonomi daerah. Untuk data produksi spesifik, disarankan untuk mengacu pada laporan dari dinas terkait atau perusahaan pertambangan.",
            0: "menu_konsultasi",
        },
    },
    janji_temu: {
        text: `Silahkan Buat Janji Temu nya Pada Link Berikut: https://datapedia.terpal-babel.my.id/janjitemu/online\n0. ↩️ Kembali`,
        options: { 0: "chatbot" },
    },
    perpustakaan: {
        text: `Perpustakaan BPS Provinsi Kepulauan Bangka Belitung menyediakan layanan media dalam bentuk hardcopy dan softcopy dalam format PDF serta dapat diakses secara:\n\n- Online melalui https://perpustakaan.bps.go.id/opac/\n\n- Offline dengan datang langsung ke kantor BPS Kabupaten Bangka Tengah.\n0. ↩️ Kembali`,
        options: { 0: "chatbot" },
    },
    menu_info: {
        text: `Kategori: 🏢 Info Umum\n\n1. Jam Operasional\n2. Alamat & Kontak\n3. Profil BPS\n0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Jam operasional kami:\n- Senin–Kamis: 08.00–16.00 WIB\n- Jumat: 08.00–16.30 WIB",
            2: "Jawaban: **Alamat & Kontak BPS Provinsi Kep. Bangka Belitung**\n- **Alamat:** Komp. Perkantoran Terpadu Pemprov. Kep. Bangka Belitung, Air Itam, Pangkalpinang.\n- **Telepon:** (0717) 439422\n- **Email:** bps1900@bps.go.id\n- **Website:** https://babel.bps.go.id",
            3: "Jawaban: **Profil BPS**\nBadan Pusat Statistik (BPS) adalah Lembaga Pemerintah Non-Kementerian yang bertanggung jawab langsung kepada Presiden. Kami bertugas menyediakan data statistik dasar yang berkualitas untuk perencanaan dan evaluasi pembangunan nasional dan daerah.",
            0: "chatbot",
        },
    },
    layanan_lainnya: {
        text: `Kategori: 🛠️ Layanan Lainnya\n\n1. Unduh Publikasi & Data Gratis\n2. Rekomendasi Kegiatan Statistik (ROMANTIK)\n3. Portal Satu Data Babel\n0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Anda dapat mengunduh semua publikasi dan data kami secara gratis melalui website resmi BPS Babel: https://babel.bps.go.id",
            2: "Jawaban: Untuk pengajuan rekomendasi kegiatan statistik sektoral, silakan kunjungi portal ROMANTIK di: https://romantik.web.bps.go.id",
            3: "Jawaban: Temukan data statistik sektoral dari berbagai instansi di Provinsi Kepulauan Bangka Belitung melalui portal Satu Data Indonesia: https://sdi.babelprov.go.id",
            0: "chatbot",
        },
    },
};

// State per User & DB Connection
const userStates = {};
const db = mysql.createPool({
    host: "datapedia.terpal-babel.my.id",
    user: "terd7172",
    password: "9sEdJPd87TA725",
    database: "terd7172_datapedia",
});

// ====== WhatsApp Client Init ======
const client = new Client({
    authStrategy: new LocalAuth(),
    puppeteer: {
        args: ["--no-sandbox", "--disable-setuid-sandbox"],
    },
});

client.on("qr", async (qr) => {
    await QRCode.toFile("./qr_code.png", qr, { scale: 8 });
    console.log("✅ Scan QR Code yang telah dibuat di file ./qr_code.png");
});
client.on("ready", () => console.log("✅ WhatsApp client siap digunakan!"));

// ====== Message Handler Utama ======
client.on("message", async (message) => {
    const from = message.from;
    const text = message.body.trim().toLowerCase();

    try {
        const phoneNumber = from.split("@")[0];
        const [users] = await db.query("SELECT id FROM users WHERE no_hp = ?", [
            phoneNumber,
        ]);
        if (users.length === 0) return; // Abaikan pesan dari nomor tidak terdaftar

        const currentState = userStates[from];

        if (currentState === "pencarian_data") {
            if (text === "0" || text === "kembali") {
                userStates[from] = "chatbot";
                await client.sendMessage(from, menus.chatbot.text);
                return;
            }
            await client.sendMessage(
                from,
                "⏳ Sedang mencari data, mohon tunggu..."
            );
            // PERBAIKAN: Memanggil fungsi yang benar
            const searchResult = await searchBpsWithGoogle(text);
            await client.sendMessage(from, searchResult);

            // Kembali ke menu utama setelah pencarian selesai
            userStates[from] = "chatbot";
            await client.sendMessage(from, "\nSilakan pilih menu lainnya.");
            await client.sendMessage(from, menus.chatbot.text);
            return;
        }

        if (currentState === "agent_chat") {
            if (text === "chatbot") {
                userStates[from] = "chatbot";
                await client.sendMessage(
                    from,
                    "Anda kembali ke menu chatbot. Silakan pilih layanan."
                );
                await client.sendMessage(from, menus.chatbot.text);
            }
            return; // Abaikan pesan lain
        }

        if (!currentState) {
            userStates[from] = "main";
            await client.sendMessage(from, menus.main.text);
            return;
        }

        const currentMenu = menus[currentState];
        const nextState = currentMenu.options[text];

        if (nextState) {
            if (nextState === "start_agent_chat") {
                if (isWithinWorkingHours()) {
                    userStates[from] = "agent_chat";
                    await client.sendMessage(
                        from,
                        "Sekarang anda telah terhubung kepada konsultan statistik kami.\n\nSilahkan Ketik *chatbot* kapan saja untuk kembali ke menu utama."
                    );
                } else {
                    await client.sendMessage(
                        from,
                        "Maaf, layanan konsultasi dengan petugas hanya tersedia pada jam kerja (Senin-Jumat).\n\nSilakan gunakan layanan chatbot di bawah ini."
                    );
                    await client.sendMessage(from, currentMenu.text);
                }
            } else if (nextState.startsWith("Jawaban:")) {
                await client.sendMessage(
                    from,
                    nextState.replace("Jawaban: ", "")
                );
                await client.sendMessage(from, currentMenu.text);
            } else {
                userStates[from] = nextState;
                await client.sendMessage(from, menus[nextState].text);
            }
        } else {
            await client.sendMessage(
                from,
                "Pilihan tidak valid. Silakan ketik angka dari menu yang tersedia."
            );
            await client.sendMessage(from, currentMenu.text);
        }
    } catch (err) {
        console.error(`❌ Error pada pesan dari ${from}:`, err);
        await client.sendMessage(
            from,
            "Maaf, terjadi kesalahan pada sistem. Silakan coba lagi nanti."
        );
    }
});

client
    .initialize()
    .catch((err) => console.error("❌ Gagal inisialisasi WhatsApp:", err));

// ====== Notifikasi Terjadwal ======
setInterval(async () => {
    console.log(
        "Mengecek notifikasi 'pending' pada " + new Date().toLocaleTimeString()
    );
    try {
        const [rows] = await db.query(
            "SELECT * FROM notifikasi_wa WHERE status = 'pending' LIMIT 5"
        );
        if (rows.length > 0) {
            console.log(`Ditemukan ${rows.length} notifikasi untuk dikirim.`);
        }
        for (const notif of rows) {
            const nomor = notif.no_hp.startsWith("62")
                ? notif.no_hp
                : `62${notif.no_hp.replace(/^0/, "")}`;
            const chatId = await client.getNumberId(nomor);
            if (chatId) {
                await client.sendMessage(chatId._serialized, notif.pesan);
                await db.query(
                    "UPDATE notifikasi_wa SET status = 'sent' WHERE id = ?",
                    [notif.id]
                );
                console.log(`📤 Notifikasi terkirim ke ${notif.no_hp}`);
            } else {
                await db.query(
                    "UPDATE notifikasi_wa SET status = 'failed' WHERE id = ?",
                    [notif.id]
                );
                console.log(`❌ Nomor tidak valid: ${nomor}`);
            }
        }
    } catch (err) {
        console.error(
            "❌ Gagal memeriksa atau mengirim notifikasi:",
            err.message
        );
    }
}, 10000);

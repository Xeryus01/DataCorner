const { Client, LocalAuth } = require("whatsapp-web.js");
require("dotenv").config();
let clientReady = false;
const QRCode = require("qrcode");
const mysql = require("mysql2/promise");
const natural = require("natural");
const axios = require("axios");
const tokenizer = new natural.WordTokenizer();
const classifier = new natural.BayesClassifier();
const GOOGLE_API_KEY = "AIzaSyDJMYaK-5DuiOs1x5mZGM4veb6vwVJhyHM";
const SEARCH_ENGINE_ID = "34f5c1bb471694759";
// const Sastrawi = require("sastrawijs");
// const stemmer = new Sastrawi.StemmerFactory().createStemmer();
const { LevenshteinDistance } = natural;
const intentKeywords = {
    INFLASI: ["inflasi", "kenaikan harga", "ihk"],
    IPM: ["ipm", "indeks pembangunan manusia"],
    KEMISKINAN: ["kemiskinan", "penduduk miskin"],
    JAM_KERJA: ["jam kerja", "jam operasional", "buka jam"],
    ALAMAT: ["alamat bps", "lokasi bps"],
};
const OpenAI = require("openai");

const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});

// -----------------------------------------------------------

// ====== TRAINING DATA NLP ======

// SALAM
classifier.addDocument("halo", "SALAM");
classifier.addDocument("hai", "SALAM");
classifier.addDocument("pagi", "SALAM");
classifier.addDocument("siang", "SALAM");
classifier.addDocument("sore", "SALAM");
classifier.addDocument("malam", "SALAM");
classifier.addDocument("assalamualaikum", "SALAM");

// TERIMA KASIH
classifier.addDocument("terima kasih", "TERIMAKASIH");
classifier.addDocument("makasih", "TERIMAKASIH");
classifier.addDocument("ok terima kasih", "TERIMAKASIH");
classifier.addDocument("sip", "TERIMAKASIH");
classifier.addDocument("mantap", "TERIMAKASIH");

// INFLASI
classifier.addDocument("inflasi", "INFLASI");
classifier.addDocument("inflasi babel", "INFLASI");
classifier.addDocument("tingkat inflasi", "INFLASI");
classifier.addDocument("kenaikan harga", "INFLASI");
classifier.addDocument("harga barang naik", "INFLASI");
classifier.addDocument("indeks harga konsumen", "INFLASI");
classifier.addDocument("ihk", "INFLASI");

classifier.addDocument("pdrb", "PDRB");
classifier.addDocument("pertumbuhan ekonomi", "PDRB");
classifier.addDocument("ekonomi bangka belitung", "PDRB");
classifier.addDocument("pdrb adhb", "PDRB");
classifier.addDocument("pdrb adhk", "PDRB");
classifier.addDocument("ekonomi tumbuh", "PDRB");

classifier.addDocument("pengangguran", "TPT");
classifier.addDocument("tpt", "TPT");
classifier.addDocument("pengangguran terbuka", "TPT");
classifier.addDocument("angkatan kerja", "TPT");
classifier.addDocument("orang belum kerja", "TPT");

// IPM
classifier.addDocument("ipm", "IPM");
classifier.addDocument("indeks pembangunan manusia", "IPM");
classifier.addDocument("pendidikan", "IPM");
classifier.addDocument("rata rata lama sekolah", "IPM");
classifier.addDocument("harapan hidup", "IPM");

// KEMISKINAN
classifier.addDocument("kemiskinan", "KEMISKINAN");
classifier.addDocument("penduduk miskin", "KEMISKINAN");
classifier.addDocument("garis kemiskinan", "KEMISKINAN");
classifier.addDocument("angka kemiskinan", "KEMISKINAN");
classifier.addDocument("tingkat kemiskinan", "KEMISKINAN");

classifier.addDocument("jumlah penduduk", "PENDUDUK");
classifier.addDocument("penduduk babel", "PENDUDUK");
classifier.addDocument("populasi", "PENDUDUK");
classifier.addDocument("laju pertumbuhan penduduk", "PENDUDUK");
classifier.addDocument("berapa penduduk", "PENDUDUK");

classifier.addDocument("pertanian", "PERTANIAN");
classifier.addDocument("nilai tukar petani", "PERTANIAN");
classifier.addDocument("ntp", "PERTANIAN");
classifier.addDocument("hasil pertanian", "PERTANIAN");
classifier.addDocument("produksi padi", "PERTANIAN");

classifier.addDocument("timah", "TAMBANG");
classifier.addDocument("pertambangan", "TAMBANG");
classifier.addDocument("produksi timah", "TAMBANG");
classifier.addDocument("hasil tambang", "TAMBANG");

// JAM OPERASIONAL
classifier.addDocument("jam kerja", "JAM_KERJA");
classifier.addDocument("jam operasional", "JAM_KERJA");
classifier.addDocument("bps buka jam berapa", "JAM_KERJA");
classifier.addDocument("hari kerja bps", "JAM_KERJA");

// ALAMAT
classifier.addDocument("alamat bps", "ALAMAT");
classifier.addDocument("lokasi kantor bps", "ALAMAT");
classifier.addDocument("nomor telepon bps", "ALAMAT");
classifier.addDocument("email bps", "ALAMAT");

// KEMBALI
classifier.addDocument("kembali", "KEMBALI");
classifier.addDocument("menu", "KEMBALI");
classifier.addDocument("chatbot", "KEMBALI");

classifier.addDocument("publikasi bps", "PUBLIKASI");
classifier.addDocument("download data", "PUBLIKASI");
classifier.addDocument("unduh pdf", "PUBLIKASI");
classifier.addDocument("laporan statistik", "PUBLIKASI");

classifier.addDocument("buat janji", "JANJI");
classifier.addDocument("janji temu", "JANJI");
classifier.addDocument("konsultasi online", "JANJI");
classifier.addDocument("ketemu petugas", "JANJI");

classifier.addDocument("menu", "KEMBALI");
classifier.addDocument("kembali", "KEMBALI");
classifier.addDocument("chatbot", "KEMBALI");
classifier.addDocument("ulang", "KEMBALI");

classifier.addDocument("apa maksudnya", "TIDAK_JELAS");
classifier.addDocument("tidak paham", "TIDAK_JELAS");
classifier.addDocument("gimana", "TIDAK_JELAS");

// TRAIN
classifier.train();

function getNlpResponse(text) {
    const intent = classifier.classify(text);

    switch (intent) {
        case "SALAM":
            return "Halo 👋 Selamat datang di layanan Chatbot BPS Bangka Belitung.";

        case "TERIMAKASIH":
            return "Sama-sama 😊 Senang bisa membantu.";

        case "INFLASI":
            return menus.menu_ekonomi.options[2].replace("Jawaban: ", "");

        case "IPM":
            return menus.menu_sosial.options[4].replace("Jawaban: ", "");

        case "KEMISKINAN":
            return menus.menu_sosial.options[3].replace("Jawaban: ", "");

        case "JAM_KERJA":
            return menus.menu_info.options[1];

        case "ALAMAT":
            return menus.menu_info.options[2];

        case "KEMBALI":
            return "MENU_CHATBOT";

        default:
            return null;
    }
}

function preprocessText(text) {
    const clean = text
        .toLowerCase()
        .replace(/[^a-zA-Z\s]/g, "")
        .trim();

    return stemmer.stem(clean);
}

function isAllowedForChatGPT(text) {
    const blacklist = [
        "politik",
        "pemilu",
        "agama",
        "hoax",
        "presiden",
        "partai",
    ];

    return !blacklist.some((word) => text.includes(word));
}

async function askChatGPTFallback(question) {
    try {
        const completion = await openai.chat.completions.create({
            model: "gpt-4o-mini",
            temperature: 0.2,
            max_tokens: 250,
            messages: [
                {
                    role: "system",
                    content: `
    Anda adalah asisten informasi statistik resmi.
    Jawaban HARUS:
    - Singkat
    - Netral
    - Tidak berspekulasi
    - Tidak membuat data
    - Jika tidak yakin, katakan "silakan cek website resmi BPS"
    `,
                },
                {
                    role: "user",
                    content: question,
                },
            ],
        });

        return (
            "🤖 *Informasi Tambahan (AI)*\n" +
            completion.choices[0].message.content +
            "\n\n📌 *Catatan:* Informasi ini bersifat penjelasan umum. Untuk data resmi silakan merujuk ke website BPS."
        );
    } catch (err) {
        console.error("ChatGPT error:", err.message);
        return null;
    }
}

function similarityMatch(text) {
    let bestIntent = null;
    let lowestDistance = Infinity;

    for (const intent in intentKeywords) {
        for (const keyword of intentKeywords[intent]) {
            const distance = LevenshteinDistance(text, keyword);
            if (distance < lowestDistance && distance <= 3) {
                lowestDistance = distance;
                bestIntent = intent;
            }
        }
    }
    return bestIntent;
}

async function handleSmartNlp(text, from) {
    const processed = preprocessText(text);

    // 1️⃣ Intent NLP
    let intent = classifier.classify(processed);

    // 2️⃣ Similarity
    if (!intent || intent === "undefined") {
        intent = similarityMatch(processed);
    }

    // 3️⃣ Simpan analytics
    await logIntent(from, text, intent ?? "UNKNOWN");

    // 4️⃣ Jawaban berbasis intent
    switch (intent) {
        case "INFLASI":
            return menus.menu_ekonomi.options[2].replace("Jawaban: ", "");

        case "IPM":
            return menus.menu_sosial.options[4].replace("Jawaban: ", "");

        case "KEMISKINAN":
            return menus.menu_sosial.options[3].replace("Jawaban: ", "");

        case "JAM_KERJA":
            return menus.menu_info.options[1];

        case "ALAMAT":
            return menus.menu_info.options[2];
        case "PDRB":
            return "PDRB (Produk Domestik Regional Bruto) menggambarkan nilai tambah barang dan jasa di suatu wilayah. Data lengkap tersedia di website resmi BPS.";

        case "TPT":
            return "Tingkat Pengangguran Terbuka (TPT) menunjukkan persentase angkatan kerja yang belum bekerja.";

        case "PENDUDUK":
            return "Data jumlah dan pertumbuhan penduduk Bangka Belitung tersedia dalam publikasi kependudukan BPS.";

        case "PERTANIAN":
            return "BPS menyediakan data NTP dan produksi pertanian utama seperti padi dan hortikultura.";

        case "TAMBANG":
            return "Bangka Belitung merupakan salah satu produsen timah utama nasional. Data resmi tersedia pada publikasi BPS.";

        case "PUBLIKASI":
            return "Anda dapat mengunduh publikasi resmi BPS secara gratis di https://babel.bps.go.id";

        case "JANJI":
            return "Silakan buat janji temu melalui layanan online di website resmi BPS.";
    }

    // 5️⃣ Google Search
    const googleResult = await searchBpsWithGoogle(text);
    if (!googleResult.includes("Tidak ditemukan")) {
        return googleResult;
    }

    // 6️⃣ CHATGPT (FALLBACK TERAKHIR)
    if (isAllowedForChatGPT(text)) {
        const gptReply = await askChatGPTFallback(text);
        if (gptReply) return gptReply;
    }

    // 7️⃣ Default aman
    return (
        "Maaf, pertanyaan Anda belum dapat kami jawab secara otomatis.\n" +
        "Silakan hubungi petugas BPS atau kunjungi https://babel.bps.go.id"
    );
}

function isWithinWorkingHours() {
    const now = new Date(
        new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" })
    );
    const day = now.getDay();
    const hour = now.getHours();
    const minute = now.getMinutes();

    if (day >= 1 && day <= 4) {
        return hour >= 8 && hour < 16;
    }
    if (day === 5) {
        if (hour < 8) return false;
        if (hour > 16) return false;
        if (hour === 16 && minute >= 30) return false;
        return true;
    }
    return false;
}

async function searchBpsWithGoogle(keyword) {
    const searchUrl = "https://www.googleapis.com/customsearch/v1";
    const currentYear = new Date().getFullYear();
    const minYear = currentYear - 5;

    try {
        const response = await axios.get(searchUrl, {
            params: {
                key: GOOGLE_API_KEY,
                cx: SEARCH_ENGINE_ID,
                q: `site:babel.bps.go.id ${keyword}`,
                num: 10,
            },
        });

        let results = response.data.items || [];

        // 🔎 FILTER 5 TAHUN TERAKHIR
        results = results.filter((item) => {
            const text = `${item.title} ${item.snippet} ${item.link}`;
            const yearMatch = text.match(/20\d{2}/g);
            if (!yearMatch) return false;

            return yearMatch.some((year) => parseInt(year) >= minYear);
        });

        if (results.length === 0) {
            return `Tidak ditemukan data *${keyword}* dalam 5 tahun terakhir.`;
        }

        let reply = `📊 *Hasil Pencarian Data BPS (5 Tahun Terakhir)*\n`;
        reply += `🔍 Kata kunci: *${keyword}*\n\n`;

        results.slice(0, 10).forEach((item, index) => {
            reply += `*${index + 1}. ${item.title}*\n`;
            reply += `_${item.snippet.replace(/\n/g, " ")}_\n`;
            reply += `🔗 ${item.link}\n\n`;
        });

        return reply.trim();
    } catch (error) {
        console.error("Google Search Error:", error.message);
        return "❌ Terjadi kesalahan saat mengambil data dari BPS.";
    }
}

// ====== Menu Navigasi
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

    menu_konsultasi: {
        text: `📊 *Konsultasi Data Statistik*\n\nSilakan pilih topik:\n
1. 📈 Ekonomi & Perdagangan
2. 👥 Sosial & Kependudukan
3. 🌾 Pertanian, Perikanan & Kehutanan
4. 🏭 Industri & Energi
5. 🏗️ Infrastruktur & Konstruksi
6. 💼 Ketenagakerjaan
7. 📚 Pendidikan
8. 🏥 Kesehatan
9. 🌍 Lingkungan & Iklim
10. ❓ Data tidak ditemukan?
0. ↩️ Kembali`,
        options: {
            1: "menu_ekonomi",
            2: "menu_sosial",
            3: "menu_pertanian",
            4: "menu_industri",
            5: "menu_infrastruktur",
            6: "menu_tenagakerja",
            7: "menu_pendidikan",
            8: "menu_kesehatan",
            9: "menu_lingkungan",
            10: "menu_tidak_ditemukan",
            0: "chatbot",
        },
    },

    menu_ekonomi: {
        text: `📈 *Ekonomi & Perdagangan*\n
1. Produk Domestik Regional Bruto (PDRB)
2. Pertumbuhan Ekonomi
3. Inflasi & IHK
4. Ekspor
5. Impor
6. Nilai Tukar Petani (NTP)
7. Indeks Tendensi Konsumen (ITK)
8. Harga Produsen
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: PDRB menggambarkan nilai tambah barang dan jasa...",
            2: "Jawaban: Pertumbuhan ekonomi Bangka Belitung...",
            3: "Jawaban: Inflasi diukur menggunakan IHK...",
            4: "Jawaban: Data ekspor utama Bangka Belitung...",
            5: "Jawaban: Data impor Provinsi Kep. Babel...",
            6: "Jawaban: Nilai Tukar Petani (NTP)...",
            7: "Jawaban: Indeks Tendensi Konsumen...",
            8: "Jawaban: Harga produsen mencerminkan...",
            0: "menu_konsultasi",
        },
    },
    menu_sosial: {
        text: `👥 *Sosial & Kependudukan*\n
1. Jumlah Penduduk
2. Laju Pertumbuhan Penduduk
3. Kemiskinan
4. Indeks Pembangunan Manusia (IPM)
5. Gini Ratio
6. Perumahan & Sanitasi
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Jumlah penduduk berdasarkan proyeksi...",
            2: "Jawaban: Laju pertumbuhan penduduk...",
            3: "Jawaban: Tingkat kemiskinan diukur...",
            4: "Jawaban: IPM mencerminkan kualitas manusia...",
            5: "Jawaban: Gini Ratio menunjukkan ketimpangan...",
            6: "Jawaban: Kondisi perumahan dan sanitasi...",
            0: "menu_konsultasi",
        },
    },

    menu_pertanian: {
        text: `🌾 *Pertanian, Perikanan & Kehutanan*\n
1. Nilai Tukar Petani (NTP)
2. Produksi Padi
3. Produksi Hortikultura
4. Produksi Perikanan
5. Luas Lahan Pertanian
6. Kehutanan
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Nilai Tukar Petani (NTP) merupakan indikator kesejahteraan petani yang membandingkan indeks harga yang diterima dan dibayar petani.",
            2: "Jawaban: BPS menyediakan data produksi padi tahunan dan musiman berdasarkan hasil Survei Kerangka Sampel Area (KSA).",
            3: "Jawaban: Data hortikultura mencakup produksi sayur dan buah utama yang dipublikasikan secara berkala oleh BPS.",
            4: "Jawaban: Statistik perikanan meliputi produksi perikanan tangkap dan budidaya.",
            5: "Jawaban: Data luas lahan pertanian mencakup sawah dan non-sawah hasil pendataan BPS.",
            6: "Jawaban: Statistik kehutanan mencakup luas kawasan hutan dan hasil hutan tertentu.",
            0: "menu_konsultasi",
        },
    },
    menu_industri: {
        text: `🏭 *Industri & Energi*\n
1. Industri Manufaktur
2. Industri Pengolahan
3. Produksi Listrik
4. Konsumsi Energi
5. Indeks Produksi Industri
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Statistik industri manufaktur mencakup jumlah usaha, tenaga kerja, dan nilai produksi.",
            2: "Jawaban: Industri pengolahan merupakan salah satu sektor utama penyumbang PDRB.",
            3: "Jawaban: Data produksi listrik dipublikasikan BPS berdasarkan laporan instansi terkait.",
            4: "Jawaban: Statistik konsumsi energi mencakup penggunaan listrik dan bahan bakar.",
            5: "Jawaban: Indeks Produksi Industri menggambarkan perkembangan output sektor industri.",
            0: "menu_konsultasi",
        },
    },
    menu_infrastruktur: {
        text: `🏗️ *Infrastruktur & Konstruksi*\n
1. Indeks Kemahalan Konstruksi
2. Panjang Jalan
3. Bangunan & Perumahan
4. Proyek Konstruksi
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Indeks Kemahalan Konstruksi (IKK) menggambarkan tingkat kesulitan pembangunan konstruksi antar daerah.",
            2: "Jawaban: Data panjang jalan mencakup jalan nasional, provinsi, dan kabupaten/kota.",
            3: "Jawaban: Statistik perumahan mencakup kondisi bangunan dan kepemilikan rumah.",
            4: "Jawaban: Data proyek konstruksi bersumber dari Survei Konstruksi BPS.",
            0: "menu_konsultasi",
        },
    },
    menu_tenagakerja: {
        text: `💼 *Ketenagakerjaan*\n
1. Tingkat Pengangguran Terbuka (TPT)
2. Angkatan Kerja
3. Status Pekerjaan
4. Upah Pekerja
5. Jam Kerja
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: TPT menunjukkan persentase angkatan kerja yang belum bekerja.",
            2: "Jawaban: Angkatan kerja mencakup penduduk usia kerja yang bekerja dan mencari kerja.",
            3: "Jawaban: Status pekerjaan meliputi pekerja formal dan informal.",
            4: "Jawaban: Statistik upah mencerminkan rata-rata pendapatan pekerja.",
            5: "Jawaban: Data jam kerja digunakan untuk melihat tingkat produktivitas tenaga kerja.",
            0: "menu_konsultasi",
        },
    },
    menu_pendidikan: {
        text: `📚 *Pendidikan*\n
1. Angka Partisipasi Sekolah
2. Rata-rata Lama Sekolah
3. Harapan Lama Sekolah
4. Pendidikan Tertinggi
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Angka Partisipasi Sekolah menunjukkan persentase penduduk yang masih bersekolah.",
            2: "Jawaban: Rata-rata Lama Sekolah mencerminkan tingkat pendidikan penduduk.",
            3: "Jawaban: Harapan Lama Sekolah menggambarkan peluang pendidikan anak di masa depan.",
            4: "Jawaban: Data pendidikan tertinggi menunjukkan jenjang pendidikan yang telah ditamatkan.",
            0: "menu_konsultasi",
        },
    },
    menu_kesehatan: {
        text: `🏥 *Kesehatan*\n
1. Angka Harapan Hidup
2. Akses Fasilitas Kesehatan
3. Jaminan Kesehatan
4. Status Gizi
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Angka Harapan Hidup merupakan indikator kesehatan masyarakat.",
            2: "Jawaban: Data fasilitas kesehatan mencakup rumah sakit dan puskesmas.",
            3: "Jawaban: Statistik jaminan kesehatan menunjukkan cakupan kepesertaan penduduk.",
            4: "Jawaban: Data status gizi digunakan untuk melihat kualitas kesehatan penduduk.",
            0: "menu_konsultasi",
        },
    },

    menu_lingkungan: {
        text: `🌍 *Lingkungan & Iklim*\n
1. Kualitas Lingkungan Hidup
2. Curah Hujan
3. Perubahan Iklim
4. Pengelolaan Sampah
0. ↩️ Kembali`,
        options: {
            1: "Jawaban: Indeks Kualitas Lingkungan Hidup menggambarkan kondisi lingkungan suatu wilayah.",
            2: "Jawaban: Data curah hujan diperoleh dari instansi meteorologi dan dipublikasikan BPS.",
            3: "Jawaban: Statistik perubahan iklim mencakup tren suhu dan curah hujan.",
            4: "Jawaban: Data pengelolaan sampah mencakup sistem dan volume sampah.",
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
    host: "127.0.0.1",
    user: "root",
    password: "",
    database: "project_akhir",
    port: 3306,
});

// ====== WhatsApp Client Init ======
const client = new Client({
    authStrategy: new LocalAuth({
        dataPath: "./.wwebjs_auth",
    }),
    puppeteer: {
        headless: false, // WAJIB false (penting!)
        args: [
            "--no-sandbox",
            "--disable-setuid-sandbox",
            "--disable-dev-shm-usage",
            "--disable-gpu",
        ],
    },
});

client.on("qr", async (qr) => {
    await QRCode.toFile("./qr_code.png", qr, { scale: 8 });
    console.log("✅ Scan QR Code yang telah dibuat di file ./qr_code.png");
});
client.on("ready", () => console.log("✅ WhatsApp client siap digunakan!"));
function isMenuInput(text) {
    return /^[0-9]+$/.test(text);
}

// ====== Message Handler Utama ======
client.on("message", async (message) => {
    if (message.from === "status@broadcast") return;
    if (!message.from.endsWith("@c.us")) return;
    if (message.from.endsWith("@g.us")) return;
    const from = message.from;
    const text = message.body.trim().toLowerCase();
    const currentState = userStates[from];
    try {
        const phoneNumber = from.split("@")[0];

        const [users] = await db.query("SELECT id FROM users WHERE no_hp = ?", [
            phoneNumber,
        ]);

        if (users.length === 0) {
            console.log(`Abaikan nomor tidak terdaftar: ${phoneNumber}`);
            return;
        }
    } catch (err) {
        console.error("DB Error:", err.message);
        return;
    }

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
        return;
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
            return;
        } else if (nextState.startsWith("Jawaban:")) {
            await client.sendMessage(from, nextState.replace("Jawaban: ", ""));
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
    // ====== NLP HANDLER ======
    const nlpResponse = getNlpResponse(text);
    if (nlpResponse) {
        if (nlpResponse === "MENU_CHATBOT") {
            userStates[from] = "chatbot";
            await client.sendMessage(from, menus.chatbot.text);
        } else {
            await client.sendMessage(from, nlpResponse);
        }
        return;
    }
});

client
    .initialize()
    .catch((err) => console.error("❌ Gagal inisialisasi WhatsApp:", err));

// ====== Notifikasi Terjadwal ======
setInterval(async () => {
    if (!clientReady) {
        console.log("⏳ Client belum siap, lewati pengecekan notifikasi");
        return;
    }

    try {
        const [rows] = await db.query(
            "SELECT * FROM notifikasi_wa WHERE status = 'pending' LIMIT 5"
        );

        if (rows.length === 0) return;

        console.log(`Ditemukan ${rows.length} notifikasi untuk dikirim.`);

        for (const notif of rows) {
            const nomor = notif.no_hp.startsWith("62")
                ? notif.no_hp
                : `62${notif.no_hp.replace(/^0/, "")}`;

            const chatId = await client.getNumberId(nomor);

            if (!chatId) {
                console.log(`❌ Nomor WA tidak valid: ${nomor}`);
                await db.query(
                    "UPDATE notifikasi_wa SET status = 'failed' WHERE id = ?",
                    [notif.id]
                );
                continue;
            }

            await client.sendMessage(chatId._serialized, notif.pesan);

            await db.query(
                "UPDATE notifikasi_wa SET status = 'sent' WHERE id = ?",
                [notif.id]
            );

            console.log(`📤 Notifikasi terkirim ke ${nomor}`);
        }
    } catch (err) {
        console.error("❌ Gagal mengirim notifikasi:", err.message);
    }
}, 10000);

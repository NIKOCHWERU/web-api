<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $articles = [
            [
                'title' => "Pentingnya Legalitas Bisnis untuk UMKM",
                'content' => "
                    <p>Legalitas usaha adalah fondasi utama bagi setiap pelaku bisnis, termasuk Usaha Mikro, Kecil, dan Menengah (UMKM). Banyak pelaku UMKM yang masih menganggap bahwa mengurus izin usaha adalah proses yang rumit dan mahal. Padahal, di era digital saat ini, pemerintah telah mempermudah proses perizinan melalui sistem Online Single Submission (OSS).</p>
                    
                    <h3>Mengapa Legalitas Itu Penting?</h3>
                    <p>Beberapa alasan mengapa legalitas sangat penting antara lain:</p>
                    <ul>
                        <li><strong>Perlindungan Hukum:</strong> Usaha Anda memiliki payung hukum yang kuat jika terjadi sengketa di kemudian hari.</li>
                        <li><strong>Akses Permodalan:</strong> Lembaga keuangan seperti bank mewajibkan adanya dokumen legalitas bagi pelaku usaha yang ingin mengajukan kredit.</li>
                        <li><strong>Meningkatkan Kepercayaan Konsumen:</strong> Konsumen dan mitra bisnis lebih percaya untuk bekerja sama dengan usaha yang memiliki identitas resmi.</li>
                        <li><strong>Fasilitas Pemerintah:</strong> Banyak program bantuan dan pembinaan dari pemerintah yang dikhususkan bagi UMKM yang sudah berizin.</li>
                    </ul>
                    <p>Segera urus Nomor Induk Berusaha (NIB) Anda untuk memastikan bisnis Anda tumbuh secara berkelanjutan dan profesional.</p>
                ",
                'image' => "https://images.unsplash.com/photo-1589829545856-d10d557cf95f?auto=format&fit=crop&w=1200&q=80",
                'is_published' => true,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => "Memahami Proses Litigasi di Pengadilan",
                'content' => "
                    <p>Menghadapi sengketa hukum di pengadilan bisa menjadi pengalaman yang menegangkan jika Anda tidak memahami prosedurnya. Litigasi adalah proses penyelesaian sengketa melalui jalur pengadilan, di mana hakim akan memutuskan perkara berdasarkan bukti-bukti yang diajukan.</p>
                    <h3>Tahapan Litigasi Perdata</h3>
                    <p>Tahapan umum dalam litigasi perdata meliputi:</p>
                    <ol>
                        <li><strong>Pendaftaran Gugatan:</strong> Penggugat mengajukan berkas ke pengadilan yang berwenang.</li>
                        <li><strong>Mediasi:</strong> Tahapan wajib di mana kedua belah pihak mencoba berdamai dengan bantuan mediator hakim.</li>
                        <li><strong>Pembacaan Gugatan & Jawaban:</strong> Jika mediasi gagal, persidangan masuk ke pokok perkara.</li>
                        <li><strong>Pembuktian:</strong> Tahap krusial untuk mengajukan bukti surat, saksi, maupun saksi ahli.</li>
                        <li><strong>Kesimpulan & Putusan:</strong> Hakim memberikan penilaian akhir atas perkara tersebut.</li>
                    </ol>
                    <p>Persiapan yang matang dan dokumentasi yang lengkap adalah kunci utama dalam menghadapi proses litigasi. Konsultasikan dengan tenaga profesional untuk memastikan hak-hak hukum Anda terlindungi dengan maksimal.</p>
                ",
                'image' => "https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=1200&q=80",
                'is_published' => true,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => "Cara Membuat Kontrak Bisnis yang Aman",
                'content' => "
                    <p>Kontrak atau perjanjian adalah 'undang-undang' bagi pihak-pihak yang membuatnya. Dalam dunia bisnis, kontrak tertulis sangat vital untuk menghindari interpretasi yang berbeda di masa mendatang.</p>
                    <h3>Kriteria Kontrak Bisnis yang Kuat</h3>
                    <ul>
                        <li><strong>Identitas Lengkap:</strong> Pastikan subjek hukum (pihak yang bertanda tangan) memiliki kewenangan yang sah.</li>
                        <li><strong>Objek Perjanjian:</strong> Jelaskan secara mendetail apa yang menjadi hak dan kewajiban masing-masing pihak.</li>
                        <li><strong>Klausul Wanprestasi:</strong> Tentukan apa yang terjadi jika salah satu pihak gagal memenuhi janji, termasuk denda atau sanksi.</li>
                        <li><strong>Penyelesaian Sengketa:</strong> Tentukan tempat penyelesaian masalah, apakah melalui negosiasi, arbitrase, atau pengadilan tertentu.</li>
                    </ul>
                    <p>Jangan pernah menandatangani kontrak yang tidak Anda pahami sepenuhnya. Review hukum oleh profesional dapat menyelamatkan bisnis Anda dari kerugian besar di masa depan.</p>
                ",
                'image' => "https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1200&q=80",
                'is_published' => true,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => "Perlindungan Konsumen di Era Digital",
                'content' => "
                    <p>Belanja online memberikan kemudahan, namun juga menyimpan risiko. Sebagai konsumen, Anda dilindungi oleh Undang-Undang Perlindungan Konsumen (UUPK).</p>
                    <h3>Hak-Hak Utama Konsumen</h3>
                    <ul>
                        <li>Hak atas informasi yang benar, jelas, dan jujur mengenai kondisi barang/jasa.</li>
                        <li>Hak untuk mendapatkan keamanan dan keselamatan dalam mengonsumsi barang/jasa.</li>
                        <li>Hak untuk didengar pendapat dan keluhannya.</li>
                        <li>Hak untuk mendapatkan kompensasi atau ganti rugi jika barang yang diterima tidak sesuai.</li>
                    </ul>
                    <p>Jika Anda merasa dirugikan dalam transaksi digital, simpan semua bukti percakapan dan bukti pembayaran. Anda dapat melapor ke Badan Penyelesaian Sengketa Konsumen (BPSK).</p>
                ",
                'image' => "https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&w=1200&q=80",
                'is_published' => true,
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => "Panduan Lengkap Hak Waris",
                'content' => "
                    <p>Hukum waris di Indonesia memiliki dualisme, yaitu Hukum Waris Islam dan Hukum Waris Perdata (KUHPerdata). Pemilihan hukum yang berlaku tergantung pada keyakinan dan kesepakatan keluarga.</p>
                    <h3>Poin Penting Pembagian Warisan</h3>
                    <ol>
                        <li><strong>Ahli Waris:</strong> Siapa saja yang masuk dalam urutan utama penerima warisan.</li>
                        <li><strong>Harta Waris:</strong> Seluruh harta kekayaan pewaris setelah dikurangi utang-utang yang ada.</li>
                        <li><strong>Legitieme Portie:</strong> Bagian mutlak yang harus diterima oleh ahli waris tertentu menurut KUHPerdata.</li>
                    </ol>
                    <p>Penyusunan wasiat sejak dini atau konsultasi dengan ahli hukum dapat meminimalisir potensi konflik keluarga di kemudian hari terkait pembagian harta.</p>
                ",
                'image' => "https://images.unsplash.com/photo-1544027993-37dbfe43562a?auto=format&fit=crop&w=1200&q=80",
                'is_published' => true,
                'published_at' => now()->subDays(20),
            ],
        ];

        foreach ($articles as $article) {
            Article::updateOrCreate(
                ['slug' => Str::slug($article['title'])],
                [
                    'title' => $article['title'],
                    'content' => $article['content'],
                    'image' => $article['image'],
                    'is_published' => $article['is_published'],
                    'published_at' => $article['published_at'],
                ]
            );
        }
    }
}

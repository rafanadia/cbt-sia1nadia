<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $subjects = [
            [
                'name' => 'Bahasa Indonesia',
                'description' => 'Bahasa dan Sastra Indonesia',
            ],
            [
                'name' => 'IPS',
                'description' => 'Ilmu Pengetahuan Sosial',
            ],
            [
                'name' => 'Matematika',
                'description' => 'Matematika Dasar',
            ],
        ];

        foreach ($subjects as $subjectData) {

            $subjectId = DB::table('subjects')->insertGetId([
                'name' => $subjectData['name'],
                'description' => $subjectData['description'],
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            for ($i = 1; $i <= 150; $i++) {

                $question = $this->generateQuestion(
                    $subjectData['name'],
                    $i
                );

                $questionId = DB::table('questions')->insertGetId([
                    'subject_id' => $subjectId,
                    'title' => $question['title'],
                    'score' => 1,
                    'correct_answer' => $question['correct'],
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                foreach ($question['answers'] as $option => $answer) {
                    DB::table('answers')->insert([
                        'question_id' => $questionId,
                        'option' => $option,
                        'answer' => $answer,
                        'is_active' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    private function generateQuestion(string $subject, int $number): array
    {
        if ($subject === 'Bahasa Indonesia') {
            return $this->bahasaIndonesia($number);
        }

        if ($subject === 'IPS') {
            return $this->ips($number);
        }

        return $this->matematika($number);
    }

    private function bahasaIndonesia(int $number): array
    {
        $data = [
            [
                'title' => 'Kata yang memiliki makna berlawanan disebut ...',
                'answers' => [
                    'A' => 'Sinonim',
                    'B' => 'Antonim',
                    'C' => 'Homonim',
                    'D' => 'Hiponim',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Kata yang memiliki makna sama atau hampir sama disebut ...',
                'answers' => [
                    'A' => 'Sinonim',
                    'B' => 'Antonim',
                    'C' => 'Homonim',
                    'D' => 'Polisemi',
                ],
                'correct' => 'A',
            ],
            [
                'title' => 'Penulisan kata depan "ke" yang tepat adalah ...',
                'answers' => [
                    'A' => 'kerumah',
                    'B' => 'kesekolah',
                    'C' => 'ke rumah',
                    'D' => 'kePasar',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Kalimat yang digunakan untuk menanyakan sesuatu disebut kalimat ...',
                'answers' => [
                    'A' => 'Perintah',
                    'B' => 'Tanya',
                    'C' => 'Berita',
                    'D' => 'Seruan',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Gagasan utama yang menjadi dasar sebuah paragraf disebut ...',
                'answers' => [
                    'A' => 'Kalimat penjelas',
                    'B' => 'Kata kunci',
                    'C' => 'Ide pokok',
                    'D' => 'Kesimpulan',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Cerita yang tokohnya berupa binatang dan memiliki sifat seperti manusia disebut ...',
                'answers' => [
                    'A' => 'Legenda',
                    'B' => 'Fabel',
                    'C' => 'Mitos',
                    'D' => 'Cerpen',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Lawan kata dari "besar" adalah ...',
                'answers' => [
                    'A' => 'Tinggi',
                    'B' => 'Panjang',
                    'C' => 'Kecil',
                    'D' => 'Lebar',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Urutan peristiwa yang membentuk sebuah cerita disebut ...',
                'answers' => [
                    'A' => 'Tokoh',
                    'B' => 'Alur',
                    'C' => 'Latar',
                    'D' => 'Tema',
                ],
                'correct' => 'B',
            ],
        ];

        return $this->repeatQuestion($data, $number);
    }

    private function ips(int $number): array
    {
        $data = [
            [
                'title' => 'Kegiatan membeli dan menjual barang disebut kegiatan ...',
                'answers' => [
                    'A' => 'Produksi',
                    'B' => 'Distribusi',
                    'C' => 'Konsumsi',
                    'D' => 'Perdagangan',
                ],
                'correct' => 'D',
            ],
            [
                'title' => 'Kegiatan menghasilkan barang atau jasa disebut ...',
                'answers' => [
                    'A' => 'Produksi',
                    'B' => 'Konsumsi',
                    'C' => 'Distribusi',
                    'D' => 'Investasi',
                ],
                'correct' => 'A',
            ],
            [
                'title' => 'Orang yang menggunakan barang atau jasa disebut ...',
                'answers' => [
                    'A' => 'Produsen',
                    'B' => 'Distributor',
                    'C' => 'Konsumen',
                    'D' => 'Pedagang',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Indonesia disebut sebagai negara kepulauan karena ...',
                'answers' => [
                    'A' => 'Memiliki banyak gunung',
                    'B' => 'Terdiri atas banyak pulau',
                    'C' => 'Memiliki banyak sungai',
                    'D' => 'Memiliki wilayah yang luas',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Proklamasi Kemerdekaan Indonesia dibacakan pada tanggal ...',
                'answers' => [
                    'A' => '17 Agustus 1945',
                    'B' => '10 November 1945',
                    'C' => '1 Juni 1945',
                    'D' => '28 Oktober 1928',
                ],
                'correct' => 'A',
            ],
            [
                'title' => 'Organisasi ASEAN didirikan di kota ...',
                'answers' => [
                    'A' => 'Jakarta',
                    'B' => 'Bangkok',
                    'C' => 'Manila',
                    'D' => 'Kuala Lumpur',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Sumber daya alam yang dapat diperbarui adalah ...',
                'answers' => [
                    'A' => 'Minyak bumi',
                    'B' => 'Batu bara',
                    'C' => 'Gas alam',
                    'D' => 'Tumbuhan',
                ],
                'correct' => 'D',
            ],
            [
                'title' => 'Kegiatan menyalurkan barang dari produsen kepada konsumen disebut ...',
                'answers' => [
                    'A' => 'Produksi',
                    'B' => 'Distribusi',
                    'C' => 'Konsumsi',
                    'D' => 'Eksploitasi',
                ],
                'correct' => 'B',
            ],
        ];

        return $this->repeatQuestion($data, $number);
    }

    private function matematika(int $number): array
    {
        $data = [
            [
                'title' => 'Hasil dari 10 + 5 adalah ...',
                'answers' => [
                    'A' => '12',
                    'B' => '15',
                    'C' => '20',
                    'D' => '25',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Hasil dari 20 - 8 adalah ...',
                'answers' => [
                    'A' => '10',
                    'B' => '11',
                    'C' => '12',
                    'D' => '14',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Hasil dari 6 × 7 adalah ...',
                'answers' => [
                    'A' => '36',
                    'B' => '40',
                    'C' => '42',
                    'D' => '48',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Hasil dari 81 ÷ 9 adalah ...',
                'answers' => [
                    'A' => '7',
                    'B' => '8',
                    'C' => '9',
                    'D' => '10',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Hasil dari 15 + 25 adalah ...',
                'answers' => [
                    'A' => '30',
                    'B' => '35',
                    'C' => '40',
                    'D' => '45',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Jika x = 5, maka nilai 2x + 3 adalah ...',
                'answers' => [
                    'A' => '10',
                    'B' => '11',
                    'C' => '12',
                    'D' => '13',
                ],
                'correct' => 'B',
            ],
            [
                'title' => 'Luas persegi dengan sisi 5 cm adalah ...',
                'answers' => [
                    'A' => '10 cm²',
                    'B' => '20 cm²',
                    'C' => '25 cm²',
                    'D' => '30 cm²',
                ],
                'correct' => 'C',
            ],
            [
                'title' => 'Hasil dari 100 ÷ 4 adalah ...',
                'answers' => [
                    'A' => '20',
                    'B' => '25',
                    'C' => '30',
                    'D' => '40',
                ],
                'correct' => 'B',
            ],
        ];

        return $this->repeatQuestion($data, $number);
    }

    private function repeatQuestion(array $data, int $number): array
    {
        $index = ($number - 1) % count($data);
        $question = $data[$index];

        // Membuat nomor soal tetap unik
        if ($number > count($data)) {
            $question['title'] .= " (Soal nomor {$number})";
        }

        return $question;
    }
}
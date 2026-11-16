<?php

namespace Database\Seeders;

use App\Models\Story;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Story::updateOrCreate(
            ['slug' => 'senja-di-ujung-kota'],
            [
                'title' => 'Senja di Ujung Kota',
                'author' => 'Aurelia',
                'genre' => 'Romance',
                'synopsis' => 'Di tengah hiruk pikuk kota, dua orang asing bertemu dalam keadaan yang tidak pernah mereka rencanakan. Sebuah kisah tentang pertemuan, kehilangan, dan kesempatan kedua.',
                'content' => "Hujan baru saja berhenti ketika Aruna melangkah keluar dari stasiun. Langit sore berwarna jingga, dan jalanan mulai dipenuhi cahaya lampu kendaraan.\n\nIa tidak pernah menyangka bahwa seseorang yang pernah menjadi bagian dari masa lalunya akan kembali hadir di tempat yang sama. Di ujung jalan, seorang pria berdiri dengan payung hitam.\n\nNama itu masih sama. Begitu pula kenangan yang selama ini berusaha ia lupakan.",
                'status' => 'published',
            ]
        );

        Story::updateOrCreate(
            ['slug' => 'the-last-starlight'],
            [
                'title' => 'The Last Starlight',
                'author' => 'Elara Moon',
                'genre' => 'Fantasy',
                'synopsis' => 'Ketika bintang terakhir mulai menghilang, seorang gadis menemukan bahwa takdir dunia berada di tangannya.',
                'content' => "Pada malam ketika bintang terakhir menghilang dari langit, seluruh kerajaan terdiam.\n\nTidak ada seorang pun yang mengetahui alasan di balik kejadian itu, kecuali seorang gadis bernama Lyra. Di telapak tangannya terdapat cahaya kecil yang tidak pernah padam.\n\nCahaya itu adalah awal dari sebuah perjalanan yang akan mengubah segalanya.",
                'status' => 'published',
            ]
        );

        Story::updateOrCreate(
            ['slug' => 'the-silent-room'],
            [
                'title' => 'The Silent Room',
                'author' => 'Noah Reeve',
                'genre' => 'Mystery',
                'synopsis' => 'Sebuah kamar terkunci, sebuah surat tanpa nama, dan rahasia yang tersembunyi selama bertahun-tahun.',
                'content' => "Pukul sebelas malam, sebuah suara terdengar dari kamar nomor tujuh.\n\nAnehnya, kamar itu sudah terkunci selama lebih dari sepuluh tahun. Tidak ada penghuni, tidak ada jendela yang terbuka, dan tidak ada alasan bagi siapa pun untuk berada di dalamnya.\n\nNamun, ketika pintunya akhirnya berhasil dibuka, sebuah surat ditemukan di atas meja.",
                'status' => 'published',
            ]
        );
    }
}

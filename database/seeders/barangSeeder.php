<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; // untuk operasi file
use Carbon\Carbon;

class barangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sourcePath = public_path('build/assets/images/tensura');
        $destinationPath = storage_path('app/public/images');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $images = [
            "16f2be12f2f5e4f8681667042646.jpg",
            "37139852-a70a-480e-af8e-8921e670fd45.jpeg",
            "65aa78de-534e-4eda-a514-efa327de6dc4.jpeg",
            "Anime_Blu-ray_1.jpg",
            "Anime_Blu-ray_4.jpg",
            "Anime_Cover.jpg",
            "Anime_Season_3_Visual.jpg",
            "Anime_Visual_2.jpg",
            "Blu-ray_S2_1_29.jpg",
            "Blu-ray_S2_2.jpg",
            "Blu-ray_S2_3.jpg",
            "Blu-ray_S2_4.jpg",
            "Coleus_Dream_Key_Visual.jpg",
            "fposter,small,wall_texture,product,750x1000.jpg",
            "Guren_no_kizuna-Hen_Promotional_Poster.jpg",
            "Guren_no_Kizuna-hen_Promotional_Poster_2.jpg",
            "Movie_Key_Visual.jpg",
            "OAD_3_Visual.jpg",
            "Promo_visual.jpg",
            "Rimuru Tempest - Tensei Shitara Slime Datta Ken Wallpaper.jpeg",
            "Rimuru Tempest _ Stats and skills _ Light novel Vol_16.jpeg",
            "Rimuru Tempest.jpeg",
            "Rimuru.jpeg",
            "Rimururu Tempest.jpeg",
            "Season_2_Anime_Visual.jpg",
            "Season_2_Anime_Visual_2.jpg",
            "Season_2_Lunar_New_Year_Visual.jpg",
            "Season_2_Part_2_Visual.jpg",
            "Season_2_Visual_4.jpg",
            "That_Time_I_Got_Reincarnated_as_a_Slime_Visual.jpg",
            "The_Slime_Diaries_Anime_Blu-ray_1.jpg",
            "The_Slime_Diaries_Anime_Blu-ray_2.jpg",
            "The_Slime_Diaries_Anime_DVD_1.jpg",
        ];

        $names = [
            "Rimuru Tempest Figure",
            "Diablo Premium Statue",
            "Shuna Limited Edition Poster",
            "Benimaru Art Card",
            "Milim Nava Blu-ray",
            "Shion Special Illustration",
            "Veldora Wall Art",
            "Hinata Sakaguchi Visual",
            "Tempest Federation Emblem",
            "Rimuru Light Novel Collection",
            "Coleus Dream Key Visual",
            "Seasonal Anime Visual Set",
            "Rimuru Exclusive Print",
            "Tensura Key Visual",
            "Tensura Promotional Poster",
            "Rimuru Training Visual",
            "Rimuru Awakening Edition",
            "Milim Battle Art",
            "Rimuru Demon Lord Arc Poster",
            "Rimuru OAD Visual Card",
            "Kizuna-hen Promo Poster",
            "Tempest Festival Visual",
            "Blu-ray Tensura Special",
            "Anime Cover Tensura",
            "Tensura Vol.19 Illustration",
        ];

        $deskripsi = [
            "Barang koleksi eksklusif dari anime Tensura.",
            "Merchandise original dengan kualitas premium.",
            "Edisi terbatas yang sulit ditemukan.",
            "Item collector's edition dengan detail tinggi.",
            "Produk resmi dari seri Tensura.",
            "Koleksi seni visual dari dunia Tensura.",
            "Blu-ray premium dengan cover eksklusif.",
            "Poster berkualitas tinggi edisi spesial.",
        ];

        $data = [];

        foreach ($images as $img) {
            $sourceFile = $sourcePath . '/' . $img;
            $destFile = $destinationPath . '/' . $img;
            if (File::exists($sourceFile)) {
                File::copy($sourceFile, $destFile);
            } else {
                continue;
            }

            $data[] = [
                "nama_barang"       => $names[array_rand($names)],
                "tgl_masuk"         => now()->subDays(rand(0, 10)),
                "harga_awal"        => rand(100_000, 5_000_000),
                "deskripsi_barang"  => $deskripsi[array_rand($deskripsi)],
                "gambar"            => "images/" . $img,
                "created_at"        => now(),
                "updated_at"        => now(),
            ];
        }
        DB::table("barangs")->insert($data);
    }
}

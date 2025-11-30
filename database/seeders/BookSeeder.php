<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $title = [ 
            'The Great Adventure',
            'Mystery of the Lost City',
            'Journey to the Unknown',
            'Secrets of the Ancient World',
            'Tales of the Enchanted Forest',
            'Legends of the Hidden Temple',
            'Chronicles of the Brave Hero',
            'Whispers in the Dark',
            'Echoes of the Past',
            'Voices from Beyond',
            'Shadows of the Night',
            'Dreams of Tomorrow',
            'Wonders of the Universe',
            'Paths of Destiny',
            'Lights in the Sky',
            'Zelda and the Lost Kingdom',
            'The Enchanted Garden',
            'Pokemon: Journey to the Elite Four',
            'The Secret of the Magic Sword',
            'Adventures in Neverland'
        ];

        foreach ($title as $bookTitle) {
            Book::create([
                'title' => $bookTitle,
                'description' => fake('id_ID')->paragraph(),
                'price' => fake('id_ID')->randomFloat(2, 50000, 100000),
            ]);
        }
    }
}

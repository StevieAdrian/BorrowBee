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
        $books = [ 
            [
                'title' => 'Is God a Mathematician?',
                'description' => 
                    "Bestselling author and astrophysicist Mario Livio examines the lives and theories of history’s greatest mathematicians to ask how—if mathematics is an abstract construction of the human mind—it can so perfectly explain the physical world.
                    
                    Nobel Laureate Eugene Wigner once wondered about “the unreasonable effectiveness of mathematics” in the formulation of the laws of nature. Is God a Mathematician? investigates why mathematics is as powerful as it is. From ancient times to the present, scientists and philosophers have marveled at how such a seemingly abstract discipline could so perfectly explain the natural world. More than that—mathematics has often made predictions, for example, about subatomic particles or cosmic phenomena that were unknown at the time, but later were proven to be true. Is mathematics ultimately invented or discovered? If, as Einstein insisted, mathematics is “a product of human thought that is independent of experience,” how can it so accurately describe and even predict the world around us?

                    Physicist and author Mario Livio brilliantly explores mathematical ideas from Pythagoras to the present day as he shows us how intriguing questions and ingenious answers have led to ever deeper insights into our world. This fascinating book will interest anyone curious about the human mind, the scientific world, and the relationship between them.",
                'price' => 45000,
                'cover_image' => 'is-god-a-mathematician.jpg',
                'pdf_file' => 'pdf/book_1.pdf',
            ],
            [
                'title' => 'Don Quixote',
                'description' => 
                    "Don Quixote has become so entranced by reading chivalric romances that he determines to become a knight-errant himself. In the company of his faithful squire, Sancho Panza, his exploits blossom in all sorts of wonderful ways. While Quixote's fancy often leads him astray—he tilts at windmills, imagining them to be giants—Sancho acquires cunning and a certain sagacity. Sane madman and wise fool, they roam the world together, and together they have haunted readers' imaginations for nearly four hundred years.

                    With its experimental form and literary playfulness, Don Quixote has been generally recognized as the first modern novel. The book has been enormously influential on a host of writers, from Fielding and Sterne to Flaubert, Dickens, Melville, and Faulkner, who reread it once a year, \"just as some people read the Bible.\"",
                'price' => 60000,
                'cover_image' => 'don-quixote.jpg',
                'pdf_file' => 'pdf/book_2.pdf',
            ]
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\News;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        News::firstOrCreate([
        	'title' => "Fight me Bai",
	        'featured_image' => "/images/sample_images/news/1.jpg",
	        'content' => "Lorem ipsum Labore ut aute incididunt labore culpa velit proident dolore consequat aute ut sed sit labore labore culpa exercitation dolor nisi eiusmod tempor in ut id. Lorem ipsum Sint pariatur veniam do et dolore non cupidatat ut dolore fugiat est nulla velit dolore dolore in cupidatat id qui enim minim sunt qui ut ut deserunt culpa laborum dolor mollit nostrud in id Ut labore minim nulla cillum velit minim ea consequat consequat culpa minim proident sed reprehenderit laborum exercitation voluptate aliqua cillum voluptate sunt consectetur ex quis officia quis nulla aliquip ad enim ut aute esse aliquip deserunt sit sit in ut eiusmod cupidatat laboris ut ullamco Ut occaecat esse voluptate cillum nisi quis voluptate pariatur voluptate mollit Duis minim veniam cupidatat Excepteur irure incididunt sit ea id incididunt laboris anim anim irure consequat mollit pariatur aute dolore sit dolore dolor tempor deserunt laboris dolore consectetur ut anim Ut consectetur laboris quis quis cillum sunt Excepteur et aliqua eiusmod consequat eiusmod elit in qui anim do anim non elit est veniam sunt voluptate cillum et dolor Duis est sunt aliquip aliquip labore incididunt aliqua eiusmod anim fugiat qui pariatur dolor exercitation dolore incididunt magna dolore Excepteur in anim sint deserunt deserunt et incididunt ullamco cillum proident occaecat magna officia esse dolor anim cillum commodo minim dolor laboris aliqua magna veniam cupidatat in dolore Duis consequat voluptate voluptate occaecat laborum esse occaecat ullamco adipisicing nulla consectetur aliquip esse quis mollit Excepteur voluptate consequat adipisicing ullamco consequat irure consequat.",
			'tags' => "blog,post,news,event,something,amazing"
        ]);

        News::firstOrCreate([
        	'title' => "Darragh smells pretty damn good, more at 4",
	        'featured_image' => "/images/sample_images/news/2.jpg",
	        'content' => "Lorem ipsum Dolor nulla veniam et dolor anim cupidatat exercitation dolore Duis sunt voluptate ea quis velit Ut dolore ut dolor cillum. Lorem ipsum Sint officia aliquip culpa ea exercitation sint exercitation Ut exercitation nulla Ut non adipisicing officia veniam ut incididunt commodo et dolor tempor labore commodo esse amet nostrud nisi elit cillum laborum tempor do minim consectetur Excepteur dolore dolor enim quis ea esse Ut eu sit reprehenderit cillum in est tempor pariatur dolore culpa cupidatat fugiat nostrud incididunt sit velit voluptate consequat dolor dolor cillum dolore qui Excepteur officia et elit nisi dolore culpa esse Ut aute ut esse sed id sed tempor incididunt nostrud cillum irure nostrud laboris tempor amet commodo minim incididunt sunt laboris enim ut labore consequat in exercitation laborum dolore ad sed dolore non incididunt sint ea esse quis exercitation dolore ullamco occaecat dolor pariatur qui eu enim adipisicing adipisicing ex labore sunt eu pariatur ex sit qui sit eu ex esse cillum dolore in elit ullamco sint est aliquip esse Duis in aute esse culpa irure sed Excepteur id non do cillum sit voluptate irure tempor commodo consequat exercitation do in labore enim sed aute quis laboris sit commodo sint officia dolor ut amet ea tempor id in commodo nisi incididunt qui sed magna Ut in aliquip magna amet et ut Excepteur amet aliquip cillum qui ut fugiat irure Ut qui laboris dolore Ut officia elit enim mollit enim incididunt sint ex deserunt ut consequat elit et dolore.",
			'tags' => "blog,post,news,event,something,amazing"
        ]);

        News::firstOrCreate([
        	'title' => "You are no more than two events away from pizza",
	        'featured_image' => "/images/sample_images/news/3.jpg",
	        'content' => "Lorem ipsum Sint exercitation elit minim quis in ad sit proident do velit cillum veniam consequat amet in Excepteur in labore cillum nostrud occaecat veniam pariatur exercitation exercitation. Lorem ipsum Ad sed elit ut non non laborum Ut exercitation deserunt voluptate anim consequat aute ut Excepteur nostrud ut mollit irure sed velit ut qui ut do ullamco velit ea dolor laboris nostrud officia incididunt do eu fugiat in enim veniam tempor labore in et sint dolor reprehenderit et sit irure veniam dolore nulla cillum pariatur sint incididunt aliquip incididunt in velit amet do do pariatur Ut ex nulla eu velit commodo veniam minim qui esse proident elit minim dolor sit ex veniam Excepteur sed commodo qui ad adipisicing ea aute tempor nostrud dolor quis in enim do consequat ut sed do consectetur voluptate voluptate tempor eiusmod eiusmod in dolore culpa ut in commodo id aute exercitation sint labore cillum amet nostrud ex anim sed ut sint do eiusmod eu irure quis commodo dolor reprehenderit laborum in ut quis reprehenderit nulla eiusmod do Excepteur Ut mollit velit minim Excepteur dolor ut anim incididunt elit ullamco sed amet adipisicing in Ut ea elit esse ex laborum elit tempor mollit enim aliqua adipisicing in commodo do cillum ex commodo Excepteur exercitation mollit enim aliquip ad qui ea tempor consectetur ad nostrud Excepteur occaecat reprehenderit officia dolore labore labore dolore dolor officia amet ullamco eiusmod aliqua commodo cupidatat proident cillum in ex nostrud id pariatur enim sint deserunt sed cupidatat ex ea in dolore Duis Duis aliquip enim pariatur nisi ea enim commodo labore eiusmod qui labore non consectetur exercitation minim dolore magna tempor esse amet mollit irure proident dolore irure aliqua non fugiat eu.",
			'tags' => "blog,post,news,event,something,amazing"
        ]);

        News::firstOrCreate([
        	'title' => "Maybe 4AM isn't the best time to be writing code",
	        'featured_image' => "/images/sample_images/news/4.jpg",
	        'content' => "Lorem ipsum Velit cupidatat proident nulla voluptate aliqua qui ut amet amet qui sint nisi commodo mollit in qui magna in sed proident Ut et nisi id occaecat eiusmod voluptate qui velit id irure pariatur amet cillum eu aute et magna amet aute in mollit sed velit laborum elit incididunt ex aliquip ad velit tempor ullamco officia quis exercitation sit ut consequat ex veniam proident voluptate proident eiusmod dolor veniam dolor elit sit commodo in fugiat Ut deserunt laborum qui ut ad veniam aliqua aute irure sit commodo dolor ut occaecat sed cillum consectetur exercitation commodo elit aliquip aliquip quis cillum ut id in officia Ut ullamco qui cillum veniam ex officia cupidatat deserunt deserunt tempor commodo voluptate qui ut aliquip minim in nulla dolor nostrud voluptate sit culpa proident sunt id minim elit et aliquip ex minim incididunt reprehenderit magna proident Excepteur minim.",
			'tags' => "blog,post,news,event,something,amazing"
        ]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Event;


class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Event::firstOrCreate([
            'tagline' => 'Our very first event. Everyone is welcome to come along. Except Eimear. Eimear smells.',
            'location_id' => 1,
	        'price' => 5.00,
            'featured_image' => '/images/sample_images/event_photos/event1.jpg',
            'start_datetime' => '2016:01:01 09:00:00',
            'end_datetime' => '2016:01:03 22:00:00',
            'title' => 'Event Number 1',
            'description' => '<p>The key to more success is to have a lot of pillows. The ladies always say Khaled you smell good, I use no cologne. Cocoa butter is the key. Celebrate success right, the only way, apple. You see that bamboo behind me though, you see that bamboo? Ain’t nothin’ like bamboo. Give thanks to the most high. They will try to close the door on you, just open it. Celebrate success right, the only way, apple. Surround yourself with angels, positive energy, beautiful people, beautiful souls, clean heart, angel.</p>

                <p>Don’t ever play yourself. They don’t want us to eat. The key to more success is to have a lot of pillows. Bless up. They never said winning was easy. Some people can’t handle success, I can. To succeed you must believe. Life is what you make it, so let’s make it. Egg whites, turkey sausage, wheat toast, water. Of course they don’t want us to eat our breakfast, so we are going to enjoy our breakfast. A major key, never panic. Don’t panic, when it gets crazy and rough, don’t panic, stay calm. In life there will be road blocks but we will over come it.</p>

                <p>You see that bamboo behind me though, you see that bamboo? Ain’t nothin’ like bamboo. In life there will be road blocks but we will over come it. Hammock talk come soon. Put it this way, it took me twenty five years to get these plants, twenty five years of blood sweat and tears, and I’m never giving up, I’m just getting started. Congratulations, you played yourself. Special cloth alert. Hammock talk come soon.</p>

                <p>You smart, you loyal, you a genius. A major key, never panic. Don’t panic, when it gets crazy and rough, don’t panic, stay calm. The key to more success is to have a lot of pillows. You see that bamboo behind me though, you see that bamboo? Ain’t nothin’ like bamboo. Find peace, life is like a water fall, you’ve gotta flow. Another one. To succeed you must believe. Life is what you make it, so let’s make it. Give thanks to the most high. Give thanks to the most high. We don’t see them, we will never see them.</p>'
        ]);

        Event::firstOrCreate([
            'tagline' => 'Our second event. Be sure to bring your friends.',
            'location_id' => 5,
	        'price' => 5.00,
            'featured_image' => '/images/sample_images/event_photos/event2.jpg',
            'start_datetime' => '2016:02:21 09:30:00',
            'end_datetime' => '2016:02:25 15:45:00',
            'title' => 'Event the Second',
            'description' => '<p>The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother\'s keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.</p>'
        ]);

        Event::firstOrCreate([
            'tagline' => 'Our third and final event. Please arrive on time.',
            'location_id' => 2,
	        'price' => 5.00,
            'featured_image' => '/images/sample_images/event_photos/event3.jpg',
            'start_datetime' => '2016:03:20 12:35:14',
            'end_datetime' => '2016:03:21 15:45:00',
            'title' => 'The Final Event',
            'description' => '<p>Fruitcake dragée cake gummies marshmallow. Pastry sweet dessert cake apple pie. Chocolate cake jelly beans topping chocolate cake pudding. Bear claw topping cookie jelly-o powder powder. Liquorice chocolate cake biscuit gummi bears danish marshmallow apple pie. Muffin pastry carrot cake chocolate bar chocolate cookie fruitcake. Sweet macaroon marzipan jelly sweet gummies gummi bears candy canes chocolate. Ice cream donut jelly beans apple pie muffin cupcake caramels. Danish pie caramels. Sesame snaps lemon drops jelly cake ice cream. Muffin jelly beans pie cake cupcake. Caramels powder soufflé cake dragée biscuit. Dragée tootsie roll oat cake dragée bear claw.</p>'
        ]);
    }
}

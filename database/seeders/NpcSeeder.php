<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Npc;
use App\Models\Occupation;
use App\Models\Tile;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class NpcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tile1 = Tile::where('psuedo_id', '0,0')->first();

        $buildings = [
            $farmhouse = Building::create([
                'name' => 'Farmhouse',
                'description' => 'An average sized farmhouse.',
                'zone_id' => $farmhouse_zone = Zone::create([
                    'name' => 'Farmhouse',
                    'description' => 'Generic farmhouses.',
                    'is_shop' => false,
                    'is_pub' => false,
                    'is_house' => false,
                    'is_bed' => false,
                    'is_accessible' => true,
                    'is_locked' => false,
                    'is_pilferable' => false,
                ])->id,
            ]),
            $church = Building::create([
                'name' => 'Church',
                'description' => 'A basic wooden church.',
                'zone_id' => Zone::create([
                    'name' => 'Church',
                    'description' => 'Generic, basic churches.',
                    'is_shop' => false,
                    'is_pub' => false,
                    'is_house' => false,
                    'is_bed' => false,
                    'is_accessible' => true,
                    'is_locked' => false,
                    'is_pilferable' => false,
                ])->id,
            ]),
            $bar = Building::create([
                'name' => 'Bar',
                'description' => 'A bar that looks like it has been around a while.',
                'zone_id' => Zone::create([
                    'name' => 'Bar',
                    'description' => 'Places to acquire a drink.',
                    'is_shop' => false,
                    'is_pub' => true,
                    'is_house' => false,
                    'is_bed' => false,
                    'is_accessible' => true,
                    'is_locked' => false,
                    'is_pilferable' => true,
                ])->id,
            ]),
            $shop = Building::create([
                'name' => 'Shop',
                'description' => 'A generic, basic shop.',
                'zone_id' => Zone::create([
                    'name' => 'Shop',
                    'description' => 'Generic, basic shops.',
                    'is_shop' => true,
                    'is_pub' => false,
                    'is_house' => false,
                    'is_bed' => false,
                    'is_accessible' => true,
                    'is_locked' => false,
                    'is_pilferable' => true,
                ])->id,
            ]),
        ];

        $medieval_tower_zone = Zone::create([
            'name' => 'Medieval Tower',
            'description' => 'A tall, ancient tower made of stone.',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => false,
            'is_bed' => false,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $humble_hut_zone = Zone::create([
            'name' => 'Humble Hut',
            'description' => 'A small, humble hut made of wood.',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => true,
            'is_bed' => true,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $house_zone = Zone::create([
            'name' => 'House',
            'description' => 'Generic, basic houses. Resting is available here.',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => true,
            'is_bed' => true,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $house = Building::create([
            'name' => 'House',
            'description' => 'A standard wooden house.',
            'zone_id' => $house_zone->id,
        ]);
        $rundown_house = Building::create([
            'name' => 'Abandoned House',
            'description' => 'A rundown wooden house.',
            'zone_id' => $house_zone->id,
        ]);
        $empty_house = Building::create([
            'name' => 'Empty House',
            'description' => 'The bed appears to have been made recently.',
            'zone_id' => $house_zone->id,
        ]);

        $tile1->buildings()->attach($farmhouse);
        $tile1->buildings()->attach($church);
        $tile1->buildings()->attach($shop);
        $tile1->buildings()->attach($house);
        $tile1->buildings()->attach($rundown_house);
        $tile1->buildings()->attach($empty_house);

        $large_house = Building::create([
            'name' => 'Large House',
            'description' => 'A spacious house with multiple rooms.',
            'zone_id' => $house_zone->id,
        ]);

        $small_house = Building::create([
            'name' => 'Small House',
            'description' => 'A tiny one-room house.',
            'zone_id' => $house_zone->id,
        ]);

        $cozy_cottage = Building::create([
            'name' => 'Cozy Cottage',
            'description' => 'A small but cozy cottage with a fireplace.',
            'zone_id' => $house_zone->id,
        ]);

        $seaside_cabin = Building::create([
            'name' => 'Seaside Cabin',
            'description' => 'A cabin by the sea, with a view of the water.',
            'zone_id' => $house_zone->id,
        ]);

        $rustic_cabin = Building::create([
            'name' => 'Rustic Cabin',
            'description' => 'A cabin in the woods, with a rustic feel.',
            'zone_id' => $house_zone->id,
        ]);

        $old_mansion = Building::create([
            'name' => 'Old Mansion',
            'description' => 'A large, old mansion with creaky floors and hidden passageways.',
            'zone_id' => $house_zone->id,
        ]);

        $modern_apartment = Building::create([
            'name' => 'Modern Apartment',
            'description' => 'A sleek and modern apartment with all the latest amenities.',
            'zone_id' => $house_zone->id,
        ]);

        $artistic_loft = Building::create([
            'name' => 'Artistic Loft',
            'description' => 'A loft apartment filled with art and creative touches.',
            'zone_id' => $house_zone->id,
        ]);

        $medieval_tower = Building::create([
            'name' => 'Medieval Tower',
            'description' => 'A tall tower with stone walls and narrow staircases.',
            'zone_id' => $medieval_tower_zone->id,
        ]);

        $humble_hut = Building::create([
            'name' => 'Humble Hut',
            'description' => 'A simple hut made of mud and thatch.',
            'zone_id' => $humble_hut_zone->id,
        ]);

        $small_cabin = Building::create([
            'name' => 'Small Cabin',
            'description' => 'A tiny cabin made of logs.',
            'zone_id' => $humble_hut_zone->id,
        ]);

        $cozy_cottage = Building::create([
            'name' => 'Cozy Cottage',
            'description' => 'A warm and inviting cottage with a thatched roof.',
            'zone_id' => $humble_hut_zone->id,
        ]);

        $quaint_house = Building::create([
            'name' => 'Quaint House',
            'description' => 'A small, charming house with a white picket fence.',
            'zone_id' => $house_zone->id,
        ]);

        $spacious_house = Building::create([
            'name' => 'Spacious House',
            'description' => 'A large and airy house with plenty of windows.',
            'zone_id' => $house_zone->id,
        ]);

        $rustic_cabin = Building::create([
            'name' => 'Rustic Cabin',
            'description' => 'A cozy log cabin with a fireplace.',
            'zone_id' => $humble_hut_zone->id,
        ]);

        $sturdy_house = Building::create([
            'name' => 'Sturdy House',
            'description' => 'A sturdy stone house with a thatched roof.',
            'zone_id' => $house_zone->id,
        ]);

        $grand_mansion = Building::create([
            'name' => 'Grand Mansion',
            'description' => 'An opulent mansion with a sprawling lawn.',
            'zone_id' => $house_zone->id,
        ]);

        $modest_home = Building::create([
            'name' => 'Modest Home',
            'description' => 'A simple home with a welcoming atmosphere.',
            'zone_id' => $house_zone->id,
        ]);

        $tall_apartment = Building::create([
            'name' => 'Tall Apartment',
            'description' => 'A tall building with multiple levels of apartments.',
            'zone_id' => $house_zone->id,
        ]);

        $coastal_cottage = Building::create([
            'name' => 'Coastal Cottage',
            'description' => 'A cozy cottage on the beach with a view of the ocean.',
            'zone_id' => $humble_hut_zone->id,
        ]);

        $stone_house = Building::create([
            'name' => 'Stone House',
            'description' => 'A sturdy house made of stone.',
            'zone_id' => $house_zone->id,
        ]);
        $thatched_cottage = Building::create([
            'name' => 'Thatched Cottage',
            'description' => 'A quaint cottage with a thatched roof.',
            'zone_id' => $house_zone->id,
        ]);
        $cozy_cabin = Building::create([
            'name' => 'Cozy Cabin',
            'description' => 'A small, cozy cabin nestled in the woods.',
            'zone_id' => $house_zone->id,
        ]);
        $tudor_house = Building::create([
            'name' => 'Tudor House',
            'description' => 'An elegant Tudor-style house with exposed timber framing.',
            'zone_id' => $house_zone->id,
        ]);
        $brick_townhouse = Building::create([
            'name' => 'Brick Townhouse',
            'description' => 'A row of connected brick townhouses.',
            'zone_id' => $house_zone->id,
        ]);
        $rustic_farmhouse = Building::create([
            'name' => 'Rustic Farmhouse',
            'description' => 'A large farmhouse with a rustic charm.',
            'zone_id' => $farmhouse_zone,
        ]);
        $modern_house = Building::create([
            'name' => 'Modern House',
            'description' => 'A contemporary house with sleek design elements.',
            'zone_id' => $house_zone->id,
        ]);
        $small_hovel = Building::create([
            'name' => 'Small Hovel',
            'description' => 'A cramped, humble dwelling.',
            'zone_id' => $house_zone->id,
        ]);
        $halfling_burrow = Building::create([
            'name' => 'Halfling Burrow',
            'description' => 'A cozy underground burrow, perfect for a halfling family.',
            'zone_id' => $house_zone->id,
        ]);
        $mage_tower = Building::create([
            'name' => 'Mage Tower',
            'description' => 'A tall, slender tower filled with magical artifacts and a living space.',
            'zone_id' => $house_zone->id,
        ]);

        $zones = [
            $industrial_zone = Zone::create([
                'name' => 'Industrial Zone',
                'description' => 'For factories, warehouses, and other industrial buildings.',
                'is_shop' => false,
                'is_pub' => false,
                'is_house' => false,
                'is_bed' => false,
                'is_accessible' => true,
                'is_locked' => false,
                'is_pilferable' => false,
            ]),
            $residential_zone = Zone::create([
                'name' => 'Residential Zone',
                'description' => 'For houses, apartments, and other types of residential buildings.',
                'is_shop' => false,
                'is_pub' => false,
                'is_house' => true,
                'is_bed' => true,
                'is_accessible' => true,
                'is_locked' => false,
                'is_pilferable' => false,
            ]),
            $commercial_zone = Zone::create([
                'name' => 'Commercial Zone',
                'description' => 'For shops, malls, and other types of commercial buildings.',
                'is_shop' => true,
                'is_pub' => true,
                'is_house' => false,
                'is_bed' => false,
                'is_accessible' => true,
                'is_locked' => false,
                'is_pilferable' => false,
            ]),
            $educational_zone = Zone::create([
                'name' => 'Educational Zone',
                'description' => 'For schools, universities, and other educational buildings.',
                'is_shop' => false,
                'is_pub' => false,
                'is_house' => false,
                'is_bed' => false,
                'is_accessible' => true,
                'is_locked' => false,
                'is_pilferable' => false,
            ]),
            $medical_zone = Zone::create([
                'name' => 'Medical Zone',
                'description' => 'For hospitals, clinics, and other medical buildings.',
                'is_shop' => false,
                'is_pub' => false,
                'is_house' => false,
                'is_bed' => true,
                'is_accessible' => true,
                'is_locked' => false,
                'is_pilferable' => false,
            ]),
        ];

        $inn_zone = Zone::create([
            'name' => 'Inn',
            'description' => 'A place for travelers to rest, eat, and drink.',
            'is_shop' => false,
            'is_pub' => true,
            'is_house' => false,
            'is_bed' => true,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $tavern_zone = Zone::create([
            'name' => 'Tavern',
            'description' => 'A place for drinking, eating, and socializing.',
            'is_shop' => false,
            'is_pub' => true,
            'is_house' => false,
            'is_bed' => false,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $forge_zone = Zone::create([
            'name' => 'Forge',
            'description' => 'A place for metalworking and crafting weapons and armor.',
            'is_shop' => true,
            'is_pub' => false,
            'is_house' => false,
            'is_bed' => false,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $laboratory_zone = Zone::create([
            'name' => 'Laboratory',
            'description' => 'A place for conducting experiments and researching new inventions.',
            'is_shop' => true,
            'is_pub' => false,
            'is_house' => false,
            'is_bed' => false,
            'is_accessible' => true,
            'is_locked' => true,
            'is_pilferable' => false,
        ]);

        $guild_zone = Zone::create([
            'name' => 'Guild',
            'description' => 'A place for joining forces with other adventurers and completing quests together.',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => false,
            'is_bed' => false,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => false,
        ]);

        $hideout_zone = Zone::create([
            'name' => 'Hideout',
            'description' => 'A secret place for outlaws and criminals to gather and plan their heists.',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => true,
            'is_bed' => false,
            'is_accessible' => false,
            'is_locked' => true,
            'is_pilferable' => true,
        ]);

        $tower_zone = Zone::create([
            'name' => 'Tower',
            'description' => 'A tall, imposing structure for conducting arcane research and practicing magic.',
            'is_shop' => false,
            'is_pub' => false,
            'is_house' => false,
            'is_bed' => true,
            'is_accessible' => true,
            'is_locked' => true,
            'is_pilferable' => false,
        ]);

        $lodge_zone = Zone::create([
            'name' => 'Lodge',
            'description' => 'A cozy retreat for hunters and outdoors enthusiasts, complete with rustic accommodations and hunting gear.',
            'is_shop' => true,
            'is_pub' => false,
            'is_house' => true,
            'is_bed' => true,
            'is_accessible' => true,
            'is_locked' => false,
            'is_pilferable' => true,
        ]);

        $more_buildings = [
            Building::create([
                'name' => 'The Rusty Blade Inn',
                'description' => 'A bustling inn in the center of town, with a lively common room and cozy rooms for rent.',
                'zone_id' => $inn_zone->id,
            ]),
            Building::create([
                'name' => 'The Silver Spoon Tavern',
                'description' => 'A high-end establishment for fine dining and drinks, with a private dining room for special occasions.',
                'zone_id' => $tavern_zone->id,
            ]),
            Building::create([
                'name' => 'The Blacksmith\'s Forge',
                'description' => 'A spacious workshop filled with the sound of hammers on metal, where skilled smiths craft all manner of weapons and armor.',
                'zone_id' => $forge_zone->id,
            ]),
            Building::create([
                'name' => 'The Alchemist\'s Laboratory',
                'description' => 'A dimly lit room filled with strange devices and bubbling potions, where an eccentric alchemist concocts all manner of mysterious elixirs.',
                'zone_id' => $laboratory_zone->id,
            ]),
            Building::create([
                'name' => 'The Adventurer\'s Guild',
                'description' => 'A central hub for adventurers seeking work, where bulletin boards are filled with job postings and rumors abound of hidden treasure.',
                'zone_id' => $guild_zone->id,
            ]),
            Building::create([
                'name' => 'The Thieves\' Den',
                'description' => 'A dark, secretive hideout for thieves and cutthroats, where whispered conversations and the clink of stolen loot can be heard in every corner.',
                'zone_id' => $hideout_zone->id,
            ]),
            Building::create([
                'name' => 'The Wizard\'s Tower',
                'description' => 'A towering structure of stone and crystal, where powerful wizards study ancient tomes and experiment with arcane magic.',
                'zone_id' => $tower_zone->id,
            ]),
            Building::create([
                'name' => 'The Hunter\'s Lodge',
                'description' => 'A rustic cabin on the outskirts of town, where skilled hunters gather to swap stories and plan their next great hunt.',
                'zone_id' => $lodge_zone->id,
            ]),
            Building::create([
                'name' => 'The Bookworm\'s Retreat',
                'description' => 'A cozy little library filled with shelves of dusty tomes and the scent of old paper, where studious scholars come to read and relax.',
                'zone_id' => $educational_zone->id,
            ]),
            Building::create([
                'name' => 'The Farmstead',
                'description' => 'A sprawling complex of fields and barns.',
                'zone_id' => $farmhouse_zone,
            ]),
            Building::create([
                'name' => 'The Enchanter\'s Emporium',
                'description' => 'A mystical shop filled with all manner of enchanted items, from talismans to wands to magic potions.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Armory',
                'description' => 'A bustling store filled with racks of gleaming armor and weapons, where adventurers come to purchase the gear they need for their next quest.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Scroll Shop',
                'description' => 'A small storefront filled with dusty scrolls and magical tomes, where spellcasters can find the perfect spell for any situation.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Bard\'s Stage',
                'description' => 'A lively tavern with a stage for live music and entertainment, where bards and minstrels can earn their coin with a good performance.',
                'zone_id' => $tavern_zone->id,
            ]),
            Building::create([
                'name' => 'The General Store',
                'description' => 'A one-stop-shop for all manner of adventuring supplies, from rations to rope to torches to backpacks.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Potion Master\'s Shop',
                'description' => 'A small shop filled with bubbling cauldrons and mysterious ingredients, where a skilled potion master brews all manner of helpful elixirs.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Gambling Hall',
                'description' => 'A lively casino filled with games of chance, where gamblers can try their luck and perhaps walk away with a small fortune.',
                'zone_id' => $tavern_zone->id,
            ]),
            Building::create([
                'name' => 'The Merchant\'s Guildhall',
                'description' => 'A grand building where the town\'s wealthiest merchants gather to discuss trade and commerce, and perhaps recruit adventurers for a particularly lucrative job.',
                'zone_id' => $guild_zone->id,
            ]),
            Building::create([
                'name' => 'The Golden Loaf Bakery',
                'description' => 'A warm, inviting bakery filled with the scent of freshly baked bread and pastries. A must-visit for any bread lover.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Sizzling Steakhouse',
                'description' => 'A bustling steakhouse with an open kitchen and sizzling hot grills, serving up the finest cuts of meat around.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Hungry Halfling Inn',
                'description' => 'A cozy inn with a hearty menu of classic comfort foods, perfect for travelers looking for a warm meal and a comfortable bed.',
                'zone_id' => $inn_zone->id,
            ]),
            Building::create([
                'name' => 'The Fowl Fare Poultry Market',
                'description' => 'A bustling marketplace filled with the freshest chicken, turkey, and other poultry around, as well as a variety of eggs and feather-related goods.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Butcher\'s Block',
                'description' => 'A family-owned butcher shop specializing in all manner of meat cuts, from the basics to the exotic.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Sweet Spot',
                'description' => 'A cozy, colorful candy shop filled with all manner of sweets and treats, from hard candies to gummies to chocolates.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Spice Emporium',
                'description' => 'A fragrant marketplace filled with spices and herbs from all over the world, perfect for any aspiring chef or alchemist.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Tea Room',
                'description' => 'A tranquil, relaxing space for tea lovers, with a wide variety of teas and tea-related accoutrements available for purchase.',
                'zone_id' => $commercial_zone->id,
            ]),
            Building::create([
                'name' => 'The Thirsty Dwarf Tavern',
                'description' => 'A lively, raucous tavern with a wide selection of beers, ales, and spirits, as well as a menu of hearty pub fare.',
                'zone_id' => $tavern_zone->id,
            ]),
        ];

        $npcs = [
            Npc::create([
                'name' => 'Chef Isaac',
                'description' => 'A highly skilled chef. He is a bit of a stickler for the quality of his food. Prefers to cook pork.',
                'occupation_id' => Occupation::create([
                    'name' => 'Chef',
                    'description' => 'A talented cook by nature.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Priest Peter',
                'description' => 'A priest of the church. He speaks in foreign tongues and wears a pendant with what looks like a squid.',
                'occupation_id' => Occupation::create([
                    'name' => 'Priest',
                    'description' => 'Lives and works in the church.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Asselin Alderman',
                'description' => 'A very friendly person. He is holding a heavy book and seems to know what he is talking about.',
                'occupation_id' => Occupation::create([
                    'name' => 'Guide',
                    'description' => 'Offers guidance.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Vicar Bertaut',
                'description' => 'A scar under his eye, and a beard that is a bit too long. The quality of his armor is lacking but he sports expensive jewelry.',
                'occupation_id' => Occupation::create([
                    'name' => 'Guard',
                    'description' => 'A pay-to-play mercenary.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Edrick Fryee',
                'description' => 'Wearing an unfamiliar animal skin, he plays a beautiful and unique string instrument of his own creation.',
                'occupation_id' => Occupation::create([
                    'name' => 'Bard',
                    'description' => 'Sing me a song, you\'re the music man.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Thistle Tatume',
                'description' => 'Mystical eyes look back at you, inviting you for a drink.',
                'occupation_id' => Occupation::create([
                    'name' => 'Bartender',
                    'description' => 'Serves you food and beverages, and maybe has heard a thing or two.',
                ])->id,
            ]),
            Npc::create([
                'name' => 'Sylvia Wescotte',
                'description' => 'A beautiful girl that appears to be poverty-stricken. She works hard and shares little information.',
                'occupation_id' => Occupation::create([
                    'name' => 'Barmaid',
                    'description' => 'Serves you food and beverages, and maybe has heard a thing or two.',
                ])->id,
            ]),
        ];

        $farmer = Occupation::create([
            'name' => 'Farmer',
            'description' => 'Works the farm.',
        ]);
        $farmhouse->npcs()->create([
            'name' => 'Gibb Wyon',
            'description' => 'An experienced farmer, born and raised. His clothing looks worn.',
            'occupation_id' => $farmer->id,
        ]);

        Occupation::create([
            'name' => 'Clerk',
            'description' => 'Works the cash register.',
        ]);
        Occupation::create([
            'name' => 'Cook',
            'description' => 'Cooks the food.',
        ]);

        $occupations = [
            Occupation::create([
                'name' => 'Baker',
                'description' => 'A skilled artisan who creates a variety of baked goods.',
            ]),
            Occupation::create([
                'name' => 'Butcher',
                'description' => 'A skilled meat cutter who prepares a variety of meats for sale.',
            ]),
            Occupation::create([
                'name' => 'Cheesemaker',
                'description' => 'A skilled artisan who creates a variety of cheeses.',
            ]),
            Occupation::create([
                'name' => 'Fishmonger',
                'description' => 'A skilled seller of fresh and saltwater fish.',
            ]),
            Occupation::create([
                'name' => 'Gardener',
                'description' => 'A skilled cultivator of fruits, vegetables, and herbs.',
            ]),
            Occupation::create([
                'name' => 'Herbalist',
                'description' => 'A skilled practitioner of herbal medicine and remedies.',
            ]),
            Occupation::create([
                'name' => 'Pastry Chef',
                'description' => 'A skilled artisan who creates a variety of desserts and pastries.',
            ]),
            Occupation::create([
                'name' => 'Sommelier',
                'description' => 'A skilled wine expert who recommends and serves wine to customers.',
            ]),
        ];

        Occupation::create([
            'name' => 'Baker',
            'description' => 'Skilled in the art of making bread and pastries.',
        ]);

        Occupation::create([
            'name' => 'Butcher',
            'description' => 'A skilled meat cutter who knows how to break down carcasses and prepare meat for sale.',
        ]);

        Occupation::create([
            'name' => 'Brewer',
            'description' => 'An expert in creating beer, ale, and other fermented beverages.',
        ]);

        Occupation::create([
            'name' => 'Cheesemaker',
            'description' => 'A skilled artisan who can turn milk into a variety of delicious cheeses.',
        ]);

        Occupation::create([
            'name' => 'Coffee Roaster',
            'description' => 'An expert in roasting and brewing coffee to perfection.',
        ]);

        Occupation::create([
            'name' => 'Fishmonger',
            'description' => 'A seller of fish and other seafood, with expertise in filleting and preparation.',
        ]);

        Occupation::create([
            'name' => 'Pastry Chef',
            'description' => 'An expert in creating desserts and other sweet treats.',
        ]);

        Occupation::create([
            'name' => 'Sommelier',
            'description' => 'A wine expert who can recommend the perfect vintage to accompany any meal.',
        ]);

        $church->npcs()->create([
            'name' => 'Kimberley Haytere',
            'description' => 'A bishop of the church.',
            'occupation_id' => Occupation::create([
                'name' => 'Bishop',
                'description' => 'Lives and works in the church. Rarely seen without their hat on.',
            ])->id,
        ]);

        $shop->npcs()->create([
            'name' => 'Lilith',
            'description' => 'A shopkeeper.',
            'occupation_id' => Occupation::create([
                'name' => 'Shopkeeper',
                'description' => 'Sells you goods.',
            ])->id,
        ]);

        $farmhouse->occupations()->attach($farmer);
        $farmhouse->npcs()->attach($farmer);
        $church->occupations()->attach($npcs[1]); // priest
        $bar->occupations()->attach($npcs[5]); // bartender
        $bar->occupations()->attach($npcs[6]); // barmaid
        $shop->occupations()->attach($npcs[0]); // chef
        $shop->occupations()->attach($npcs[3]); // guard

        $tile1->npcs()->attach($npcs[4]); // bard
        $tile1->npcs()->attach($npcs[2]); // guide

        $bar->npcs()->attach($npcs[5]); // bartender
        $bar->npcs()->attach($npcs[6]); // barmaid

        $shop->npcs()->attach($npcs[0]); // chef
        $shop->npcs()->attach($npcs[3]); // guard

        $house->npcs()->attach($npcs[2]); // guide

    }
}

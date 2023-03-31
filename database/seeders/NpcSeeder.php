<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Npc;
use App\Models\Occupation;
use App\Models\Tile;
use App\Models\Zone;
use App\Models\Zoneproperty;
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

        $is_shop = Zoneproperty::create([
            'name' => 'is_shop',
            'description' => 'Is this a shop? Can we buy things from it?',
        ]);

        $is_pub = Zoneproperty::create([
            'name' => 'is_pub',
            'description' => 'Is this a pub? Can we drink here?',
        ]);

        $is_house = Zoneproperty::create([
            'name' => 'is_house',
            'description' => 'Is this a house? Can we sleep here?',
        ]);

        $is_bed = Zoneproperty::create([
            'name' => 'is_bed',
            'description' => 'Is this a bed? Can we sleep here?',
        ]);

        $is_accessible = Zoneproperty::create([
            'name' => 'is_accessible',
            'description' => 'Is this accessible? Can we go here?',
        ]);

        $is_locked = Zoneproperty::create([
            'name' => 'is_locked',
            'description' => 'Is this locked? Can we go here?',
        ]);

        $is_pilferable = Zoneproperty::create([
            'name' => 'is_pilferable',
            'description' => 'Is this pilferable? Can we steal from it?',
        ]);

        $church_zone = Zone::create([
            'name' => 'Church',
            'description' => 'Generic, basic churches.',
        ]);
        $church_zone->zoneproperties()->attach($is_accessible);

        $bar_zone = Zone::create([
            'name' => 'Bar',
            'description' => 'Places to acquire a drink.',
        ]);
        $bar_zone->zoneproperties()->attach($is_pub);
        $bar_zone->zoneproperties()->attach($is_accessible);
        $bar_zone->zoneproperties()->attach($is_pilferable);

        $shop_zone = Zone::create([
            'name' => 'Shop',
            'description' => 'Generic, basic shops.',
        ]);
        $shop_zone->zoneproperties()->attach($is_shop);
        $shop_zone->zoneproperties()->attach($is_accessible);
        $shop_zone->zoneproperties()->attach($is_pilferable);

        $farmhouse_zone = Zone::create([
            'name' => 'Farmland',
            'description' => 'Potentially a lot of farming related shops .',
        ]);
        $farmhouse_zone->zoneproperties()->attach($is_shop);
        $farmhouse_zone->zoneproperties()->attach($is_accessible);
        $farmhouse_zone->zoneproperties()->attach($is_pilferable);

        $buildings = [
            $farmhouse = Building::create([
                'name' => 'Farmhouse',
                'description' => 'An average sized farmhouse.',
                'zone_id' => $farmhouse_zone->id,
            ]),
            $church = Building::create([
                'name' => 'Church',
                'description' => 'A basic wooden church.',
                'zone_id' => $church_zone->id,
            ]),
            $bar = Building::create([
                'name' => 'Bar',
                'description' => 'A bar that looks like it has been around a while.',
                'zone_id' => $bar_zone->id,
            ]),
            $shop = Building::create([
                'name' => 'Shop',
                'description' => 'A generic, basic shop.',
                'zone_id' => $shop_zone->id,
            ]),
        ];

        $medieval_tower_zone = Zone::create([
            'name' => 'Medieval Tower',
            'description' => 'A tall, ancient tower made of stone.',
        ]);
        $medieval_tower_zone->zoneproperties()->attach($is_accessible);

        $living_quarters_zone = Zone::create([
            'name' => 'Residential',
            'description' => 'Living quarters. Resting should be available here.',
        ]);
        $living_quarters_zone->zoneproperties()->attach($is_house);
        $living_quarters_zone->zoneproperties()->attach($is_bed);
        $living_quarters_zone->zoneproperties()->attach($is_accessible);

        $house = Building::create([
            'name' => 'House',
            'description' => 'A standard wooden house.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $rundown_house = Building::create([
            'name' => 'Abandoned House',
            'description' => 'A rundown wooden house.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $empty_house = Building::create([
            'name' => 'Empty House',
            'description' => 'The bed appears to have been made recently.',
            'zone_id' => $living_quarters_zone->id,
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
            'zone_id' => $living_quarters_zone->id,
        ]);

        $small_house = Building::create([
            'name' => 'Small House',
            'description' => 'A tiny one-room house.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $cozy_cottage = Building::create([
            'name' => 'Cozy Cottage',
            'description' => 'A small but cozy cottage with a fireplace.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $seaside_cabin = Building::create([
            'name' => 'Seaside Cabin',
            'description' => 'A cabin by the sea, with a view of the water.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $rustic_cabin = Building::create([
            'name' => 'Rustic Cabin',
            'description' => 'A cabin in the woods, with a rustic feel.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $old_mansion = Building::create([
            'name' => 'Old Mansion',
            'description' => 'A large, old mansion with creaky floors and hidden passageways.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $modern_apartment = Building::create([
            'name' => 'Modern Apartment',
            'description' => 'A sleek and modern apartment with all the latest amenities.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $artistic_loft = Building::create([
            'name' => 'Artistic Loft',
            'description' => 'A loft apartment filled with art and creative touches.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $medieval_tower = Building::create([
            'name' => 'Medieval Tower',
            'description' => 'A tall tower with stone walls and narrow staircases.',
            'zone_id' => $medieval_tower_zone->id,
        ]);

        $humble_hut = Building::create([
            'name' => 'Humble Hut',
            'description' => 'A simple hut made of mud and thatch.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $small_cabin = Building::create([
            'name' => 'Small Cabin',
            'description' => 'A tiny cabin made of logs.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $cozy_cottage = Building::create([
            'name' => 'Cozy Cottage',
            'description' => 'A warm and inviting cottage with a thatched roof.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $quaint_house = Building::create([
            'name' => 'Quaint House',
            'description' => 'A small, charming house with a white picket fence.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $spacious_house = Building::create([
            'name' => 'Spacious House',
            'description' => 'A large and airy house with plenty of windows.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $rustic_cabin = Building::create([
            'name' => 'Rustic Cabin',
            'description' => 'A cozy log cabin with a fireplace.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $sturdy_house = Building::create([
            'name' => 'Sturdy House',
            'description' => 'A sturdy stone house with a thatched roof.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $grand_mansion = Building::create([
            'name' => 'Grand Mansion',
            'description' => 'An opulent mansion with a sprawling lawn.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $modest_home = Building::create([
            'name' => 'Modest Home',
            'description' => 'A simple home with a welcoming atmosphere.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $tall_apartment = Building::create([
            'name' => 'Tall Apartment',
            'description' => 'A tall building with multiple levels of apartments.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $coastal_cottage = Building::create([
            'name' => 'Coastal Cottage',
            'description' => 'A cozy cottage on the beach with a view of the ocean.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $stone_house = Building::create([
            'name' => 'Stone House',
            'description' => 'A sturdy house made of stone.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $thatched_cottage = Building::create([
            'name' => 'Thatched Cottage',
            'description' => 'A quaint cottage with a thatched roof.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $cozy_cabin = Building::create([
            'name' => 'Cozy Cabin',
            'description' => 'A small, cozy cabin nestled in the woods.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $tudor_house = Building::create([
            'name' => 'Tudor House',
            'description' => 'An elegant Tudor-style house with exposed timber framing.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $brick_townhouse = Building::create([
            'name' => 'Brick Townhouse',
            'description' => 'A row of connected brick townhouses.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $rustic_farmhouse = Building::create([
            'name' => 'Rustic Farmhouse',
            'description' => 'A large farmhouse with a rustic charm.',
            'zone_id' => $farmhouse_zone->id,
        ]);
        $modern_house = Building::create([
            'name' => 'Modern House',
            'description' => 'A contemporary house with sleek design elements.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $small_hovel = Building::create([
            'name' => 'Small Hovel',
            'description' => 'A cramped, humble dwelling.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $halfling_burrow = Building::create([
            'name' => 'Halfling Burrow',
            'description' => 'A cozy underground burrow, perfect for a halfling family.',
            'zone_id' => $living_quarters_zone->id,
        ]);
        $mage_tower = Building::create([
            'name' => 'Mage Tower',
            'description' => 'A tall, slender tower filled with magical artifacts and a living space.',
            'zone_id' => $living_quarters_zone->id,
        ]);

        $zones = [
            $industrial_zone = Zone::create([
                'name' => 'Industrial Zone',
                'description' => 'For factories, warehouses, and other industrial buildings.',
            ]),
            $residential_zone = Zone::create([
                'name' => 'Residential Zone',
                'description' => 'For houses, apartments, and other types of residential buildings.',
            ]),
            $commercial_zone = Zone::create([
                'name' => 'Commercial Zone',
                'description' => 'For shops, malls, and other types of commercial buildings.',
            ]),
            $educational_zone = Zone::create([
                'name' => 'Educational Zone',
                'description' => 'For schools, universities, and other educational buildings.',
            ]),
            $medical_zone = Zone::create([
                'name' => 'Medical Zone',
                'description' => 'For hospitals, clinics, and other medical buildings.',
            ]),
        ];
        $industrial_zone->zoneproperties()->attach($is_accessible);

        $residential_zone->zoneproperties()->attach($is_house);
        $residential_zone->zoneproperties()->attach($is_accessible);
        $residential_zone->zoneproperties()->attach($is_bed);

        $commercial_zone->zoneproperties()->attach($is_shop);
        $commercial_zone->zoneproperties()->attach($is_pub);
        $commercial_zone->zoneproperties()->attach($is_accessible);

        $educational_zone->zoneproperties()->attach($is_accessible);

        $medical_zone->zoneproperties()->attach($is_accessible);
        $medical_zone->zoneproperties()->attach($is_bed);

        $inn_zone = Zone::create([
            'name' => 'Inn',
            'description' => 'A place for travelers to rest, eat, and drink.',
        ]);
        $inn_zone->zoneproperties()->attach($is_bed);
        $inn_zone->zoneproperties()->attach($is_accessible);
        $inn_zone->zoneproperties()->attach($is_pub);

        $tavern_zone = Zone::create([
            'name' => 'Tavern',
            'description' => 'A place for drinking, eating, and socializing.',
        ]);
        $tavern_zone->zoneproperties()->attach($is_accessible);
        $tavern_zone->zoneproperties()->attach($is_pub);

        $forge_zone = Zone::create([
            'name' => 'Forge',
            'description' => 'A place for metalworking and crafting weapons and armor.',
        ]);
        $forge_zone->zoneproperties()->attach($is_shop);
        $forge_zone->zoneproperties()->attach($is_accessible);

        $laboratory_zone = Zone::create([
            'name' => 'Laboratory',
            'description' => 'A place for conducting experiments and researching new inventions.',
        ]);
        $laboratory_zone->zoneproperties()->attach($is_shop);
        $laboratory_zone->zoneproperties()->attach($is_accessible);
        $laboratory_zone->zoneproperties()->attach($is_locked);

        $guild_zone = Zone::create([
            'name' => 'Guild',
            'description' => 'A place for joining forces with other adventurers and completing quests together.',
        ]);
        $guild_zone->zoneproperties()->attach($is_accessible);

        $hideout_zone = Zone::create([
            'name' => 'Hideout',
            'description' => 'A secret place for outlaws and criminals to gather and plan their heists.',
        ]);
        $hideout_zone->zoneproperties()->attach($is_locked);

        $tower_zone = Zone::create([
            'name' => 'Tower',
            'description' => 'A tall, imposing structure for conducting arcane research and practicing magic.',
        ]);
        $tower_zone->zoneproperties()->attach($is_locked);
        $tower_zone->zoneproperties()->attach($is_bed);
        $tower_zone->zoneproperties()->attach($is_accessible);

        $lodge_zone = Zone::create([
            'name' => 'Lodge',
            'description' => 'A cozy retreat for hunters and outdoors enthusiasts, complete with rustic accommodations and hunting gear.',
        ]);
        $lodge_zone->zoneproperties()->attach($is_shop);
        $lodge_zone->zoneproperties()->attach($is_house);
        $lodge_zone->zoneproperties()->attach($is_bed);
        $lodge_zone->zoneproperties()->attach($is_accessible);
        $lodge_zone->zoneproperties()->attach($is_pilferable);

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
                'zone_id' => $farmhouse_zone->id,
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

        $chef_occupation = Occupation::create([
            'name' => 'Chef',
            'description' => 'A highly skilled chef. He is a bit of a stickler for the quality of his food. Prefers to cook pork.',
        ]);

        $priest_occupation = Occupation::create([
            'name' => 'Priest',
            'description' => 'A priest of the church. He speaks in foreign tongues and wears a pendant with what looks like a squid.',
        ]);

        $guide_occupation = Occupation::create([
            'name' => 'Guide',
            'description' => 'A very friendly person. He is holding a heavy book and seems to know what he is talking about.',
        ]);

        $guard_occupation = Occupation::create([
            'name' => 'Guard',
            'description' => 'A scar under his eye, and a beard that is a bit too long. The quality of his armor is lacking but he sports expensive jewelry.',
        ]);

        $bard_occupation = Occupation::create([
            'name' => 'Bard',
            'description' => 'Wearing an unfamiliar animal skin, he plays a beautiful and unique string instrument of his own creation.',
        ]);

        $bartender_occupation = Occupation::create([
            'name' => 'Bartender',
            'description' => 'Mystical eyes look back at you, inviting you for a drink.',
        ]);

        $barmaid_occupation = Occupation::create([
            'name' => 'Barmaid',
            'description' => 'A beautiful girl that appears to be poverty-stricken. She works hard and shares little information.',
        ]);

        $npcs = [
            Npc::create([
                'name' => 'Chef Isaac',
                'occupation_id' => $chef_occupation->id,
                'species' => 'human',
                'gender' => 'male',
            ]),
            Npc::create([
                'name' => 'Priest Peter',
                'occupation_id' => $priest_occupation->id,
                'species' => 'human',
                'gender' => 'male',
            ]),
            Npc::create([
                'name' => 'Asselin Alderman',
                'occupation_id' => $guide_occupation->id,
                'species' => 'human',
                'gender' => 'male',
            ]),
            Npc::create([
                'name' => 'Vicar Bertaut',
                'occupation_id' => $guard_occupation->id,
                'species' => 'human',
                'gender' => 'male',
            ]),
            Npc::create([
                'name' => 'Edrick Fryee',
                'occupation_id' => $bard_occupation->id,
                'species' => 'human',
                'gender' => 'male',
            ]),
            Npc::create([
                'name' => 'Thistle Tatume',
                'occupation_id' => $bartender_occupation->id,
                'species' => 'elf',
                'gender' => 'non-binary',
            ]),
            Npc::create([
                'name' => 'Sylvia Wescotte',
                'occupation_id' => $barmaid_occupation->id,
                'species' => 'human',
                'gender' => 'female',
            ]),
        ];

        $farmer = Occupation::create([
            'name' => 'Farmer',
            'description' => 'An experienced farmer, born and raised. His clothing looks worn. He is holding a pitchfork; how cliché.',
        ]);
        $farmhouse->npcs()->create([
            'name' => 'Gibb Wyon',
            'occupation_id' => $farmer->id,
            'species' => 'human',
            'gender' => 'male',
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
            Occupation::create([
                'name' => 'Baker',
                'description' => 'Skilled in the art of making bread and pastries.',
            ]),
            Occupation::create([
                'name' => 'Butcher',
                'description' => 'A skilled meat cutter who knows how to break down carcasses and prepare meat for sale.',
            ]),
            Occupation::create([
                'name' => 'Brewer',
                'description' => 'An expert in creating beer, ale, and other fermented beverages.',
            ]),
            Occupation::create([
                'name' => 'Cheesemaker',
                'description' => 'A skilled artisan who can turn milk into a variety of delicious cheeses.',
            ]),
            Occupation::create([
                'name' => 'Coffee Roaster',
                'description' => 'An expert in roasting and brewing coffee to perfection.',
            ]),
            Occupation::create([
                'name' => 'Fishmonger',
                'description' => 'A seller of fish and other seafood, with expertise in filleting and preparation.',
            ]),
            Occupation::create([
                'name' => 'Pastry Chef',
                'description' => 'An expert in creating desserts and other sweet treats.',
            ]),
            Occupation::create([
                'name' => 'Sommelier',
                'description' => 'A wine expert who can recommend the perfect vintage to accompany any meal.',
            ]),
            Occupation::create([
                'name' => 'Clerk',
                'description' => 'Works the cash register.',
            ]),
            Occupation::create([
                'name' => 'Cook',
                'description' => 'Cooks the food.',
            ]),
        ];

        $church->npcs()->create([
            'name' => 'Kimberley Haytere',
            'occupation_id' => Occupation::create([
                'name' => 'Bishop',
                'description' => 'Lives and works in the church. Rarely seen without their hat on.',
            ])->id,
            'species' => 'human',
            'gender' => 'female',
        ]);

        $shop->npcs()->create([
            'name' => 'Lilith',
            'occupation_id' => Occupation::create([
                'name' => 'Shopkeeper',
                'description' => 'Sells you goods and manages the shop.',
            ])->id,
            'species' => 'human',
            'gender' => 'female',
        ]);

        $church_zone->occupations()->attach($npcs[1]->occupation()->first()); // priest
        $bar_zone->occupations()->attach($npcs[5]->occupation()->first()); // bartender
        $bar_zone->occupations()->attach($npcs[6]->occupation()->first()); // barmaid
        $shop_zone->occupations()->attach($npcs[0]->occupation()->first()); // chef
        $shop_zone->occupations()->attach($npcs[3]->occupation()->first()); // guard

        $farmhouse_zone->occupations()->attach($farmer);
        $farmhouse_zone->occupations()->attach($occupations[0]); // baker
        $farmhouse_zone->occupations()->attach($occupations[1]); // butcher
        $farmhouse_zone->occupations()->attach($occupations[2]); // cheesemaker
        $farmhouse_zone->occupations()->attach($occupations[3]); // fishmonger
        $farmhouse_zone->occupations()->attach($occupations[4]); // gardener
        $farmhouse_zone->occupations()->attach($occupations[5]); // herbalist
        $farmhouse_zone->occupations()->attach($occupations[11]); // cheesemaker
        $farmhouse_zone->occupations()->attach($occupations[13]); // fishmonger

        $bar_zone->occupations()->attach($occupations[6]); // pastry chef
        $bar_zone->occupations()->attach($occupations[7]); // sommelier
        $bar_zone->occupations()->attach($occupations[8]); // clerk

        $shop_zone->occupations()->attach($occupations[3]); // fishmonger
        $shop_zone->occupations()->attach($occupations[2]); // cheesemaker
        $shop_zone->occupations()->attach($occupations[9]); // cook
        $shop_zone->occupations()->attach($occupations[10]); // brewer
        $shop_zone->occupations()->attach($occupations[11]); // cheesemaker
        $shop_zone->occupations()->attach($occupations[12]); // coffee roaster
        $shop_zone->occupations()->attach($occupations[13]); // fishmonger
        $shop_zone->occupations()->attach($occupations[14]); // pastry chef
        $shop_zone->occupations()->attach($occupations[15]); // sommelier

        $farmhouse->npcs()->attach($farmer);

        $tile1->npcs()->attach($npcs[4]); // bard
        $tile1->npcs()->attach($npcs[2]); // guide

        $bar->npcs()->attach($npcs[5]); // bartender
        $bar->npcs()->attach($npcs[6]); // barmaid

        $shop->npcs()->attach($npcs[0]); // chef
        $shop->npcs()->attach($npcs[3]); // guard

        $house->npcs()->attach($npcs[2]); // guide

    }
}

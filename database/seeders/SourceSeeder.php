<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


/**
 * Class SourceSeeder
 *
 * @package   Database\Seeders
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class SourceSeeder extends Seeder
{


    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sources')->insertOrIgnore(
            ['name' => 'NewsAPI', 'url' => 'https://newsapi.org/v2']
        );
        DB::table('sources')->insertOrIgnore(
            ['name' => 'NewYorkTimes', 'url' => 'https://api.nytimes.com/svc/search/v2/articlesearch.json']
        );
    }//end run()
}//end class

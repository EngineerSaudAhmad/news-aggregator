<?php

namespace App\Console\Commands;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Facades\Http;
use Throwable;

/**
 * Class FetchArticles
 *
 * @package App\Console\Commands
 * @author    Engineer Saud <engr.saud94@gmail.com>
 * @copyright 2024 All rights reserved.
 * @since     Oct 21, 2024
 * @project   news-aggregator
 */
class FetchArticles extends Command
{

    /**
     * Property signature
     *
     * @var string
     */
    protected $signature = 'fetch:articles';

    /**
     * Property description
     *
     * @var string
     */
    protected $description = 'Fetch articles from external the defined sources news APIs';


    /**
     * Function handle
     *
     * @return void
     */
    public function handle(): void
    {
        $sources = Source::all();

        foreach ($sources as $source) {
            $this->fetchArticlesFromSource($source);
        }

        $this->info('Articles fetched successfully!');
    }//end handle()


    /**
     * Function fetchArticlesFromSource
     *
     * @param Source $source
     *
     * @return void
     */
    private function fetchArticlesFromSource(Source $source): void
    {
        try {
            $articles = $this->newsAPIAggregator($source);

            if (!empty($articles)) {
                foreach ($articles as $articleData) {
                    Article::updateOrCreate(
                        ['title' => $articleData['title'], 'source_id' => $source->id],
                        [
                            'content' => $articleData['content'] ?? $articleData['description'],
                            'author' => $articleData['author'],
                            'published_at' => $articleData['publishedAt'],
                            'category_id' => $this->getCategoryId($articleData['category'] ?? $articleData['source']['name'] ?? 'General'),
                        ]
                    );
                }
            } else {
                $this->error("Failed to fetch articles from {$source->name}");
            }
        } catch (Throwable $e) {
            report($e);
        }
    }//end fetchArticlesFromSource()


    /**
     * Function getCategoryId
     *
     * @param string $categoryName
     *
     * @return int
     */
    private function getCategoryId(string $categoryName): int
    {
        // Logic to get or create category by name
        // This is a simplified version. You might want to implement a more robust solution.
        return Category::firstOrCreate(['name' => $categoryName])->id;
    }


    /**
     * Function newsAPIAggregator
     *
     * @param Source $source
     *
     * @return array
     */
    private function newsAPIAggregator(Source $source): array
    {
        try {
            if ($source->name === 'NewsAPI') {
                $response = Http::get("$source->url/everything", [
                    'apiKey' => config("sources.$source->name.api_key"),
                    'sources' => 'abc-news, abc-news-au, aftenposten, al-jazeera-english, ANSA.it, ars-technica, ary-news',
                    'from' => Carbon::yesterday()->toDateString(),
                    'to' => Carbon::today()->toDateString(),
                ]);

                $response = $response->json();
                if (!empty($response['totalResults'])) {
                    return $response['articles'] ?? [];
                }
            } elseif ($source->name === 'TheGuardian') {
                $articleData = [];
                $response = Http::get("$source->url", [
                    'api-key' => config("sources.$source->name.api_key"),
                    'from-date' => Carbon::today()->toDateString(),
                ]);

                if (!empty($response->json()['response']['results'])) {
                    foreach ($response->json()['response']['results'] as $key => $data) {
                        $articleData[$key]['title'] = $data['webTitle'];
                        $articleData[$key]['content'] = $data['webTitle'];
                        $articleData[$key]['publishedAt'] = Carbon::parse($doc['webPublicationDate'] ?? Carbon::today()->toDateString())->toDateTimeString();
                        $articleData[$key]['author'] = null;
                        $articleData[$key]['category'] = $doc['sectionName'] ?? null;
                    }
                }

                return $articleData;
            } elseif ($source->name === 'NewYorkTimes') {
                $articleData = [];
                $response = Http::get("$source->url", [
                    'api-key' => config("sources.$source->name.api_key"),
                    'fq' => 'pub_date:(' . Carbon::today()->toDateString() . ')',
                ]);

                if (!empty($response->json())
                    && !empty($response->json()['response'])
                    && !empty($response->json()['response']['docs'])
                ) {
                    foreach ($response->json()['response']['docs'] as $key => $doc) {
                        $articleData[$key]['title'] = $doc['headline']['main'] ?? $doc['abstract'] ?? null;
                        $articleData[$key]['content'] = $doc['lead_paragraph'] ?? null;
                        $articleData[$key]['publishedAt'] = Carbon::parse($doc['pub_date'] ?? Carbon::today()->toDateString())->toDateTimeString();
                        $articleData[$key]['author'] = $doc['byline']['original'] ? ltrim($doc['byline']['original'], 'By ') : null;
                        $articleData[$key]['category'] = $doc['source'] ?? null;
                    }
                }
                return $articleData;
            }
        } catch (Throwable $e) {
            report($e);
        }

        return [];
    }//end newsAPIAggregator()
}//end class

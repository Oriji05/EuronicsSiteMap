<?php

namespace App\Management;

use App\Api\CategoriaManagementInterface;
use App\Models\Category;
use App\Repository\CategoriaRepository;
use App\Repository\ProdottiRepository;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;
use vipnytt\SitemapParser;
use vipnytt\SitemapParser\Exceptions\SitemapParserException;

class CategoriaManagement implements CategoriaManagementInterface
{
    public function unsignedCategory()
    {
        $repository = app()->make(CategoriaRepository::class);
        $repository->save(Category::factory()->make(['categoria' => 'default']));

    }


    public function loadCategory()
    {
        $repository = app()->make(CategoriaRepository::class);
        $count = 0;
        try {
            if (Cache::has('urlsCategory')){
                $urls = Cache::get('urlsCategory');
            } else {
                $parser = new SitemapParser();
                $parser->parse('https://www.euronics.it/sitemap_1-category.xml');
                $urls = array_keys($parser->getURLs());
                shuffle($urls);
                Cache::put('urlsCategory', $urls, now()->addMinute(10));
            }
            foreach ($urls as $key => $url) {

                try {
                    $html = @file_get_contents($url);
                    $crawler = new Crawler($html);
                    if (Category::where('categoria', '=', $crawler->filterXPath("//h1[@class='catname']")->text())->get()->isEmpty()) {
                        $repository->save(Category::factory()->make(['categoria' => $crawler->filterXPath("//h1[@class='catname']")->text()]));
                        $count++;
                        if ($count > 2) {
                            break;
                        }
                    } else {
                        unset($urls[$key]);
                        Cache::put('urlsCategory', $urls, now()->addMinute(10));
                        $urls = Cache::get('urlsCategory');
                    }

                } catch (\InvalidArgumentException $e) {
                    echo "Nodo vuoto. \n";
                }

            }
        } catch (SitemapParserException $e) {
            echo $e->getMessage();
        }
    }

    public function getCategoria(string $url)
    {
        // TODO: Implement getCategoria() method.
    }
}

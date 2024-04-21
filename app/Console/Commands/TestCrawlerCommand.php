<?php

namespace App\Console\Commands;

use App\Management\CategoriaManagement;
use App\Management\ProdottoManagement;
use App\Models\Category;
use App\Models\Product;
use App\Repository\CategoriaRepository;
use App\Repository\ProdottiRepository;
use Illuminate\Console\Command;
use Symfony\Component\DomCrawler\Crawler;
use vipnytt\SitemapParser;
use vipnytt\SitemapParser\Exceptions\SitemapParserException;

class TestCrawlerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-crawler';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function handle(CategoriaManagement $categoriaManagement, ProdottoManagement $prodottoManagemt)
    {

        $prodottoManagemt->updatePrice();
        /*$repository = app()->make(ProdottiRepository::class);
        try {
            $parser = new SitemapParser();
            $parser->parse('https://www.euronics.it/sitemap_0-product.xml');
            foreach ($parser->getURLs() as $url => $tags) {

                try {

                    $html = @file_get_contents($url);
                    $crawler = new Crawler($html);
                    $category = Category::where('categoria', '=', $crawler->filterXPath("//div[@class='product-section']//li[3]")->text())->get()->first();

                    $repository->save(Product::factory()->make([
                        'titolo' => $crawler->filterXPath("//div[@class='product-section']//li[4]")->text(),
                        'prezzo' => $crawler->filterXPath("//p[@class='mb-0 price pcs-price font-bold']")->text(),
                        'url' => $url,
                        'categoria_id' => $category->getKey()
                        ]));

                } catch (\InvalidArgumentException $e) {
                    echo $e->getMessage() . "\n";
                }

            }
        } catch (SitemapParserException $e) {
            echo $e->getMessage();
        }*/

    }
}

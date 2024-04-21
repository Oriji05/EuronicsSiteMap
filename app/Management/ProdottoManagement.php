<?php

namespace App\Management;

use App\Api\ProdottoManagementInterface;
use App\Models\Category;
use App\Models\Product;
use App\Repository\ProdottiRepository;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;
use vipnytt\SitemapParser;
use vipnytt\SitemapParser\Exceptions\SitemapParserException;

class ProdottoManagement implements ProdottoManagementInterface
{
    public function loadProducts()
    {
        $count = 0;
        $repository = app()->make(ProdottiRepository::class);
        try {
            if (Cache::has('urls')){
                $urls = Cache::get('urls');
            } else {
                $parser = new SitemapParser();
                $parser->parse('https://www.euronics.it/sitemap_0-product.xml');
                $urls = array_keys($parser->getURLs());
                shuffle($urls);
                Cache::put('urls', $urls, now()->addMinute(10));
            }
            foreach ($urls as $key => $url) {

                try {

                    $html = file_get_contents($url);
                    $crawler = new Crawler($html);
                    echo $crawler->filterXPath("//div[@class='product-section']//li[4]")->text() . "\n";
                    if (Product::where('titolo', '=', $crawler->filterXPath("//div[@class='product-section']//li[4]")->text())->get()->isEmpty()){
                        if (!(Category::where('categoria', '=', $crawler->filterXPath("//div[@class='product-section']//li[3]")->text())->get()->isEmpty())) {
                            $category = Category::where('categoria', '=', $crawler->filterXPath("//div[@class='product-section']//li[3]")->text())->get()->first();
                            $repository->save(Product::factory()->make([
                            'titolo' => $crawler->filterXPath("//div[@class='product-section']//li[4]")->text(),
                            'prezzo' => $crawler->filterXPath("//p[@class='mb-0 price pcs-price font-bold']")->text(),
                            'price_updated_at' => now(),
                            'url' => $url,
                            'categoria_id' => $category->getKey()
                        ]));
                        } else {
                            $repository->save(Product::factory()->make([
                                'titolo' => $crawler->filterXPath("//div[@class='product-section']//li[4]")->text(),
                                'prezzo' => $crawler->filterXPath("//p[@class='mb-0 price pcs-price font-bold']")->text(),
                                'url' => $url,
                                'price_updated_at' => now()
                            ]));
                        }
                        $count++;
                        if ($count > 2) {
                            break;
                        }
                    } else {
                        unset($urls[$key]);
                        Cache::put('urls', $urls, now()->addMinute(10));
                        $urls = Cache::get('urls');
                    }

                } catch (\InvalidArgumentException $e) {
                    echo $e->getMessage() . "\n";

                }

            }
        } catch (SitemapParserException $e) {
            echo $e->getMessage();
        }

    }

    public function updatePrice()
    {
        $repository = app()->make(ProdottiRepository::class);
        $prodotti = Product::where('price_updated_at', '<', now()->subHour(24))->take(5)->get();
        foreach ($prodotti as $prodotto) {
            $prodotto->price_updated_at = now();
            $prodotto->prezzo = $this->prezzoAggiornato($prodotto->prezzo);
            $repository->save($prodotto);
            echo $prodotto->titolo;
        }
    }
    public function getCategoria(string $url)
    {
        // TODO: Implement getCategoria() method.
    }

    private function prezzoAggiornato(string $prezzo)
    {
        $prezzo = substr($prezzo, 2);
        $prezzo = (float)$prezzo;
        $prezzo = $prezzo * 1.1;
        return '€ ' . $prezzo;
    }
}

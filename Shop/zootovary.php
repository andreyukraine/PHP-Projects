<?php
//zootovary.com
class Zootovary extends Sites
{
    public static function GetProduct($code = null)
    {
        require_once("Utilites/phpQuery/phpQuery.php");

        $i = 1;
        $products = array();

        $c = 0;


        do {
            //$url = "http://topbrands.ru/search/?q=".urlencode($query)."&page=".$i."&perpage=90";
            //$url = "https://www.zootovary.com/advanced_search_result.php?inc_subcat=1&keywords=".urlencode($query)."&page=".$i;

            $url = "https://www.zootovary.com/Advance/Advance-m-82.html";

            $html = file_get_contents($url);
            phpQuery::newDocument($html);
            if ($i <= 1) {
                $pagesCount = pq('ul.pagination:eq(0) li:nth-last-child(2)')->length;
            }
            foreach (pq('#item') as $product) {
                $temp = 0;
                $products[$c]['url'] = pq($product)->find('a')->attr('href');
                $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                $products[$c]['name'] = pq($product)->find('img')->attr('alt');
                $p = 0;
                $offers = array();
                $opt = array();
                foreach (pq($product)->find('#options_name .attributes-price') as $key => $item) {
                    if ($code == pq($item)->find('input')->attr('value')){
                        return substr(pq($item)->find('.price div')->text(),0,-6);
                    }
                    $opt[$p]['sku'] = pq($item)->find('input')->attr('value');
                    $opt[$p]['offer'] = pq($item)->find('.option')->text();
                    $opt[$p]['price'] = pq($item)->find('.price div')->text();
                    $p++;
                }
                $offers[$c] = $opt;
                $products[$c]['offers'] = $opt;


                $c++;
            }
            $i++;
        } while ($i <= $pagesCount);

        return null;

    }
}


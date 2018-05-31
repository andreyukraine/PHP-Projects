<?php

class Zooapteka extends Sites {
    public static function GetProduct($code = null)
    {
        require_once("Utilites/phpQuery/phpQuery.php");

        $i = 1;
        $products = array();

        $c = 0;


        do {

            $url = "https://www.zooapteka.kiev.ua/search/search?search=Advance";

            $html = file_get_contents($url);
            phpQuery::newDocument($html);
            $pagesCount = 1;
            foreach (pq('.search-item') as $product) {
                $temp = 0;
                $products[$c]['url'] = pq($product)->find('a')->attr('href');
                $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                $products[$c]['name'] = pq($product)->find('img')->attr('alt');


                foreach (pq($product)->find('option') as $key => $item) {
                    if (pq($item)->attr('data-value') == $code) {

                        $price = substr (pq($item)->attr('data-price'), 0, strrpos(pq($item)->attr('data-price'), ' '));
                        return pq($price)->text();
                    };
                }

                $c++;
            }
            $i++;
        } while ($i <= $pagesCount);

        return null;

    }
}
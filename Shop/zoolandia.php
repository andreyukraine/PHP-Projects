<?php

class Zoolandia extends Sites {
    public static function GetProduct($code = null)
    {
        if($code == null){
            return 0;
        }else {
            require_once("Utilites/phpQuery/phpQuery.php");

            $i = 1;
            $products = array();

            $c = 0;


            do {

                $url = "http://zoolandia.com.ua/index.php?manufacturers_id=5";

                $html = file_get_contents($url);
                phpQuery::newDocument($html);
                //if ($i <= 1) {
                //$pagesCount = pq('ul.pagination:eq(0) li:nth-last-child(2)')->length;
                //}
                $pagesCount = 1;
                foreach (pq('.productListing-data') as $product) {
                    $temp = 0;
                    $products[$c]['url'] = pq($product)->find('a')->attr('href');
                    $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                    $products[$c]['name'] = pq($product)->find('img')->attr('alt');

                    $offers = array();
                    $opt = array();
                    if (pq($product)->attr('align') == 'right') {
                        foreach (pq($product)->find('form') as $key => $item) {
                            if (pq($item)->attr('id') == $code) {
                                return substr(pq($item)->find('.shopP q')->text(), 0, -7);
                            };

                        }
                    }
                    $offers[$c] = $opt;
                    $products[$c]['offers'] = $opt;


                    $c++;
                }
                $i++;
            } while ($i <= $pagesCount);
            return 0;
        }

    }
}
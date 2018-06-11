<?php
//paralapok.com.ua
class Paralapok extends Sites {
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
                $url = "http://paralapok.com.ua/29_advance?p=" . $i;

                $html = file_get_contents($url);
                phpQuery::newDocument($html);

                if ($i <= 1) {
                    $pagesCount = pq('.pagination li')->length - 2;
                }

                foreach (pq('.ajax_block_product') as $product) {
                    $pr = 0;
                    $products[$c]['url'] = pq($product)->find('a')->attr('href');
                    $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                    $products[$c]['name'] = pq($product)->find('img')->attr('alt');

                    if ("ajax_id_product_".$code == pq($product)->find('.button')->attr('rel')) {
                        $pr = substr(pq($product)->find('.price')->text(), 0, -7);
                        return $pr;
                    };


                    $c++;
                }
                $i++;
            } while ($i <= $pagesCount);
            return 0;
        }

    }
}
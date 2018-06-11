<?php
//korm.com.ua
class Korm extends Sites {
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
                $url = "https://korm.com.ua/search/?subcats=y&pcode_from_q=y&pshort=y&pfull=y&pname=y&pkeywords=y&search_performed=y&q=advance&page" . $i;
                $html = file_get_contents($url);
                phpQuery::newDocument($html);

                if ($i <= 1) {
                    $pagesCount = pq('.ty-pagination__items a')->length + 1;
                }
                foreach (pq('.ty-grid-list__item form') as $product) {
                    $pr = 0;
                    $products[$c]['url'] = pq($product)->find('a')->attr('href');
                    $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                    $products[$c]['name'] = pq($product)->find('img')->attr('alt');

                    if ("add_to_cart_update_".$code == pq($product)->find('.button-container div')->attr('id')) {
                        $pr = substr(pq($product)->find('.ty-price-num')->text(), 0, -8);
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
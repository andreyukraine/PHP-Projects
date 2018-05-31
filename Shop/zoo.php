<?php
//zoo.com.ua
class Zoo extends Sites {
    public static function GetProduct($code = null)
    {
        require_once("Utilites/phpQuery/phpQuery.php");

        $i = 1;
        $products = array();

        $c = 0;


        do {
            //$url = "http://topbrands.ru/search/?q=".urlencode($query)."&page=".$i."&perpage=90";
            //$url = "https://www.zootovary.com/advanced_search_result.php?inc_subcat=1&keywords=".urlencode($query)."&page=".$i;

            $url = "http://zoo.com.ua/catalog/?q=Advance&PAGEN_2=".$i;

            $html = file_get_contents($url);
            phpQuery::newDocument($html);
            if ($i <= 1) {
                $pagesCount = pq('.nums a')->length;
            }

            foreach (pq('.catalog_item') as $product) {
                $pr = 0;
                $products[$c]['url'] = pq($product)->find('a')->attr('href');
                $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                $products[$c]['name'] = pq($product)->find('img')->attr('alt');

                if (pq('.counter_wrapp div')->attr('data-item') == $code) {
                    $pr = substr(pq($product)->find('.item_info .price')->text(), 0, -7);
                    return $pr;
                };


                $c++;
            }
            $i++;
        } while ($i <= $pagesCount);

        return null;

    }
}
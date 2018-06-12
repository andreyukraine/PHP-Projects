<?php
//zoopitomec.org.ua
class Zoopitomec extends Sites
{
    public static function GetProduct($code = null)
    {
        if($code == null){
            return 0;
        }else{
            require_once("Utilites/phpQuery/phpQuery.php");

            $i = 1;
            $products = array();

            $c = 0;


            do {

                $url = "https://zoopitomec.org.ua/site_search/page_".$i."?search_term=Advance";

                $html = file_get_contents($url);
                phpQuery::newDocument($html);

                if ($i <= 1) {
                    $pagesCount = (int)pq('.b-pager__link:eq(2)')->text();
                }
                foreach (pq('li.b-online-edit') as $product) {
                    $temp = 0;
                    $products[$c]['url'] = pq($product)->find('a')->attr('href');
                    $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                    $products[$c]['name'] = pq($product)->find('img')->attr('alt');
                    if (pq($product)->attr('data-product-id') == $code){
                        return substr(pq($product)->find('.b-product-gallery__current-price')->text(), 0, -7);
                    }
                    $offers = array();
                    $opt = array();
                    $sku_product = "";

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


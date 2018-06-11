<?php
//zootovary.com
class Zootovary extends Sites
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
                    $sku_product = "";
                    foreach (pq($product)->find('#options_name .attributes-price') as $key => $item) {
                        foreach (pq($item)->find('form input') as $inp) {
                            if (pq($inp)->attr('name') == "products_id") {
                                $sku_product = pq($inp)->attr('value');
                            }
                            if (pq($inp)->attr('name') == "id[1]") {
                                $sku_product .= "_". pq($inp)->attr('value');
                                if ($code == $sku_product) {
                                    return substr(pq($item)->find('.price div')->text(), 0, -6);
                                }
                            }
                        }
                        $p++;
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


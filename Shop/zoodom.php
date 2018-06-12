<?php
//zoodom.com.ua
class Zoodom extends Sites
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

                $url = "http://zoo-dom.com.ua/shopsearch/".$i.".htm?fenum2=&fenum1=&next=1&q=advance&p=0";

                $html = file_get_contents($url);
                phpQuery::newDocument($html);

                if ($i <= 1) {
                    $pagesCount = pq('.paggination:eq(1) ul li')->length;
                }
                foreach (pq('.doplinksort table') as $product) {
                    if (pq('.doplinksort table tr td')->attr("width") == "188"){

                        $products[$c]['url'] = pq($product)->find('a')->attr('href');
                        $products[$c]['imgUrl'] = pq($product)->find('img')->attr('src');
                        $products[$c]['name'] = pq($product)->find('img')->attr('alt');
                        foreach (pq($product)->find('tr td table tr td table tr') as $offers){
                            if (pq($offers)->attr('itemprop') == "offers"){
                                $price_sku = 0;
                                $result = "";
                                foreach (pq($offers)->find('td') as $sku) {
                                    if ($price_sku == 0) {
                                        $price_sku = pq($sku)->find('span span')->text();
                                    }
                                    $result = pq($sku)->find('input')->attr('id');
                                }
                                if ($result == $code) {
                                    return $price_sku;
                                }
                            }
                        }

                        $offers = array();
                        $opt = array();
                        $sku_product = "";
                        $offers[$c] = $opt;
                        $products[$c]['offers'] = $opt;

                        $c++;
                    }

                }
                $i++;
            } while ($i <= $pagesCount);
            return 0;
        }

    }
}


<?php
header("Content-type: text/txt; charset=UTF-8");

if (isset($_GET['q'])) {
    if ($_GET['q'] == 1) {
        $table = "";
        $column = "";
        $uploaddir = $_SERVER['DOCUMENT_ROOT'];
        $file = $uploaddir .'/'. basename($_GET['file']);

        require("Utilites/PHPExcel/Classes/PHPExcel.php");

        $excel = PHPExcel_IOFactory::load(basename($file));
        foreach ($excel->getWorksheetIterator() as $worksheet) {
            $lists[] = $worksheet->toArray();
        }


        include_once '/sites.php';
        $q = new Sites();

        $table .= '<table class="table table-striped">';
        foreach ($lists as $list) {

                // Перебор строк
                $sites = $list[0];
                unset($list[0]);
                $temp_site = "";


            //вывводим сайты
            $table .= '<tr>';
                    foreach ($sites as $site){
                        $table .=  '<td>' . $site . '</td>';
                    }
            $table .=  '</tr>';

                //вывводим товары с ценной
                foreach ($list as $row) {

                    $table .=  '<tr>';
                    foreach ($row as $w => $col) {
                        $step = $w;

                        $temp_site = $sites[$w];
                        if ($w == 1) {
                            $rec_price = $col;
                        }
                        $result = "";
                        if ($w != 0 && $w != 1) {
                            $result = $q->make($temp_site,$col);
                            if ($result < $rec_price){
                                $color = "red";
                            }else{
                                $color = "black";
                            }
                            $table .= '<td style="color:'.$color.'">' . $result . '</td>';
                        } else {
                            $table .= '<td>' . $col . '</td>';
                        }

                    }
                    $table .= '</tr>';

                }
            $temp_site = "";



        }
        $table .= '</table>';
        $data = array(
            'table_g' => $table,
        );
        echo json_encode($data);

    }
}
?>
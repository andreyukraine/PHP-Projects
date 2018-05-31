<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Parser</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
</head>
<body>
<div class="container">
<?php


?>





        <!-- Название элемента input определяет имя в массиве $_FILES -->
        <div class="row" style="padding-top: 15px; padding-bottom: 15px">
            <div class="col-md-6 col-md-offset-3">
                <div class="wrapper">
                    <input type="file" multiple="multiple" accept=".txt,image/*">
                    <a href="#" class="upload_files button">Загрузить файлы</a>
                    <div class="ajax-reply"></div>
                    <button id="aj">Получить данные</button>
                </div>
            </div>
        </div>



        <div id="groupConsole">
        </div>

        <div id="loader" style="display: none"><img src="ajax-loader.gif"></div>

    <?php
//


?>
    <script type="text/javascript">

        $(document).ready(function(){
            var files; // переменная. будет содержать данные файлов




            // заполняем переменную данными файлов, при изменении значения file поля
            $('input[type=file]').on('change', function(){
                files = this.files;
            });

            // по окончанию загрузки страницы
            $('#aj').click(function(){      // вешаем на клик по элементу с id = example-1
                //отправляю GET запрос и получаю ответ
                // создадим данные файлов в подходящем для отправки формате

                $.ajax({
                    type: 'get',                        //тип запроса: get,post либо head
                    url: '/ajax.php',                    //url адрес файла обработчика
                    data: { 'q':'1', 'file': 'test.xlsx'},                  //параметры запроса
                    dataType: "JSON",
                    beforeSend: function() {
                        $('#loader').show();
                    },
                    success:function (data) {
                        //возвращаемый результат от сервера
                        $('#groupConsole').html(data.table_g);
                    },
                    complete: function() {
                        $('#loader').hide();
                    }

                }); // загрузку HTML кода из файла example.html
            })


// обработка и отправка AJAX запроса при клике на кнопку upload_files
            $('.upload_files').on( 'click', function( event ){

                event.stopPropagation(); // остановка всех текущих JS событий
                event.preventDefault();  // остановка дефолтного события для текущего элемента - клик для <a> тега

                // ничего не делаем если files пустой
                if( typeof files == 'undefined' ) return;

                // создадим данные файлов в подходящем для отправки формате
                var data = new FormData();
                $.each( files, function( key, value ){
                    data.append( key, value );
                });

                // добавим переменную идентификатор запроса
                data.append( 'my_file_upload', 1 );

                // AJAX запрос
                $.ajax({
                    url         : './submit.php',
                    type        : 'POST',
                    data        : data,
                    cache       : false,
                    dataType    : 'json',
                    // отключаем обработку передаваемых данных, пусть передаются как есть
                    processData : false,
                    // отключаем установку заголовка типа запроса. Так jQuery скажет серверу что это строковой запрос
                    contentType : false,
                    // функция успешного ответа сервера
                    success     : function( respond, status, jqXHR ){

                        // ОК
                        if( typeof respond.error === 'undefined' ){
                            // файлы загружены, делаем что-нибудь

                            // покажем пути к загруженным файлам в блок '.ajax-reply'

                            var files_path = respond.files;
                            var html = '';
                            $.each( files_path, function( key, val ){
                                html += val +'<br>';
                            } )

                            $('.ajax-reply').html( html );
                        }
                        // error
                        else {
                            console.log('ОШИБКА: ' + respond.error );
                        }
                    },
                    // функция ошибки ответа сервера
                    error: function( jqXHR, status, errorThrown ){
                        console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
                    }

                });

            });

        });



    </script>
</div>
</body>
</html>

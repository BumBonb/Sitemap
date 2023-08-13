<?php
require_once 'activator.php';

// список страниц

return [
    'pages' => [
        ['https://site.ru/', '2020-12-14', 1, 'hourly'],
        ['https://site.ru/news', '2020-12-10', 0.5, 'daily'],
        ['https://site.ru/about', '2020-12-07', 0.1, 'weekly'],
        ['https://site.ru/products', '2020-12-12', 0.5, 'daily'],
        ['https://site.ru/products/ps5', '2020-12-11', 0.1, 'weekly'],
        ['https://site.ru/products/xbox', '2020-12-12', 0.1, 'weekly'],
        ['https://site.ru/products/wii', '2020-12-11', 0.1, 'weekly']
    ],
   
    // форматы csv json xml
    
    'format' => 'json', 
    
    // пусть для сохранения файла карты сайта 
    
    'dir' => 'upload'
];
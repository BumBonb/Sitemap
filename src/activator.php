<?php

require_once 'SitemapGenerator.php';

$config = require 'config_sitemap.php';

try {
    $generator = new SitemapGenerator($config['format'], $config['dir'] . '/sitemap.' . $config['format']);

    foreach ($config['pages'] as $page) {
        $generator->addPage(...$page);
    }

    if (!is_dir($config['dir'])) {
        if (!mkdir($config['dir'], 0755, true)) {
            throw new DirectoryCreationException('Failed to create directory for saving.');
        }
    }

    $sitemapData = '';

    if ($config['format'] === 'xml') {
        $sitemapData = $generator->generateXML();
    } elseif ($config['format'] === 'csv') {
        $sitemapData = $generator->generateCSV();
    } elseif ($config['format'] === 'json') {
        $sitemapData = $generator->generateJSON();
    }

    file_put_contents($config['dir'] . '/sitemap.' . $config['format'], $sitemapData);

    echo "Sitemap generated and saved in directory: " . $config['dir'];
} catch (InvalidFormatException $e) {
    echo 'Invalid format specified.';
} catch (DirectoryCreationException $e) {
    echo 'Failed to create directory for saving.';
} catch (FileWriteException $e) {
    echo 'Failed to write to the file.';
} catch (\Exception $e) {
    echo 'An error occurred: ' . $e->getMessage();
}
<?php
class SitemapGenerator {
    private array $pages;
    private string $format;
    private string $filePath;

    public function __construct($format, $filePath) {
        $this->format = $format;
        $this->filePath = $filePath;

        if (!in_array($this->format, ['xml', 'csv', 'json'])) {
            throw new InvalidFormatException('Invalid format specified.');
        }
    }
    
    public function addPage($url, $lastModified = null, $priority = null, $changeFreq = null) {
        $this->pages[] = array(
            'loc' => $url,
            'lastmod' => $lastModified,
            'priority' => $priority,
            'changeFreq' => $changeFreq
        );
    }

    public function generateXML() {
        $xml = new DOMDocument('1.0', 'UTF-8');
        $xml->formatOutput = true;

        $urlset = $xml->createElementNS('http://www.sitemaps.org/schemas/sitemap/0.9', 'urlset');
        $urlset->setAttribute('xmlns:xsi', 'http://www.w3.org/2001/XMLSchema-instance');
        $urlset->setAttribute('xsi:schemaLocation', 'http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');

        foreach ($this->pages as $page) {
            $url = $xml->createElement('url');

            $loc = $xml->createElement('loc', $page['loc']);
            $lastmod = $xml->createElement('lastmod', $page['lastmod']);
            $priority = $xml->createElement('priority', $page['priority']);
            $changefreq = $xml->createElement('changeFreq', $page['changeFreq']);

            $url->appendChild($loc);
            $url->appendChild($lastmod);
            $url->appendChild($priority);
            $url->appendChild($changefreq);

            $urlset->appendChild($url);
        }

        $xml->appendChild($urlset);

        return $xml->saveXML();
    }
    
    public function generateCSV() {
    $csv = "loc,lastmod,priority,changeFreq\n";

    foreach ($this->pages as $page) {
    $csv .= "{$page['loc']},{$page['lastmod']},{$page['priority']},{$page['changeFreq']}\n";
    }

    return $csv;
    }

    public function generateJSON() {
    return json_encode($this->pages, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    }
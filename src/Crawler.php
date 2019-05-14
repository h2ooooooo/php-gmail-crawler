<?php


namespace jalsoedesign\GmailCrawler;

use \Google_Service_Gmail;

class Crawler
{
    /** @var Google_Service_Gmail */
    protected $service;

    public function __construct(Google_Service_Gmail $service) {
        $this->service = $service;
    }
}
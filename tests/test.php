<?php

use CLImax\ApplicationUtf8;
use CLImax\Plugins\HighlightPlugin;
use jalsoedesign\PersistentOAuthGoogleClient\Client;
use jalsoedesign\PersistentOAuthGoogleClient\ClientConfiguration;
use jalsoedesign\GmailCrawler\Crawler;

require_once(__DIR__ . '/../vendor/autoload.php');

class TestApplication extends ApplicationUtf8 {
    protected $crawler;

    public function init() {
        $this->registerPlugin(new HighlightPlugin());

        $config = new ClientConfiguration();
        $config->setAuthConfigPath(__DIR__ . '/../../lib/oauth.json');
        $config->setScopes([Google_Service_Gmail::GMAIL_READONLY]);
        $config->setTokenPath(__DIR__ . '/../../lib/gmail-user-token.json');

        $client = new Client($config);
        $client->setApplication($this);

        $forceRefresh = $this->arguments->has('refresh');
        if ($forceRefresh) {
            $this->info(sprintf('Forcing a reset because {{--refresh}} was passed!'));
        }

        $googleClient = $client->getGoogleClient($forceRefresh);
        $service = new Google_Service_Gmail($googleClient);

        $this->crawler = new Crawler($service);
    }

}

TestApplication::launch();
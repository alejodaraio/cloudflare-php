# cloudflare-php

[![Coverage Status](https://coveralls.io/repos/github/alejodaraio/cloudflare-php/badge.svg?branch=master)](https://coveralls.io/github/alejodaraio/cloudflare-php?branch=master)

Cloudflare v4 API with PHP

#### Example

```php
use CloudFlare;

$cf = new CloudFlare('email@email.com', 'theKey', 'theZoneId');

try {
  $urls = array('http://mysite.com/example');
  $tags = array();
  $cf->purge_files($urls, $tags);
}
catch(CloudFlareException $e) {
  print $e->getMessage();
}

```
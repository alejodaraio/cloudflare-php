# Cloudflare Purge Files

[![Coverage Status](https://coveralls.io/repos/github/alejodaraio/cloudflare-php/badge.svg?branch=master)](https://coveralls.io/github/alejodaraio/cloudflare-php?branch=master)

Small library for purge files on Cloudflare using the API version 4

#### Example

```php
use CloudFlare;

try {
  $cf = new CloudFlare('email@email.com', 'theKey', 'theZoneId');
  
  $urls = array('http://mysite.com/example');
  $tags = array();
  $cf->purge_files($urls, $tags);
}
catch(CloudFlareException $e) {
  print $e->getMessage();
}

```
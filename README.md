# Cloudflare Purge Files

Small library for purge files on Cloudflare using the API version 4

[![Coverage Status](https://coveralls.io/repos/github/alejodaraio/cloudflare-php/badge.svg)](https://coveralls.io/github/alejodaraio/cloudflare-php?branch=master)
[![Latest Stable Version](https://poser.pugx.org/alejodaraio/cloudflare-purgefile/v/stable)](https://packagist.org/packages/alejodaraio/cloudflare-purgefile)
[![Total Downloads](https://poser.pugx.org/alejodaraio/cloudflare-purgefile/downloads)](https://packagist.org/packages/alejodaraio/cloudflare-purgefile)
[![Daily Downloads](https://poser.pugx.org/alejodaraio/cloudflare-purgefile/d/daily)](https://packagist.org/packages/alejodaraio/cloudflare-purgefile)
[![Dependency Status](http://www.versioneye.com/user/projects/586a755cc1ff04003f9937d3/badge.svg?style=flat)](http://www.versioneye.com/user/projects/586a755cc1ff04003f9937d3)

#### Install

Installation should be done via composer, details of how to install composer can be found at https://getcomposer.org/

`composer require alejodaraio/cloudflare-purgefile`

#### Usage

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

License

MIT
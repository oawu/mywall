<?php
  define ('DOMAIN_NAME', preg_replace ("/^[\w]{2,6}:\/\/([\w\d\.\-]+).*$/", "$1", $_SERVER['SERVER_NAME']));

  switch (DOMAIN_NAME) {
    default:
    case 'test2.dymc.no-ip.org':
    case 'test.dymc.no-ip.org':
      define ('ENVIRONMENT', 'test');
      break;

    case 'dymc.no-ip.org':
      define ('ENVIRONMENT', 'server');
      break;
  }
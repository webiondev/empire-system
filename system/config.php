<?php
  //define("SITE_DOMAIN", "https://www.findloansg.com/");
  //define("DB_SERVER", "thesundaystudio.cddemi06qrpk.ap-southeast-1.rds.amazonaws.com");
  define("DB_SERVER", "localhost");
  define("DB_USERNAME", "root");
  define("DB_PASSWORD", '');
 // define("DB_SERVER", "thesundaystudio.cddemi06qrpk.ap-southeast-1.rds.amazonaws.com");
 //  define("DB_USERNAME", "empire");
 //  define("DB_PASSWORD", 'password@1');
  define("DB", "empire_portal");
  define("SITE_NAME", "Empire Portal");
  define("HASH_SECRET", "empire");
  define("ITEM_PER_PAGE", 50);
  define("ATTACHE_DOMAIN", "https://attache.fullstackbranding.com");
  define("ATTACHE_SECRET", "c8c6df27f1c74cd820d00e5dbf8b9ee095100f3e");
  define("FROM_EMAIL", "Full Stack Consultancy <no-reply@fullstackbranding.com>");

  $uuid = time();
  $expiration = strtotime("+60 minutes");

?>
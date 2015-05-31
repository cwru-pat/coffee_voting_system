<?php

define("DEFAULT_EXPIRATION_DATESTRING", '-1 Month');

define(
    "DEFAULT_ARXIVS_SERIALIZED",
    serialize(
        array(
        "astro-ph.CO",
        "astro-ph.HE",
        "astro-ph.GA",
        "astro-ph.IM",
        "gr-qc",
        "hep-ph",
        "hep-th"
        )
    )
);

define("ARXIV_RSS_BASE_URL", 'http://export.arxiv.org/rss/');

define("PHP_LOG_FILE", __DIR__.'/log/error.log');

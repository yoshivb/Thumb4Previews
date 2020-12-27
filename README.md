Piwigo Thumb 4 Previews
==============

This is a [Piwigo](http://piwigo.org/) plugin that will allow you to enable previews with thumbnails for example in the use of [Twitter Cards](https://dev.twitter.com/cards/types/summary-large-image)

Example usage:
==============
header.tpl
```
{if isset($PAGE_THUMB)}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{$GALLERY_TITLE}">
    <meta name="twitter:description" content="{$PAGE_TITLE}">
    <meta name="twitter:image" content="{$PAGE_THUMB}">
    <meta name="twitter:site" content="{$TWITTER_SITE}">
{/if}
```
# SeoBundle

This bundle takes the information from https://www.strangebuzz.com/en/blog/adding-a-custom-data-collector-in-the-symfony-debug-bar and wraps it in an installable bundle.

It alerts developers to pages where the length of the title or description outside of a defined range.

```bash
composer req survos/seo-bundle --dev
```

## Customize

```php
# config/packages/survos_seo.yaml
survos_seo:
    # branding will be added if the title is short enough.  So a title of "Welcome" becomes "MyBrand Welcome"
    branding:             '' 
    minTitleLength:       30
    maxTitleLength:       150
    minDescriptionLength: 10
    maxDescriptionLength: 255

```


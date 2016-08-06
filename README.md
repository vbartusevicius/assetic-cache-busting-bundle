# assetic-cache-busting-bundle
Provides proper cache busting for assetic.

### Installation
- `composer require vb/lib-assetic-cache-busting-bundle:^1.0`
- Register bundle in your `AppKernel`

### Usage
- Completely remove the `cache/*` folder as assetic holds some information there.
- Run `app/console assetic:dump`
- If you want to disable cache busting in `dev` environment, add this to your `app_dev.yml`:
```
vb_assetic_cache_busting:
    enabled: false
```

### How it works
Bundle registers `assetic.factory_worker`, which calculates hash on dumped asset. All hashes are stored in cache file.
The custom `VersionStrategyInterface` suffixes asset url with it's hash as a version, i.e.: `29d9e04.css?v=5ad5d41d`.
If asset contents are not changed, the hash will remain the same.

Original assetic cache busting works as long as you do not have variables in assets. 
It does not provide the list of variables to asset and with original cache busting the asset with variable will not be found. 

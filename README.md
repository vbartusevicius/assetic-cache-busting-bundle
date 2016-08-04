# assetic-cache-busting-bundle
Provides proper cache busting for assetic.

### Installation
- `composer require vb/lib-assetic-cache-busting-bundle:^1.0`
- Register bundle in your `AppKernel`

### Usage
- Completely remove the `cache/*` folder as assetic holds some information there.
- Run `app/console assetic:dump`

### How it works
Bundle registers `assetic.factory_worker`, which calculates hash on dumped asset. All hashes are stored in cache file.
The custom `VersionStrategyInterface` suffixes asset url with it's hash as a version, i.e.: `29d9e04.css?v=5ad5d41d`.
If asset contents are not changed, the hash will remain the same.


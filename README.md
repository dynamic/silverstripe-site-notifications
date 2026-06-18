# Silverstripe Site Notifications

Display site notifications like violators and pop ups

[![CI](https://github.com/dynamic/silverstripe-site-notifications/actions/workflows/ci.yml/badge.svg)](https://github.com/dynamic/silverstripe-site-notifications/actions/workflows/ci.yml) [![Sponsors](https://img.shields.io/badge/GitHub-Sponsors-ff69b4?logo=github)](https://github.com/sponsors/dynamic)

[![Latest Stable Version](https://poser.pugx.org/dynamic/silverstripe-site-notifications/v/stable)](https://packagist.org/packages/dynamic/silverstripe-site-notifications)
[![Total Downloads](https://poser.pugx.org/dynamic/silverstripe-site-notifications/downloads)](https://packagist.org/packages/dynamic/silverstripe-site-notifications)
[![Latest Unstable Version](https://poser.pugx.org/dynamic/silverstripe-site-notifications/v/unstable)](https://packagist.org/packages/dynamic/silverstripe-site-notifications)
[![License](https://poser.pugx.org/dynamic/silverstripe-site-notifications/license)](https://packagist.org/packages/dynamic/silverstripe-site-notifications)

## Requirements

* SilverStripe: ^6
* silverstripe/linkfield: ^5

## Installation

```
composer require dynamic/silverstripe-site-notifications
```

## License

See [License](LICENSE.md)

## Configuration

Apply `SiteTreeDataExtension` to `SiteTree`:

```yaml
SilverStripe\CMS\Model\SiteTree:
  extensions:
    - Dynamic\Notifications\Extension\SiteTreeDataExtension
```

## Template

In your top-level `Page.ss` template:

```html
<% if $Violators %>
    <div class="violators">
        <% loop $Violators %>
            <div id="special-discount-line-{$ID}" class="violators__violator top4">
                <div class="special-discount-content">
                    <div class="special-discount-text">
                        $Content
                    </div>
                </div>
            </div>
        <% end_loop %>
    </div>
<% end_if %>

<% if $PopUps %>
    <% loop $PopUps.Limit(1) %>
        <% if not $PopUpCookie %>
        <div id="eighteen" class="popup special-discount" data-cookie="$CookieName">
            $Content
        </div>
        <% end_if %>
    <% end_loop %>
<% end_if %>
```

## Maintainers

 *  [Dynamic](https://www.dynamicagency.com) (<dev@dynamicagency.com>)

## Bugtracker

Bugs are tracked in the issues section of this repository. Before submitting an issue please read over
existing issues to ensure yours is unique.

If the issue does look like a new bug:

 - Create a new issue
 - Describe the steps required to reproduce your issue, and the expected outcome. Unit tests, screenshots
 and screencasts can help here.
 - Describe your environment as detailed as possible: SilverStripe version, Browser, PHP version,
 Operating System, any installed SilverStripe modules.

Please report security issues to the module maintainers directly. Please don't file security issues in the bugtracker.

## Development and contribution

If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

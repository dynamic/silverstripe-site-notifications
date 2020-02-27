# Silverstripe Site Noitifcations

Display site notifications like violators and pop ups

## Requirements

* SilverStripe ^4.0
* dynamic/silverstripe-linkable ^1.0

## Installation

```
composer require dynamic/silverstripe-site-notifications
```

## License
See [License](license.md)

## Configuration

Apply `SiteTreeDataExtension` to `SiteTree`:

```yaml
SilverStripe\CMS\Model\SiteTree:
  extensions:
    - Dynamic\Notifications\Extension\SiteTreeDataExtension

```

## Template

In your top-level `Page.ss` template:

```yaml
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
*  [Dynamic](http://www.dynamicagency.com) (<dev@dynamicagency.com>)

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

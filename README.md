# ORCID Profile Link Provider

**NOTE: This plugin is a work in progress and not yet ready for production use.**

**NOTE: Please ensure you're using the correct branch. Use [ojs-dev-2_4 branch](https://github.com/defstat/OJS-ORCIDProfileLink) for OJS 2.4.x.**

Plugin for PKP user link to ORCID profiles (tested with OJS 2.x)

Copyright © National Documentation Centre

Licensed under GPL 2 or better.

## Features:

 * Hooks into the Issue View Page and Article View Page to add orcid profile link for the authors that are providing one.

## Install:

 * Copy the source into the PKP product's plugins/generic folder.
 * Run `tools/upgrade.php upgrade` to allow the system to recognize the new plugin.
 * Enable this plugin within the administration interface.

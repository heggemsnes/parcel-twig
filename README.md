# ParcelTwig plugin for Craft CMS 3.x

Get correct asset paths from Parcel when using Parcel Manifest.

![Screenshot](resources/img/plugin-logo.png)

## Requirements

This plugin requires Craft CMS 3.0.0-beta.23 or later.

## Installation

To install the plugin, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require heggemsnes/parcel-twig

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for ParcelTwig.

## ParcelTwig Overview

Simple plugin for extracting correct asset path from parcel-manifest.json when using parcel. Check out https://github.com/kult-byra/parcel-craft-docker for usecase.

## Configuring ParcelTwig

You can change the path to the parcel-manifest.json file as well as to your dist folder in the settings.

## Using ParcelTwig

Use the twig function {{asset("index.js")}} to generate a script tag linking to i.e. js.00a46daa.js bundle.

Brought to you by [Sigurd Heggemsnes](kult.design)

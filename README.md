# Arsors.GlobalContent
A NEOS extension package which adds a new backend menu item. It allows you to create global content and read it everywhere from fusion.

**Attention!! This package helped me to learn a few things about NEOS. It is a small rudimentary project which should be tested extensively before running in production mode.**

## Install
- Drop `composer require arsors/globalcontent` in your NEOS Project.
- Migrate database with `./flow doctrine:migrate`

## How to use
- Login into NEOS
- Go to the menu on the upper left corner
- Go to "Global Content"
- Add some data
- (Add some data for your content dimension. Use as dimension your content dimension value: de OR en OR en_US ...)
- Get the contents by fusion with: `varName = Arsors.GlobalContent:Get {key = 'your-feld-key'}`

## Content Dimensions
If you have a different content dimension as `language` you can set this in your `Settings.yaml` like:
```
Arsors:
  GlobalContent:
    contentDimension: language
```

## What else I can imagine in the future for this project:
- Automatically recognized content dimensions
- Synchronized keys between dimensions
- Better caching rules
- More types (integer, date, phone number and so on)
- Cleaner code

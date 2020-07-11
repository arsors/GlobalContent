# Arsors.GlobalContent
A NEOS extension package which adds a new page document type. It allows you to create global content and read it everywhere from fusion.

## Install
Drop `composer require arsors/globalcontent` in your NEOS Project.

## Setup global properties
- Create a `NodeTypes.GlobalContent.yaml` in your site package configuration folder.
- Fill into `NodeTypes.GlobalContent.yaml` and adjust:
```
'Arsors.GlobalContent:GlobalContent':
  ui:
    groups:
      default:
        label: 'General'
        collapsed: true
        icon: 'globe' # Use fontawesome icon titles (without icon- prefix)
      anotherGroup:
        label: 'Another Group'
        collapsed: false
  properties:
    set-a-key:
      type: string
      defaultValue: 'Default Value'
      ui:
        inlineEditable: TRUE
``` 
- Add one `Global Content` page to your site.

## Read global properties
- Get the contents by fusion with:
```
varName = getGlobalContent {
    key = 'your-feld-key'
}
```

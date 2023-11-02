# Arsors.GlobalContent
A NEOS extension package which adds a new page document type. It allows you to create global content and read it everywhere from fusion.

## Install
Drop `composer require arsors/globalcontent` in your NEOS Project.

## Setup single global content page
- Create a `NodeTypes.GlobalContent.yaml` in your site package configuration folder.
- Fill into `NodeTypes.GlobalContent.yaml` and adjust:
```
'Arsors.GlobalContent:GlobalContent':
  ui:
    inspector:
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
        group: 'default' # You can leave out the group (Standard group is 'default')
        inlineEditable: TRUE  
```
- Add one `Global Content` page to your site.

## Setup multiple global content pages
For multiple global content pages you have to add and adjust the Settings.yaml of your package. Also you have to add your global content yaml configuration and set your NodeType(s) to the Arsors.GlobalContent:Abstract prototype in fusion.

Follow these steps to achieve multiple global content pages:
- Add and adjust to your `Settings.yaml`:
```
Arsors:
  GlobalContent:
    instanceof:
      - 'Arsors.GlobalContent:GlobalContent'
      - 'Vendor.Packagename:AnotherGlobalContent'
```
- Create a `NodeTypes.GlobalContent.yaml` in your site package configuration folder.
- Fill into `NodeTypes.GlobalContent.yaml` and adjust:
```
'Arsors.GlobalContent:GlobalContent':
  ui:
    inspector:
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
        group: 'default' # You can leave out the group (Standard group is 'default')
        inlineEditable: TRUE

'Vendor.Packagename:AnotherGlobalContent':
  superTypes:
    'Arsors.GlobalContent:Abstract': true
  ui:
    label: 'Form Translation'
    icon: 'file'
  properties:
    set-another-key:
      type: string
      defaultValue: 'Your default value'
      ui:
        inlineEditable: TRUE
```
- Add to your fusion file:
```
prototype(Vendor.Packagename:AnotherGlobalContent) < prototype(Arsors.GlobalContent:Abstract)
```
- Add your global content pages to your site.

**TIP** If you want to deactivate the standard global content NodeType see below.

## Read global properties  
- Get the contents by fusion with:
```
varName = Arsors.GlobalContent:GetGlobalContent {
    key = 'your-feld-key'
}
```

## Deactivate standard global content NodeType
- Add `'Arsors.GlobalContent:GlobalContent': ~` in a NodeTypes yaml file

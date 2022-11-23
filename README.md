# Radiohead

A REDCap External Module that adds (grouping) headings to radio and checkbox fields.

## Installation

- Install this module from the REDCap External Module Repository and enable it.
- Enable the module in any projects that want to make use of it.

Manual installation:

- Clone this repo into `<redcap-root>/modules/redcap_radiohead_v<version-number>`.
- Go to _Control Center > External Modules > Manage_ and enable 'Radiohead'.
- Enable the module in any projects that want to make use of it.

## Configuration

A **debug** mode can be enable in the module's project settings. When enabled, some information about the module's actions that may be useful for troubleshooting is output to the browser console.

## Usage

The module's actions are controlled by **Action Tags**: 

- **`@RADIOHEAD`** will apply the module's effect to each tagged field. The action tag can be applied multiple times per field.

### Valid targets fields

- Multiple Choice - Radio Buttons (Single Answer)
- Mulitple Choice - Drop-down List (Single Answer)
- Checkboxes (Multiple Answers)

### Required parameter

The `@RADIOHEAD` action tag requries a parameter of type string wrapped in single or double quotes and separated from the action tag by an equal sign. The string must consist of a valid choice code followed by a comma and the text to be used for the label. Limited HTML is allowed. To apply multiple titles to a single field, simply add more `@RADIOHEAD` action tags. Their order does not matter.

Each title will then be inserted _above_ the choice label specified by the code given in the parameter.

Note, for dropdown lists, headings are added as so called option groups. An option group will extend to the very end of the list or until the next heading. To limit an option group to only a few items, simply add an empty header (i.e., specifiy a code only in another `@RADIOHEAD` action tag).

### Example

Consider a radio field with 7 options, encoded as 1 to 7. Before the first and fourth item, the headings "Items 1-3" and "Items 4-7" should be added. To insert these headings, use this:

```
@RADIOHEAD="1,Items 1-3"
@RADIOHEAD="4,Items 4-7"
```

## Changelog

Version | Comment
------- | -------------
1.0.0   | Initial release.
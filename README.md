# Magic Forms Honeypot
Dismisses bot submissions to Magic Forms using the honeypot technique.

Detected bot submissions won't be saved to the database or e-mailed anywhere at all.

## Requires
- PHP version 8.0 or higher

## Works with
- martin.forms
- blakejones.magicforms
- publipresse.forms
- webbook.forms

## Instructions
### Instal the plugin
`php artisan plugin:install RegularJogger.MagicFormsHoneypot --from=git@github.com:regularjogger/magicformshoneypot-plugin.git`

### Add the honeypot field to your form markup
`{% component 'honeypotField' %}` is made available to you to do that. Just place it logically in your markup so it makes sense in the context of the form.

### Check the event log for dismissed submissions
Dismissed submissions are being logged to the event log (form alias/name with data posted + URL, User-Agent and IP address of the request) instead of being saved to the database and e-mailed according to your configuration.

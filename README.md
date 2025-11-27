# Magic Forms Honeypot
Dismisses bot submissions to Magic Forms using the honeypot technique.

Detected bot submissions won't be saved to the database or e-mailed anywhere at all.

## Works with
- martin.forms
- blakejones.magicforms
- publipresse.forms

## Instructions
### Instal the plugin
`php artisan plugin:install RegularJogger.MagicFormsHoneypot --from=git@github.com:regularjogger/magicformshoneypot-plugin.git`

### Add the honeypot field to your form markup
`{{ honeypot_field() }}` twig function is made available to you to do that. Just add it logically to your markup so it makes sense in the context of the form.

The default output of that function is `<label>Web <input type="text" id="web" name="web" placeholder="www" class="web-form-control"></label>`.

*TODO: Describe customizing the field by passing strings as arguments to the twig function.*

### Add this CSS to your stylesheet
`label:has(input.web-form-control) { display: none; }`

**DO NOT** inline this CSS. Place it in one of your stylesheets.

*TODO: Note to change the class according to customizations made to the honeypot_field twig function output.*

### Check the event log for dismissed submissions
Dismissed submissions are being logged to the event log (form alias/name with data posted) instead of being saved to the database and e-mailed according to your configuration.

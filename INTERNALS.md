# Implementation Details

## Offset Configurations

Configurations are held in app/config/offsets.yml. YAML was chosen as it is
concise and easy to edit by hand. It is compiled to a PHP array and cached
for efficiency and to reduce project dependencies.

See `app/console.php build:offsets --help`.

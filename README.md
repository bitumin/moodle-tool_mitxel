# Moodle plugin - Admin Tool Mitxel

A Moodle admin tool plugin

## Run tests

### Prepare testing db

```
php admin/tool/behat/cli/init.php
php admin/tool/phpunit/cli/init.php
```

### Run Behat tests
```
php admin/tool/behat/cli/run.php --tags="@tool_mitxel"
```

### Run PHPUnit tests

```
vendor/bin/phpunit admin/tool/mitxel/tests/api_test.php
vendor/bin/phpunit admin/tool/mitxel/tests/events_test.php
vendor/bin/phpunit admin/tool/mitxel/tests/privacy_provider_test.php
```

## License

2018 Mitxel Moriana <mitxel@tresipunt.com>

This program is free software: you can redistribute it and/or modify it under
the terms of the GNU General Public License as published by the Free Software
Foundation, either version 3 of the License, or (at your option) any later
version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with
this program.  If not, see <http://www.gnu.org/licenses/>.


Sample WordPress Theme
===

This is a WordPress sample theme intended to demonstrate good practices in theme development. 
Use it as-is for a blog, or extend it into a more fully featured site.
[See a demo here](https://sampletheme.jamiebergen.com/).

The theme was built from the `_s` starter theme (also known as `underscores`). Features include:

* Sass: Styles are organized in modular `.scss` files and compiled using the [Sass CSS preprocessor](https://sass-lang.com/).
* Gulp: Makes use of [WP-Gulp](https://github.com/ahmadawais/WPGulp), an easy-to-use WordPress Gulp boilerplate. This enables live browser reloads using BrowserSync, Sass to CSS conversion, autoprefixing, CSS minification, JS concatenation, and image minification, among other things.
(Note that `gulp-zip` was added to generate an installable zip file of the theme.)
* Modern CSS: Layouts were achieved using Flexbox and CSS Grid.
* Accessible and responsive multi-level menu based on [responsive-nav.js](https://github.com/viljamis/responsive-nav.js)
* Strings are translation ready.

Testing
---------------

The theme was tested as follows:

1. Verify that the theme doesn't cause any PHP or JavaScript errors.
2. [Validate HTML and CSS](https://codex.wordpress.org/Validating_a_Website).
3. Import WordPress [Theme Unit Test](https://codex.wordpress.org/Theme_Unit_Test) data.
4. Create a page with [Gutenberg test content](https://sridharkatakam.com/dummy-content-for-gutenberg/).
5. Run [Theme Check](https://wordpress.org/plugins/theme-check/) plugin
6. Test for compliance with [WCAG 2.0 accessibility guidelines](https://www.w3.org/WAI/intro/wcag), Level AA 
7. Test on common browsers - based on [w3schools.com browser usage statistics](https://www.w3schools.com/browsers/default.asp) 
8. Test on common devices - based on [BrowserStack guidelines](https://www.browserstack.com/test-on-the-right-mobile-devices)
9. !!!TO DO: Test for adherence with WordPress coding standards using [PHP_CodeSniffer](https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards)

Gists and Documentation
---------------

* [Accessible and translatable "read more" link for excerpts](https://gist.github.com/48d41daa1ec6ffe3bc6276d8506ab3bc)
* [Accessible search form using icon for submit button](https://gist.github.com/d5f15744341b8b6dbc37212cc3460df0)
* [Responsive, accessible menu based on responsive-nav.js](https://gist.github.com/d08164cbf17671732782fd4e807599a3)

To use the theme in a WordPress install
---------------

* Download jmb-sample-theme.zip and upload it via the WordPress dashboard (Admin > Appearance > Themes).
* It is recommended that you create a [child theme](https://codex.wordpress.org/Child_Themes) if you want to make modifications.

To continue development on the theme
---------------

1. Set up a fresh WordPress install on your local machine.
2. `git clone` the project into your themes directory.
3. Update the `projectURL` variable in `gulpfile.js` to match your local project URL.
4. Ensure that you have NodeJS, NPM, and Gulp installed on your local machine. (If not, refer to the instructions [here](https://github.com/ahmadawais/WPGulp).)
5. Navigate to the root of jmb-sample-theme directory and run the command `sudo npm install`. This will create a `node_modules` folder.
6. Type the `gulp` command. This will launch the site in your browser and enable live reloads using BrowserSync.
7. To stop Gulp, press `CTRL (⌃) + C`.

Optional commands:
```
# To generate a zip file of the theme (excluding Sass and Gulp files/folders)
gulp zip
```
```
# To optimize images
gulp images
```
```
# To generate WP POT translation file.
gulp translate
```

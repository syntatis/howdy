# 👋 Howdy

> [!CAUTION]  
> This project is still under active development. It's not quite ready for production use *yet*.

**Howdy** is a starter kit for creating WordPress plugins. It gives you an opinionated structure with pre-configured tools to help you start developing plugins using modern PHP practices like [PSR-4 Autoloading](https://www.php-fig.org/psr/psr-4/) with [Composer](https://getcomposer.org), [PHP Code Sniffer (PHPCS)](https://github.com/PHPCSStandards/PHP_CodeSniffer), namespaces, and Dependency Injection (DI) Containers—without the hassle of setting everything up from scratch.

## Requirements

- PHP 7.4 or higher
- Node.js 18 or higher
- [Composer](https://getcomposer.org)

## Usage

To start a new plugin project, simply run:

```bash
composer create-project syntatis/howdy -s dev
```

This command will set up the boilerplate files in a directory named `howdy`. It will ask you a few questions to customize your project, like the plugin name, slug, and PHP namespace.

![Composer create-project command run in Terminal](/art/composer-create-project-terminal.png)

Once you've input all these details, it will scope the plugin dependency libraries to prevent naming conflicts with other plugins which may also be using the same libraries. You can find the scoped dependencies in the `dist-autoload` directory.

> [!TIP]  
> Want to create the project in a different folder? Just add the directory name at the end of the command, like this:
> ```bash
> composer create-project syntatis/howdy -s dev awesome-plugin
> ```
> This will create the project in the `awesome-plugin` directory.  
> For more details, check out the [Composer CLI documentation](https://getcomposer.org/doc/03-cli.md#create-project).

After the project setup is complete, run the following command within your plugin directory to start compiling the assets, like the stylesheets and the JavaScript files. It will also watch for the changes within the files and recompile them automatically.

```bash
npm install
npm run start
```

## References

- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/) for plugin guidelines.
- [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate) for inspiration.

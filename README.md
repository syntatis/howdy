# 👋 howdy

> [!CAUTION]
> This boilerplate is currently in active development. It is not recommended for production use *just yet*.

Provides an opinionated structure with pre-configured tools, helping you start developing a new WordPress plugin with some common (modern) approaches in PHP such as [PSR-4: Autoloader](https://www.php-fig.org/psr/psr-4/) with [Composer](https://getcomposer.org/), [PHP Code Sniffer (PHPCS)](https://github.com/PHPCSStandards/PHP_CodeSniffer), Namespace scoping, and Dependency Injection (DI) Container without the hassle of setting up everything from scratch.

## Requirements

- PHP 7.4 or higher
- Node.js 18 or higher
- [Composer](https://getcomposer.org/)

## Usage

To start a new plugin project using this boilerplate, run:

```bash
composer create-project syntatis/howdy -s dev
```

This command will create a project with the boilerplate in the directory named `howdy`. It will also prompt a few questions to set up the project details, such as the project name, the plugin name, the plugin slug, and the PHP namespace.

![Composer create-project command run in Terminal](/art/composer-create-project-terminal.png)

Once you've input all these details, it will run a command to scope the plugin dependencies to prevent naming conflicts with other plugins. You can find the scoped dependencies in the `dist-autoload` directory.

> [!TIP]
> If you want to create a new project in a custom directory, we can specify the directory name at the end of the command, for example:
> ```bash
> composer create-project syntatis/howdy -s dev awesome-plugin
> ```
> This command will create the project in the directory named `awesome-plugin` instead.
> For more information, see [Composer CLI documentation on creating a project](https://getcomposer.org/doc/03-cli.md#create-project).

Once the project setup is complete, run the following command within your plugin directory to start compiling the assets, like the stylesheets and the JavaScript files. It will also watch for the changes within the files and recompile them automatically.

```bash
npm install
npm run start
```

## References

* [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/), for the guidelines.
* [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate), for the inspiration.

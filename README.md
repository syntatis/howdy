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

This command will set up the boilerplate files in a directory named `howdy`. It will ask you a few questions to customize your project, like the plugin slug, name, and the PHP namespaces.

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

## Commands

Commands are available to help you with the development process. You can run these commands from the root of your plugin directory.

<table>
    <thead>
        <th width="40%">Command</th>
        <th>Description</th>
    </thead>
    <tbody>
        <tr>
            <td><code>composer codex:project init</code></td>
            <td>Initializes the project. It runs automatically after creating the project. But if if failed and you need to re-run it, you can do so with this command. It will prompt you with a few questions, such as to enter the plugin name, slug, and PHP namespaces.</td>
        </tr>
        <tr>
            <td><code>composer scope</code></td>
            <td>Scopes the plugin dependencies to prevent naming conflicts with other plugins. Typically you'd need to run it after installing a new dependencies or updating the existing ones.</td>
        </tr>
</table>


## References

- [WordPress Plugin Handbook](https://developer.wordpress.org/plugins/) for plugin guidelines.
- [WordPress Plugin Boilerplate](https://github.com/DevinVinson/WordPress-Plugin-Boilerplate) for inspiration.

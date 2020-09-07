# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/42coders/workflows.svg?style=flat-square)](https://packagist.org/packages/42coders/workflows)
[![Build Status](https://img.shields.io/travis/42coders/workflows/master.svg?style=flat-square)](https://travis-ci.org/42coders/workflows)
[![Quality Score](https://img.shields.io/scrutinizer/g/42coders/workflows.svg?style=flat-square)](https://scrutinizer-ci.com/g/42coders/workflows)
[![Total Downloads](https://img.shields.io/packagist/dt/42coders/workflows.svg?style=flat-square)](https://packagist.org/packages/42coders/workflows)

The Workflow Package add Drag & Drop Workflows to your Laravel Application. A Workflow consists of a Triggers and Tasks.
The Trigger is responsible for starting a Workflow. The Tasks are single nodes of code execution. The package comes
with some handy tasks bundled, but you can easily write your own as well.

If you are interested of news and updates 
- Follow me on [Twitter](https://twitter.com/gwagwagwa) && || register to our [Newsletter](https://workflows.42coders.com)

## Installation

You can install the package via composer:

```bash
composer require 42coders/workflows
```

Notes to the Early Access Users. You have to manually clone the Package to a folder inside of the Project you want
to use the Package in or next to it.

After you have clonded it locally you need to add it to Projects composer.json file.

First you need to set the local repository. 
In the example the Package is in the subfolder of the same parent folder as the Project is.

```json
"repositories": [
    {
        "type": "path",
        "url": "../packages/workflows"
    }
],
```

The next step is to register it as a dependency. To do so add it to the required Packages.

```json
"the42coders/workflows": "*"
``` 

You need to register the routes to your web.php routes File as well.

```php
\the42coders\Workflows\Workflows::routes();
```

You need to publish the assets of the Package

```bash
php artisan vendor:publish --provider="the42coders\Workflows\WorkflowsServiceProvider"  --tag=assets  
```

Other publishable Contents are

config

```bash
php artisan vendor:publish --provider="the42coders\Workflows\WorkflowsServiceProvider"  --tag=config  
```

language

```bash
php artisan vendor:publish --provider="the42coders\Workflows\WorkflowsServiceProvider"  --tag=lang  
```

views

```bash
php artisan vendor:publish --provider="the42coders\Workflows\WorkflowsServiceProvider"  --tag=views  
```

## Usage

The Workflow Package is working out of the Box in your Laravel application. Just go to the route /workflows 
to get started.

### Workflows

A Workflow is gets started by a Trigger and then executes the Tasks in the Order you set them. 
To pass information between the Tasks we have the DataBus. 

### Triggers

A Trigger is the Starting Point and defines how a Workflow gets called. 

#### ObserverTrigger

The Observer Trigger can listen to Eloquent Model Events and will then pass the Model which triggered the Event to the 
Workflow.

To make it Work add the WorkflowObservable to your Eloquent Model. 

``` php
 use WorkflowObservable;
```

### Tasks

A Task is a single code execution Node in the Workflow. 

#### HtmlInput

The HtmlInput Task offers you a Trix Input Field which is able to render Blade. You can put in placeholders for dynamic
content in two Ways.
 1. From the Model passed through the Workflow
 2. From the DataBus
 
#### Execute

The Execute Task offers you to execute Shell Commands and is able to push the output of them to the DataBus.

#### PregReplace

The PregReplace Task offers you a way to to a preg replace on a Value from the Model or a DataBus Variable.

#### DomPDF 

The DomPDF Task offers you a way to generate a PDF from HTML and put it to the DataBus 
(Works great with the HtmlInput Task).

#### SaveFile

The SaveFile Task allows you to save Data to a File. Works easy with your registered Storage defines.

#### SendMail

The SendMail Task allows you to send a Mail. You can pass the Content and Attachments to it. 
(Works great with HtmlInput and DomPDF) 

#### HttpStatus

The HttpStatus offers you a way to receive the Http Status of a given url.

### DataBus

The DataBus is a way to pass information between the single Tasks. This keeps the Tasks independent to each other.

#### ValueResource

The Value Resource is the simplest Resource. You can just write your Data in an input field.

#### ConfigResource 

The Config Resource let you access values from your Config Files.

#### ModelResource

The ModelResource lets you access the Data from the passed Eloquent Model.

#### DataBusResource

The DataBusResource lets you acces the Data from the DataBus. This means all values which got set by a
previous Task are access able here.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email max@42coders.com instead of using the issue tracker.

## Credits

- [Max Hutschenreiter](https://github.com/42coders)
- [All Contributors](../../contributors)
- jerosoler for [Drawflow](https://github.com/jerosoler/Drawflow)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).

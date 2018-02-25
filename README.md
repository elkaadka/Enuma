# Enuma

Package that will help you create and Edit php classes, interfaces and traits dynamically

![build](https://travis-ci.org/elkaadka/Enuma.svg?branch=master)

# Create classes, interfaces and traits

## Basic usage

1. <u>Create a class</u>

```php

$phpClass = new PhpClass('Foo');

$enuma = new Enuma();
$enuma->save($phpClass, 'path/to/a/file);

```

will create or rewrite the file with :

```php
<?php

class Foo
{

}

```

2. <u>Create an interface</u>

```php

$phpInterface = new PhpInterface('Foo');

$enuma = new Enuma();
$enuma->save($phpInterface, 'path/to/a/file);

```

will create or rewrite the file with :

```php
<?php

interface Foo
{

}

```

3. <u>Create a trait</u>

```php

$phpTrait = new PhpTrait('Foo');

$enuma = new Enuma();
$enuma->save($phpTrait, 'path/to/a/file);

```

will create or rewrite the file with :

```php
<?php

trait Foo
{

}

```

## Advanced usage

### Coding style

Default coding style is PSR2.
If you need to customize it you can :

1. Encoding

Default PSR2 encoding is UTF-8, if you want to use yours :

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setEncoding('your encoding');
```

2. Php Closing Tag

Default behaviour is not having the ?> closing tag 
If you want to have it :

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setUsePhpClosingTag(true);
```

3. Indentation

Default behaviour is 4 spaces, 
If you want to change it (only space characters allowed):

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setIndentation("\t");
```

4. Class braces

Default behaviour is class opening braces in new line, 
If you want to have them on same line as the class:

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setClassBracesInNewLine(false);

//will generate : 

class A {

}
```

4. Method braces

Default behaviour is method's opening braces in new line, 
If you want to have them on same line as the method:

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setMethodBracesInNewLine(false);

//will generate : 

class A 
{
    public function aaa() {
    
    }
}
```

5. Unix line feed

Default behaviour is having an extra new line after class braces closing, 
If you don't want to have it:

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setUnixLineFeedEnding(false);
```

6. Windows new line

Default behaviour is Unix new line \n
Ifw you want to have windows new line \r\n:

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->useWindowsNewLine(true);
```

7. Array annotation

Default behaviour is short annotation []
If you want to use standard annotation array() :
```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->useShortArrayNotation(false);
```

8. Auto comments

Default behaviour is adding automatic @param and @return comments for methods
If you don't want to have them:

```php
$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setAutoComments(false);
```


### Class creation


you can define many things when creating a class/interface/trait :

1. Coding style:

```php

$customCodingStyle = new CustomCodingStyle();
$customCodingStyle->setClassBracesInNewLine(false);

$phpClass = new PhpClass('Foo', $customCodingStyle);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);
```

will output:

```php
<?php

class Foo {

}

```

2. <u>Namespace</u>

<b>Works for : PhpClass, PhpInterface and PhpTrait</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass->namespace('My\\Name\\Space');

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```

will output:

```php
<?php

namespace My\Name\Space; 

class Foo
{

}

```

3. <u>Use classes</u>

<b>Works for : PhpClass, PhpInterface and PhpTrait</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass->use('My\\Package\\Class1');

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

use My\Package\Class1;

class Foo
{

}

```

4. <u>Class comment</u>

<b>Works for : PhpClass, PhpInterface and PhpTrait</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->use('My\\Package\\Class1')
    ->addComment("This is my class\n@package My\\Name\\Space");

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

use My\Package\Class1;

/**
 * This is my class
 * @package My\Name\Space
 */
class Foo
{

}

```

5. <u>Make class Abstract</u>

<b>Only Works for PhpClass</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->abstract(true);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

abstract class Foo
{

}

```

6. <u>Make class Final</u>

<b>Only Works for PhpClass</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->final(true);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

final class Foo
{

}

```

Since a class can either be final or abstract, setting one to true automatically sets the other to false.


7. <u>Extend a class </u>

<b>Only Works for PhpClass</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->extends('My\\OtherPackage\\Class2');

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

use My\OtherPackage\Class2;

final class Foo extends Class2
{

}
```

8. <u>Implement interfaces</u>

<b>Only Works for PhpClass</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->implements('My\\OtherPackage\\Interface1')
    ->implements('My\\OtherPackage\\Interface2');

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

use My\OtherPackage\Interface1;
use My\OtherPackage\Interface2;

class Foo implements Interface1, Interface2
{

}
```


9. <u>Use a trait</u>

<b>Works for PhpClass and PhpTrait</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->useTrait('My\\OtherPackage\\Trait1')
    ->useTrait('My\\OtherPackage\\Trait2');

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

use My\OtherPackage\Trait1;
use My\OtherPackage\Trait2;

class Foo
{
    use Trait1;
    use Trait2;
}
```


10. <u>add a Constant</u>

<b>Works for PhpClass and PhpInterface</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addConst(new Constant('MY_CONST', true));
    ->addConst(new Constant('MY_OTHER_CONST', array(1, 2, 3));


$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    const My_CONST = true;
    const MY_OTHER_CONST = [1, 2, 3];
}
```

10.1. <u>add a Property</u>

<b>Works for PhpClass and PhpTrait</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addProperty(new Property('property1'));

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    public $property1;
}
```

10.2. <u>Set a visibility for a property</u>

You can specify a visibility for the property using the Hint class constants:

```
Kanel\Enuma\Hint\Visibility::PROTECTED;
Kanel\Enuma\Hint\Visibility::PUBLIC;    <-- default
Kanel\Enuma\Hint\Visibility::PRIVATE;
```

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addProperty(new Property('property1', Visibility::PROTECTED));

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    protected $property1;
}
```

10.3. <u>Set a property as static</u>

```php
$property = new Property('property1', Visibility::PROTECTED);
$property->setIsStatic(true);

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addProperty($property);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);
```


will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    protected static $property1;
}
```

10.4. <u>Set a property's default value</u>

```php
$property = new Property('property1', Visibility::PROTECTED);
$property->setValue(null);

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addProperty($property);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);
```

will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    protected static $property1 = null;
}
```

11. <u>add a Method</u>

<b>Works for : PhpClass, PhpInterface and PhpTrait</b>

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod(new Method('bar'));

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * @return mixed 
     */
    public function bar()
    {
        
    }
}
```

11.1. <u>add a Method Visibility</u>

For interfaces, visibility is always public

```php

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod(new Method('bar', Visibility::PROTECTED));

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * @return mixed 
     */
    protected function bar()
    {
        
    }
}
```


11.2. <u>Set Method as static</u>

```php

$method = new Method('bar', Visibility::PROTECTED);
$method->setIsStatic(true);

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod($method);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * @return mixed 
     */
    protected static function bar()
    {
        
    }
}
```

11.3. <u>Set Method as abstract (and the class implicitly)</u>

```php

$method = new Method('bar', Visibility::PROTECTED);
$method->setIsAbstract(true);

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod($method);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

abstract class Foo
{
    /**
     * @return mixed 
     */
    abstract protected function bar();
}
```

11.4. <u>Set Method as final</u>

```php

$method = new Method('bar', Visibility::PROTECTED);
$method->setIsFinal(true);

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod($method);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * @return mixed 
     */
    final protected function bar()
    {
        
    }
}
```

Since a method can either be final or abstract, setting one to true automatically sets the other to false.

11.5. <u>add Method comment</u>

```php

$method = new Method('bar', Visibility::PROTECTED);
$method->setComment('This is my function');

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod($method);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * This is my function
     * @return mixed 
     */
    protected function bar()
    {
        
    }
}
```

11.6. <u>add Method Return type</u>

```php

$method = new Method('bar', Visibility::PROTECTED);
$method->setReturnType('bool');

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod($method);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * This is my function
     * @return bool
     */
    protected function bar(): bool
    {
        
    }
}
```

11.6. <u>add Method parameters</u>

```php

$method = new Method('bar', Visibility::PROTECTED);
$parameter = new Parameter("test");
$parameter->setValue(true);
$parameter->setType('bool');

$method->addParameter($parameter);

$phpClass = new PhpClass('Foo');
$phpClass
    ->namespace('My\\Name\\Space')
    ->addMethod($method);

$enuma = new Enuma();
echo $enuma->stringify($phpClass);

```
will output:

```php
<?php

namespace My\Name\Space;

class Foo
{
    /**
     * @param bool $test   
     * @return mixed
     */
    protected function bar(bool $test = true)
    {
        
    }
}
```

### Edit classes

Coming soon
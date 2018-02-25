<?php

namespace spec\Kanel\Enuma;

use Kanel\Enuma\CodingStyle\CustomCodingStyle;
use Kanel\Enuma\Php\Php;
use Kanel\Enuma\Php\PhpClass;
use Kanel\Enuma\Entity\Constant;
use Kanel\Enuma\Entity\Method;
use Kanel\Enuma\Entity\Parameter;
use Kanel\Enuma\Entity\Property;
use Kanel\Enuma\Enuma;
use Kanel\Enuma\Hint\Type;
use Kanel\Enuma\Hint\Visibility;
use Kanel\Enuma\Php\PhpInterface;
use Kanel\Enuma\Php\PhpTrait;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EnumaSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Enuma::class);
    }

    function it_should_be_able_to_stringify_standalone_class()
	{
		$phpClass = new PhpClass('Foo');
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

class Foo
{

}
');
	}

	function it_should_be_able_to_specify_namespace()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

class Foo
{

}
');
	}

	function it_should_be_able_to_use_classes()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$phpClass->use('Kanel\Enuma\Test\Fake1');
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

class Foo
{

}
');
	}

	function it_should_be_able_to_define_class_abstract()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$phpClass->use('Kanel\Enuma\Test\Fake1');
		$phpClass->abstract();
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

abstract class Foo
{

}
');
	}

	function it_should_be_able_to_define_class_final()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$phpClass->use('Kanel\Enuma\Test\Fake1');
		$phpClass->final();
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

final class Foo
{

}
');
	}

	function it_should_be_either_abstract_or_final_1()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$phpClass->use('Kanel\Enuma\Test\Fake1');
		$phpClass->final();
		$phpClass->abstract();
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

abstract class Foo
{

}
');
	}

	function it_should_be_either_abstract_or_final_2()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$phpClass->use('Kanel\Enuma\Test\Fake1');
		$phpClass->abstract();
		$phpClass->final();
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

final class Foo
{

}
');
	}

	function it_should_be_able_to_extend_a_class()
	{
		$phpClass = new PhpClass('Foo');
		$phpClass->namespace('Kanel\Enuma\Test');
		$phpClass->use('Kanel\Enuma\Test\Fake1');
		$phpClass->extends('Kanel\Enuma\Test\Fake2');
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;

class Foo extends Fake2
{

}
');
	}

    function it_should_be_able_to_implement_an_interface()
    {
        $phpClass = new PhpClass('Foo');
        $phpClass->namespace('Kanel\Enuma\Test');
        $phpClass->use('Kanel\Enuma\Test\Fake1');
        $phpClass->implements('Kanel\Enuma\Test\Interface1');
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Interface1;

class Foo implements Interface1
{

}
');
    }

    function it_should_be_able_to_implement_many_interfaces()
    {
        $phpClass = new PhpClass('Foo');
        $phpClass->namespace('Kanel\Enuma\Test');
        $phpClass->use('Kanel\Enuma\Test\Fake1');
		$phpClass->implements('Kanel\Enuma\Test\Interface1');
		$phpClass->implements('Kanel\Enuma\Test\Interface2');
        $phpClass->implements('Kanel\Enuma\Test\Interface3');
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo implements Interface1, Interface2, Interface3
{

}
');
    }

    function it_should_be_able_to_extend_and_implement_many_interfaces()
    {
        $phpClass = new PhpClass('Foo');
        $phpClass->namespace('Kanel\Enuma\Test');
        $phpClass->use('Kanel\Enuma\Test\Fake1');
        $phpClass->extends('Kanel\Enuma\Test\Fake2');
		$phpClass->implements('Kanel\Enuma\Test\Interface1');
		$phpClass->implements('Kanel\Enuma\Test\Interface2');
		$phpClass->implements('Kanel\Enuma\Test\Interface3');
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{

}
');
    }

    function it_should_be_able_to_use_trait()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->useTrait('Kanel\Enuma\Test\Trait1')
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\Trait1;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    use Trait1;
}
');
    }

    function it_should_be_able_to_use_many_traits()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
			->useTrait('Kanel\Enuma\Test\Trait1')
			->useTrait('Kanel\Enuma\Test\Trait2')
            ->useTrait('Kanel\Enuma\Test\Trait3')
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\Trait1;
use Kanel\Enuma\Test\Trait2;
use Kanel\Enuma\Test\Trait3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    use Trait1;
    use Trait2;
    use Trait3;
}
');
    }

    function it_should_be_able_to_add_a_constant()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addConst(new Constant('MY_CONST', true))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    const MY_CONST = true;
}
');
    }

    function it_should_be_able_to_add_many_constants()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addConst(new Constant('MY_CONST', true))
            ->addConst(new Constant('ALSO_MY_CONST', false))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    const MY_CONST = true;
    const ALSO_MY_CONST = false;
}
');
    }

    function it_should_be_able_to_add_many_constants_with_visibility()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;
}
');
    }

    function it_should_be_able_to_add_an_array_constant()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addConst(new Constant('MY_CONST', [1, 2, 4]))
            ->addConst(new Constant('ALSO_MY_CONST', ['name' => 'toto', 'address' => 'totoville']))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    const MY_CONST = [1, 2, 4];
    const ALSO_MY_CONST = [\'name\' => \'toto\', \'address\' => \'totoville\'];
}
');
    }

    function it_should_be_able_to_add_an_array_constant_with_long_syntax()
    {
        $codingStyle = new CustomCodingStyle();
        $codingStyle->useShortArrayNotation(false);

        $phpClass = (new PhpClass('Foo', $codingStyle))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addConst(new Constant('MY_CONST', [1, 2, 4]))
            ->addConst(new Constant('ALSO_MY_CONST', ['name' => 'toto', 'address' => 'totoville']))
        ;

        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    const MY_CONST = array(1, 2, 4);
    const ALSO_MY_CONST = array(\'name\' => \'toto\', \'address\' => \'totoville\');
}
');
    }

    function it_should_be_able_to_add_a_naked_property()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty(new Property('property1'));
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    public $property1;
}
');
    }

    function it_should_be_able_to_add_a_property_with_visibility()
    {
        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty(new Property('property1', Visibility::PROTECTED));
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    protected $property1;
}
');
    }

    function it_should_be_able_to_add_multiple_properties_with_visibility_and_a_default_value()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addProperty($property2)
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    protected $property1 = null;
    private $property2 = true;
}
');
    }

    function it_should_be_able_to_add_static_properties()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);
        $property1->setIsStatic(true);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addProperty($property2)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected static $property1 = null;
    private $property2 = true;
}
');
    }

    function it_should_be_able_to_add_multiple_properties_and_consts()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addProperty($property2)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;
}
');
    }

    function it_should_be_able_to_add_naked_method()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod(new Method('bar'))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @return mixed
     */
    public function bar()
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_add_method_with_visibility()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod(new Method('bar', Visibility::PUBLIC))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @return mixed
     */
    public function bar()
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_add_static_method()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $method = new Method('bar', Visibility::PUBLIC);
        $method->setIsStatic(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method)
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @return mixed
     */
    public static function bar()
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_add_abstract_method()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $method = new Method('bar', Visibility::PUBLIC);
        $method->setIsAbstract(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method)
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

abstract class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @return mixed
     */
    abstract public function bar();
}
');
    }

    function it_should_be_able_to_add_final_method()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $method = new Method('bar', Visibility::PUBLIC);
        $method->setIsFinal(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method)
        ;
        $string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @return mixed
     */
    final public function bar()
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_add_manys_methods()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod(new Method('bar', Visibility::PUBLIC))
            ->addMethod(new Method('foobar', Visibility::PROTECTED))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @return mixed
     */
    public function bar()
    {
        // TODO: Implement method body
    }

    /**
     * @return mixed
     */
    protected function foobar()
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_add_parameters()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);

        $method1 = new Method('bar', Visibility::PUBLIC);
        $method1->addParameter(new Parameter("abc"));
        $method1->addParameter(new Parameter("def"));

        $method2 = new Method('foobar', Visibility::PROTECTED);
        $method2->addParameter(new Parameter("ghi"));


        $phpClass = (new PhpClass('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method1)
            ->addMethod($method2)
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param mixed $abc
     * @param mixed $def
     * @return mixed
     */
    public function bar($abc, $def)
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return mixed
     */
    protected function foobar($ghi)
    {
        // TODO: Implement method body
    }
}
');
    }

	function it_should_be_able_to_add_typed_parameters()
	{
		$property1 = new Property('property1', Visibility::PROTECTED);
		$property1->setValue(null);

		$property2 = new Property('property2', Visibility::PRIVATE);
		$property2->setValue(true);


		$method1 = new Method('bar', Visibility::PUBLIC);

		$parameter1 = new Parameter("abc");
		$parameter1->setType(Type::STRING);

		$parameter2 = new Parameter("def");
		$parameter2->setType("Kanel\Enuma\Test\ParamType");

		$method1->addParameter($parameter1, $parameter2);

		$method2 = new Method('foobar', Visibility::PROTECTED);
		$method2->addParameter(new Parameter("ghi"));


		$phpClass = (new PhpClass('Foo'))
			->namespace('Kanel\Enuma\Test')
			->use('Kanel\Enuma\Test\Fake1')
			->extends('Kanel\Enuma\Test\Fake2')
			->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
			->implements('Kanel\Enuma\Test\Interface3')
			->addProperty($property1)
			->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
			->addProperty($property2)
			->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
			->addMethod($method1)
			->addMethod($method2)
		;
		$string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param string $abc
     * @param ParamType $def
     * @return mixed
     */
    public function bar(string $abc, ParamType $def)
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return mixed
     */
    protected function foobar($ghi)
    {
        // TODO: Implement method body
    }
}
');
	}

	function it_should_be_able_to_add_typed_parameters_with_default_values()
	{
		$property1 = new Property('property1', Visibility::PROTECTED);
		$property1->setValue(null);

		$property2 = new Property('property2', Visibility::PRIVATE);
		$property2->setValue(true);


		$method1 = new Method('bar', Visibility::PUBLIC);

		$parameter1 = new Parameter("abc");
		$parameter1->setType(Type::STRING);
		$parameter1->setValue('Hello');

		$parameter2 = new Parameter("def");
		$parameter2->setType("Kanel\Enuma\Test\ParamType");
		$parameter2->setValue(null);

		$method1->addParameter($parameter1, $parameter2);

		$method2 = new Method('foobar', Visibility::PROTECTED);
		$method2->addParameter(new Parameter("ghi"));


		$phpClass = (new PhpClass('Foo'))
			->namespace('Kanel\Enuma\Test')
			->use('Kanel\Enuma\Test\Fake1')
			->extends('Kanel\Enuma\Test\Fake2')
			->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
			->implements('Kanel\Enuma\Test\Interface3')
			->addProperty($property1)
			->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
			->addProperty($property2)
			->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
			->addMethod($method1)
			->addMethod($method2)
		;
		$string = $this->stringify($phpClass);
		$string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param string $abc
     * @param ParamType $def
     * @return mixed
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null)
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return mixed
     */
    protected function foobar($ghi)
    {
        // TODO: Implement method body
    }
}
');
	}

	function it_should_be_able_to_add_return_type_to_methods()
	{
		$property1 = new Property('property1', Visibility::PROTECTED);
		$property1->setValue(null);

		$property2 = new Property('property2', Visibility::PRIVATE);
		$property2->setValue(true);


		$method1 = new Method('bar', Visibility::PUBLIC);
		$method1->setReturnType('void');
		$parameter1 = new Parameter("abc");
		$parameter1->setType(Type::STRING);
		$parameter1->setValue('Hello');

		$parameter2 = new Parameter("def");
		$parameter2->setType("Kanel\Enuma\Test\ParamType");
		$parameter2->setValue(null);

		$method1->addParameter($parameter1, $parameter2);

		$method2 = new Method('foobar', Visibility::PROTECTED);
		$method2->addParameter(new Parameter("ghi"));
		$method2->setReturnType('bool');


		$phpClass = (new PhpClass('Foo'))
			->namespace('Kanel\Enuma\Test')
			->use('Kanel\Enuma\Test\Fake1')
			->extends('Kanel\Enuma\Test\Fake2')
			->implements('Kanel\Enuma\Test\Interface1')
			->implements('Kanel\Enuma\Test\Interface2')
			->implements('Kanel\Enuma\Test\Interface3')
			->addProperty($property1)
			->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
			->addProperty($property2)
			->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
			->addMethod($method1)
			->addMethod($method2)
		;
		$string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param string $abc
     * @param ParamType $def
     * @return void
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null): void
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return bool
     */
    protected function foobar($ghi): bool
    {
        // TODO: Implement method body
    }
}
');
	}

    function it_should_put_class_braces_in_new_line_if_asked_to()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);


        $method1 = new Method('bar', Visibility::PUBLIC);
        $method1->setReturnType('void');
        $parameter1 = new Parameter("abc");
        $parameter1->setType(Type::STRING);
        $parameter1->setValue('Hello');

        $parameter2 = new Parameter("def");
        $parameter2->setType("Kanel\Enuma\Test\ParamType");
        $parameter2->setValue(null);

        $method1->addParameter($parameter1, $parameter2);

        $method2 = new Method('foobar', Visibility::PROTECTED);
        $method2->addParameter(new Parameter("ghi"));
        $method2->setReturnType('bool');


        $codingStyle = new CustomCodingStyle();
        $codingStyle->setClassBracesInNewLine(false);

        $phpClass = (new PhpClass('Foo', $codingStyle))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
            ->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method1)
            ->addMethod($method2)
        ;
        $string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

class Foo extends Fake2 implements Interface1, Interface2, Interface3 {
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param string $abc
     * @param ParamType $def
     * @return void
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null): void
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return bool
     */
    protected function foobar($ghi): bool
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_put_method_braces_in_new_line_if_asked_to()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);


        $method1 = new Method('bar', Visibility::PUBLIC);
        $method1->setReturnType('void');
        $parameter1 = new Parameter("abc");
        $parameter1->setType(Type::STRING);
        $parameter1->setValue('Hello');

        $parameter2 = new Parameter("def");
        $parameter2->setType("Kanel\Enuma\Test\ParamType");
        $parameter2->setValue(null);

        $method1->addParameter($parameter1, $parameter2);

        $method2 = new Method('foobar', Visibility::PROTECTED);
        $method2->addParameter(new Parameter("ghi"));
        $method2->setReturnType('bool');


        $codingStyle = new CustomCodingStyle();
        $codingStyle->setClassBracesInNewLine(false);
        $codingStyle->setMethodBracesInNewLine(false);

        $phpClass = (new PhpClass('Foo', $codingStyle))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
            ->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method1)
            ->addMethod($method2)
        ;
        $string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

class Foo extends Fake2 implements Interface1, Interface2, Interface3 {
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param string $abc
     * @param ParamType $def
     * @return void
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null): void {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return bool
     */
    protected function foobar($ghi): bool {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_possible_to_add_comment()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);


        $method1 = new Method('bar', Visibility::PUBLIC);
        $method1->setReturnType('void');
        $parameter1 = new Parameter("abc");
        $parameter1->setType(Type::STRING);
        $parameter1->setValue('Hello');

        $parameter2 = new Parameter("def");
        $parameter2->setType("Kanel\Enuma\Test\ParamType");
        $parameter2->setValue(null);

        $method1->addParameter($parameter1, $parameter2);

        $method2 = new Method('foobar', Visibility::PROTECTED);
        $method2->addParameter(new Parameter("ghi"));
        $method2->setReturnType('bool');

        $phpClass = (new PhpClass('Foo'))
            ->addComment('Hello World')
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
            ->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method1)
            ->addMethod($method2)
        ;
        $string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

/**
 * Hello World
 */
class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * @param string $abc
     * @param ParamType $def
     * @return void
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null): void
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return bool
     */
    protected function foobar($ghi): bool
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_possible_to_add_method_comment()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);


        $method1 = new Method('bar', Visibility::PUBLIC);
        $method1->setReturnType('void');
        $method1->setComment('This is my fct');
        $parameter1 = new Parameter("abc");
        $parameter1->setType(Type::STRING);
        $parameter1->setValue('Hello');

        $parameter2 = new Parameter("def");
        $parameter2->setType("Kanel\Enuma\Test\ParamType");
        $parameter2->setValue(null);

        $method1->addParameter($parameter1, $parameter2);

        $method2 = new Method('foobar', Visibility::PROTECTED);
        $method2->addParameter(new Parameter("ghi"));
        $method2->setReturnType('bool');

        $phpClass = (new PhpClass('Foo'))
            ->addComment('Hello World')
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
            ->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method1)
            ->addMethod($method2)
        ;
        $string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

/**
 * Hello World
 */
class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * This is my fct
     * @param string $abc
     * @param ParamType $def
     * @return void
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null): void
    {
        // TODO: Implement method body
    }

    /**
     * @param mixed $ghi
     * @return bool
     */
    protected function foobar($ghi): bool
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_possible_to_disable_auto_comment()
    {
        $property1 = new Property('property1', Visibility::PROTECTED);
        $property1->setValue(null);

        $property2 = new Property('property2', Visibility::PRIVATE);
        $property2->setValue(true);


        $method1 = new Method('bar', Visibility::PUBLIC);
        $method1->setReturnType('void');
        $method1->setComment('This is my fct');
        $parameter1 = new Parameter("abc");
        $parameter1->setType(Type::STRING);
        $parameter1->setValue('Hello');

        $parameter2 = new Parameter("def");
        $parameter2->setType("Kanel\Enuma\Test\ParamType");
        $parameter2->setValue(null);

        $method1->addParameter($parameter1, $parameter2);

        $method2 = new Method('foobar', Visibility::PROTECTED);
        $method2->addParameter(new Parameter("ghi"));
        $method2->setReturnType('bool');

        $custom = new CustomCodingStyle();
        $custom->setAutoComments(false);

        $phpClass = (new PhpClass('Foo', $custom))
            ->addComment('Hello World')
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->extends('Kanel\Enuma\Test\Fake2')
            ->implements('Kanel\Enuma\Test\Interface1')
            ->implements('Kanel\Enuma\Test\Interface2')
            ->implements('Kanel\Enuma\Test\Interface3')
            ->addProperty($property1)
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addProperty($property2)
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod($method1)
            ->addMethod($method2)
        ;
        $string = $this->stringify($phpClass);

        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;
use Kanel\Enuma\Test\Fake2;
use Kanel\Enuma\Test\Interface1;
use Kanel\Enuma\Test\Interface2;
use Kanel\Enuma\Test\Interface3;
use Kanel\Enuma\Test\ParamType;

/**
 * Hello World
 */
class Foo extends Fake2 implements Interface1, Interface2, Interface3
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    protected $property1 = null;
    private $property2 = true;

    /**
     * This is my fct
     */
    public function bar(string $abc = \'Hello\', ParamType $def = null): void
    {
        // TODO: Implement method body
    }

    protected function foobar($ghi): bool
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_stringify_interface()
    {
        $phpClass = (new PhpInterface('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->addConst(new Constant('MY_CONST', true, Visibility::PRIVATE))
            ->addConst(new Constant('ALSO_MY_CONST', false, Visibility::PROTECTED))
            ->addMethod(new Method('Hello'))
            ->addMethod(new Method('World', Visibility::PROTECTED))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

interface Foo
{
    private const MY_CONST = true;
    protected const ALSO_MY_CONST = false;

    /**
     * @return mixed
     */
    public function Hello()
    {
        // TODO: Implement method body
    }

    /**
     * @return mixed
     */
    protected function World()
    {
        // TODO: Implement method body
    }
}
');
    }

    function it_should_be_able_to_stringify_trait()
    {
        $phpClass = (new PhpTrait('Foo'))
            ->namespace('Kanel\Enuma\Test')
            ->use('Kanel\Enuma\Test\Fake1')
            ->addProperty(new Property('foo'))
            ->addProperty(new Property('bar'))
            ->addMethod(new Method('Hello'))
            ->addMethod(new Method('World', Visibility::PROTECTED))
        ;
        $string = $this->stringify($phpClass);
        $string->shouldBe('<?php

namespace Kanel\Enuma\Test;

use Kanel\Enuma\Test\Fake1;

trait Foo
{
    public $foo;
    public $bar;

    /**
     * @return mixed
     */
    public function Hello()
    {
        // TODO: Implement method body
    }

    /**
     * @return mixed
     */
    protected function World()
    {
        // TODO: Implement method body
    }
}
');
    }
}

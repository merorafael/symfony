<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Routing\Tests\Matcher;

use Symfony\Component\Routing\Matcher\Dumper\PhpMatcherDumper;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;

class DumpedUrlMatcherTest extends UrlMatcherTest
{
    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage The "schemes" requirement is only supported for URL matchers that implement RedirectableUrlMatcherInterface.
     */
    public function testSchemeRequirement()
    {
        parent::testSchemeRequirement();
    }

    protected function getUrlMatcher(RouteCollection $routes, RequestContext $context = null)
    {
        static $i = 0;

        $class = 'DumpedUrlMatcher'.++$i;
        $dumper = new PhpMatcherDumper($routes);
        $dumpedRoutes = eval('?>'.$dumper->dump(array('class' => $class)));

        return new $class($context ?: new RequestContext());
    }
}

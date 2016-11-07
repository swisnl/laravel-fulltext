<?php
namespace Tests;

use Swis\LaravelFulltext\TermBuilder;

class TermBuilderTest extends AbstractTestCase {

    public function test_termbuilder_builds_terms_array()
    {
        $configReturn= false;
        global $configReturn;

        $termsResult = ['hi', 'im', 'a', 'few', 'terms'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $diff = $terms->diff($termsResult);
        $this->assertCount(0, $diff);
    }

    public function test_termbuilder_builds_terms_array_with_wildcard()
    {
        $configReturn = true;
        global $configReturn;

        $termsResult = ['hi', 'im', 'a', 'few', 'terms'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $termsResultWithWilcard = ['hi*', 'im*', 'a*', 'few*', 'terms*'];
        $diff = $terms->diff($termsResult);
        $this->assertCount(0, $diff);
    }
}

namespace Swis\LaravelFulltext;

function config($arg)
{
    global $configReturn;
    return $configReturn;
}

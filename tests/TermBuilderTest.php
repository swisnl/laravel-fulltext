<?php

namespace Swis\Laravel\Fulltext\Tests;

use Swis\Laravel\Fulltext\TermBuilder;

class TermBuilderTest extends AbstractTestCase
{
    public function testTermbuilderBuildsTermsArray()
    {
        global $configReturn;
        $configReturn = false;

        $termsResult = ['hi', 'im', 'a', 'few', 'terms'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $diff = $terms->diff($termsResult);
        $this->assertCount(0, $diff);
    }

    public function testTermbuilderDoesNotBuildEmptyTerms()
    {
        global $configReturn;
        $configReturn = false;

        $termsResult = ['<hi', 'im', 'a', 'few', 'terms>'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $termsResultWithoutSpecialChars = ['hi', 'im', 'a', 'few', 'terms'];
        $diff = $terms->diff($termsResultWithoutSpecialChars);
        $this->assertCount(0, $diff);
    }

    public function testTermbuilderBuildsTermsArrayWithWildcard()
    {
        global $configReturn;
        $configReturn = true;

        $termsResult = ['hi', 'im', 'a', 'few', 'terms'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $termsResultWithWildcard = ['hi*', 'im*', 'a*', 'few*', 'terms*'];
        $diff = $terms->diff($termsResultWithWildcard);
        $this->assertCount(0, $diff);
    }
}

namespace Swis\Laravel\Fulltext;

function config($arg)
{
    global $configReturn;

    return $configReturn;
}

<?php

namespace Swis\Laravel\Fulltext\Tests;

use Illuminate\Support\Facades\Config;
use Swis\Laravel\Fulltext\TermBuilder;

class TermBuilderTest extends AbstractTestCase
{
    public function testTermbuilderBuildsTermsArray()
    {
        Config::set('laravel-fulltext.enable_wildcards', false);

        $termsResult = ['hi', 'im', 'a', 'few', 'terms'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $diff = $terms->diff($termsResult);
        $this->assertCount(0, $diff);
    }

    public function testTermbuilderDoesNotBuildEmptyTerms()
    {
        Config::set('laravel-fulltext.enable_wildcards', false);

        $termsResult = ['<hi', 'im', 'a', 'few', 'terms>'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $termsResultWithoutSpecialChars = ['hi', 'im', 'a', 'few', 'terms'];
        $diff = $terms->diff($termsResultWithoutSpecialChars);
        $this->assertCount(0, $diff);
    }

    public function testTermbuilderBuildsTermsArrayWithWildcard()
    {
        Config::set('laravel-fulltext.enable_wildcards', true);

        $termsResult = ['hi', 'im', 'a', 'few', 'terms'];
        $terms = TermBuilder::terms(implode(' ', $termsResult));
        $termsResultWithWildcard = ['hi*', 'im*', 'a*', 'few*', 'terms*'];
        $diff = $terms->diff($termsResultWithWildcard);
        $this->assertCount(0, $diff);
    }
}

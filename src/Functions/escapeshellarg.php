<?php

namespace Recca0120\Support\Functions\Enable\Escapeshellarg
{
    if (function_exists('escapeshellarg') === true) {
        function escapeshellarg($input)
        {
            return \escapeshellarg($input);
        }
    } else {
        function escapeshellarg($input)
        {
            $input = str_replace('\'', '\\\'', $input);

            return '\''.$input.'\'';
        }
    }
}

namespace SebastianBergmann\Environment
{
    function escapeshellarg($input)
    {
        return \Recca0120\Support\Functions\Enable\Escapeshellarg\escapeshellarg($input);
    }
}

namespace Symfony\Component\Console\Input
{
    function escapeshellarg($input)
    {
        return \Recca0120\Support\Functions\Enable\Escapeshellarg\escapeshellarg($input);
    }
}

namespace Symfony\Component\HttpFoundation\File\MimeType
{
    function escapeshellarg($input)
    {
        return \Recca0120\Support\Functions\Enable\Escapeshellarg\escapeshellarg($input);
    }
}

namespace Symfony\Component\Process
{
    function escapeshellarg($input)
    {
        return \Recca0120\Support\Functions\Enable\Escapeshellarg\escapeshellarg($input);
    }
}

namespace Tracy
{
    function escapeshellarg($input)
    {
        return \Recca0120\Support\Functions\Enable\Escapeshellarg\escapeshellarg($input);
    }
}

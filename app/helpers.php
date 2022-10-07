<?php



if ( !function_exists('md_slashes') )
{
    function md_slashes($text)
    {
        return addcslashes($text, '\"_`*<>{}[]()#+-.|!');
    }
}

if ( !function_exists('array_hash') )
{
    function array_hash(...$args)
    {
        return short_md5(serialize($args));
    }
}

if ( !function_exists('pluck_not_null') )
{
    function pluck_not_null($data, $key)
    {
        $ids = array_column($data, $key);
        $ids = array_filter($ids, fn($v) => $v);
        return $ids;
    }
}

if ( !function_exists('format_price') )
{
    function format_price($int, $addPlus = false)
    {
        $str = number_format($int, 0, '.', ' ');

        if ($addPlus && $int > 0)
            $str = '+'.$str;

        return $str;
    }
}

if ( !function_exists('format_date') )
{
    function format_date($date)
    {
        return date('d.m.Y', strtotime($date));
    }
}

if ( !function_exists('format_datetime') )
{
    function format_datetime($date)
    {
        return date('d.m.Y H:i:s', strtotime($date));
    }
}

if ( !function_exists('paginator_elements') )
{
    function paginator_elements($elements, $currentPage)
    {
        foreach($elements as $k => $element)
        {
            if ( $k === 0 && (isset($elements[1]) || isset($elements[3])) )
            {
                $element = array_slice($element, 0, $currentPage + 2, true);
                if ( count($element) == 2 )
                    $element = array_slice($element, 0, 1, true);
                elseif ($currentPage != 1)
                {
                    $element = array_slice($element, 0, $currentPage + 1, true);
                }
            }
            if ( $k === 4 )
            {
                if (count($element) == 2 && isset($elements[3]))
                    $element = array_slice($element, 1, 1, true);
                else
                {
                    $key = max(0, array_search($currentPage, array_keys($element), true) - 1);
                    $element = array_slice($element, $key, $currentPage + 30, true);
                }
            }

            $elements[$k] = $element;
        }

        return $elements;
    }
}


if ( !function_exists('rename_file') )
{
    function rename_file($fileName)
    {
        $_ext     = pathinfo( $fileName, PATHINFO_EXTENSION );
        $_name    = pathinfo( $fileName, PATHINFO_FILENAME );

        // $_name = Str::of($_name)->slug('_')->lower();
        $_name = short_md5($_name);

        return $_name . '.' . $_ext;
    }
}


if ( !function_exists('set_separator') )
{
    function set_separator($subject)
    {
        $path = (DIRECTORY_SEPARATOR === '\\')
                ? str_replace('/', '\\', $subject)
                : str_replace('\\', '/', $subject);
        return $path;
    }
}

if ( !function_exists('short_md5') )
{
    function short_md5($str)
    {
        return substr(md5($str), 0, 13);
    }
}


if ( !function_exists('clear_phone') )
{
    function clear_phone($phone)
    {
        return '+' . preg_replace('/\D+/', '', $phone);
    }
}

if ( !function_exists('text_to_array') )
{
    function text_to_array($text)
    {
        $rows = explode("\n", trim($text));
        return $rows;
    }
}

if ( !function_exists('email_to_username') )
{
    function email_to_username($email)
    {
        $array = explode("@", trim($email));
        return $array[0];
    }
}

if ( !function_exists('is_desktop') )
{
    function is_desktop()
    {
        $agent = new \Jenssegers\Agent\Agent();
        return $agent->isDesktop();
    }
}
if ( !function_exists('sklonenie') )
{
    function sklonenie($num, $titles)
    {
        $cases = array(2, 0, 1, 1, 1, 2);

        return $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
    }
}

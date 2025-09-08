<?php
require 'TemplateEngine.php';
require 'Elem.php';

/* ========= Mini test runner & helpers ========= */

/**
 * Run a named test and display the result.
 */
function run(string $name, callable $fn) {
    echo "• $name … ";
    try { 
        $fn(); 
        echo "OK\n"; 
    } catch (Throwable $e) { 
        echo "FAIL: {$e->getMessage()}\n"; 
    }
}

/**
 * Assert whether a document is valid or not, according to validPage().
 */
function expectValid(Elem $doc, bool $expected, string $msg = '') {
    $isValid = null;
    try {
        // Try to generate HTML and validate the document
        $doc->getHTML();
        $res = $doc->validPage();
        $isValid = (bool)$res;
    } catch (Throwable $e) {
        // If validPage() throws, we consider it invalid
        $isValid = false;
    }
    if ($isValid !== $expected) {
        $str = $expected ? 'true' : 'false';
        throw new RuntimeException($msg !== '' ? $msg : "validPage() should return {$str}");
    }
}

/* ========= Rule 1: <html> must contain exactly one <head> followed by one <body> ========= */

run('R1-OK: html = [head, body] (exactly)', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $body = new Elem('body');
    $html->pushElement($head);
    $html->pushElement($body);
    
    expectValid($html, true, 'html must contain head then body');
});

run('R1-KO: wrong order (body then head)', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $body = new Elem('body');
    $html->pushElement($body);
    $html->pushElement($head);
    expectValid($html, false, 'head must come before body');
});

run('R1-KO: duplicate head', function () {
    $html = new Elem('html');
    $head1 = new Elem('head');
    $head2 = new Elem('head');
    $body = new Elem('body');
    $html->pushElement($head1);
    $html->pushElement($head2);
    $html->pushElement($body);
    expectValid($html, false, 'head must be unique');
});

run('R1-KO: duplicate body', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $body1 = new Elem('body');
    $body2 = new Elem('body');
    $html->pushElement($head);
    $html->pushElement($body1);
    $html->pushElement($body2);
    expectValid($html, false, 'body must be unique');
});

/* ========= Rule 2: <head> must contain exactly one <title> and one <meta charset> ========= */

run('R2-OK: head = [title, meta charset]', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title', 'Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    expectValid($html, true, 'head must contain title + meta charset');
});

run('R2-KO: head missing title', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $meta = new Elem('meta', 'charset="UTF-8"');
    $body = new Elem('body');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($meta);

    expectValid($html, false, 'head must contain a title');
});

run('R2-KO: head missing meta charset', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title', 'Title');
    $body = new Elem('body');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);

    expectValid($html, false, 'head must contain a meta charset');
});

run('R2-KO: head contains extra element (script)', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $script = new Elem('script');
    $body = new Elem('body');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);
    $head->pushElement($script); // extra element not allowed

    expectValid($html, false, 'head must only contain title and meta charset');
});

/* ========= Rule 3: <p> must contain text only, no child elements ========= */

run('R3-OK: p with text only', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');
    $p = new Elem('p','Hello');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);
    $body->pushElement($p);

    expectValid($html, true, 'p with text only must be valid');
});

run('R3-KO: p containing another element (b)', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $p = new Elem('p','Paragraph');
    $b = new Elem('b','bold');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($p);
    $p->pushElement($b); // not allowed

    expectValid($html, false, 'p must not contain nested elements');
});

/* ========= Rule 4: <table> → <tr> → (<th>|<td>) ========= */

run('R4-OK: table contains tr, tr contains th/td', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $table = new Elem('table');
    $tr = new Elem('tr');
    $th = new Elem('th','H');
    $td = new Elem('td','D');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($table);
    $table->pushElement($tr);
    $tr->pushElement($th);
    $tr->pushElement($td);

    expectValid($html, true, 'valid table/tr/th-td structure');
});

run('R4-KO: table contains td directly (no tr)', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $table = new Elem('table');
    $td = new Elem('td','D');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($table);
    $table->pushElement($td); // not allowed

    expectValid($html, false, 'table must only contain tr');
});

run('R4-KO: tr contains p (instead of th/td)', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $table = new Elem('table');
    $tr = new Elem('tr');
    $p = new Elem('p','x');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($table);
    $table->pushElement($tr);
    $tr->pushElement($p); // not allowed

    expectValid($html, false, 'tr must only contain th or td');
});

/* ========= Rule 5: <ul>/<ol> must only contain <li> ========= */

run('R5-OK: ul and ol containing only li', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $ul = new Elem('ul');
    $ol = new Elem('ol');
    $li1 = new Elem('li','a');
    $li2 = new Elem('li','b');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($ul);
    $ul->pushElement($li1);
    $body->pushElement($ol);
    $ol->pushElement($li2);

    expectValid($html, true, 'ul/ol with li only must be valid');
});

run('R5-KO: ul containing a p', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $ul = new Elem('ul');
    $p = new Elem('p','x');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($ul);
    $ul->pushElement($p); // not allowed

    expectValid($html, false, 'ul must only contain li');
});

run('R5-KO: ol containing a div', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $ol = new Elem('ol');
    $div = new Elem('div');

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($ol);
    $ol->pushElement($div); // not allowed

    expectValid($html, false, 'ol must only contain li');
});

/* ========= Rule 6: unknown elements are forbidden ========= */

run('R6-KO: unknown element <foo>', function () {
    $html = new Elem('html');
    $head = new Elem('head');
    $title = new Elem('title','Title');
    $meta = new Elem('meta', 'charset="UTF-8"');

    $body = new Elem('body');

    $foo = new Elem('foo'); // invented/unknown tag

    $html->pushElement($head);
    $html->pushElement($body);
    $head->pushElement($title);
    $head->pushElement($meta);

    $body->pushElement($foo); // forbidden

    expectValid($html, false, '<foo> element should not be allowed');
});

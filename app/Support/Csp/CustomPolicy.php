<?php

namespace App\Support\Csp;

use Spatie\Csp\Policies\Basic;
use Spatie\Csp\Directive;

class CustomPolicy extends Basic
{
    public function configure()
    {
        parent::configure();

        $this->addDirective(Directive::SCRIPT, [
            'self',
            'unsafe-inline',
            'unsafe-eval',
            'cdn.jsdelivr.net',
            'cdn.tailwindcss.com',
            'code.jquery.com',
            'ajax.googleapis.com',
            'fonts.gstatic.com',
            'unpkg.com',
        ]);

        $this->addDirective(Directive::STYLE, [
            'self',
            'unsafe-inline',
            'cdn.jsdelivr.net',
            'cdn.tailwindcss.com',
            'fonts.googleapis.com',
        ]);

        $this->addDirective(Directive::FONT, [
            'self',
            'fonts.gstatic.com',
            'fonts.googleapis.com',
            'data:',
        ]);

        $this->addDirective(Directive::IMG, [
            'self',
            'data:',
            'cdn.jsdelivr.net',
        ]);

        $this->addDirective(Directive::FRAME_ANCESTORS, [
            'self',
            'https://mintoku.vn',
            'https://test.mintoku.vn',
            'https://cv.mintoku.vn',
        ]);

        $this->addDirective(Directive::FRAME, [
            'self',
            'https://mintoku.vn',
            'https://cv.mintoku.vn',
            'https://test.mintoku.vn',
        ]);
    }
}

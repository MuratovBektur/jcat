<?php

namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;

class PDFHelper
{
  protected $content;

  public function __construct($content)
  {
    $this->content = $content;
  }

  public function generateHtml()
  {
    $html = "<!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>

          <title>Document</title>
          <style>
            * {
              /*font-family: Helvetica, sans-serif;*/
              font-family: \"DejaVu Sans\", sans-serif;
            }
          </style>
        </head>
        <body>
          $this->content
        </body>
        </html>";
    return $html;
  }

  public function savePdfInFolder($path)
  {
    $html = $this->generateHtml();
    return Pdf::loadHTML($html)->save($path);
  }
}
<?php

namespace App\Helpers;

use App\Helpers\URL;

use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Config;

class Helper
{
    public static function showCategoryNestedset($item, $categories, $categoryIdCurrent = null)
    {
        $xhtmlMenu = '';

        $xhtmlMenu .= sprintf(
            '<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false"> %s </a> ',
            $item['name'],
        );
        $xhtmlMenu .= '<ul class="dropdown-menu">';
        $xhtml = '';
        self::showCategory($categories, $categoryIdCurrent, $xhtml);
        $xhtmlMenu .= $xhtml;
        $xhtmlMenu .= ' </ul>';
        $xhtmlMenu .= '</li>';

        return $xhtmlMenu;
    }

    public static function  showCategory($categories, $categoryIdCurrent, &$xhtml)
    {
        
        foreach ($categories as $category) {
            // $categoryIdCurrent = $idCurrent;

            $linkSubList = URL::linkCategory($category->id, $category->name);
            $classActiveSubList = $categoryIdCurrent == $category->id ? 'active' : '';
            if ($category->children->count() > 0) {
                $xhtml .= sprintf('<li><a class=" %s dropdown-item dropdown-toggle" href="%s">%s</a>', $classActiveSubList, $linkSubList, $category->name);
            } else {
                $xhtml .= sprintf('<li><a class="%s dropdown-item" href="%s">%s</a>', $classActiveSubList, $linkSubList, $category->name);
            }
            if ($category->children->count() > 0) {
                $xhtml .= '<ul class="submenu dropdown-menu">';
                self::showCategory($category->children, $categoryIdCurrent, $xhtml);
                $xhtml .= '</ul>';
            }
            $xhtml .= '</li>';
        }
    }
}

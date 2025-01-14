<?php


namespace Okay\Helpers\MetadataHelpers;


use Okay\Core\FrontTranslations;
use Okay\Core\Modules\Extender\ExtenderFacade;

class BlogCategoryMetadataHelper extends CommonMetadataHelper
{
 
    /**
     * @inheritDoc
     */
    public function getH1Template(): string
    {
        $category = $this->design->getVar('category');

        $categoryH1 = !empty($category->name_h1) ? $category->name_h1 : $category->name;
        if ($pageH1 = parent::getH1Template()) {
            $h1 = $pageH1;
        } else {
            $h1 = (string)$categoryH1;
        }

        return ExtenderFacade::execute(__METHOD__, $h1, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getAnnotationTemplate(): string
    {
        $category = $this->design->getVar('category');
        $isAllPages = $this->design->getVar('is_all_pages');
        $currentPageNum = $this->design->getVar('current_page_num');

        if ((int)$currentPageNum > 1 || $isAllPages === true) {
            $annotation = '';
        } elseif ($pageAnnotation = parent::getAnnotationTemplate()) {
            $annotation = $pageAnnotation;
        } else {
            $annotation = (string)$category->annotation;
        }

        return ExtenderFacade::execute(__METHOD__, $annotation, func_get_args());
    }

    /**
     * @inheritDoc
     */
    public function getDescriptionTemplate(): string
    {
        $category = $this->design->getVar('category');
        $isAllPages = $this->design->getVar('is_all_pages');
        $currentPageNum = $this->design->getVar('current_page_num');

        if ((int)$currentPageNum > 1 || $isAllPages === true) {
            $description = '';
        } elseif ($pageDescription = parent::getDescriptionTemplate()) {
            $description = $pageDescription;
        } else {
            $description = (string)$category->description;
        }

        return ExtenderFacade::execute(__METHOD__, $description, func_get_args());
    }
    
    public function getMetaTitleTemplate(): string
    {
        $category = $this->design->getVar('category');
        $isAllPages = $this->design->getVar('is_all_pages');
        $currentPageNum = $this->design->getVar('current_page_num');
        
        if ($pageTitle = parent::getMetaTitleTemplate()) {
            $metaTitle = $pageTitle;
        } else {
            $metaTitle = (string)$category->meta_title;
        }

        // Добавим номер страницы к тайтлу
        if ((int)$currentPageNum > 1 && $isAllPages !== true) {
            /** @var FrontTranslations $translations */
            $translations = $this->SL->getService(FrontTranslations::class);
            $metaTitle .= $translations->getTranslation('meta_page') . ' ' . $currentPageNum;
        }
        
        return ExtenderFacade::execute(__METHOD__, $metaTitle, func_get_args());
    }
    
    public function getMetaKeywordsTemplate(): string
    {
        $category = $this->design->getVar('category');
        
        if ($pageKeywords = parent::getMetaKeywordsTemplate()) {
            $metaKeywords = $pageKeywords;
        } else {
            $metaKeywords = (string)$category->meta_keywords;
        }

        return ExtenderFacade::execute(__METHOD__, $metaKeywords, func_get_args());
    }
    
    public function getMetaDescriptionTemplate(): string
    {
        $category = $this->design->getVar('category');
        
        if ($pageMetaDescription = parent::getMetaDescriptionTemplate()) {
            $metaDescription = $pageMetaDescription;
        } else {
            $metaDescription = (string)$category->meta_description;
        }

        return ExtenderFacade::execute(__METHOD__, $metaDescription, func_get_args());
    }
    
    /**
     * @inheritDoc
     */
    protected function getParts(): array
    {

        if (!empty($this->parts)) {
            return $this->parts; // no ExtenderFacade
        }
        
        $category = $this->design->getVar('category');
        
        $this->parts = [
            '{$category}' => ($category->name ? $category->name : ''),
            '{$category_h1}' => ($category->name_h1 ? $category->name_h1 : ''),
            '{$sitename}' => ($this->settings->get('site_name') ? $this->settings->get('site_name') : ''),
        ];

        return $this->parts = ExtenderFacade::execute(__METHOD__, $this->parts, func_get_args());
    }
    
}
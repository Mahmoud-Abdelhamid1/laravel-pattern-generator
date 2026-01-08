<?php

namespace MahmoudAbdelhamid\PatternGenerator\Traits;

trait LanguageTrait
{
    protected $name;
    protected $description;

    public function lang()
    {
        $locale = app()->getLocale();
        $headerLang = request()->header('Lang');

        if ($locale == "ar" || $headerLang == "ar") {
            $this->name = "name_ar as name";
            $this->description = "description_ar as description";
        } elseif ($locale == "fr" || $headerLang == "fr") {
            $this->name = "name_fr as name";
            $this->description = "description_fr as description";
        } else {
            $this->name = "name as name";
            $this->description = "description as description";
        }

    }
    public function langForResource()
    {
        $locale = app()->getLocale();
        $headerLang = request()->header('Lang');

        if ($locale == "ar" || $headerLang == "ar") {
            $this->nameField = "name_ar as name";
            $this->descriptionField = "description_ar";
        } elseif ($locale == "fr" || $headerLang == "fr") {
            $this->nameField = "name_fr as name";
            $this->descriptionField = "description_fr";
        } else {
            $this->nameField = "name";
            $this->descriptionField = "description";
        }
    }
    public function langForModel()
    {
        $locale = app()->getLocale();
        $headerLang = request()->header('Lang');

        if ($locale == "ar" || $headerLang == "ar") {
            $this->nameField = "name_ar";
            $this->descriptionField = "description_ar";
        } elseif ($locale == "fr" || $headerLang == "fr") {
            $this->nameField = "name_fr";
            $this->descriptionField = "description_fr";
        } else {
            $this->nameField = "name";
            $this->descriptionField = "description";
        }
    }
}
